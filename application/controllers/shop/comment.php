<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Shop端评论控制类
 *
 * @package		o2o_supermarket
 * @author 		lp1900
 * @copyright	Copyright (c) 2014. 云帆工作室.
 * @version		Version 1.0
 * @since		2014.4.8
 */

class Comment extends S_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('comment_m', 'shop_m', 'user_m', 'order_m'));
	}
	
	public function index()
	{
		
	}
	
	/**
	 * 卖家回复
	 */
	public function add()
	{
		
	}
	
	/**
	 * 修改回复
	 */
	public function modify()
	{
		
	}
	
	/**
	 * （软）删除回复
	 */
	public function delete()
	{
		
	}
	
	/**
	 * 显示当前卖家的所有评论
	 */
	public function shop_cmt()
	{
		
	}
	
	/**
	 * 显示当前商品的所有评论
	 */
	public function goods_cmt()
	{
		
	}
}