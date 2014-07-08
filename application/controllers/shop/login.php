<?php
/**
 * 商家端登录功能
 *
 * @package		o2o_supermarket
 * @author 		
 * @copyright	Copyright (c) 2014. 云帆工作室.
 * @version		Version 1.0
 */

class Login extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		load_model('shop_user_m');
	}
	
	public function index() 
	{
		$check = $this->session->userdata('verifytext');
		$this->session->unset_userdata('verifytext');
		
		$username = get('username');
		$password = get('password', FALSE);
		
		if ($check == FALSE || $check != get('verifytext')) {
			$out = array(
					'login'	=> 0,
					'error'	=> 1,
					'msg'	=> '验证码错误',
			);
			$this->json_out($out);
		}
		
		$shop_id = $this->shop_user_m->login($username, $password);
		if ($shop_id < 0) {
			$out = array(
					'login' => 0,
					'error'	=> 2,
					'msg'	=> '用户名或密码错误',
			);
		} else {
			$out = array(
					'login'	=> 1,
					'error'	=> 0,
			);
		}

		$this->json_out($out);
	}
}