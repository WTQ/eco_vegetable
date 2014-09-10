<?php
/**
 * APP下载
 */

class Get extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		$this->load->view('get');
	}
}