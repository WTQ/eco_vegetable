<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 商品图片模型层
 * 
 * @package		o2o_supermarket
 * @author 		lp1900
 * @copyright	Copyright (c) 2014. 云帆工作室.
 * @version		Version 1.1
 * @since		2014.5.12
 */

class Img_m extends MY_Model
{
	protected $_table = 'db_goods_img';
	
	protected $primary_key = 'img_id';
	
	public function __construct()
	{
		parent::__construct();
	
		// 加载商品分类模型和商家模型
		$this->load->model( array('category_m', 'shop_m', 'goods_m'));
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
	 * 添加图片信息，返回添加后的id
	 */
	public function add_img($data)
	{
		return $this->insert($data);
	}
	
	/**
	 * 修改商品图片
	 */
	public function edit_img($goods_id, $data)
	{
		$goods_id = (int) $goods_id;
	
		return $this->update($goods_id, $data);
	}
}