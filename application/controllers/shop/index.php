<?php
/**
 * 商家端主页
 *
 * @package		o2o_supermarket
 * @author
 * @copyright	Copyright (c) 2014. 云帆工作室.
 * @version		Version 1.0
 */

class Index extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function index() 
	{
		load_view('shop/main');
	}
}