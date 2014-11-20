<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 手机验证控制器
 *
 * @package		o2o_supermarket
 * @author		莫迟，lp1900
 * @copyright	Copyright (c) 2014. 云帆工作室.
 * @version		Version 1.1
 * @since		2014.4.17
 */
class Phone extends U_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('address_m');
		$this->load->library(array('session', 'cart', 'encrypt'));
		// 预加载了'url', 'form', 'cookie', 'date', 'input' helper
	}

	/**
	 *  TODO
	 */
	public function index()
	{
	}

	/**
	 * 验证用户手机号码
	 *
	 * TODO 发送短信的安全性，phone的检验，如何防止恶意发送短信验证码
	 */
	public function verify()
	{
		// 载入短信验证的helper
		load_helper('yuntongxun');

		$phone         = get('phone');
		$data['error'] = 0;

		// 生成验证码和session
		$phone_verify = rand(100000, 999999);
		$verify       = array(
			'phone_send'        => $phone,
			'phone_verify'      => $phone_verify,
			'phone_verify_time' => time(),
		);
		$this->session->set_userdata($verify);

		// 发送验证码
		$body[] = $phone_verify . '';
 		if (send_temp_sms($phone, $body) != TRUE) {
 			$data['error'] = 1;							// 错误码
 		}
		$data['error']        = 0;
		$data['phone_verify'] = $phone_verify;
		$this->json_out($data);
	}

	/**
	 * 检查验证码的正误
	 */
	public function check_verify()
	{
		$verify = get('verify');
		$data = array();

		if ($verify == $this->session->userdata('phone_verify')) {
			$data['check_verify'] = TRUE;
		} else {
			$data['check_verify'] = FALSE;
		}

		$this->json_out($data);
	}

	/**
	 * 检查密码的正误
	 */
	public function check_pwd()
	{
		$pwd_1	= get('pwd_1');
		$pwd_2	= get('pwd_2');
		$data	= array();

		if ($pwd_1 === $pwd_2) {
			$data['check_pwd'] = TRUE;
		} else {
			$data['check_pwd'] = FALSE;
		}

		$this->json_out($data);
	}

	/**
	 * 云通讯平台的回调地址
	 */
	public function cb()
	{

	}
}
