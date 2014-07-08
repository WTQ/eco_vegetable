<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 调试用的控制器
 * 
 * @author 风格独特
 */

class Debug extends CI_Controller 
{
	public function __construct() 
	{
		parent::__construct();
		$this->load->helper(array('load', 'input'));
		$this->load->model(array('comment_m', 'category_m', 'goods_m', 'shop_m'));
	}
	
	public function mytest()
	{
		// $this->load->model('article_type_m');
		// $this->load->model('article_m');
		// $this->article_m->add('清明节放假团购通知',2,'aaa','Kung');
		// $this->article_m->add('北京各大高校区招聘啦~~',2,'aaa','Kung');
		// $this->article_m->add('吾家店校园团购网招商令',2,'aaa','Kung');
		// var_dump($this->article_m->get_list(1));
		// $this->load->model('zone_community_m');
		// $result = $this->zone_community_m->get_search('西', 5);
		// var_dump($result);
		// $this->load->model('shop_m');
		// $data = array(
		// 	'community_id'  =>  11,
		// 	'shop_char'     =>  'daily life',
		// 	'name'          =>   '日用品',
		// );
		// $this->shop_m->add($data);
		 $this->load->model('order_m');
		 $data = array(
		 	"add_time"         =>  "1398552697",
		 	"address"          =>  "华鼎世家小区",
		 	"phone"            =>  "123456789",
		 	"total_prices"     =>  "123456789",
		 	"stage"            =>  "1",
		 	"phone"            =>  "123456789",
		 	"shop"             =>  "1",
		 );
		 $this->order_m->add($data);

		// $this->zone_community_m->add('国美第一城', 6);
		// $this->zone_community_m->add('天通苑西三区', 6);
		// $this->zone_community_m->add('育新花园', 6);
	}
	
	public function index()
 	{
 		//setcookie('community_id', '5', time() + 3600 * 24, '/');
 		//setcookie('address', urlencode('21#楼17层1703'), time() + 3600 * 24, '/');
 		//setcookie('user_id', 1, time() + 3600 * 24, '/');
 		
 		// 设置登录
 		load_model('user_m');
 		$this->user_m->login_phone('18810338888');
 		// $this->user_m->logout();
 		
 		//echo md5('000000');exit;
// 		$data['a'] = 'aaaaaaaa';
// 		$data['b'] = 'bbbbbbbbbb';
// // 		load_view(array('a', 'b'), $data);
// 		load_library('curl');
// 		load_helper('yuntongxun');

 		
//  		load_library('captcha_np');
//  		$this->captcha_np->setStyle(1);
//  		$this->captcha_np->setBgColor(array(255, 255, 255));
//  		$this->captcha_np->setFontColor(array(0, 102, 204));
//  		$str = $this->captcha_np->getStr();
//  		$array = array('check' => $str);
//  		$this->session->set_userdata($array);
//  		$this->captcha_np->display();
 		

//  		load_helper('captcha');
 		
//  		$data = array(    
//  				'img_path' => './captcha/',
//     			'img_url' => '/captcha/',
//     			'img_width' => '150',
//     			'img_height' => 30,
//  		);
 		
//  		$cap = create_captcha($data);
 		
//  		var_dump($cap);
		
		// var_dump(send_sms('13488681605', '中文测试'));
		
// 		$data = array('888888');
// 		var_dump(send_temp_sms('15210579218', $data));
		
// 		$this->curl->out_header();
// 		var_dump( $this->curl->post('aaa=1&bbb=2','http://t.te168.cn/'));
		
// 		var_dump($this->curl->getinfo());

	}
	
	public function cmt_add()
	{
		$a = $this->comment_m->add('good', 'Jim', 'good job');
	}
	
	public function cmt_reply()
	{
		$this->comment_m->reply(1, '谢谢惠顾');
	}
	
	public function cmt_modify()
	{
		
	}
	
	public function cmt_get()
	{
		$data = $this->comment_m->get_cmt(1);
		var_dump($data);
	}
	
	public function sub_cmt_get()
	{
		$data = $this->comment_m->get_sub(1);
		var_dump($data);
	}
	
	public function num_get()
	{
		var_dump($this->comment_m->get_num());
	}
	
	public function shop_get()
	{
		var_dump($this->comment_m->get_shop(0));
	}
	
	// 分类测试
	public function class_add()
	{
		$ret = $this->category_m->add(0, '饮品');
		var_dump($ret);
	}
	
	public function class_modify()
	{
		$ret = $this->category_m->modify(1, '饮品类');
		var_dump($ret);
	}
	
	public function get_all_class()
	{
		$ret = $this->category_m->get_all();
		var_dump($ret);
	}
	
	public function name_get()
	{
		$ret = $this->category_m->get_name(1);
		var_dump($ret);
	}
	
	public function getbyname()
	{
		$this->load->model('goods_m');
		$ret = $this->goods_m->get_num(1, 1);
		var_dump($ret);
	}
	
	/**
	 * goods_m模型层测试部分
	 */
	public function test()
	{
		var_dump($this->goods_m->today_recommend());
	}
	
	public function add_img()
	{
		$this->load->model('img_m');
		$data = array(
				'goods_id'	=>	'1',
				'pic1'		=>	'bbbb',
				'pic2'		=>	'cccc',
				'pic3'		=>	'dddd',
				'pic4'		=>	'eeee',
				'pic5'		=>	'ffff',
		);
		$this->img_m->add_img($data);
	}
	/**
	 * 测试图片的json_decode
	 */
	public function pic_decode()
	{
		$this->load->model('goods_m');
		$goods = $this->goods_m->get(8);
		$pic = $this->goods_m->pic_dejson($goods->pic);
// 		$pic_2 = $this->goods_m->pic_dejson($pic->more);
		var_dump($pic->more->pic1);
	}
	public function path()
	{
		$path = "/testweb/test.txt";
		print_r(pathinfo($path, PATHINFO_EXTENSION));
	}
	
	/**
	 * 添加优惠券
	 */
	public function add_coupon()
	{
		$this->load->model('coupon_m');
		$content = $this->coupon_m->coupon_json(100, 8.5, 0, '');
		$arr = array(
			'shop_id' => 1,
			'content' => $content,
		);
		$this->coupon_m->add_coupon($arr);
	}
	
	/**
	 * 解析coupon
	 */
	public function decode_coupon()
	{
		$this->load->model('coupon_m');
		var_dump($this->coupon_m->get_reduce(1));
	}
}