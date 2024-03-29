<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 订单控制器
 *
 * @package		o2o_supermarket
 * @author		莫迟
 * @copyright	Copyright (c) 2014. 云帆工作室.
 * @since		Version 1.0
 */

class Order extends U_Controller
{
	public function __construct()
	{
		parent::__construct();
		load_model(array('order_m', 'address_m', 'user_m', 'order_items_m', 'coupon_m', 'alipay_m'));
		load_helper('page');
	}

	/**
	 * 查看订单列表
	 */
	public function index()
	{
		if( $this->check_login() == FALSE ) {
			$data = array(
				'status'	=> 1,
				'msg'		=> '用户未登录'
			);
			$this->json_out($data);
		} else {
			// type变量表示想要获取订单的类型，近一个月的订单与一个月之前的订单，分别用1与2表示
			$phone  = $this->get_phone();
			$start  = (int) get('start');
			$update = (int) get('update');
			$type   = (int) get('type');
			if($type < 1) {
				$type = 1;
			}
			$per_page = 5;
			$orders   = $this->order_m->user_orders($phone, $start, $per_page, $update, $type);
			$data     = array(
				'orders' => $orders,
				'status' => 0
			);
			$this->json_out($data);
		}
	}

	/**
	 * 订单详情
	 */
	public function detail()
	{
		$order_id = (int) get('order_id');
		// 如果没有登录，返回空数组
		if( $this->check_login() == FALSE ) {
			$data['order'] = array();
			$this->json_out($data);
			return;
		}

		$data = array();
		$data['order'] = $this->order_m->get_order($order_id);
		// 错误处理
		if ($data['order'] == FALSE) {
			$data['error'] = 1;
		} else {
			$data['error'] = 0;
		}

		$this->json_out($data);
	}

	/**
	 * 订单提交
	 */
	public function submit()
	{
		// 未登录时
		if ( !$this->check_login()) {
			$data = array(
				'status' => 1,
				'msg'    => '用户未登录'
			);

			$this->json_out($data);
		}

		// 购物车无物品时执行操作，直接跳转至首页
		if($this->cart->total_items() < 1) {
		//if((int)get('total_items') < 1) {
 			$data = array(
 				'status' => 2,
 				'msg'    => '购物车为空'
 			);

 			$this->json_out($data);
 		}

		$shop_id       = (int) cookie('shop_id');
		$phone         = $this->get_phone();
		$user_id       = $this->user_m->phone2id($phone);
		$address       = $this->address_m->get_default($user_id)->name;
		$payment       = (int) get('payment');
		$delivery_time = $this->get_delivery_time((int) get('delivery_time'));
		$coupon_id     = (int) get('coupon_id');
		$coupon        = $this->coupon_m->deal_coupon($coupon_id);	// 查询所选的优惠券的详细内容

		$total_prices = $this->cart->total();

		// 创建订单
		$order_add = array(
			'total_prices'  => $total_prices,
			'shop'          => $shop_id,
			'phone'         => $phone,
			'user_id'       => $user_id,
			'address'       => $address,
			'delivery_time' => $delivery_time,
			'stage'         => ORDER_STAGE_SUBMIT,
			'add_time'      => time()
		);
		$order_id = $this->order_m->add($order_add);

		// 订单创建成功，执行将购物车内容添加到订购表中
		if ($order_id > 0) {
			foreach ($this->cart->contents() as $item) {
				$goods_id = $item['id'];
				$goods    = $this->goods_m->get($goods_id);

				// 销量统计
				$this->goods_m->add_sale($goods_id, $item['qty']);

				// 存在商品即结算
				if($goods != FALSE) {
					$item_add = array(
						'order_id'     => $order_id,
						'goods_id'     => $goods_id,
						'price'        => $goods->price,
						'name'         => $goods->name,
						'unit'         => $goods->unit,
						'shop'         => $shop_id,
						'quantity'     => $item['qty'],
						'total_prices' => $item['subtotal']
					);
					$this->order_items_m->add($item_add);
				}
			}
			// 货到付款
			if ($payment == 0) {
				// 订单处理成功，销毁本次购物车内容
				$this->cart->destroy();
				$out = array(
					'order_id' => $order_id,
					'status'   => '0'
				);
			} else if ($payment == 1) {
				// 支付宝，创建流水
				$flow = array(
					'order_id'     => $order_id,
					'total_fee'    => $total_prices,
					'out_trade_no' => $this->_rand_id(),
					'status'       => 'ORDER_STAGE_UNPAYED',
					'create_time'  => time(),
					'payer'        => $user_id
				);
				$this->order_m->edit($order_id, array('stage'=>7));	// 在线支付状态有别
				$flow_id = $this->alipay_m->add_flow($flow);
				if ($flow_id > 0) {
					$out = array(
						'order_id' => $order_id,
						'flow_id'  => $flow_id,
						'status'   => '0'
					);
				} else {
					$out = array('status' => '3', 'msg' => '流水创建失败');
				}
			}
		} else {
			$out = array('status' => '4', 'msg' => '订单创建失败');
		}

		$this->json_out($out);
	}
	
	/**
	 * 获取订单的配送时间
	 */
	public function get_delivery_time($id)
	{
		$id = (int)$id;
		switch ($id) {
			case 1: return "8:00-10:00";  break;
			case 2: return "10:00-12:00"; break;
			case 3: return "12:00-14:00"; break;
			case 4: return "14:00-16:00"; break;
			case 5: return "16:00-18:00"; break;
			case 6: return "18:00-20:00"; break;
			default:return 0; break;
		}
	}

	/**
	 * 订单取消
	 */
	public function cancel()
	{
		if($this->check_login()) {
			// 获取订单id
			$id = (int)$this->input->get('order_id');
			// 获取用户取消订单的原因
			$reason = get('reason');
			// 获取订单
			$order = $this->order_m->get_order($id);

			// 查询该订单是否属于改用户
			if(isset($order->order_id) && $order->phone == $this->get_phone()) {
				// 取消订单
				if($this->order_m->order_cancel($id, $reason)) {
					$out = array(
						'states' => '0'
					);

				} else {
					// 未能成功取消，设置错误信息
					$out = array(
						'states'	=> '1',
						'msg'		=> '订单取消发生错误，未能成功取消'
					);
				}
			} else {
				if(isset($order->order_id)) {
					// 订单不存在，设置错误信息
					$out = array(
						'states'	=> '2',
						'msg'		=> '订单不存在，未能成功取消'
					);
				} else {
				// 尝试删除他人订单，设置错误信息
					$out = array(
							'states' => '3',
							'msg' => '订单与用户信息不匹配，未能成功取消'
					);
				}
			}
		} else {
			// 身份验证未通过，设置错误信息
			$out = array(
					'states' => '4',
					'msg' => '您尚未登录，请登录后再尝试取消订单'
			);
		}
		$this->json_out($out);
	}

	/**
	 * 重建流水
	 */
	public function rebuild()
	{
		if ($this->check_login()) {
			$order_id = (int) get('order_id');
			$order = $this->order_m->get($order_id);
			$total_prices = $order->total_prices;
			$payer = $order->user_id;
			// 重建流水（和原order关联）
			$flow = array(
				'order_id'     => $order_id,
				'total_fee'    => $total_prices,
				'out_trade_no' => $this->_rand_id(),
				'status'       => 'ORDER_STAGE_UNPAYED',
				'create_time'  => time(),
				'payer'        => $payer
			);
			$flow_id = $this->alipay_m->add_flow($flow);

			if ($flow_id > 0) {
				$data = array('order_id'=>$order_id, 'flow_id'=>$flow_id, 'status'=>'0');
			} else {
				$data = array('status'=>'3');
			}
		} else {
			$data = array('status'=>'4');
		}

		$this->json_out($data);
	}

	/**
	 * 检验验证码
	 *
	 * @param string $captchar
	 * @return boolean
	 */
	private function captchar_check($captchar, $phone)
	{
		$captchar_s = $this->session->userdata('phone_verify');
		$verify_time = $this->session->userdata('phone_verify_time');
		$phone_send = $this->session->userdata('phone_send');

		// 注销验证码session
		$this->session->unset_userdata('phone_verify');
		$this->session->unset_userdata('phone_verify_time');
		$this->session->unset_userdata('phone_send');

		// 判断发送验证码的手机号码和用户实际提交手机号码是否相等
		if ($phone != $phone_send) {
			return FALSE;
		}

		// 超时返回FALSE
		if (time() - $verify_time >60) {
			return FALSE;
		}

		// 验证码值是否相等
		if($captchar != $captchar_s) {
			return  FALSE;
		}
		return TRUE;
	}

	/**
	 * 生成流水订单id
	 */
	private function _rand_id()
	{
		do {
			$rand_id = date('Ymdhis') . rand(10000, 99999);	// 时间+随机数=19位
			$order   = $this->alipay_m->get_by('out_trade_no', $rand_id);
		} while (isset($order->order_id));

		return $rand_id;
	}
}
