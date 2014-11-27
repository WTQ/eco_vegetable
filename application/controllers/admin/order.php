<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Admin端订单管理控制器
 *
 * @package		eco_vegetable
 * @author 		lp1900
 * @copyright	Copyright (c) 2014. 云帆工作室.
 * @version		Version 1.0
 * @since		2014.7.10
 */

class Order extends A_Controller
{
	public function __construct()
	{
		parent::__construct();
		load_model( array('admin_user_m', 'shops_m', 'order_m', 'user_m') );
		load_helper('page');
		load_library('excel');
		load_helper('form');
		load_helper('order_stage_helper');
	}

	public function index()
	{
		$per_page = 20;
		$p = (int) page_cur();
		$data['p'] = $p;
		$shop_id = 1;
		$print     = $this->input->get('print',TRUE);
		$stage     = $this->input->get('stage', TRUE);
		$date_type = $this->input->get('date_type', TRUE);
		$date      = $this->input->get('date', TRUE);
		$keywords  = $this->input->get('search_input', TRUE);
		$data['orders'] = $this->order_m->to_excel($stage, $keywords,$date_type,$date, $per_page, ($p-1)*$per_page);
		$i = 0;
		foreach ($data['orders'] as $key) {
			$data['orders'][$i]['username'] = $this->user_m->get_byid($key['user_id']);
			$i++;
		}
		$total_row = $this->order_m->num2excel($stage, $keywords,$date_type,$date);
		$data['page_html'] =  $this->_page_init($per_page, $total_row, $shop_id, $stage);
		$data['shops'] = $this->shops_m->get_all();
		if($shop_id !== FALSE) {
			$data['keywords'] ='shop_id='.$shop_id.'&stage='.$stage.'&search_input='.$keywords.'&date_type='.$date_type.'&date='.$date.'&p='.$p;

		} else {
			$data['keywords']='';
		}
		$data['shop_id'] = $shop_id;
		$data['stage'] = $stage;
		$data['date_type'] = $date_type;
		$data['date'] = $date;
		$data['search_input'] = $keywords;
		if ($print == 1) {
			load_view('admin/order_bulk_print', $data);
		} else {
			load_view('admin/order', $data);
		}
	}

/*	public function order_bulk_print()
	{
		$per_page = 20;
		$p = (int) page_cur();
		$data['p'] = $p;
		$shop_id = 1;
		$stage = $this->input->get('stage', TRUE);
		$keywords = $this->input->get('search_input', TRUE);
	
		$data['orders'] = $this->order_m->to_excel($stage, $keywords, $per_page, ($p-1)*$per_page);
		$i = 0;
		foreach ($data['orders'] as $key) {
			$data['orders'][$i]['username'] = $this->user_m->get_byid($key['user_id']);
			$i++;
		}
		$total_row = $this->order_m->num2excel($stage);
		//$data['page_html'] =  $this->_page_init($per_page, $total_row, $shop_id, $stage);
		$data['shops'] = $this->shops_m->get_all();
		if($shop_id !== FALSE) {
			$data['keywords'] ='shop_id='.$shop_id.'&stage='.$stage.'&search_input='.$keywords.'&p='.$p;
	
		} else {
			$data['keywords']='';
		}
		$data['shop_id'] = $shop_id;
		$data['stage'] = $stage;
		$data['search_input'] = $keywords;
	
		load_view('admin/order_bulk_print', $data);
	}*/
	
	public function del_some()
	{
		$order_id = $this->input->get('order_id');
		if($this->order_m->del_some($order_id))
		{
			$data = array(
				'result' => TRUE,
			);
			return $this->json_out($data);
		} else {
			$data = array(
					'result' => FALSE,
			);
			return $this->json_out($data);
		}
	}
	
	public function order_goods()
	{
		$per_page = 20;
		$p = (int) page_cur();
		$print      = $this->input->get('print',TRUE);
		//$stage      = $this->input->get('stage', TRUE);
		$sort_stage = $this->input->get('sort_stage', TRUE);
		$date_type  = $this->input->get('date_type', TRUE);
		$date       = $this->input->get('date',TRUE);
		$keywords   = $this->input->get('search');
		$type       = $this->input->get('type');
		$month      = (int)get ('month');
		/*if (empty($stage)) {
			$stage = 0;
		}*/
		if (empty($sort_stage)) {
			$sort_stage = 0;
		}
		if (empty($keywords)) {
			$keywords = 0;
		}
		if (empty($month)) {
			$month = 0;
		}
		if($type == '0') {
			$data['orders'] = $this->order_m->goods_list($sort_stage, $month,$date_type,$date, $keywords);
		} else {
			$data['orders'] = $this->order_m->goods_list_address($sort_stage, $month,$date_type,$date,$keywords);
		}
		//$data['stage'] = $stage;
		$data['sort_stage'] = $sort_stage;
		$data['search_keywords'] = $keywords;
		$data['keywords'] = 'sort_stage='.$sort_stage.'&search='.$keywords.'&month='.$month.'&type='.$type.'&date_type='.$date_type.'&date='.$date.'&p='.$p;
		$data['type'] = $type;
		$data['month'] = $month;
		$data['date_type'] = $date_type;
		$data['date'] = $date;
		if ($print == 1) {
			load_view('admin/order_goods_print', $data);
		} else {
			load_view('admin/order_goods', $data);
		}
	}
	/**
	 * 活动页面
	 */
	public function order_active()
	{	
		$month      = $this->input->get('month',TRUE);
		$month_type = $this->input->get('month_type', TRUE);//前半月，后半月
		$date       = $this->input->get('date',TRUE);
		$type       = $this->input->get('type',TRUE);//用户名、地址
		$keywords   = $this->input->get('search',TRUE);
		if (empty($month_type)) {
			$month_type = 0;
		}
		if (empty($month)) {
			$month = 0;
		}
		if (empty($date)) {
			$date = 0;
		}
		$data['orders'] = $this->order_m->order_active_query($month,$month_type,$date,$type,$keywords);
		$data['month_type'] = $month_type;
		$data['month'] = $month;
		$data['date'] = $date;
		$data['type'] = $type;
		$data['keywords'] = $keywords;
		$this->load->view('admin/order_active',$data);
	}
	
	/**
	 * 订单商品统计打印
	 */
/*	public function goods_statistic_print()
	{
		$per_page = 20;
		$p = (int) page_cur();
		$stage = $this->input->get('stage', TRUE);
		if (empty($stage)) {
			$stage = 0;
		}
	
		$sort_stage = $this->input->get('sort_stage', TRUE);
		if (empty($sort_stage)) {
			$sort_stage = 0;
		}
		$type = $this->input->get('type');
		$month = (int)get ('month');
		if (empty($month)) {
			$month = 0;
		}
		
		$keywords = $this->input->get('search');
		if (empty($keywords)) {
			$keywords = 0;
		}
		if($type == '0') {
			$data['orders'] = $this->order_m->goods_list($stage, $sort_stage, $month, $keywords);
		} else {
			$data['orders'] = $this->order_m->goods_list_address($stage, $sort_stage, $month ,$keywords);
		}
		$data['stage'] = $stage;
		$data['sort_stage'] = $sort_stage;
		$data['keywords'] = $keywords;
		load_view('admin/order_goods_print', $data);
	}*/

	public function detail()
	{
		$order_id = $this->input->get('id');
		$data['orders'] = $this->order_m->to_detail($order_id);
		$data['orders']['username'] = $this->user_m->get_byid($data['orders']['user_id']);
		load_view('admin/order_detail', $data);
	}


	public function gen_excel()
	{
		$shop_id = 1;
		$stage = $this->input->get('stage', TRUE);
		$keywords = $this->input->get('search_input', TRUE);
		$date_type = $this->input->get('date_type',TRUE);
		$date = $this->input->get('date',TRUE);
		$this->load->library('excel');
		$Orders = $this->order_m->to_excel($stage, $keywords,$date_type,$date);//$this->shops_m->shop_id2char($shop_id)
		if($shop_id == FALSE) {
			$shop['shop_name'] = '全部店铺';
		} else {
			$shop = $this->shops_m->get($shop_id);
		}
		$i = 0;
		foreach ($Orders as $key) {
			$Orders[$i]['username'] = $this->user_m->get_byid($key['user_id']);
			$i++;
		}
		$this->excel->index($Orders, $shop);
		if ( $stage == 1) {
			foreach($Orders as $Order) {
	 			$this->order_m->set_stage($Order['order_id'], 5);
	 		}
		}
	}
	
	public function goods_excel()
	{
		$shop_id = 1;
		if($shop_id == FALSE) {
			$shop['shop_name'] = '全部店铺';
		} else {
			$shop = $this->shops_m->get($shop_id);
		}
/*		$stage = $this->input->get('stage', TRUE);
		if (empty($stage)) {
			$stage = 0;
		}*/
		$sort_stage = $this->input->get('sort_stage', TRUE);
		$keywords = $this->input->get('search');
		$date_type = $this->input->get('date_type',TRUE);
		$date = $this->input->get('date',TRUE);
		$month      = (int)get ('month');
		$type       = $this->input->get('type');     //判断按地址搜索还是按商品名搜索
		if (empty($sort_stage)) {
			$sort_stage = 0;
		}
		if (empty($keywords)) {
			$keywords = 0;
		}
		if (empty($month)) {
			$month = 0;
		}
		if($type == '0') {
			$Orders = $this->order_m->goods_list($sort_stage, $month,$date_type,$date, $keywords);
		} else {
			$Orders = $this->order_m->goods_list_address($sort_stage, $month,$date_type,$date,$keywords);
		}
		$this->load->library('order_goods_excel');
		$this->order_goods_excel->index($Orders, $shop);
	}

	public function gen_word()
	{
		$per_page = 2;
		$p = (int) page_cur();
		$shop_id = $this->input->get('shop_id');
		$stage = $this->input->get('stage');
		$this->load->library('word');
		$Orders = $this->order_m->to_word($stage,$per_page,($p-1)*$per_page);//$this->shops_m->shop_id2char($shop_id)
		$i = 0;
		foreach ($Orders as $key) {
			$Orders[$i]['username'] = $this->user_m->get_byid($key['user_id']);
			$i++;
			//var_dump($key['items']);
		}
		$this->word->index($Orders);
		if ( $stage == 1) {
			foreach($Orders as $Order) {
				$this->order_m->set_stage($Order['order_id'], 5);
			}
		}
	}

	public function edit_v()
	{
		$Order_id = $this->input->get('order_id', TRUE);
		$data['Order'] = $this->order_m->get($Order_id);
		$p = $this->input->get('p');
		$data['form_url'] = '/admin/order/edit/?id='. $Order_id.'&p='.$p;
		$data['Order']->username = $this->user_m->get_byid($data['Order']->user_id);

		load_view('admin/order_edit', $data);
	}

	public function edit()
	{
		$Order_id = $this->input->get('id', TRUE);
		$p = $this->input->get('p');
		$stage = $this->input->post('stage', TRUE);
		$this->order_m->set_stage($Order_id, $stage);
// 		$data['Order'] = $this->order_m->get($Order_id);
// 		$data['form_url'] = '/admin/order/edit/?id='. $Order_id;
// 		$data['Order']->username = $this->user_m->get_byid($data['Order']->user_id);
// 		load_view('admin/order_edit', $data);
		redirect('admin/order?p='.$p);
	}
	
	public function del()
	{
		$p = $this->input->get('p');
		$Order_id = $this->input->get('id', TRUE);
		$this->order_m->del($Order_id);
		redirect('admin/order?p='.$p);
	}

	public function del_all()
	{
		$name = $this->input->get('name');
		$this->order_m->del_all_order($name);
		redirect('admin/order/order_goods');
	}
	private function _page_init($per_page, $total_row, $shop_id, $stage)
	{
		$this->load->library('pagination');

		$config['total_rows'] = $total_row;

		$config['per_page'] = $per_page;
		if($shop_id) {
			$config['base_url'] = '/admin/order/?shop_id='. $shop_id. '&stage='. $stage;
		} else {
			$config['base_url'] = '/admin/order/?';
		}
		$config['num_links'] = 10;
		$config['query_string_segment'] = 'p';
		$config['first_link'] = '首页';
		$config['last_link'] = '末页';
		$config['prev_link'] = '上一页';
		$config['next_link'] = '下一页';
		$config['use_page_numbers'] = TRUE;
		$config['page_query_string'] = TRUE;

		$this->pagination->initialize($config);
		return $this->pagination->create_links();
	}
}
