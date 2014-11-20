<?php
/**
 * 用户密码管理控制器
 * 
 * @author 风格独特
 * @version 1.0, 2014-10-14
 */

class Password extends U_Controller 
{
	public function __construct() 
	{
		parent::__construct();
		load_model('user_m');
		$this->load->library(array('session', 'cart', 'encrypt'));
	}
	
	/**
	 * 发送修改密码验证码
	 */
	public function code() 
	{
		//load_library('sms_189cn');
		// 载入短信验证的helper
		load_helper('yuntongxun');		
		
		$phone = get('phone');
		
		// 判断该号码是否已注册
		$user = $this->user_m->get_byph($phone);
		if (!isset($user->user_id)) {
			$data = array(
				'error' => 1,
				'msg'	=> '该手机还未注册',
			);
			return $this->json_out($data);
		}
		
		// 三分钟内只能发一条验证短信
		if (time() - 180 < (int) $this->session->userdata('pw_time')) {
			$data = array(
				'error' => 2,
				'msg'	=> '验证码发送频繁',
			);
			return $this->json_out($data);
		}
		
		// 生成验证码和session
		$phone_verify = rand(100000, 999999);
		$verify = array(
			'pw_phone'		=> $phone,
			'pw_code'		=> $phone_verify,
			'pw_time' 		=> time(),
		);
		$this->session->set_userdata($verify);
		
		// 发送验证码
		$body[] = $phone_verify . '';
		//$body = array('code' => $phone_verify);
		//if ($this->sms_189cn->send_temp_sms($phone, $body, 'password_reset') != TRUE) {
		if (send_temp_sms($phone, $body) != TRUE) {
			$data = array(
				'error'	=> 3,
				'msg'	=> '验证码发送失败',
			);
			return $this->json_out($data);
		}
		
		$data = array(
			'error'	=> 0,
		);
		return $this->json_out($data);
	}
	
	/**
	 * 找回密码操作
	 */
	public function find() 
	{
		$code = get('code');
		$phone = get('phone');
		$password = get('password');
		
		// 判断该号码是否已注册
		$user = $this->user_m->get_byph($phone);
		if (isset($row->user_id)) {
			$data = array(
					'error' => 1,
					'msg'	=> '该手机还未注册',s
			);
			return $this->json_out($data);
		}
		
		// 判断验证手机是否匹配
		if ($phone != $this->session->userdata('pw_phone')) {
			$data = array(
				'error'	=> 2,
				'msg'	=> '验证手机不匹配',
			);
			return $this->json_out($data);
		}
		
		// 判断验证码是否超期
		if ((time() - 180) > $this->session->userdata('pw_time')) {
			$data = array(
				'error'	=> 3,
				'msg'	=> '验证码已经过期',
			);
			return $this->json_out($data);
		}
		
		// 判断雅正吗是否相等
		if ($code != $this->session->userdata('pw_code')) {
			$data = array(
				'error'	=> 4,
				'msg'	=> '验证码不正确',
			);
			return $this->json_out($data);
		}
		
		// 判断密码长度是否在6-15位之间
		if (strlen($password) < 6 || strlen($password) > 15) {
			$data = array(
				'error'	=> 5,
				'msg'	=> '密码长度应为6-15位',
			);
			return $this->json_out($data);
		}
		
		// 密码修改失败
		if ($this->user_m->edit_password($phone, $password) == FALSE) {
			$data = array(
				'error'	=> 6,
				'msg'	=> '修改密码失败',
			);
			return $this->json_out($data);
		}
		
		$data = array(
			'error'	=> 0,
		);
		return $this->json_out($data);
	}
}