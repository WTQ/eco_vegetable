<?php
/**
 * 登录控制器
 * 
 * @author 风格独特
 * @version 1.0 2014-4-28
 */

class login extends A_Controller 
{
	public function __construct() 
	{
		MY_Controller::__construct();
		load_model('admin_user_m');
		// 先验证登录
		$uid = $this->admin_user_m->check_login();
		
		if ($uid > 0) {
			redirect('admin');
		}
	}
	
	public function index() 
	{
		if (is_post()) {
			$this->_login();
		} else {
			load_view('admin/login');
		}
	}
	
	/**
	 * 验证码图片生成
	 * 
	 * TODO 需要加上header防止缓存
	 */
	public function captcha() 
	{
		load_library('captcha_np');
		$this->captcha_np->setStyle(1);
		$this->captcha_np->setBgColor(array(0, 23, 33));
		$this->captcha_np->setFontColor(array(255, 255, 235));
		
		$this->session->set_userdata('admin_img_check', $this->captcha_np->getStr());
		$this->captcha_np->display();
	}
	
	/**
	 * 登录的控制器
	 */
	private function _login() 
	{
		/*$img_check = $this->session->userdata('admin_img_check');
		$this->session->unset_userdata('admin_img_check');
		
		if ($img_check == FALSE || $img_check != post('admin_img_check')) {
			$this->pub_error('验证码错误');
		}*/
		
		$uid = $this->admin_user_m->login(post('username'), post('password'));
		if ($uid < 0) {
			$this->pub_error('用户名或者密码错误');
		}
		
		redirect('admin');
	}
	
	/**
	 * 登录显示错误页面
	 * @param string $msg
	 */
	private function pub_error($msg) 
	{
		load_vars('error', $msg);
		load_view('admin/login');
		$this->output->_display();
		exit;
	}
}
