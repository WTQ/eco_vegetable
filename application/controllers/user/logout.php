<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 注销函数
 * 
 * @package		o2o_supermarket
 * @author mm
 * @copyright	Copyright (c) 2014. 云帆工作室.
 * @version 1.0 2014-07-23
 */
 
class Logout extends U_Controller {

	public function __construct()
	{
		parent::__construct();
	}
	/**
	 * 退出登录
	 */
	public function index()
	{
		set_cookie('shop_id', '', -1);
		//set_cookie('address','',-1);
		set_cookie('phone','',-1);
		$data['login'] = 0;
		$this->json_out($data);
	}
}