<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 文章类型控制器  for admin
 *
 * @package		o2o_supermarket
 * @author		Kung
 * @copyright	Copyright (c) 2014. 云帆工作室.
 * @since		Version 1.0
 */

class Article_type extends A_Controller 
{
	public function __construct() 
	{
		parent::__construct();
		$this->load->model(array('article_m', 'article_type_m'));
		$this->load->helper('page_helper');
	}
	
	public function index()
	{
		$data['types'] = $this->article_type_m->get_option();
	
		$this->load->view('admin/article_type_index.php', $data);
	}
	
	public function add()
	{
		if (is_post()) {
			$pid = (int) $this->input->post('pid');
			$name = $this->input->post('name', TRUE);
			if($name === FALSE || $pid < 0) {
				redirect('/admin/article_type');
			}
			$this->article_type_m->add_type($name, $pid);
			redirect('/admin/article_type');
		} else {
			$data['pid'] = 0;
			$data['name'] = '';
			$data['form_url'] = '/admin/article_type/add';
			$data['types'] = $this->article_type_m->get_option();
			
			$this->load->view('admin/article_type_add.php', $data);
		}
	}

	public function edit()
	{
		if (is_post()) {
			$tid = (int) $this->input->get('tid');
			$pid = (int) $this->input->post('pid');
			$name = $this->input->post('name', TRUE);
			if($tid < 1 || $pid < 0) {
				redirect('/admin/article_type');
			}
			$this->article_type_m->edit_type($tid, $name, $pid);
			redirect('/admin/article_type');
		} else {
			$tid = (int) $this->input->get('tid');
			if($tid < 0) {
				redirect('/admin/article_type');
			}
			$name = $this->article_type_m->get_name($tid);
			
			$data['pid'] = $this->article_type_m->get_parent($tid);
			$data['name'] = $name;
			$data['form_url'] = '/admin/article_type/edit/?tid=' . $tid;
			$data['types'] = $this->article_type_m->get_option();
			
			$this->load->view('admin/article_type_add.php', $data);
		}
	}
	
	public function del()
	{
		$tid = (int) $this->input->get('tid');
		if($tid < 0) {
			redirect('/admin/article_type');
		}
		$this->article_type_m->del_type($tid);
		redirect('/admin/article_type');
	}
	
}