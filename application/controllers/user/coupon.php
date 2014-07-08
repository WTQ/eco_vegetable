<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @package		优惠管理控制器
 * @author 		lp1900
 */

class Coupon extends U_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model( array('category_m', 'goods_m', 'shop_m', 'user_m', 'coupon_m') );
	}

	/**
	 * 显示该店铺下的优惠信息
	 */
	public function index()
	{
		$shop_id        = (int) cookie('shop_id');
		$total_price    = get('total_price');						// 获取订单金额，判断是够满足优惠条件
		$coupon         = $this->coupon_m->get_byid($shop_id);		// 获取该商铺下全部优惠信息
		$data['coupon'] = array();

		foreach ($coupon as $row) {
			$data['coupon'][] = array(
				'coupon_id' => $row->coupon_id,
				'content'   => $this->coupon_m->deal_coupon($row->coupon_id),
			);
		}

		$this->json_out($data);
	}

	/**
	 * 根据coupon_id查询指定的优惠券信息
	 */
	public function get_coupon()
	{
		$coupon_id = (int) get('coupon_id');
		$data      = $this->coupon_m->deal_coupon($coupon_id);

		$this->json_out($data);
	}
}
