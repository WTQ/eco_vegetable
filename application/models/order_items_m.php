<?php
/**
 * 订单子项模型层
 * 
 * @package		o2o_supermarket
 * @author		莫迟
 * @copyright	Copyright (c) 2014. 云帆工作室.
 * @since		Version 1.0
 */

class Order_items_m extends MY_Model 
{
	protected $_table		= 'order_items';
	
	protected $primary_key	= 'item_id';
	
	function __construct() 
	{
		parent::__construct();
	}

	/**
	 * 添加订单子项
	 */
	public function add($data)
	{
		return $this->insert($data);
	
	}
	
	/**
	 * 删除订单子项
	 */
	public function del($item_id) {
		return $this->delete_by('item_id', (int)$item_id);
	}
}