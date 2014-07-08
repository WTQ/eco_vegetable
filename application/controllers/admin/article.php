<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 文章控制器  for admin
 *
 * @package		o2o_supermarket
 * @author		Kung
 * @copyright	Copyright (c) 2014. 云帆工作室.
 * @since		Version 1.0
 */

class Article extends A_Controller 
{
	public function __construct() 
	{
		parent::__construct();
		$this->load->model(array('article_m', 'article_type_m'));
		$this->load->helper('page_helper');
	}
	
	public function index() 
	{
		$p = page_cur();
		$data['articles'] = $this->article_m->get_list(10, ($p - 1) * 10);
		$data['page_html'] = page($this->article_m->count_all());
		
		$this->load->view('admin/article_index', $data);
	}
	
	public function add() 
	{
		if (is_post()) {
			$title = $this->input->post('title', TRUE);
			$type = (int) $this->input->post('type');
			$content = $this->input->post('ue_content');
			$this->article_m->add($title, $type, $content, 'Kung');
			redirect('/admin/article');			
		} else {
			$article_type = $this->article_m->article_type_m;
			
			$data['types'] = $article_type->get_option();
			$data['title'] = '';
			$data['content'] = '';
			$data['tid'] = 0;
			$data['form_url'] = '/admin/article/add';			

			$this->load->view('admin/article_add.php', $data);
		}
	}
	
	public function edit()
	{
		if (is_post()) {
			$aid = (int) $this->input->get('aid');
			$data['title'] = $this->input->post('title', TRUE);
			$data['type'] = (int) $this->input->post('type');
			$data['content'] = $this->input->post('ue_content');
			if($data['title'] === FALSE || $data['type'] === FALSE || $data['content'] === FALSE) {
				redirect('/admin/article');
			}
			$this->article_m->edit($aid, $data);
			redirect('/admin/article');
		} else {
			$aid = (int) $this->input->get('aid');
			$article = $this->article_m->get($aid);
			if($article === FALSE) {
				redirect('/admin/article');
			}
			
			$article_type = $this->article_m->article_type_m;
			$data['types'] = $article_type->get_option();
			$data['title'] = $article->title;
			$data['content'] = $article->content;
			$data['tid'] = $article->type;
			$data['form_url'] = '/admin/article/edit/?aid=' . $aid;
			
			$this->load->view('admin/article_add.php', $data);
		}
	}
	
	public function del() 
	{
		$aid = (int) $this->input->get('aid');
		if($aid > 1) {
			$this->article_m->del($aid);
		}
		redirect('/admin/article');		;
	}
}