<?php
/**
 * 管理员退出登录
 * 
 * @author 风格独特
 * @version 1.0 2014-04-28
 */

class Logout extends D_Controller 
{
	public function __construct() 
	{
		parent::__construct();
	}
	
	public function index()
	{
		$this->depot_user_m->logout();
		redirect('depot/');
	}
}