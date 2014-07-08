<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 优惠信息模型层
 *
 * @package		o2o_supermarket
 * @author 		lp1900
 * @copyright	Copyright (c) 2014. 云帆工作室.
 * @version		Version 1.0
 * @since		2014.4.10
 */

/**
 * 满减类
 */
class Coupon_full
{
	public $full;

	public $reduce;

	public function __construct($content = NULL)
	{
		if ($content != NULL) {
			$obj          = json_decode($content);
			$this->full   = $obj->full;
			$this->reduce = $obj->reduce;
		}
	}

	public function content()
	{
		$data = array(
			'full'		=> $this->full,
			'reduce'	=> $this->reduce,
		);
		return json_encode($data);
	}
}

class Coupon_m extends MY_Model
{
	protected $_table      = 'coupon';

	protected $primary_key = 'coupon_id';

	public function __construct()
	{
		parent::__construct();
		// 加载商品分类、商品信息和商家模型层
		$this->load->model(array('category_m', 'shop_m', 'goods_m'));
	}

	/**
	 * 由主id查询单条信息，返回对象
	 * 调用MY_Model中get($primary_value)
	 */

	/**
	 * 由主id查询全部信息，返回对象
	 * 调用My_Model中get_all()
	 */

	/**
	 * 查询优惠表下全部信息数量
	 */
	public function get_total_num()
	{
		return $this->count_all();
	}

	/**
	 * 由商家id查询优惠信息，返回对象
	 */
	public function get_byid($shop_id)
	{
		$shop_id = (int) $shop_id;

		return $this->get_many_by('shop_id', $shop_id);
	}

	/**
	 * 由商家名称查询优惠信息，返回对象
	 */
	public function get_byshop($shop_char)
	{
		$shop_id = (int) $this->shop_m->shop_char2id($shop_char);

		return $this->get_byid($shop_id);
	}

	/**
	 * 检查是否全局优惠
	 */
	public function check_global($coupon_id)
	{
		$coupon_id = (int) $coupon_id;
		$global    = $this->get($coupon_id)->shop_id;

		if ($global === 0) {
			return TRUE;		// global = 0时，优惠所有商家有效
		} else {
			return FALSE;		// global != 0时，优惠仅对当前商家有效
		}
	}

	/**
	 * 对不同类别优惠券的不同处理
	 * type =1 为满减
	 * type =2 为满送
	 * type =3 为折扣
	 */
	public function deal_coupon($coupon_id)
	{
		$coupon_id = (int) $coupon_id;
		if ($coupon_id != 0) {
			$type = $this->get($coupon_id)->type;
			switch ($type)
			{
				case 1 :					// 满减类型
					return $this->deal_reduce($coupon_id);
					break;
				case 2 :					// 满送类型
					return $this->deal_present($coupon_id);
					break;
				case 3 :					// 折扣类型
					return $this->deal_discount($coupon_id);
					break;
				default:
					return $data['error'] = 1;
					break;
			}
		} else {
			return $data['error'] = 1;
		}

	}

	/**
	 * type = 1
	 * 对满减类型优惠券的处理
	 */
	public function deal_reduce($coupon_id)
	{
		$coupon		= $this->get($coupon_id);
		$content	= json_decode($coupon->content);
		$full		= $content->full;
		$reduce		= $content->reduce;
		$info		= "满" . $full . "减" . $reduce . "元";		// 优惠的具体介绍
		$data		= array(
			'full'		=>	$full,
			'reduce'	=>	$reduce,
			'info'		=>	$info,
			'error'		=>	0,
		);

		return $data;
	}

	/**
	 * type = 2
	 * 对满送类型优惠券的处理
	 */
	public function deal_present($coupon_id)
	{
		$coupon		= $this->get($coupon_id);
		$content	= json_decode($coupon->content);
		$full		= $content->full;
		$present	= $content->present;
		$info		= "满" . $full . "送" . $present;
		$data		= array(
			'full'		=>	$full,
			'present'	=>	$present,
			'info'		=>	$info,
			'error'		=>	0,
		);

		return $data;
	}

	/**
	 * type = 3
	 * 对折扣类型优惠券的处理
	 */
	public function deal_discount($coupon_id)
	{
		$coupon		= $this->get($coupon_id);
		$content	= json_decode($coupon->content);
		$full		= $content->full;
		$discount	= $content->discount;
		$info		= "满" . $full . "打" . $discount . "折";
		$data		= array(
			'full'		=>	$full,
			'discount'	=>	$discount,
			'info'		=>	$info,
			'error'		=>	0,
		);

		return $data;
	}

	/**
	 * 新增优惠信息
	 */
	public function add_coupon($data)
	{
		return $this->insert($data);
	}

	/**
	 * 修改优惠信息
	 */
	public function edit_coupon($coupon_id, $data)
	{
		$coupon_id = (int) $coupon_id;

		return $this->update($coupon_id, $data);
	}

	/**
	 * 删除优惠信息
	 */
	public function del_coupon($coupon_id)
	{
		$coupon_id = (int) $coupon_id;

		return $this->delete($coupon_id);
	}

	/**
	 * 将优惠内容JSON编码
	 */
	public function coupon_json($full=100, $discount=1, $reduce=0, $present='')
	{
		$content = array(
			'full'		=>	$full,				// 优惠的满额
			'discount'	=>	$discount,			// 优惠的折扣
			'reduce'	=>	$reduce,			// 满减的金额
			'present'	=>	$present,			// 满送的礼品
		);

		return json_encode($content);
	}
}
