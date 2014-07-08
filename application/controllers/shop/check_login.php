<?php
/**
 * 单独验证登录函数 
 * 
 * @package		o2o_supermarket
 * @author		风格独特
 * @copyright	Copyright (c) 2014. 云帆工作室.
 * @version		Version 1.0
 */

class Check_login extends S_Controller 
{
	public function __construct() 
	{
		parent::__construct();
	}
	
	public function index() 
	{
		$data['shop_id'] = $this->get_shopid();
		$this->json_out($data);
	}
}