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

		$shop_id = 1;
		$stage = $this->input->get('stage', TRUE);

		$data['orders'] = $this->order_m->to_excel($stage, $per_page, ($p-1)*$per_page);
		$i = 0;
		foreach ($data['orders'] as $key) {
			$data['orders'][$i]['username'] = $this->user_m->get_byid($key['user_id']);
			$i++;
		}
		$total_row = $this->order_m->num2excel($stage);
		$data['page_html'] =  $this->_page_init($per_page, $total_row, $shop_id, $stage);
		$data['shops'] = $this->shops_m->get_all();
		if($shop_id !== FALSE) {
			$data['keywords'] ='shop_id='.$shop_id.'&'.'stage='.$stage;
			
		} else {
			$data['keywords']='';
		}
		$data['shop_id'] = $shop_id;
		$data['stage'] = $stage;
		
		load_view('admin/order', $data);
	}
	
	public function gen_excel()
	{
		$shop_id = $this->input->get('shop_id');
		$stage = $this->input->get('stage');
		$this->load->library('excel');
		$Orders = $this->order_m->to_excel($stage);//$this->shops_m->shop_id2char($shop_id)
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
	
	public function edit_v()
	{
		$Order_id = $this->input->get('order_id', TRUE);
		$data['Order'] = $this->order_m->get($Order_id);
		$data['form_url'] = '/admin/order/edit/?id='. $Order_id;
		$data['Order']->username = $this->user_m->get_byid($data['Order']->user_id);

		load_view('admin/order_edit', $data);
	}
	
	public function edit()
	{
		$Order_id = $this->input->get('id', TRUE);
		
		$stage = $this->input->post('stage', TRUE);
		$this->order_m->set_stage($Order_id, $stage);
// 		$data['Order'] = $this->order_m->get($Order_id);
// 		$data['form_url'] = '/admin/order/edit/?id='. $Order_id;
// 		$data['Order']->username = $this->user_m->get_byid($data['Order']->user_id);
// 		load_view('admin/order_edit', $data);		
		redirect('admin/order');
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