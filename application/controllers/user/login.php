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
			$address      = $this->address_m->get_default($user_id)->name;			// 获取用户的地址
			$community_id = $this->address_m->get_default($user_id)->community_id;
			$shop_id      = $this->zone_community_m->get_shops($community_id);		// 查询该小区下的shop_id
			// 将用户所在的小区、地址和商家id存储到cookie
			set_cookie('community_id', $community_id, 3600 * 24 * 365);
			set_cookie('address', $address, 3600 * 24 * 365);
			set_cookie('shop_id', $shop_id, 3600 * 24 * 365);
			$data = array(
				'login'        => 1,
				'user_id'      => $user_id,
				'phone'        => $phone,
				'address'      => $address,
				'community_id' => $community_id,
				'shop_id'      => $shop_id
			);
			$this->json_out($data);
		} else {
			$data['login'] = 0;
			$this->json_out($data);
		}
	}
}
