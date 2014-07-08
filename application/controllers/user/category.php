<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * User端商品分类导航控制器
 *
 * @package		o2o_supermarket
 * @author 		lp1900
 * @copyright	Copyright (c) 2014. 云帆工作室.
 * @version		Version 1.0
 * @since		2014.4.28
 */

class Category extends U_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model( array('category_m', 'goods_m', 'shop_m', 'user_m'));
		$this->load->library( array('session', 'cart', 'encrypt'));
	}
	
	/**
	 * 显示该商家下的商品分类目录
	 */
	public function index()
	{
		$shop_id	= (int) cookie('shop_id');
		
		$data['shop_id'] = $shop_id;
		if ($shop_id !== '') {
			$this->load->view('/user/shop_list', $data);
		} else {
			redirect('user/supermarket');
		}
	}
	
	public function cate_info()
	{
		$shop_id	= (int) cookie('shop_id');
		$class_id	= (int) get('class_id');
		
		$data['shop_id']	= $shop_id;
		$data['class_id']	= $class_id;
		$data['goods']		= $this->goods_m->get_class($shop_id, $class_id);
		
		if ($shop_id !== '') {
			$this->load->view('/user/goods_list', $data);
		} else {
			redirect('user/supermarket');
		}
	}
}