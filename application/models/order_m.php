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
	public function del($order_id)
	{
		$this->db->where('order_id',$order_id);
		// 删除订单
		$data = array('order_deleted' => 1);
		
		return $this->db->update('yf_order',$data);
	}
	
	/**
	 * 批量删除订单
	 */
	public function del_some($order_id)
	{
		$this->db->where_in('order_id',$order_id);	
		if($this->db->delete('yf_order')){
			$this->db->where_in('order_id',$order_id);
			return $this->db->delete('yf_order_items');
		}
	}

	/**
	 * 获取订单stage所代表的状态字符串
	 */
	public function get_stage_name($stage)
	{
		return (isset($this->order_config[$stage])) ? $this->order_config[$stage] : '';
	}
	
	/**
	 * 按日期和时间段删选时间生成函数
	 */
	private function make_date($date_type, $date)
	{
		$date_type = (int)$date_type;
		$time00 = strtotime($date."00:00:00");
		$time24 = strtotime($date."24:00:00");
		$time11 = strtotime($date."11:00:00");
		$time23 = strtotime($date."23:00:00");
		$time_y23 = $time00-60*60*1;     //前一天23:00的时间戳
		switch ($date_type)
		{
			case 0:  $this->db->where('add_time >=',$time00);
					 $this->db->where('add_time <',$time24);
					 break;
			case 1:  $this->db->where('add_time >=',$time11);
					 $this->db->where('add_time <',$time23);
					 break;
			case 2:  $this->db->where('add_time >=',$time_y23);
					 $this->db->where('add_time <',$time11);
					 break;
			case 8:  $this->db->where('add_time >=',strtotime($date."8:00:00"));
					 $this->db->where('add_time <',strtotime($date."9:00:00"));
					 break;
			case 9:  $this->db->where('add_time >=',strtotime($date."9:00:00"));
					 $this->db->where('add_time <',strtotime($date."10:00:00"));
					 break;
			case 10: $this->db->where('add_time >=',strtotime($date."10:00:00"));
					 $this->db->where('add_time <',strtotime($date."11:00:00"));
					 break;
			case 11: $this->db->where('add_time >=',strtotime($date."11:00:00"));
					 $this->db->where('add_time <',strtotime($date."12:00:00"));
					 break;
			case 12: $this->db->where('add_time >=',strtotime($date."12:00:00"));
					 $this->db->where('add_time <',strtotime($date."13:00:00"));
					 break;
			case 13: $this->db->where('add_time >=',strtotime($date."13:00:00"));
					 $this->db->where('add_time <',strtotime($date."14:00:00"));
					 break;
			case 14: $this->db->where('add_time >=',strtotime($date."14:00:00"));
					 $this->db->where('add_time <',strtotime($date."15:00:00"));
					 break;
			case 15: $this->db->where('add_time >=',strtotime($date."15:00:00"));
					 $this->db->where('add_time <',strtotime($date."16:00:00"));
					 break;
			case 16: $this->db->where('add_time >=',strtotime($date."16:00:00"));
					 $this->db->where('add_time <',strtotime($date."17:00:00"));
					 break;
			case 17: $this->db->where('add_time >=',strtotime($date."17:00:00"));
					 $this->db->where('add_time <',strtotime($date."19:00:00"));
					 break;
			case 19: $this->db->where('add_time >=',strtotime($date."19:00:00"));
					 $this->db->where('add_time <',strtotime($date."13:00:00"));
					 break;					
			default: break;
					
		}
	}
	
	/**
	 * 订单管理模块
	 */
	public function to_excel($stage = 0, $search_input = "",$date_type, $date, $num = 0, $offset = 0)
	{
		$return = array();
		$this->db->where("order_deleted",0);
		if($stage) {
			$this->db->where('stage', $stage);
		} else {
			$this->db->where_in('stage', array(7,8));
		}
		if (strlen($search_input) != 0) {
			$this->db->like('address', $search_input);
		}
		if (!empty($date)) {
			$this->make_date($date_type, $date);
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
	
	public function num2excel($stage = 0,$search_input = "",$date_type, $date)
	{
		$this->db->where("order_deleted",0);
		if($stage) {
			$this->db->where('stage', $stage);
		} else {
			$this->db->where_in('stage', array(7,8));
		}
		if (strlen($search_input) != 0) {
			$this->db->like('address', $search_input);
		}
		if (!empty($date)) {
			$this->make_date($date_type, $date);
		}
		return $this->db->count_all_results('order');
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
	public function goods_list($sort_stage = 0, $month = 0,$date_type,$date,$keywords = 0)
	{
		$return = array();
		$this->db->select('order_id');
		if($month) {
			$y     = date("Y",time());
			$time1 = mktime(0,0,0,$month,1,$y);
			$time2 = mktime(0,0,0,$month+1,1,$y);
			$this->db->where("add_time >=",$time1);
			$this->db->where("add_time <",$time2);
		} else {
			if (!empty($date)) {
				$this->make_date($date_type, $date);
			}
		}
		/*if($stage) {
			$this->db->where('stage',$stage);
		} else {
			$this->db->where_in('stage', array(7,8));
		}*/
		$this->db->where('stage', 8);
		$query = $this->db->get('yf_order');
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
			if($keywords) {
				$query2 = $this->db->query("SELECT goods_id,name,price,SUM(quantity) as quantity FROM `yf_order_items` WHERE order_id IN " . $order_id . " and `name` LIKE '%".$keywords."%' GROUP BY goods_id");
			} else {
				$query2 = $this->db->query("SELECT goods_id,name,price,SUM(quantity) as quantity FROM `yf_order_items` WHERE order_id IN " . $order_id . " GROUP BY goods_id");
			}
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
				if (isset($return[$key]['class_id'])) {
					if ($sort_stage == $return[$key]['class_id']) {
						$result[$i++] = $row;
					}
				}
			}
		} else {
			$result = $return;
		}
		
		return $result;
	}
	
	/**
	 * 按日期和时间段删选时间生成函数
	 */
	private function make_date_sql($date_type, $date,$sql_order)
	{
		$date_type = (int)$date_type;
		$time00 = strtotime($date."00:00:00");
		$time24 = strtotime($date."24:00:00");
		$time11 = strtotime($date."11:00:00");
		$time23 = strtotime($date."23:00:00");
		$time_y23 = $time00-60*60*1;     //前一天23:00的时间戳
		switch ($date_type)
		{
			case 0: $sql_order = $sql_order.' AND b.add_time >= '.$time00.' AND b.add_time < '.$time24 ;
					break;
			case 1: $sql_order = $sql_order.' AND b.add_time >= '.$time11.' AND b.add_time < '.$time23 ;
					break;
			case 2: $sql_order = $sql_order.' AND b.add_time >= '.$time_y23.' AND b.add_time < '.$time11 ;
					break;
			case 8: $sql_order = $sql_order.' AND b.add_time >= '.strtotime($date."8:00:00").' AND b.add_time < '.strtotime($date."9:00:00") ;
					break;
			case 9: $sql_order = $sql_order.' AND b.add_time >= '.strtotime($date."9:00:00").' AND b.add_time < '.strtotime($date."10:00:00") ;
					break;
			case 10: $sql_order = $sql_order.' AND b.add_time >= '.strtotime($date."10:00:00").' AND b.add_time < '.strtotime($date."11:00:00") ;
					break;
			case 11: $sql_order = $sql_order.' AND b.add_time >= '.strtotime($date."11:00:00").' AND b.add_time < '.strtotime($date."12:00:00") ;
					break;
			case 12: $sql_order = $sql_order.' AND b.add_time >= '.strtotime($date."12:00:00").' AND b.add_time < '.strtotime($date."13:00:00") ;
					break;
			case 13: $sql_order = $sql_order.' AND b.add_time >= '.strtotime($date."13:00:00").' AND b.add_time < '.strtotime($date."14:00:00") ;
					break;
			case 14: $sql_order = $sql_order.' AND b.add_time >= '.strtotime($date."14:00:00").' AND b.add_time < '.strtotime($date."15:00:00") ;
					break;
			case 15: $sql_order = $sql_order.' AND b.add_time >= '.strtotime($date."15:00:00").' AND b.add_time < '.strtotime($date."16:00:00") ;
					break;
			case 16: $sql_order = $sql_order.' AND b.add_time >= '.strtotime($date."16:00:00").' AND b.add_time < '.strtotime($date."17:00:00") ;
					break;
			case 17: $sql_order = $sql_order.' AND b.add_time >= '.strtotime($date."17:00:00").' AND b.add_time < '.strtotime($date."19:00:00") ;
					break;
			case 19: $sql_order = $sql_order.' AND b.add_time >= '.strtotime($date."19:00:00").' AND b.add_time < '.strtotime($date."23:00:00") ;
					break;
			default:break;
				
		}
		return $sql_order;
	}
	
	/**
	 *按照地址统计订单
	 */
	public function goods_list_address($sort_stage = 0,$month = 0,$date_type,$date, $address)
	{
		$sql_order = 'WHERE b.order_id != 0 ';
		if($month) {
			$y     = date("Y",time());
			$time1 = mktime(0,0,0,$month,1,$y);
			$time2 = mktime(0,0,0,$month+1,1,$y);
			$sql_order = $sql_order.' AND b.add_time >= '.$time1.' AND b.add_time < '.$time2 ;
		} else {
			if (!empty($date)) {
				$sql_order = $this->make_date_sql($date_type, $date,$sql_order);
			}
		}
		/*if($stage) {
			$sql_order = $sql_order.' AND b.stage='.$stage;
		} else {
			$sql_order = $sql_order.' AND b.stage IN (7,8) ';
		}*/
		$sql_order = $sql_order.' AND b.stage = 8 ';
		if($sort_stage) {
			$sql_order = $sql_order.' AND c.class_id='.$sort_stage;
		}
		if($address) {
			if(!$sort_stage) {
				$sql_order = $sql_order.' AND ';
			}
			$sql_order = $sql_order."b.address LIKE '%".$address."%'";
		}
		$sql = "SELECT a.goods_id as goods_id,a.name as name,a.price as price,SUM(quantity) as quantity,class_name FROM yf_order_items AS a 
				INNER JOIN yf_order AS b ON a.order_id = b.order_id 
				INNER JOIN yf_goods AS c ON a.goods_id = c.goods_id 
				INNER JOIN yf_category AS d ON c.class_id = d.class_id 
				".$sql_order." GROUP BY a.goods_id";
		$query = $this->db->query($sql);
		$i = 0;
		if($query->num_rows()) {
			foreach ($query->result_array() as $row) {
				$return[$i]['goods_id']   = $row['goods_id'];
				$return[$i]['name']       = $row['name'];
				$return[$i]['quantity']   = $row['quantity'];
				$return[$i]['price']      = $row['price'];
				$return[$i]['class_name'] = $row['class_name'];
				$i++;
			}
		} else {
			$return = '';
		}
		return $return;
	}
	/**
	 * 删除名字为$name的所有订单
	 * @param unknown $name
	 */
	public function del_all_order($name)
	{
		$this->db->where('name',$name);
		$this->db->select('order_id');
		$query = $this->db->get('yf_order_items');
		foreach ($query->result_array() as $row) {
			$order_id = $row['order_id'];
			$this->db->where('order_id',$order_id);
			$this->db->delete('yf_order');
		}
		$this->db->where('name',$name);
		$this->db->delete('yf_order_items');
	}
	/*
	 * 查询活动订单内容
	 */
	public function order_active_query($month,$month_type,$date,$type,$keywords)
	{
		$sql_order = "";
		$sql_user = "";
		$y = date("Y",time());
		if($month != 0) {
			if($month_type == 0) {//整个月
				$time1 = mktime(0,0,0,$month,1,$y);
				$time2 = mktime(0,0,0,$month+1,1,$y);
			} else if($month_type == 1) { //前半个月
				$time1 = mktime(0,0,0,$month,1,$y);
				$time2 = mktime(0,0,0,$month,15,$y);
			} else if($month_type == 2) { //后半个月
				$time1 = mktime(0,0,0,$month,15,$y);
				$time2 = mktime(0,0,0,$month+1,1,$y);
			}
			$sql_order = $sql_order.' AND b.add_time >= '.$time1.' AND b.add_time < '.$time2 ;
		} else if($date != 0) {
			$time1 = strtotime($date."00:00:00");
			$time2 = strtotime($date."23:59:59");
			$sql_order = $sql_order.' AND b.add_time >= '.$time1.' AND b.add_time < '.$time2 ;
		}
		if(!empty($keywords)) {
			if($type == 0) {
				$sql_user = " AND phone LIKE '%$keywords%' ";
			} else if($type == 1) {
				$sql_order = $sql_order." AND b.address LIKE '%$keywords%' ";
			}
		}
		$query_max = $this->db->query("SELECT phone,SUM(total_prices) as max_prices FROM yf_order WHERE stage=8 $sql_user GROUP BY user_id ORDER BY max_prices DESC");
		$result = $query_max->result_array();
		foreach ($result as $key=>$row) {
			$sql = "SELECT DISTINCT b.phone as phone,b.address as address,a.goods_id as goods_id,a.name as name,a.price as price,d.class_id as class_id,d.class_name as class
			FROM yf_order_items AS a
			INNER JOIN yf_order AS b ON a.order_id = b.order_id
			INNER JOIN yf_goods AS c ON a.goods_id = c.goods_id
			INNER JOIN yf_category AS d ON c.class_id = d.class_id
			WHERE b.stage = 8 AND b.phone =".$row['phone']. $sql_order.
			" ORDER BY c.class_id";
			$query = $this->db->query($sql);
			$result[$key] = $query->result_array();
			foreach ($result[$key] as $key2 => $row2) {
				$sql1 = "SELECT SUM(a.quantity) as quantity FROM yf_order_items as a
					INNER JOIN yf_order AS b ON a.order_id = b.order_id
					WHERE b.stage=8 AND a.goods_id=".$row2['goods_id']." AND b.phone=".$row2['phone'].$sql_order;
				$quantity_array = $this->db->query($sql1)->result_array();
				$result[$key][$key2]['quantity'] = $quantity_array[0]['quantity'];
				$sql2 = "SELECT SUM(a.total_prices) as total_prices FROM yf_order_items as a
					INNER JOIN yf_order AS b ON a.order_id = b.order_id
					INNER JOIN yf_goods AS c ON a.goods_id = c.goods_id
					WHERE b.stage=8 AND b.phone=".$row2['phone']." AND c.class_id=".$row2['class_id'].$sql_order." GROUP BY c.class_id";
				$total_prices_array = $this->db->query($sql2)->result_array();
				$result[$key][$key2]['total_prices'] = number_format($total_prices_array[0]['total_prices'], 2, '.', '');
			}
		}
		return $result;
	}
}
