<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 订单物品处理模型层
 * 
 * @author 风格独特
 */

class Order_item_m extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function get($item_id)
	{
		$item_id = (int) $item_id;
		$this->db->where('item_id', $item_id);
		$query = $this->db->get('order_items');
		if($query->num_rows() > 0) {
			return $query->row_array();
		}
		return FALSE;
	}
	
	public function get_items($order_id) 
	{
		$order_id = (int) $order_id;
		$this->db->where('order_id', $order_id);
		$query = $this->db->get('order_items');
		return $query->result_array();
	}
	
	public function get_items_num($order_id)
	{
		$order_id = (int) $order_id;
		$this->db->where('order_id', $order_id);
		$query=$this->db->get('order_items');
		$num = $query->num_rows();
		return $num;
	}
	
	public function add($data)
	{
		if($this->db->insert('order_items', $data) === FALSE) {
			return FALSE;
		}
		return TRUE;
	}
	
	public function edit($item_id, $data) 
	{
		$item_id = (int) $item_id;
		$this->db->where('item_id', $item_id);
		if($this->db->update('order_items', $data) === FALSE) {
			return FALSE;
		}
		return TRUE;
	}
	
	public function del($item_id)
	{
		$item_id = (int) $item_id;
		$this->db->where('item_id', $item_id);
		if($this->db->delete('order_items') === FALSE) {
			return FALSE;
		}
		return TRUE;
	}
	
}