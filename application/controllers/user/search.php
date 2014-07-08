<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 用户端商品搜索控制器
 *
 * @package		o2o_supermarket
 * @author 		lp1900
 * @copyright	Copyright (c) 2014. 云帆工作室.
 * @version		Version 1.0
 * @since		2014.4.23
 */

class Search extends U_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('category_m', 'goods_m', 'shop_m', 'user_m'));
		$this->load->library(array('session', 'cart', 'encrypt'));
		// 预加载了'url', 'form', 'cookie', 'date', 'input' helper
	}

	/**
	 * 搜索页面
	 */
	public function index()
	{
		$data['shop_id'] = (int) get('shop_id');

		if ($data['shop_id'] != '') {
			$this->load->view('/user/goods_search_index', $data);
		} else {
			$this->load->view('user/zone');
		}
	}

	/**
	 * 显示模糊搜索结果
	 */
	public function search_goods()
	{
		$data['shop_id']	=	(int) get('shop_id');
		$data['keyword']	=	get('keyword');
		$data['goods']		=	$this->goods_m->get_fuzzy($data['keyword'], 9);

		$this->load->view('user/goods_search_list', $data);
	}
}
