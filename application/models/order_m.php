<?php
/**
 * 订单模型层
 *
 * @package		o2o_supermarket
 * @author		莫迟
 * @copyright	Copyright (c) 2014. 云帆工作室.
 * @since		Version 1.0
 */

class Order_m extends MY_Model
{
	protected $_table		= 'order';

	protected $primary_key	= 'order_id';

	/**
	 * 订单配置
	 */
	protected $order_config = array();

	function __construct()
	{
		parent::__construct();
		// 加载order_items_m类，goods_m类
		$this->load->model(array('order_items_m', 'goods_m', 'order_item_m', 'category_m'));

		// 加载order的配置文件
		$this->load->config('order_stage', TRUE);
		$this->order_config = $this->config->item('order_stage');
	}

	/**
	 * 获取用户所有订单
	 */
	public function get_orders($phone, $num=5, $offset=0)
	{
		$orders = $this->limit($num, $offset)->get_many_by('phone', $phone );
		$i = 0;
		foreach ($orders as $order) {
			$orders[$i] -> items = array();
			$orders[$i] -> items = $this->order_items_m->get_all('order_id', $order->order_id);
			$j = 0;
			foreach ( $orders[$i] -> items as $item) {
				$orders[$i] -> items[$j] -> pic = $this->goods_m->get_goods( $item->goods_id);

				$j ++;
			}
			$i ++;
		}
		return $orders;
	}

	/**
	 * 查找用户订单
	 * $phone为用户手机号
	 * $start为从那个订单号开始查询
	 * $num要查询的记录条数
	 * $offset为查询记录的偏移量
	 * $update区分查询新订单还是旧订单，1表示查询更新的订单，0表示查询老订单
	 * $type为查询类型，1表示查询一个月之内的订单，2表示查询一个月之前的订单
	 */
	public function user_orders($phone, $start = 0, $num = 5, $update = 0, $type = 1 )
	{
		$time = time() - 3600 * 24 * 30;
		// 如果起始订单编号$start=0，则查询最新的$num条返回
		if($start == 0) {
			if($type == 1 ) {
				$query = $this->db->query("SELECT * FROM `yf_order` WHERE ( `phone` = {$phone} AND `add_time` >= {$time} ) ORDER BY `order_id` DESC LIMIT {$num}");
			} else {
				$query = $this->db->query("SELECT * FROM `yf_order` WHERE ( `phone` = {$phone} AND `add_time` < {$time} ) ORDER BY `order_id` DESC LIMIT {$num}");
			}

		} else {
			if ($update == 1) {
				if( $type == 1 ) {
					// 查询从$start订单开始之后的新数据
					$query = $this->db->query("SELECT * FROM `yf_order` WHERE ( `phone` = {$phone} AND `add_time` >= {$time} AND `order_id` > {$start}) ORDER BY `order_id` DESC");
				} else {
					// 查询从$start订单开始之后的新数据
					$query = $this->db->query("SELECT * FROM `yf_order` WHERE ( `phone` = {$phone} AND `add_time` < {$time} AND `order_id` > {$start}) ORDER BY `order_id` DESC");
				}

			} else {
				if ($update==1) {
					// 查询$start订单之前的老数据
					$query = $this->db->query("SELECT * FROM `yf_order` WHERE ( `phone` = {$phone} AND `add_time` >= {$time} `order_id` < {$start})  ORDER BY `order_id` DESC LIMIT {$num}");
				} else {
					// 查询$start订单之前的老数据
					$query = $this->db->query("SELECT * FROM `yf_order` WHERE ( `phone` = {$phone} AND `add_time` >= {$time} AND `order_id` < {$start})  ORDER BY `order_id` DESC LIMIT {$num}");
				}
			}
		}
		if($query->num_rows() > 0) {
			$orders = $query->result();
		} else {
			$orders = new stdClass();
		}
		$result = $this->_items($orders);
		return $result;
	}

	/**
	 * 查找商铺订单
	 * @param number $shop_id 待查询订单的商户ID
	 * @param number $type 1代表查询stage=1的订单，2代表查询stage为2的订单，3代表查询stage为4，5，6的订单
	 * @param number $num  查询结果的数目
	 * @param number $offset 查询结果的偏移
	 * @param number $order_type 查询结果按order_id大小的排列方式，1为从大到小，2为从小到大
	 * @return stdClass 订单结果
	 */
	public function shop_orders($shop_id, $type =1, $num=5, $offset=0, $order_type = 1)
	{
		if ($order_type==1) {
			$this->order_by('order_id', 'DESC');
		} else {
			$this->order_by('order_id', 'ASC');
		}
		if ($type == 0) {
			$filter = array (
				'shop' => $shop_id,
			);
			$orders = $this->limit($num, $offset)->get_many_by($filter);
		} elseif (($type==1)||($type==2)) {
			$filter = array (
					'shop' => $shop_id,
					'stage' => $type
			);
			$orders = $this->limit($num, $offset)->get_many_by($filter);
		} elseif ($type==3) {
			$query = $this->db->query("SELECT * FROM `yf_order` WHERE ( `shop` = '{$shop_id}' AND `stage` = 3) OR ( `shop` = '{$shop_id}' AND `stage` = 4) OR ( `shop` = '{$shop_id}' AND `stage` = 5) LIMIT {$num}" );
			if($query->num_rows() > 0) {
				$orders = $query->result();
			} else {
				$orders = new stdClass();
			}

		}

		$i = 0;
		foreach ($orders as $order) {
			$orders[$i]->add_time_str = date('Y-m-d H:i:s', $order->add_time);
			if(isset($order->order_id)) {
				$orders[$i] -> items = $this->order_items_m->get_many_by('order_id', $order->order_id);
				$j = 0;
				foreach ( $orders[$i] -> items as $item) {
					$orders[$i] -> items[$j] -> pic = array();
					$orders[$i] -> items[$j] -> pic = $this->goods_m->get_goods((int)$item->goods_id);
					$j ++;
				}
				$orders[$i] -> items_cnt = $j ;
				$i ++;
			}
		}
		return $orders;
	}

	/**
	 * 查看新订单
	 * @param number $shop_id 商户ID
	 * @param number $num 查询数量
	 * @param number $start 待查询订单的起始编号，为0时获取最新$num条订单
	 * @param number $update 刷新类型，1为查询新数据，0为查询老数据
	 * @return stdClass
	 */
	public function fresh($shop_id, $num=5, $start=0, $update = 1)
	{
		$shop_id = (int) $shop_id;
		$this->db->order_by("order_id", "desc");
		// 如果起始订单编号$start=0，则查询最新的$num条返回
		if($start==0) {
			$filter = array (
				'shop'  => $shop_id,
				'stage' => 1
			);
			$orders = $this->limit($num)->get_many_by($filter);
		} else {
			if ($update==1) {
				// 查询从$start订单开始之后的新数据
				$query = $this->db->query("SELECT * FROM `yf_order` WHERE ( `shop` = '{$shop_id}' AND `stage` = 1 AND `order_id` >= '{$start}') ORDER BY `order_id` DESC");
			} else {
				// 查询$start订单之前的老数据
				$query = $this->db->query("SELECT * FROM `yf_order` WHERE ( `shop` = {$shop_id} AND `stage` = 1 AND `order_id` <= {$start})  ORDER BY `order_id` DESC LIMIT {$num}");
			}
			if($query->num_rows() > 0) {
				$orders = $query->result();
			} else {
				$orders = new stdClass();
			}
		}
		$result = $this->_items($orders);
		return $result;
	}

	/**
	 * 查询正在处理中的订单
	 * @param number $shop_id 商户ID
	 * @param number $num 查询数量
	 * @param number $start 待查询订单的起始编号，为0时获取最新$num条订单
	 * @param number $update 刷新类型，1为查询新数据，0为查询老数据
	 * @return stdClass
	 */
	public function processing($shop_id, $num=5, $start=0, $update = 1)
	{
		$shop_id = (int) $shop_id;
		// 如果起始订单编号$start=0，则查询最新的$num条返回
		if($start==0) {
			$filter = array (
					'shop' => $shop_id,
					'stage' => 2
			);
			$orders = $this->limit($num)->get_many_by($filter);
		} else {
			if ($update==1) {
				// 查询从$start订单开始之后的新数据
				$query = $this->db->query("SELECT * FROM `yf_order` WHERE ( `shop` = {$shop_id} AND `stage` = 2 AND `order_id` >= {$start}) ORDER BY `order_id` DESC");
			} else {
				// 查询$start订单之前的老数据
				$query = $this->db->query("SELECT * FROM `yf_order` WHERE ( `shop` = {$shop_id} AND `stage` = 2 AND `order_id` <= {$start})  ORDER BY `order_id` DESC LIMIT {$num}");
			}
			if($query->num_rows() > 0) {
				$orders = $query->result();
			} else {
				$orders = new stdClass();
			}
		}
		$result = $this->_items($orders);
		return $result;
	}

	/**
	 * 查询历史订单
	 * @param number $shop_id 商户ID
	 * @param number $num 查询数量
	 * @param number $start 待查询订单的起始编号，为0时获取最新$num条订单
	 * @param number $update 刷新类型，1为查询新数据，0为查询老数据
	 * @return stdClass
	 */
	public function history($shop_id, $num=5, $start=0, $update = 1)
	{
		$shop_id = (int) $shop_id;
		// 如果起始订单编号$start=0，则查询最新的$num条返回
		if($start==0) {
			$query = $this->db->query("SELECT * FROM `yf_order` WHERE ( `shop` = '{$shop_id}' AND `stage` = 3) OR ( `shop` = '{$shop_id}' AND `stage` = 4) OR ( `shop` = '{$shop_id}' AND `stage` = 5) ORDER BY `order_id` DESC LIMIT {$num}" );
			if($query->num_rows() > 0) {
				$orders = $query->result();
			} else {
				$orders = new stdClass();
			}
		} else {
			if ($update==1) {
				// 查询从$start订单开始之后的新数据
				$query = $this->db->query("SELECT * FROM `yf_order` WHERE ( `shop` = {$shop_id} AND `stage` = 3 AND `order_id` >= {$start}) OR ( `shop` = {$shop_id} AND `stage` = 4 AND `order_id` >= {$start}) OR ( `shop` = {$shop_id} AND `stage` = 5 AND `order_id` >= {$start}) ORDER BY `order_id` ASC LIMIT {$num}");
			} else {
				// 查询$start订单之前的老数据
				$query = $this->db->query("SELECT * FROM `yf_order` WHERE ( `shop` = {$shop_id} AND `stage` = 3 AND `order_id` <= {$start}) OR ( `shop` = {$shop_id} AND `stage` = 4 AND `order_id` <= {$start}) OR ( `shop` = {$shop_id} AND `stage` = 5 AND `order_id` <= {$start})  ORDER BY `order_id` DESC LIMIT {$num}");
			}
			if($query->num_rows() > 0) {
				$orders = $query->result();
			} else {
				$orders = new stdClass();
			}
		}
		$result = $this->_items($orders);
		return $result;
	}

	/**
	 * 获取单个订单
	 */
	public function get_order($order_id)
	{
		$order_id = (int) $order_id;
		$return   = array();
		$order    = $this->get_by('order_id', $order_id );

		if(isset($order->order_id)) {
			$order->add_time   = date('m-d H:i', $order->add_time);
			// 查询该order_id下全部商品
			$order->items      = $this->order_items_m->get_many_by('order_id', $order->order_id);
			$order->stage_name = $this->get_stage_name($order->stage);

			return $order;
		} else {
			return FALSE;
		}
	}

	/**
	 * 向订单中添加订单items
	 * @param class $orders 订单
	 * @return class $orders 包含子项的订单
	 */
	private function _items($orders)
	{
		$i = 0;
		foreach ($orders as $order) {
			if(isset($order->order_id)) {
				$orders[$i]->add_time_str = date('m-d H:i', $order->add_time);
				$orders[$i]->stage_name = $this->get_stage_name($order->stage);
				$orders[$i]->items = $this->order_items_m->get_many_by('order_id', $order->order_id);
				$j = 0;
				foreach ( $orders[$i] -> items as $item) {
					$orders[$i]->items[$j] -> pic = array();
					$orders[$i]->items[$j] -> pic = $this->goods_m->get_goods((int)$item->goods_id);
					$j ++;
				}
				$orders[$i] -> items_cnt = $j ;
				$i ++;
			}
		}
		return $orders;
	}

	/**
	 * 获取用户订单数目
	 */
	public function get_num($phone)
	{
		return  $this->count_by('phone', $phone);
	}


	/**
	 * 获取数据表中订单数目
	 */
	public function get_table_num()
	{
		return $this->count_all();
	}

	/**
	 * 获取订单中商品数目
	 */
	public function get_item_cnt($order_id) {
		$this->order_items_m->count_by('order_id', $order_id);
	}

	/**
	 * 取消订单
	 */
	public function order_cancel($order_id, $reason = NULL, $type = 1) {
		if ($type == 1) {
			$order = array (
				'stage' => 4, // 用户取消订单
				'cancel_reason' => $reason
			);
		} else {
			$order = array (
					'stage' => 5, // 商户取消订单
					'cancel_reason' => $reason
			);
		}
		$this->edit($order_id, $order);
		return TRUE;
	}

	/**
	 * 添加订单
	 */
	public function add($data)
	{
		return $this->insert($data);
	}

	/**
	 * 编辑订单
	 */
	public function edit($order_id, $data)
	{
		return $this->update_by('order_id', (int)$order_id, $data);
	}

	/**
	 * 删除订单，软删除
	 */
	public function del($order_id, $reason = NULL)
	{
		// 删除订单子项
		$items = $this->order_items_m->get_many_by('order_id', $order_id);
		foreach ( $items as $item) {
			$this -> order_items_m -> del($item->item_id);
		}
		// 更新订单删除原因
		$order = array (
			'del_reason' => $reason
		);
		$this->update_by('order_id', (int)$order_id, $order);
		// 删除订单
		return $this->delete_by('order_id', (int)$order_id);
	}

	/**
	 * 获取订单stage所代表的状态字符串
	 */
	public function get_stage_name($stage)
	{
		return (isset($this->order_config[$stage])) ? $this->order_config[$stage] : '';
	}
	/**
	 * 订单管理模块
	 */
	public function to_excel($stage = 0, $search_input = "", $num = 0, $offset = 0)
	{
		$return = array();
		if($stage) {
			$this->db->where('stage', $stage);
		}
		if (strlen($search_input) != 0) {
			$this->db->like('address', $search_input);
		}

		$this->db->order_by("order_id", "desc");
		if(!$num) {
			$query = $this->db->get('order');
		} else {
			$query = $this->db->get('order', $num, $offset);
		}

		$i = 0;
		foreach ($query->result_array() as $row) {
			$return[$i] = $row;
			$return[$i]['items'] = $this->order_item_m->get_items($row['order_id']);
			$i++;
		}
		return $return;
	}

	public function to_word($stage = 0, $num=0, $offset=0)
	{
		$return = array();
		if($stage) {
			$this->db->where('stage', $stage);
		}
		$this->db->order_by("order_id", "desc");
		if(!$num) {
			$query = $this->db->get('order');
		} else {
			$query = $this->db->get('order', $num, $offset);
		}

		$i = 0;
		foreach ($query->result_array() as $row) {
			$return[$i] = $row;
			$return[$i]['items'] = $this->order_item_m->get_items($row['order_id']);
			$return[$i]['num'] = $this->order_item_m->get_items_num($row['order_id']);
			$i++;
		}
		return $return;
	}

	/**
	 * 获取打印的订单详情模块
	 */
	public function to_detail($order_id)
	{
		$order_id = (int)$order_id;
		$return = array();
		$this->db->where('order_id', $order_id);
		$query = $this->db->get('order');
		foreach ($query->result_array() as $row) {
			$return = $row;
			$return['items'] = $this->order_item_m->get_items($row['order_id']);
			$return['num'] = $this->order_item_m->get_items_num($row['order_id']);
		}
		return $return;
	}

	public function num2excel($stage = 0)
	{
		if($stage) {
			$this->db->where('stage', $stage);
		}
		return $this->db->count_all_results('order');
	}

	public function set_stage($order_id, $stage)
	{
		$data = array('stage'=>$stage);
		$this->db->where('order_id', $order_id);
		if($this->db->update('order', $data) === FALSE) {
			return FALSE;
		}
		return TRUE;
	}
	/**
	 * 商品订单统计
	 */
	public function goods_list($stage = 0, $sort_stage = 0)
	{
		$return = array();

		if($stage) {
			$query = $this->db->query("SELECT order_id FROM `yf_order` WHERE stage=" . $stage);
		} else {
			$query = $this->db->query("SELECT order_id FROM `yf_order`");
		}

		if ($query->num_rows() > 0) {
			$order_id = "(";
			foreach ($query->result_array() as $key => $row) {
				if ($key == 0) {
					$order_id = $order_id . $row['order_id'];
				} else {
					$order_id = $order_id . "," . $row['order_id'];
				}
			}
			$order_id = $order_id . ")";
			// 相同商品合并数量
			$query2 = $this->db->query("SELECT goods_id,name,SUM(quantity) FROM `yf_order_items` WHERE order_id IN " . $order_id . " GROUP BY goods_id");
			$return = $query2->result_array();
			// 获取分类、分类名称
			foreach ($return as $key => $row) {
				$query_tempid = $this->db->query("SELECT class_id FROM `yf_goods` WHERE goods_id=" . $row['goods_id'])->result_array();
				if (!empty($query_tempid)) {	
					$return[$key]['class_id'] = $query_tempid[0]['class_id'];
					$query_tempname = $this->db->query("SELECT class_name FROM `yf_category` WHERE class_id=" . $return[$key]['class_id'])->result_array();
					if (!empty($query_tempname)) {
						$return[$key]['class_name'] = $query_tempname[0]['class_name'];
					} else {
						$return[$key]['class_name'] = "";
					}
				}
			}
		}
		$result = array();
		// 剔除不符合分类名称的项目
		if($sort_stage) { 
			$i = 0;
			foreach ($return as $key => $row) {
				if ($sort_stage == $return[$key]['class_id']) {
					$result[$i++] = $row;
				}
			}
		} else {
			$result = $return;
		}
		//var_dump($result);exit();
		return $result;
	}
}
