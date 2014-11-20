<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 小区控制器  for admin
 *
 * @package		o2o_supermarket
 * @author		Kung
 * @copyright	Copyright (c) 2014. 云帆工作室.
 * @since		Version 1.0
 */

class Zone extends A_Controller 
{
	public function __construct() 
	{
		parent::__construct();
		$this->load->model(array('zone_district_m', 'zone_block_m', 'zone_community_m', 'shop_m'));
		$this->load->helper('page_helper');
	}
	
	public function index() 
	{
		$p = page_cur();
		$array['community'] = $this->zone_community_m->limit(10, ($p - 1) * 10)->get_all();
		
		foreach ($array['community'] as $row) {
			$block = $this->zone_block_m->get($row->block_id);
			$array['block'][$row->community_id] = $block;
			$array['district'][$row->community_id] = $this->zone_district_m->get($block->district_id);
		}
		
		$array['page_html'] = page($this->zone_community_m->count_all());
		
		$this->load->view('admin/zone_index', $array);
	}
	
	public function add() 
	{
		$array['now']['rank'] = '';
		$array['now']['block'] = '';
		$array['now']['district'] = '';
		$array['now']['community'] = '';
		
		if (is_post()) {
			$sort = $this->input->post('rank');
			$block = $this->input->post('block');
			$name = $this->input->post('community');

			$this->zone_community_m->add($name, $block, $sort);
			redirect('admin/zone');
		} else {
			$array['block'] = $this->zone_block_m->get_all();
			$array['district'] = $this->zone_district_m->get_all();
			$array['form_url'] = '/admin/zone/add/';
			
			load_view('admin/zone_add', $array);
		};
	}
	
	public function edit() 
	{
		if (is_post()) {
			$sort = $this->input->post('rank');
			$block = $this->input->post('block');
			$name = $this->input->post('community');
			$community_id = $this->input->get('id');

			$this->zone_community_m->edit($community_id, $name, $block, $sort);
			redirect('admin/zone');
						
		} else {
			$community_id = $this->input->get('id');
			$result = $this->zone_community_m->get($community_id);
			$result2 = $this->zone_block_m->get($result->block_id);
			
			$data['now']['rank'] = $result->sort;
			$data['now']['block'] = $result->block_id;
			$data['now']['district'] = $result2->district_id;
			$data['now']['community'] = $result->name;
			$data['block'] = $this->zone_block_m->get_all();
			$data['district'] = $this->zone_district_m->get_all();
			$data['form_url'] = '/admin/zone/edit/?id='.$community_id;
			
			load_view('admin/zone_add', $data);
		}
	}
	
	public function del() 
	{
		$community_id = $this->input->get('id');
		$result = $this->zone_community_m->get_shops($community_id);
		
		if($result) {
			echo "<script language=JavaScript>alert('删除失败');</script>";
			// redirect('admin/zone');
		} else {
			$this->zone_community_m->del($community_id);
			redirect('admin/zone');
		}
	}
}