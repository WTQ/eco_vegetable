<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * User端商品信息控制器
 *
 * @package		o2o_supermarket
 * @author 		lp1900
 * @copyright	Copyright (c) 2014. 云帆工作室.
 * @version		Version 1.0
 * @since		2014.4.8
 */

class Goods extends U_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('category_m', 'goods_m', 'shop_m', 'user_m'));
		$this->load->library(array('session', 'cart', 'encrypt'));
		$this->load->helper(array('input', 'page'));
		// 预加载了'url', 'form', 'cookie', 'date', 'input' helper
	}

	/**
	 * 显示单个商品的信息
	 */
	public function index()
	{
		$goods_id = (int) get('goods_id');

		$data['goods_id'] = $goods_id;
		$data['shop_id'] = (int) cookie('shop_id');
		$data['goods']	= $this->goods_m->get($goods_id);

		if ($data !== NULL) {
			$this->load->view('user/goods_info', $data);
		} else {
			redirect('user/supermarket');
		}
	}

	/**
	 * 由goods_id显示商品信息
	 */
	public function info()
	{
		$goods_id = (int) get('goods_id');

		$data['goods_id'] = $goods_id;
		$data['shop_id'] = (int) cookie('shop_id');
		$data['goods']	= $this->goods_m->get($goods_id);

		if ($data !== NULL) {
			$this->json_out($data);
		}
	}

	/**
	 * 页面初始化
	 */
	private function _page_init($per_page)
	{

	}

	/**
	 * 该商家下分页显示模糊搜索结果
	 */
	public function search()
	{
		$keyword	=	get('keyword');
		$shop_id	=	(int) get('shop_id');

		$per_page	=	10;						// 每页显示10项
		$p			=	page_cur();				// get('p') 获取当前分页页码

		$data['keyword']	=	$keyword;
		$data['goods']		=	$this->goods_m->get_fuzzy($keyword, $shop_id, $per_page, $per_page*($p-1) );

// 		$this->load->view('user/goods_search', $data);
		$this->json_out($data);
	}

	/**
	 * 添加到购物车
	 */
	public function add_cart()
	{

	}
}
