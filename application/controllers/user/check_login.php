<?php
/**
 * 检查登录函数
 * 
 * @author 风格独特
 * @version 1.0 2014-06-09
 */

class Check_login extends U_Controller 
{
	public function index() 
	{
		if ($this->check_login() != FALSE) {
			$data['login'] = 0;
		} else {
			$data['login'] = 1;
		}
		$this->json_out($data);
	}
}