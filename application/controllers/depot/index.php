<?php
/**
 * 商品库后台首页控制器
 * 
 * @author lp1900
 * @version 1.0 2014-05-13
 */

class Index extends D_Controller 
{
	public function __construct() 
	{
		parent::__construct();
	}
	
	public function index() 
	{
		load_view('depot/index');
	}
}