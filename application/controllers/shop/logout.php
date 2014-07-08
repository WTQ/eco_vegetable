<?php
/**
 * 商家端退出登录功能
 *
 * @package		o2o_supermarket
 * @author
 * @copyright	Copyright (c) 2014. 云帆工作室.
 * @version		Version 1.0
 */

class Logout extends S_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->shop_user_m->logout();
		$out = array(
				'login'	=> 0,
		);
		$this->json_out($out);
	}
}