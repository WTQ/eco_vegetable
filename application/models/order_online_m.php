<?php
/**
 * 订单流水模型层
 */

class Order_online_m extends MY_Model
{
	protected $_table		= 'order_online';

	protected $primary_key	= 'flow_id';

	public function __construct()
	{
		parent::__construct();
		$this->load->model( array('order_m', 'user_m', 'shop_m'));
	}

	/**
	 * 由flow_id查询商品信息，返回对象
	 * 调用MY_Model中get($flow_id)
	 */

	/**
	 * 由flow_id查询全部信息，返回对象
	 * 调用My_Model中get_all()
	 */
	
	/**
	 * 创建新流水
	 */
	public function add_flow()
	{

	}
}
