<?php
/**
 * User端手机登陆控制器
 */

class Login extends U_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model( array('user_m', 'address_m', 'shop_m', 'zone_community_m'));
	}

	public function index()
	{
		$phone    = get('phone');
		$password = get('password', FALSE);

		if ($this->user_m->login_phone($phone, $password)) {
			$user_id      = $this->user_m->phone2id($phone);
			//$address      = $this->address_m->get_default($user_id)->name;			// 获取用户的地址
			// 将用户所在的小区、地址和商家id存储到cookie
			//set_cookie('address', $address, 3600 * 24 * 365);
			$shop_id = 1;
			set_cookie('shop_id', $shop_id, 3600 * 24 * 365);
			$data = array(
				'login'        => 1,
				'user_id'      => $user_id,
				'phone'        => $phone,
				//'address'      => $address,
				'shop_id'      => $shop_id
			);
			$this->json_out($data);
		} else {
			$data['login'] = 0;
			$this->json_out($data);
		}
	}
}
