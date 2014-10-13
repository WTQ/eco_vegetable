<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 商品信息模型层
 *
 * @package		o2o_supermarket
 * @author 		lp1900
 * @copyright	Copyright (c) 2014. 云帆工作室.
 * @version		Version 1.1
 * @since		2014.4.5
 */

class Goods_m extends MY_Model
{
	protected $_table = 'goods';

	protected $primary_key = 'goods_id';

	public function __construct()
	{
		parent::__construct();

		// 加载商品分类模型和商家模型
		$this->load->model(array('category_m', 'shop_m'));
	}

	/**
	 * 由goods_id查询商品信息，返回对象
	 * 调用MY_Model中get($goods_id)
	 */

	/**
	 * 由goods_id查询全部信息，返回对象
	 * 调用My_Model中get_all()
	 */

	/**
	 * 由商家id查询信息，返回对象
	 */
	public function get_byid($shop_id)
	{
		$shop_id = (int) $shop_id;
		$this->order_by('rank', 'ASC');

		return $this->get_many_by('shop_id', $shop_id);
	}

	/**
	 * 由商家id查询全部商品信息，并将pic字段JSON解码
	 */
	public function get_pic($shop_id)
	{
		$shop_id = (int) $shop_id;
		$this->order_by('rank', 'ASC');

		$arr =  $this->get_many_by('shop_id', $shop_id);
		foreach ($arr as $row) {
			$row->pic = json_decode($row->pic);
		}
		return $arr;
	}

	/**
	 * 由商家名称查询信息，返回对象
	 */
	public function get_byshop($shop_char)
	{
		$shop_id = (int) $this->shop_m->shop_char2id($shop_char);

		return $this->get_byid($shop_id);
	}

	/**
	 * 查询商品表下全部记录条数
	 */
	public function get_total_num()
	{
		return $this->count_all();
	}

	/**
	 * 查询指定商家和指定分类下的记录条数
	 * class_id默认0为该商家下的全局查询
	 */
	public function get_num($shop_id, $class_id = 0)
	{
		$shop_id  = (int) $shop_id;
		$class_id = (int) $class_id;

		return $this->count_by( array(
			'shop_id'  => $shop_id,
			'class_id' => $class_id
		));
	}

	/**
	 * 由分类id查询相应记录
	 * 包含分页参数，返回对象
	 */
	public function get_byclass($shop_id, $class_id=NULL, $num=10, $offset=0)
	{

		$shop_id  = (int) $shop_id;
		$class_id = (int) $class_id;

		if ($class_id == 0 || $class_id == NULL) {
			return $this->limit($num, $offset)->get_many_by('shop_id', $shop_id);	// class_id = 0，查询该商店中全部商品
		} else {
			return $this->limit($num, $offset)->get_many_by(array(	// class_id != 0,查询该商店中指定分类的商品
					'shop_id'  => $shop_id,
					'class_id' => $class_id
			));
		}
	}

	/**
	 * 由商品id查询商品数量
	 */
	public function get_quantity($goods_id)
	{
		$goods_id = (int) $goods_id;
		$result = new stdClass();

		// 商品结果集以对象传递
		$result = $this->get_by('goods_id', $goods_id);
		if ($result !== FALSE) {
			return $result->quantity;
		}
		return FALSE;
	}

	/**
	 * 由商品id查询商品销量
	 */
	public function get_sale($goods_id)
	{
		$goods_id = (int) $goods_id;
		$result = new stdClass();

		$result = $this->get_by('goods_id', $goods_id);
		if ($result !== FALSE) {
			return $result->sale;
		}
		return FALSE;
	}

	/**
	 * 由商品名称搜索，商家id可选
	 * 商家id=0时为全局搜索；!=0时为在指定商家下搜索
	 */
	public function get_byname($name, $shop_id = 0)
	{
		$shop_id = (int) $shop_id;
		if ($shop_id == 0) {
			return $this->get_many_by('name', $name);
		}
		else {
			$this->db->where('shop_id', $shop_id);

			return $this->get_many_by(array(
				'name'		=>	$name,
				'shop_id'	=>	$shop_id,
			));
		}
	}

	/**
	 * 在当前商家下由商品名模糊查询
	 * 实现分页
	 */
	public function get_fuzzy($keyword = '', $shop_id, $limit=10, $offset = 0)
	{
		$this->db->select('*');
		$this->db->like('name', $keyword);
		$this->db->order_by('goods_id DESC, sale DESC');	// 按销量降序排序

		$shop_id	= (int) $shop_id;
		$query		= $this->db->get_where('goods', array('shop_id' => $shop_id), $limit, $offset);		// 从yf_goods表中满足shop_id的商品查找
		$i			= 0;
		$return		= array();
		foreach ($query->result_array() as $row) {
			$return[$i] = array(
				'goods_id'	=>	$row['goods_id'],
				'name'		=>	$row['name'],
				'pic'		=>	$row['pic'],
				'price'		=>	$row['price'],
				'unit'		=>	$row['unit'],
				'barcode'	=>	$row['barcode'],
				'intro'		=>	$row['intro'],
				'stock'		=>	$row['stock'],
			);
			++$i;
		}

		return $return;
	}

	/**
	 * 查询当前商家的今日推荐
	 */
	public function get_shop_recmd($shop_char, $num =5)
	{
		$shop_id = (int) $this->shop_m->shop_char2id($shop_char);
		$is_today = 1;

		return $this->get_many_by(array(
			'shop_id'	=>	$shop_id,
			'is_today'	=>	$is_today
		));
	}
	
	/**
	 * 由商品分类，商家id可选
	 * 商家id=0时为全局搜索；!=0时为在指定商家下搜索
	 * 分类category=0时为全局搜索；!=0时为在指定分类下搜索
	 */
	public function get_bycategory($category, $shop_id = 0)
	{
		$shop_id = (int) $shop_id;
		$category = (int)$category;
		if ($shop_id == 0) {
			if ($category == 0) {
				return $this->get_all();
			} else {
				return $this->get_many_by('class_id', $category);
			}
		}
		else {
			if ($category == 0) {
				$this->db->where('shop_id', $shop_id);				
				return $this->get_all();
			} else {
				$this->db->where('shop_id', $shop_id);
				
				return $this->get_many_by(array(
						'class_id'		=>	$category,
						'shop_id'	=>	$shop_id,
				));
			}

		}
	}
	
	/**
	 * 全部商品销量排序展示
	 */
	public function show_goods($num = 5, $offset = 0)
	{
		$this->order_by('rank, ASC', 'goods_id, ASC');
		$query = $this->db->get('goods', $num, $offset);

		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
		return FALSE;
	}

	/**
	 * 商品上架
	 */
	public function soldin($goods_id)
	{
		$goods_id = (int) $goods_id;

		if ($this->update($goods_id, array('sold' => 1)) === FALSE) {
			return FALSE;
		}
		return TRUE;
	}

	/**
	 * 商品下架
	 */
	public function soldout($goods_id)
	{
		$goods_id = (int) $goods_id;

		if ($this->update($goods_id, array('sold' => 0)) === FALSE) {
			return FALSE;
		}
		return TRUE;
	}

	/**
	 * 商品标记缺货/有货
	 */
	public function mark_stock($goods_id, $stock)
	{
		$goods_id	= (int) $goods_id;
		$data		= array('stock' => $stock);

		$this->update($goods_id, $data);
	}

	/**
	 * 商品余量更新
	 */
/*	public function edit_quantity($goods_id, $num)
	{
		$goods_id = (int) $goods_id;
		$quantity = $this->get_quantity($goods_id) + $num;

		if ($this->update($goods_id, array('quantity' => $quantity)) === FALSE) {
			return FALSE;
		}
		return TRUE;
	}*/

	/**
	 * 商品销量自增
	 */
	public function add_sale($goods_id, $num = 1)
	{
		$goods_id = (int) $goods_id;
		$sale = $this->get_sale($goods_id) + $num;

		if ($this->update($goods_id, array('sale' => $sale)) === FALSE) {
			return FALSE;
		}
		return TRUE;
	}

	/**
	 * 商品余量自减
	 */
// 	public function cut_quantity($goods_id, $num = 1)
// 	{
// 		$goods_id = (int) $goods_id;
// 		$quantity = $this->get_quantity($goods_id) - $num;

// 		// 判断商品余量，如果为0则下架该商品
// 		if ($quantity === 0) {
// 			$this->soldout($goods_id);
// 		}
// 		elseif ($this->update($goods_id, array('quantity' => $quantity)) === FALSE)
// 		{
// 			return FALSE;
// 		}
// 		return TRUE;
// 	}
	/**
	 * 今日推荐，返回对象
	 */
	public function today_recommend($num =5, $offset = 0)
	{
		$this->order_by('rank','ASC');

		return $this->get_many_by('is_today', 1);
	}

	/**
	 * 添加商品信息，返回添加后的id
	 */
	public function add_goods($data)
	{
		return $this->insert($data);
	}

	/**
	 * 修改商品信息
	 */
	public function edit_goods($goods_id, $data)
	{
		$goods_id = (int) $goods_id;

		return $this->update($goods_id, $data);
	}

	/**
	 * 删除商品信息
	 */
	public function del_goods($goods_id)
	{
		$goods_id = (int) $goods_id;

		return $this->delete($goods_id);
	}

	/**
	 * 由商品id查询信息，返回对象
	 */
	public function get_goods($goods_id)
	{
		$goods_id = (int) $goods_id;
		$this->order_by('rank', 'ASC');
		$goods = $this->get_many_by('goods_id', $goods_id);
		if( $goods ) {
			return $goods[0]->pic;
		} else {
			return "";
		}

	}

	/**
	 * 将pic字段编码为JSON，传入数组
	 */
	public function pic_json($arr)
	{
		$data = array(
				'default'	=>	$arr['pic1'],		// 首选图片路径
				'more'		=>	array(
						'pic1'	=>	$arr['pic2'],
						'pic2'	=>	$arr['pic3'],
						'pic3'	=>	$arr['pic4'],
						'pic4'	=>	$arr['pic5'],
			),
		);
		return $pic_path = json_encode($data);
	}

	/**
	 * 将JSON数据解码
	 */
	public function pic_dejson($arr)
	{
		return json_decode($arr);
	}
	
	public function search_many_num($keywords)
	{
		$this->db->like('name',$keywords);
		$query = $this->db->get('yf_goods');
		$num = $query->num_rows;
		return $num;
	}
	public function search_many_by($keywords)
	{
		$this->db->like('name',$keywords);
		return $this->get_many_by();
		
	
	}
}
