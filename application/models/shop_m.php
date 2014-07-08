<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 商品管理模型层
 *
 * @author Kung
 */

class Shop_m extends MY_Model
{
	protected $_table = 'shops';	
	
	protected $primary_key = 'shop_id';
	
	function __construct()
	{
		parent::__construct();
		
		// 加载区域模型层
		$this->load->model('zone_community_m');
	}
	
	/*
	 * 店铺用户登录
	 */
	public function login() {
		
	}
	
	
	public function get_name($shop_id)
	{
		$shop_id = (int) $shop_id;
		$query = $this->get($shop_id);
		if($query)	{
			return $query->name;
		}
		return FALSE;
	}
	
	public function get_char($shop_id)
	{
		$shop_id = (int) $shop_id;
		$query = $this->get($shop_id);
		if ($query)	{
			return $query->shop_char;
		}
		return FALSE;
	}
	
	public function is_run($shop_id)
	{	
		$shop_id = (int) $shop_id;
		$query = $this->get($shop_id);
		if($query) {
			$shop_hours = $query->shop_hours;
			$arr = json_decode($shop_hours);
			$time = time();
			$date = date("Y-m-d ", $time);
			$start = $date.$arr->start_time.':00';	// 添加秒
			$close = $date.$arr->close_time.':00';	// 添加秒
						
			if ( ($time >= strtotime($start)) && ($time <= strtotime($close)) ) {
				return TRUE;
			}
			return FALSE;
		}			
	}
	
	/**
	 * 营业时间JSON解码
	 */
	public function time_decode($shop_id)
	{
		$shop_id = (int) $shop_id;
		$query = $this->get($shop_id);
		if ($query) {
			$shop_hours = $query->shop_hours;
			$arr = json_decode($shop_hours);
			return $arr;
		}
	}
	
	/**
	 * 通过community_id查询yf_zone_community数据表
	 * 返回对象
	 */
	public function get_community($shop_id)
	{
		$shop_id		= (int) $shop_id;		
		$community_id	= (int) $this->get($shop_id)->community_id;
				
		return $this->zone_community_m->get($community_id);
	}
	
	public function get_by_char($shop_char) 
	{
		$query = $this->get_by('shop_char', $shop_char);
		if ($query) {
			return $query;
		}
		return FALSE;
	}
	
	public function shop_char2id($shop_char)
	{
		$query = $this->get_by('shop_char', $shop_char);
		if($query) {
			return $query->shop_id;
		}
		return FALSE;
	}
	
	public function shop_id2char($shop_id)
	{
		$query = $this->get($shop_id);
		if($query) {
			return $query->shop_char;
		}
		return FALSE;
	}
	
	public function get_list($num = 4, $offset = 0)
	{
		$query = $this->db->get('shops', $num, $offset);
		if($query->num_rows() > 0) {
			return $query->result_array();
		}
		return array();
	}
	
	public function time_format($start_time='', $close_time='') 
	{
		$arr = array(
			'start_time'	=> $start_time,
			'close_time'	=> $close_time,
		);
		$time = json_encode($arr);
		
		return $time;
	}
	
	public function add($data)
	{
		return $this->insert($data);
	}
	
	public function edit($shop_id, $data)
	{
		return $this->update($shop_id, $data);
	}
	
	public function del($shop_id)
	{
		return $this->delete($shop_id);	
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


