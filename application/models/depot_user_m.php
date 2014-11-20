<?php
/**
 * 商品库管理员用户模型层
 * 
 * @author 章健
 * @version 1.0 2014-05-13
 */

class Depot_user_m extends MY_Model
{
	protected $_table = 'db_user';

	protected $primary_key = 'depot_uid';

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * 登录
	 *
	 * @param string $username
	 * @param string $password
	 * @return integer
	 *         -1表示用户名不存在
	 *         -2表示密码错误
	 *         正数表示用户UID
	 */
	public function login($username, $password)
	{
		$user = $this->get_by('depot_username', $username);

		// 判断用户名
		if (!isset($user->depot_uid)) {
			return -1;
		}

		// 判断密码
		$password = $this->_make_password($password, $user->salt);
		if ($user->depot_password != $password) {
			return -2;
		}

		// 设置登录session
		$data = array(
				'depot_uid'			=> $user->depot_uid,
				'depot_username'	=> $user->depot_username,
		);

		$this->session->set_userdata($data);
		return $user->depot_uid;
	}

	/**
	 * 退出登录函数
	 */
	public function logout()
	{
		// 删除登录session
		$data = array(
				'depot_uid'			=> '',
				'depot_username'	=> '',
		);
		$this->session->unset_userdata($data);
	}

	/**
	 * 检查登录函数
	 */
	public function check_login()
	{
		// 获取session中的UID
		$uid = $this->session->userdata('depot_uid');

		if ($uid > 0) {
			return $uid;
		}

		return FALSE;
	}

	/**
	 * 数据库密码生成函数
	 *
	 * @param string $password
	 * @param string $salt
	 * @return string 返回生成的密码
	 */
	private function _make_password($password, $salt = '')
	{
		return md5(md5($password) . $salt);
	}

	/**
	 * salt生成函数
	 *
	 * @param string $len salt的长度
	 */
	private function _make_salt($len = 6)
	{
		$min = pow(10, $len - 1);
		$max = pow(10, $len) - 1;
		return mt_rand($min, $max) . '';
	}
}
