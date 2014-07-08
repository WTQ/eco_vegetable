<?php
/**
 * 商家端订单处理
 *
 * @package		o2o_supermarket
 * @author
 * @copyright	Copyright (c) 2014. 云帆工作室.
 * @version		Version 1.0
 */

class Order extends S_Controller
{
	public function __construct() 
	{
		parent::__construct();
		load_model(array('order_m', 'address_m', 'user_m', 'order_items_m'));
	}

	/**
	 * 查看订单列表
	 */
	public function index()
	{
		// 加载分页helper函数
		load_helper('page');
		$type = (int) get('type');
		$shop_id = $this->get_shopid();
		$per_page = 10;
		$orders = $this->order_m->shop_orders($shop_id, $type, $per_page, $per_page*(page_cur()-1));
		$data['orders'] = $orders;
		$this->json_out($data);
	}
	
	/**
	 * 获取新订单
	 */
	public function fresh()
	{
		// 设置每页返回的数目
		$per_page = 10;
		$shop_id = $this->get_shopid();
		$order_id = (int) get('order_id');
		$update = (int) get('update');
		$orders = $this->order_m->fresh($shop_id, $per_page, $order_id, $update);
		// 新增订单总数查询功能
		if(($update == 1) || ($order_id == 0)) {
			$filter = array (
					'stage' => 1,
					);
			$num = $this->order_m->count_by($filter);
			$data['num'] = $num;
		}
		$data['orders'] = $orders;
		
		$this->json_out($data);
	}
	
	/**
	 * 获取处理中的订单
	 */
	public function processing()
	{
		// 设置每页返回的数目
		$per_page = 10;
		$shop_id = $this->get_shopid();
		$order_id = (int) get('order_id');
		$update = (int) get('update');
		$orders = $this->order_m->processing($shop_id, $per_page, $order_id, $update);
		// 新增订单总数查询功能
		if(($update == 1) || ($order_id == 0)) {
			$filter = array (
					'stage' => 2,
			);
			$num = $this->order_m->count_by($filter);
			$data['num'] = $num;
		}		
		$data['orders'] = $orders;
		
		$this->json_out($data);
	}
	
	/**
	 * 获取历史订单
	 */
	public function history()
	{
		// 设置每页返回的数目
		$per_page = 10;
		$shop_id = $this->get_shopid();
		$order_id = (int) get('order_id');
		$update = (int) get('update');
		$orders = $this->order_m->history($shop_id, $per_page, $order_id, $update);
		$data['orders'] = $orders;
		$this->json_out($data);
	}
	
	/**
	 * 订单详情
	 */
	public function detail() 
	{
		load_view('user/order');
	}
	
	/**
	 * 订单取消
	 */
	public function cancel()
	{

		// 获取订单id
		$id = (int)get('id');
		// 获取订单取消原因
		$reason = get('reason');
		// 获取订单
		$order = $this->order_m->get_order($id);
		// 查询该订单是否属于该用户
		if (isset($order->order_id) && $order->shop == $this->get_shopid()) {
			// 取消订单
			if ($this->order_m->cancel($id, $reason, 2)) {
				$out = array(
					'states' => '0'
				);
			} else {
				// 未能成功取消，设置错误信息
				$out = array(
					'states' => '1',
						'msg' => '订单取消发生错误，未能成功取消'
				);
			}
		} else {
			if (isset($order->order_id)) {
				// 订单不存在，设置错误信息
				$out = array(
						'states' => '2',
						'msg' => '订单不存在，未能成功取消'
				);
			} else {
			// 尝试删除其它商户订单，设置错误信息
				$out = array(
						'states' => '3',
						'msg' => '订单与商户信息不匹配，未能成功取消'
				);
			}
		}
		$this->json_out($out);
	}
	
	/**
	 * 订单删除
	 */
	public function del()
	{
		$out = array(
				'states' => 'x',
				'msg' => '功能不存在'
		);
		$this->json_out($out);
		exit;
		// 获取订单id
		$id = get('id');
		// 获取订删除原因
		$reason = get('reason');
		// 获取订单
		$order = $this->order_m->get_order($id);
		// 查询该订单是否属于该商户
		if($order && $order->shop == $this->get_shopid()) {
			// 删除订单
			if($this->order_m->del($id, $reason))
			{
				$out = array(
					'states' => '0'
				);
			} else {
				// 未能成功删除，设置错误信息
				$out = array (
					'states' => '1',
						'msg' => '订单删除发生错误，未能成功取消'
				);
			}
		} else {
			if($order) {
				// 订单不存在，设置错误信息
				$out = array (
						'states' => '2',
						'msg' => '订单不存在，未能成功删除'
				);
			} else {
			// 尝试删除其它商户订单，设置错误信息
				$out = array (
						'states' => '3',
						'msg' => '订单与商户信息不匹配，未能成功删除'
				);
			}
		}
		$this->json_out($out);
	}
}
