<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 订单管理的控制类
 * 
 * @author 风格独特
 */

class Order extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin_user_m');
		if($this->admin_user_m->check_login() === FALSE) {
			redirect('/admin/index');
		}
		$this->load->model('shops_m');
		$this->load->library('excel');
		$this->load->model('order_m');
		$this->load->helper('form');
	}
	
	public function index() 
	{
		$per_page = 20;
		$p = (int) $this->input->get('p');
		if($p < 1) {
			$p = 1;
		}
		
		$shop_id = $this->input->get('shop_id', TRUE);
		$stage = $this->input->get('stage', TRUE);

		$school = $this->shops_m->shop_id2char($shop_id);
		$data['orders'] = $this->order_m->to_excel($school, $stage, $per_page, ($p-1)*$per_page);
		$total_row = $this->order_m->num2excel($school, $stage);
		$data['page_html'] =  $this->_page_init($per_page, $total_row, $shop_id, $stage);
		$data['shops'] = $this->shops_m->get_all();
		if($shop_id !== FALSE) {
			$data['keywords'] ='shop_id='.$shop_id.'&'.'stage='.$stage;
			
		} else {
			$data['keywords']='';
		}
		$data['shop_id'] = $shop_id;
		$data['stage'] = $stage;
		$this->load->view('admin/header.php', array('username' => $this->admin_user_m->user->username));
		$this->load->view('admin/left_navi.php');
		$this->load->view('admin/order.php', $data);
		$this->load->view('admin/footer.php');
	}
	
	public function gen_excel()
	{
		$shop_id = $this->input->get('shop_id');
		$stage = $this->input->get('stage');
		$this->load->library('excel');
		$Orders = $this->order_m->to_excel($this->shops_m->shop_id2char($shop_id), $stage);
		if($shop_id == FALSE) {
			$shop['shop_name'] = '全部店铺';
		} else {
			$shop = $this->shops_m->get($shop_id);
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
		
		$this->load->view('admin/header.php', array('username' => $this->admin_user_m->user->username));
		$this->load->view('admin/left_navi.php');
		$this->load->view('admin/order_edit.php', $data);
		$this->load->view('admin/footer.php');
	}
	
	public function edit()
	{
		$Order_id = $this->input->get('id', TRUE);
		
		$stage = $this->input->post('stage', TRUE);
		$this->order_m->set_stage($Order_id, $stage);
		$data['Order'] = $this->order_m->get($Order_id);
		$data['form_url'] = '/admin/order/edit/?id='. $Order_id;
	
		$this->load->view('admin/header.php', array('username' => $this->admin_user_m->user->username));
		$this->load->view('admin/left_navi.php');
		$this->load->view('admin/order_edit.php', $data);
		$this->load->view('admin/footer.php');
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