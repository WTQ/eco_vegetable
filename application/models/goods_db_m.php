<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 商品信息库模型层
 * 
 * @package		o2o_supermarket
 * @author 		lp1900
 * @copyright	Copyright (c) 2014. 云帆工作室.
 * @version		Version 1.1
 * @since		2014.5.12
 */

class Goods_db_m extends MY_Model
{
	protected $_table = 'db_goods';
	
	protected $primary_key = 'goods_id';
	
	public function __construct()
	{
		parent::__construct();
	
		// 加载商品分类模型和商家模型
		$this->load->model( array('category_m', 'shop_m', 'goods_m', 'img_m'));
	}
	
	/**
	 * 由pic_id查询图片信息，返回对象
	 * 调用MY_Model中get($primary_value)
	 */
	
	/**
	 * 由pic_id查询全部信息，返回对象
	 * 调用My_Model中get_all()
	 */
	
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
}