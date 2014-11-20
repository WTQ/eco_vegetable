<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 用户模型层
 *
 * @package		o2o_supermarket
 * @author		Kung
 * @copyright	Copyright (c) 2014. 云帆工作室.
 * @since		Version 1.0
*/

class Article_m extends MY_Model
{
	protected $_table = 'article';

	protected $primary_key = 'aid';

	public function __construct()
	{
		parent::__construct();
		$this->load->model('article_type_m');
	}

	public function get_list($limit, $offset = 0, $type = 0, $order = 'aid DESC')
	{
		$i = 0;
		$return = array();
		if($type > 0) {
			$this->db->where('type', (int) $type);
		}
		$this->db->select('aid, type, title, add_time, add_date, add_user');
		$this->db->order_by($order);
		$query = $this->db->get('article', $limit, $offset);
		foreach ($query->result_array() as $row) {
			$return[$i] = $row;
			$return[$i]['type_name'] = $this->article_type_m->get_name($row['type']);
			++$i;
		}
		return $return;
	}
	
	public function set_list_type($type = 0)
	{
		if($type != 0) {
			$this->db->where('type', $type);
		}
		return $this;
	}
	
	/**
	 *
	 * @param integer $type
	 * @param string $name_keyword
	 * @param string $content_keyword
	 * @return integer 文章总数
	 * @todo 完成标题关键字，和内容关键字查询
	 */
	public function get_num($type = 0, $name_keyword = '', $content_keyword = '')
	{
		if($type != 0) {
			$this->db->where('type', $type);
		}
		if($name_keyword != '') {
			$this->db->like('title', $name_keyword);
		}
		if($content_keyword != '') {
				
		}
		return $this->count_all();
	}
	
	public function get_search($keyword = '', $limit, $offset = 0, $type = 0)
	{
		$return = array();
		$i = 0;
		$this->db->select('aid, type, title, add_time, add_date, add_user');
		$this->db->like('title', $keyword);
		$this->db->order_by('aid DESC');
		if($type != 0) {
			$this->db->where('type', $type);
		}
		$query = $this->db->get('article', $limit, $offset);
		foreach ($query->result_array() as $row) {
			$return[$i] = $row;
			$return[$i]['type_name'] = $this->article_type_m->get_name($row['type']);
			++$i;
		}
		return $return;
	}
	
	public function add($title, $type, $content, $add_user)
	{
		if($this->article_type_m->get_name($type) === FALSE) {
			return FALSE;
		}
		$data = array(
				'title'		=>	$title,
				'type'		=>	$type,
				'content'	=>	$content,
				'add_date'	=>	date('Y-m-d', time()),
				'add_time'	=>	time(),
				'add_user'	=>	$add_user,
		);
		return $this->insert($data);
	}
	
	public function edit($aid, $data)
	{
		$aid = (int) $aid;
		return $this->update(aid, $data);
	}
	
	public function del($aid)
	{
		return $this->delete($aid);			
	}
	
}