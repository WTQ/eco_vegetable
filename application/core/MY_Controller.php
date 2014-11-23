<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 扩展 Controller 类
 * 
 * 设置默认编码为 utf-8
 * 设置默认时区为东八区
 * 加入站点标题全局常量 __TITLE__
 * 加入资源全局常量 __RESOURCES__
 * 加入公共样式全局常量 __COMMON_STATIC__
 * 加入上传文件全局常量 __UPLOADS__
 */
class MY_Controller extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		header('Content-type:text/html; charset=utf-8');
		header('Access-Control-Allow-Origin: *');
		date_default_timezone_set('Asia/Shanghai');
		define('__WEB_ROOT__', rtrim(str_replace("\\", "/", FCPATH), '/'));
		define('__TITLE__', $this->config->item('web_title'));
		define('__RESOURCES__', $this->config->item('base_url') . '/' . $this->config->item('web_resource') . '/');
		// define('__COMMON_STATIC__', $this->config->item('base_url') . '/static/common/');
		define('__UPLOADS__', __WEB_ROOT__ . '/uploads');
	}
	
	/**
	 * 登录显示错误页面
	 * @param string $msg
	 */
	public function pub_msg($msg, $tmp)
	{
		load_vars('pub_msg', $msg);
		load_view($tmp);
		$this->output->_display();
		exit;
	}
	
	/**
	 * json输出数据
	 */
	public function json_out($data) 
	{
		// header('Content-Type:application/json; charset=utf-8');
		
		$callback = get('callback');
		
		if ($callback != FALSE) {
			$jsonp = $callback . '(' . json_encode($data) . ')';
			$this->output->set_output($jsonp);
		} else {
			$this->output->set_output(json_encode($data));
		}
		$this->output->_display();
		exit;
	}
}

/**
 * 用户控制器类
 */
class U_Controller extends MY_Controller
{
	/**
	 * 登录后的手机号码
	 */
	protected $phone = NULL;
	
	/**
	 * 登录后的用户UID
	 */
	protected $user_id = NULL;

	/*
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_m');
		
		// 检查用户登录
		$user = $this->user_m->login();
		if ($user !== FALSE) {
			$this->phone = $user->phone;
			$this->user_id = $user->user_id;
		}
	}
	
	/**
	 * 返回用户的手机号码，当未登录是返回NULL
	 */
	protected function get_phone() {
		return $this->phone;
	}
	
	/**
	 * 返回用户的UID，当未登录是返回NULL
	 */
	protected function get_uid() {
		return $this->user_id;
	}
	
	/**
	 * 验证用户登录
	 */
	protected function check_login()
	{
		$user = new stdClass();
		$this->load->model('user_m');
		if (($user = $this->user_m->login()) !== FALSE) {
			return $user;	// 返回对象形式的用户信息
		} else {
			return FALSE;
		}
	}
}

/**
 * 店铺控制器类
 */
class S_Controller extends MY_Controller
{
	/**
	 * 店铺的shop_id
	 */
	private $shop_id = NULL;
	
	/**
	 * 店铺的username
	 */
	private $username = NULL;
	
	public function __construct()
	{
		parent::__construct();
		load_model('shop_user_m');
		
		// 先验证登录
		$shop_id = $this->shop_user_m->check_login();
		if ($shop_id == FALSE) {
			$data = array(
					'login'	=> '0',
			);
			parent::json_out($data);
		}
		
		$shop 			= $this->shop_user_m->get($shop_id);
		$this->shop_id 	= $shop->shop_id;
		$this->username = $shop->username;
	}
	
	public function get_shopid() 
	{
		return $this->shop_id;
	}
	
	/**
	 * json输出数据
	 */
	public function json_out($data)
	{
		$data = (array) $data;
		
		if (!isset($data['login'])) {
			$data['login'] = 1;
		}
		parent::json_out($data);
	}
}

/**
 * 管理员基础控制器
 * 
 * @author 风格独特
 */
class A_Controller extends MY_Controller 
{
	protected $uid = NULL;
	
	protected $username = NULL;
	
	public function __construct() 
	{
		parent::__construct();
		load_model('admin_user_m');
		
		// 先验证登录
		$uid = $this->admin_user_m->check_login();
		if ($uid == FALSE) {
			redirect('admin/login');
		}
		
		$user 			= $this->admin_user_m->get($uid);
		$this->uid 		= $data['uid']		= $user->uid;
		$this->username = $data['username'] = $user->username;
		$this->power    = $data['power'] = $user->power;
		
		// 往view中传递参数
		load_vars($data);
	}
	
	/**
	 * 获取登录用户的UID
	 */
	public function get_uid() 
	{
		return $this->uid;
	}
	
	/**
	 * 获取登录用户的username
	 */
	public function get_username() 
	{
		return $this->username;
	}
}

/**
 * 商品库操作员基础控制器
 *
 * @author 风格独特
 */
class D_Controller extends MY_Controller
{
	protected $depot_uid 		= NULL;

	protected $depot_username	= NULL;

	public function __construct()
	{
		parent::__construct();
		load_model('depot_user_m');

		// 先验证登录
		$uid = $this->depot_user_m->check_login();
		if ($uid == FALSE) {
			redirect('depot/login');
		}

		$user 					= $this->depot_user_m->get($uid);
		$this->depot_uid 		= $data['depot_uid']		= $user->depot_uid;
		$this->depot_username	= $data['depot_username'] 	= $user->depot_username;

		// 往view中传递参数
		load_vars($data);
	}

	/**
	 * 获取登录用户的UID
	 */
	public function get_uid()
	{
		return $this->uid;
	}

	/**
	 * 获取登录用户的username
	 */
	public function get_username()
	{
		return $this->username;
	}
}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */