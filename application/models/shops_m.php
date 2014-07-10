<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 店铺处理模型层
 * 
 * @author 风格独特
 */

class Shops_m extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function get($shop_id=1)
	{
		$shop_id = (int) $shop_id;
		$this->db->where('shop_id', $shop_id);
		$query = $this->db->get('shops');
		if($query->num_rows() > 0) {
			return $query->row_array();
		}
		return FALSE;
	}
	public function get_name($shop_id)
	{
		$shop_id = (int) $shop_id;
		$this->db->where('shop_id', $shop_id);
		$query = $this->db->get('shops');
		if($query->num_rows() > 0) {
			 $result = $query->row_array();
			 return $result['shop_name'];
		}
		return FALSE;
	}
	public function get_char($shop_id)
	{
		$shop_id = (int) $shop_id;
		$this->db->where('shop_id', $shop_id);
		$query = $this->db->get('shops');
		if($query->num_rows() > 0) {
			$result = $query->row_array();
			return $result['shop_char'];
		}
		return FALSE;
	}
	
	public function is_run($shop_char)
	{
		$shop_char = strtoupper($shop_char);
		$this->db->select('is_run');
		$this->db->where('shop_char', $shop_char);
		$query = $this->db->get('shops');
		if($query->num_rows() > 0) {
			$data = $query->row_array();
			return $data['is_run'];
		}
		
		return -1; //无该店铺
	}
	
	public function views_add($shop_id, $num = 1 )
	{
		$shop_id = (int) $shop_id;
		$shop = $this->get($shop_id);
		$view_today = $shop['view_today'] + $num;
		$view_all = $shop['view_all'] + $num;
		$data=array('view_today'=>$view_today, 'view_all'=>$view_all);
		$this->db->where('shop_id', $shop_id);
		if($this->db->update('shops', $data) === FALSE) {
			return FALSE;
		}
		return TRUE;
	}
	
	public function get_by_char($shop_char)
	{
		$this->db->where('shop_char', strtoupper($shop_char));
		$query = $this->db->get('shops');
		if($query->num_rows() > 0) {
			return $query->row_array();
		}
		return FALSE;
	}
	
	public function shop_char2id($shop_char)
	{
		$this->db->select('shop_id')->where('shop_char', strtoupper($shop_char));
		$query = $this->db->get('shops');
		if($query->num_rows() > 0) {
			$result =  $query->row_array();
			return $result['shop_id'];
		}
		return FALSE;
	}
	public function shop_id2char($shop_id)
	{
		$this->db->select('shop_char')->where('shop_id', $shop_id);
		$query = $this->db->get('shops');
		if($query->num_rows() > 0) {
			$result =  $query->row_array();
			return $result['shop_char'];
		}
		return FALSE;
	}
	public function get_all()
	{
		$this->db->order_by('order ASC');
		$query = $this->db->get('shops');
		if($query->num_rows() > 0) {
			return $query->result_array();
		}
		return array();
	}
	
	public function get_list($num = 4, $offset = 0)
	{
		$query = $this->db->get('shops', $num, $offset);
		if($query->num_rows() > 0) {
			return $query->result_array();
		}
		return array();
	}
	public function add($data)
	{
		if($this->db->insert('shops', $data) === FALSE) {
			return FALSE;
		}
		return $this->db->insert_id();
	}
	
	public function edit($shop_id, $data)
	{
		$id = (int) $id;
		$this->db->where('shop_id', $shop_id);
		if($this->db->update('shops', $data) === FALSE) {
			return FALSE;
		}
		return TRUE;
	}
	
	public function del($shop_id)
	{
		$id = (int) $shop_id;
		$this->db->where('shop_id', $id);
		if($this->db->delete('shops') === FALSE) {
			return FALSE;
		}
		return TRUE;
	}
	
	public function get_num()
	{
		return $this->db->count_all_results('shops');
	}
	
}