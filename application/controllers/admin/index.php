<?php
/**
 * 管理员后台首页控制器
 * 
 * @author 风格独特
 * @version 1.0 2014-04-28
 */

class Index extends A_Controller 
{
	public function __construct() 
	{
		parent::__construct();
	}
	
	public function index() 
	{
		load_view('admin/index');
	}
}