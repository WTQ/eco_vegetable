<?php
/**
 * 用户模型层
 * 
 * @author		莫迟
 * @copyright	Copyright (c) 2014. 云帆工作室.
 * @since		Version 1.0
 */

class User_m extends MY_Model 
{
	protected $_table		= 'users';
	protected $primary_key	= 'user_id';
	
	function __construct() {
		parent::__construct();
	}
	
	/**
	 * 首先判断user数据表中是否有该手机号
	 * 1.如果有则检查cookie中的token与User数据表中的token是否相同，若相同则登录成功
	 */
	public function login() {
		// 从COOKIE中取出用户手机
		$phone = $this->input->cookie('phone');
		if($phone) {
			$user = $this->get_byph($phone);
			if (isset($user->token)) {
				$c_token = $this->input->cookie('token');
				if ($user->token == $c_token) {
					return $user;
				}
			}
		}
		return FALSE;
	}
	
	public function login_phone($phone, $password) 
	{
		$user = $this->get_byph($phone);
		
		if (isset($user->user_id)) {
			$password =md5(md5($password) . $user->salt);
			if ($user->password != $password) {
				return FALSE;
			}
			
			// 设置token更新的方式
			$token = $user->token;
			if (strlen($token) < 32) {
				// 生成token
				$salt = rand(100000, 999999) ;
				$token = md5(md5(time() . $salt));
			
				// 更新token
				$this->update($user->user_id, array('token' => $token));
			}
			
			// 设置cookie
			set_cookie('phone', $phone, 86500 * 365 * 10);
			set_cookie('token', $token, 86500 * 365 * 10);
			
			return TRUE;
		}
		return FALSE;
	}
	
	public function logout() 
	{
		set_cookie('phone', '', -1);
		set_cookie('token', '', -1);
	}
	
	/**
	 * 按照手机号获取用户信息
	 */
	public function get_byph($phone) {
		return $this->get_by('phone', $phone);
	}

	/**
	 * 按照手机号获取用户ID
	 */
	public function phone2id($phone) {
		$user = $this->get_by('phone', $phone);
		if ( isset($user->user_id)) {
			return $user->user_id;
		} else {
			return FALSE;
		}
	}
	
	/**
	 * 添加用户
	 */
	public function add($phone, $pwd) {	
		$username	= $phone;								// 用户名同手机号
		$salt		= $this->_make_salt();
		$password	= $this->_make_password($pwd, $salt);	// 加盐后的密码
// 		$salt		= rand(100000, 999999);
		$token		= (md5(md5(time() . $salt)));
		$data		= array(
				'username'	=>	$username,
				'phone'		=>	$phone,
				'token'		=>	$token,
				'salt'		=>	$salt,
				'password'	=>	$password,					// 加盐后的密码
		);
		
		$user_id = $this->insert($data);
	
		// 数据库操作失败
		if (!$user_id) {
			return -2;
		}

		//在用户浏览器cookie中设置手机号与token
		set_cookie('phone', $phone, 86500 * 365 * 10);
		set_cookie('token', $token, 86500 * 365 * 10);

		return $user_id;
	}
	
	/**
	 * 删除用户
	 */
	public function delete($phone) {
		return $this->delete_by('phone', $phone);
	}
	
	/**
	 * 修改用户信息
	 */
	public function modify($phone,$data) {
		return $this->update_by('phone', $data);
	}
	
	/**
	 * 修改用户密码
	 */
	public function edit_password($phone, $password)
	{
		$salt = $this->_make_salt();
		$password = $this->_make_password($password, $salt);
	
		$data = array(
				'password'	=> $password,
				'salt'		=> $salt,
		);
	
		$where = array(
				'phone'	=> $phone,
		);
		return $this->db->where($where)->update('users', $data);
	}
	
	/**
	 * 按照用户ID获取用户名
	 */
	public function get_byid($id) {
		$user = $this->get_by('user_id', $id);
		return $user->username;
	}
	/**
	 * 统计用户数量
	 */
	public function count()
	{
		return $this->db->count_all_results('yf_users');
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