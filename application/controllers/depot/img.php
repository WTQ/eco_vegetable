<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 商品图片库管理控制器
 *
 * @package		o2o_supermarket
 * @author 		lp1900
 * @copyright	Copyright (c) 2014. 云帆工作室.
 * @version		Version 1.0
 * @since		2014.5.13
 */

class Img extends D_Controller
{
	public function __construct()
	{
		parent::__construct();
		load_model( array('shop_m', 'goods_m', 'category_m', 'coupon_m', 'img_m', 'goods_db_m') );
		load_helper('page');
		$this->load->library('uploader_ue', 'session');
	}
	
	/**
	 * 显示图片库首页
	 */
	public function index()
	{
		load_view('depot/img');
	}
}