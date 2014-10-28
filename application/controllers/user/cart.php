<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 购物车控制器
 *
 * @package		o2o_supermarket
 * @author		莫迟
 * @copyright	Copyright (c) 2014. 云帆工作室.
 * @since		Version 1.0
 */

class Cart extends U_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('cart');
		$this->load->model(array('goods_m', 'address_m', 'user_m', 'shop_m', 'coupon_m'));

		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0");
		$this->output->set_header("Pragma: no-cache");
	}

	public function index()
	{
		// 销毁购物车
		$this->cart->destroy();
		// 对用户端发送的购物车信息JSON解码，包含goods_id和pty
		$cart = json_decode(get('cart'));
		$check_cart = array();
		// 查询的商品是否缺货或下架
		foreach ($cart as $value) {
			$goods = $this->goods_m->get($value->goods_id);
			if (isset($goods->goods_id) && $goods->stock == '1' && $goods->sold == '1') {
				$tmp = array(
					'id'    => $goods->goods_id,
					'price' => $goods->price,
					'name'  => $goods->name,
					'qty'   => $value->qty
				);
				$this->cart->insert($tmp);
			}
		}

		$data = $this->_cart_data();

		$this->json_out($data);
	}
	
	/**
	 * 判断店铺是否在营业若是则可以下单，否则不能下单
	 */
	public function shop_close()
	{
		$shop_id = $this->input->get('shop_id');
		$return = $this->shop_m->get_ifclose($shop_id);
		$data = array(
			'shop_close' => $return,
		);
		$this->json_out($data);
	}

	/**
	 * 点击结算商品时的确认操作
	 */
	public function check()
	{
		if ($this->check_login() != FALSE) {
			$data = $this->_cart_data();

			// 填充用户信息
			$user = new stdclass();
			$user->phone = $this->phone;
			$user_id = $this->user_m->phone2id($user->phone);
			$user->address = $this->address_m->get_default($user_id)->name;		// 此处获取用户默认地址
			$data['user'] = $user;
			$data['login'] = 1;

			$this->json_out($data);
		} else {
			$data['login'] = 0;
			$this->json_out($data);
		}
	}

	/**
	 * 向购物车中添加商品
	 */
	public function add()
	{
		$id		= (int) get('goods_id');
		$goods	= $this->goods_m->get($id);

		if(isset($goods->goods_id)) {
			$contents	= $this->cart->contents();
			$rowid		= md5($id);

			if(isset($contents[$rowid])) {
				// 更新购物车
				$qty	= 1 + $contents[$rowid]['qty'];
				$data	= array(
					'rowid' => $rowid,
					'qty'   => $qty,
				);
				$this->cart->update($data);
			} else {
				// 添加购物车
				$data = array(
					'goods_id'=> $id,
					'qty'     => 1,
					'price'   => $goods->price,
					'name'    => $goods->name,
				);
				$this->cart->insert($data);
			}
		}
		$this->json_out($this->_cart_data());
	}

	/**
	 * 更新购物车内容
	 */
	public function update()
	{
		$id		= (int) $this->input->get('id');
		$qty	= (int) $this->input->get('qty');
		$goods	= $this->goods_m->get($id);
		$rowid	= md5($id);

		if(isset($goods->goods_id)) {
			$data = array(
				'rowid'	=> $rowid,
				'qty'	=> $qty,
			);
			$this->cart->update($data);
		}
		$this->json_out($this->_cart_data());
	}

	/**
	 * 删除购物车里面的条目
	 */
	public function del()
	{
		$data = array(
					'rowid'	=>	md5((int) $this->input->get('id')),
					'qty'	=>	0,
				);
		$this->cart->update($data);

		$this->json_out($this->_cart_data());
	}

	/**
	 * 清空购物车
	 */
	public function destroy()
	{
		$this->cart->destroy();
		$this->json_out($this->_cart_data());
	}

	/**
	 * 获取购物车输出内容
	 */
	private function _cart_data()
	{
		$cart_content = $this->cart->contents();
		$output       = array(
			'total_items'  => $this->cart->total_items(),
			'total_prices' => $this->cart->total(),
			'total_sub'    => count($cart_content),
		);

		// 填充购物车信息
		$i = 0;
		$output['items'] = array();
		foreach ($cart_content as $items) {
			$output['items'][$i]['goods_id'] = $items['id'];
			$output['items'][$i]['name']     = $items['name'];
			$output['items'][$i]['price']    = $items['price'];
			$output['items'][$i]['qty']      = $items['qty'];
			$output['items'][$i]['subtotal'] = $items['subtotal'];
			$i++;
		}

		return $output;
	}
}
