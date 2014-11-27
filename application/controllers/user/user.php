<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 买家端用户信息控制器
 *
 * @package		o2o_supermarket
 * @author		莫迟，lp1900
 * @copyright	Copyright (c) 2014. 云帆工作室.
 * @version		Version 1.1
 * @since		2014.4.17
 */
class User extends U_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model( array('user_m', 'address_m', 'zone_community_m'));
		$this->load->library( array('session', 'cart', 'encrypt'));
	}

	/**
	 * 显示我的小卖部
	 */
	public function index()
	{
		$this->load->view('user/myinfo');
	}

	/**
	 * 显示用户信息
	 */
	public function show_info()
	{
		if (($data = $this->check_login()) !== FALSE) {
			$this->load->view('user/用户信息页面', $data);	// TODO
			return TRUE;
		} else {
			redirect('user/myinfo');	// TODO
			return FALSE;
		}
	}

	/**
	 * 获取用户信息
	 */
	public function get_info()
	{
		// 验证登录成功则返回对象形式用户信息，否则FALSE
		return $this->check_login();
	}

	/**
	 * 添加新用户
	 */
	public function add_user()
	{
		$phone          = get('phone');
		$pwd            = get('password');
		$user           = $this->user_m->get_byph($phone);

		// 需要检查手机号码是否重复注册
		if (isset($user->user_id)) {
			// 该手机已注册
			$data['error'] = 1;
		} else {
			$user_id            = $this->user_m->add($phone, $pwd);
			// TODO 注意，此时用户尚未填写配送地址，address字段为空
			$address_id         = $this->address_m->add_address($user_id);
			$data = array(
				'user_id'        => $user_id,
				'phone'          => $phone,
				'address_id'     => $address_id,
				'user'           => $this->user_m->get($user_id),
				'error'          => 0
			);
/*			$data['user_id']	= $user_id;
			$data['address_id'] = $address_id;
			$data['user']       = $this->user_m->get($user_id);
			$data['error']      = 0;*/
		}

		$this->json_out($data);
	}

	/**
	 * 编辑用户信息
	 */
	public function edit_info()
	{
		$data = array();

		if ($this->check_login() !== FALSE) {
			$data = array(
				'username'	=>	post('username'),
				'phone'		=>	post('phone'),
				'address'	=>	post('address'),
			);
			$this->user_m->modify($this->check_login()->phone, $data);
		} else {
			redirect('user/shop');
		}
	}

	/**
	 * 返回用户信息
	 */
	public function user_info()
	{
		if ($this->check_login()) {
 			$user_id = $this->user_m->phone2id($this->get_phone());

 			$result['login'] = 1;
 			$result['address'] = $this->address_m->get_by_uid($user_id);
 			$result['phone'] = $this->input->cookie('phone');

 			$this->json_out($result);
		} else {
			$result['login'] = 0;
			$this->json_out($result);
		}
	}
}
