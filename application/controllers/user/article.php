<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 区域控制器
 *
 * @package		o2o_supermarket
 * @author		Kung
 * @copyright	Copyright (c) 2014. 云帆工作室.
 * @since		Version 1.0
 */

class Article extends CI_Controller 
{	
	/**
	 * 构造函数
	 */
	public function __construct() 
	{
		parent::__construct();
		$this->load->model('article_m');
		$this->load->model('article_type_m');
		$this->load->library('cart');
		$this->load->model('user_m');
	}

	// 首页
	public function index()
	{
		$aid = (int) $this->input->get('aid');
		$data['article'] = $this->article_m->get($aid);
		
		if($data['article'] == FALSE) {
			$result['article'] = $this->article_m->get_all();
			$this->load->view('/user/article_list', $result);
		} else {
			$this->load->view('/user/article_index', $data);
		}
	}
	
	// 分类显示文章列表
	public function type() 
	{

	}
	
	// 初始化分页类
	private function _page_init($per_page)
	{

	}
	
	public function search()
	{
		$aid = $this->input->get('id');
		$result = $this->article_m->get($aid);
		$data['title'] = $result->title;
		$data['content'] = $result->content;
		
		$this->load->view('user/news.php', $data);
	}
}
