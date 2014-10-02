<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 支付宝流水 Model层
 */
class Alipay_m extends MY_Model
{
	protected $_table      = 'order_online';
	
	protected $primary_key = 'flow_id';

	public function __construct()
	{
		parent::__construct();

		$this->load->model( array('category_m', 'order_m', 'user_m', 'shop_m'));
	}

	/**
	 * 获取支付请求
	 */
	public function get_req($order_id=0)
	{
		require_once(APPPATH.'third_party/alipay/alipay_submit.class.php');
		// 获取订单信息
		$order;
		if ( isset($order->order_id)) {
			$this->config->load('alipay_config', TRUE);
			$alipay_config = $this->config->item('alipay_config');
		}
	}

	/**
	 * 创建新流水
	 */
	public function add_flow($data)
	{
		return $this->insert($data);
	}

	public function get_by()
	{

	}
}
