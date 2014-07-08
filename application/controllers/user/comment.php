<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 买家评论控制类
 *
 * @package		o2o_supermarket
 * @author 		lp1900
 * @copyright	Copyright (c) 2014. 云帆工作室.
 * @version		Version 1.0
 * @since		2014.4.8
 */

class Comment extends U_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('comment_m', 'shop_m', 'user_m', 'order_m'));
	}
	
	/**
	 * 评论起始页
	 */
	public function index()
	{
		
	}
	
	/**
	 * 发表评论
	 */
	public function add()
	{
	
	}
	
	/**
	 * 修改评论
	 */
	public function modify()
	{
		
	}
	
	/**
	 * （软）删除评论
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
	
	public function save()
	{
		$community_id = $this->input->cookie("community_id");
		$shop_id = $this->zone_community_m->get_shops($community_id);	
		$user_id = $this->input->cookie("user_id");
		$content = get("content");
		$type = get("type");
		
		$data = array(
			"shop_id" =>  $shop_id,
			"user_id" =>  $user_id,
			"content" =>  $content,
			"time"    =>  time(),
			"type"    =>  $type,
		);
		
		$this->comment_m->insert($data);
	}
}