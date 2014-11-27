<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * User端访问商家首页控制器
 *
 * @package		o2o_supermarket
 * @author 		lp1900
 * @copyright	Copyright (c) 2014. 云帆工作室.
 * @version		Version 1.0
 * @since		2014.4.8
 */

class Shop extends U_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('shop_m', 'goods_m', 'category_m', 'user_m') );
		$this->load->library(array('session', 'cart', 'encrypt') );
		$this->load->helper(array('input', 'page'));
	}

	/**
	 * 显示商家首页
	 */
	public function index()
	{
		$shop_id = (int) get('shop_id');

		$shop = $this->shop_m->get($shop_id);


		if (isset($shop->shop_id)) {
			$data = array(
				'shop_id'		=> $shop_id,
				'shop'			=> $shop,
				'time'			=> $this->shop_m->is_run($shop_id),			// TRUE/FALSE，判断是否营业
				'shop_hours'	=> $this->shop_m->time_decode($shop_id),	// 营业时间JSON解码
				'low_price'		=> $shop->low_price,						// 获取商家起送价
				'goods'			=> $this->goods_m->get_byid($shop_id),		// 获取该商家全部商品信息
				'error'			=> 0,
			);

			$this->json_out($data);
		} else {
			$data = array(
				'error' => 1,
			);
			$this->json_out($data);
		}
	}

	/**
	 * 显示该商家下指定分类的商品列表
	 */
	public function list_goods()
	{
		$shop_id  = (int) get('shop_id');
		$class_id = (int) get('class_id');
		$p        = page_cur();				// 获取当前分页页码
		$per_page = 10;						// 每页显示10项
		
		$shop = $this->shop_m->get($shop_id);

		$data['goods'] = $this->goods_m->get_byclass($shop_id, $class_id, $per_page, $per_page*($p-1));
		$data['low_price'] = $shop->low_price;
		return $this->json_out($data);
	}
}
