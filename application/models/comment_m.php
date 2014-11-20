<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 买家评论模型层
 * 
 * @package		o2o_supermarket
 * @author 		lp1900
 * @copyright	Copyright (c) 2014. 云帆工作室.
 * @version		Version 1.1
 * @since		2014.4.4
 */
class Comment_m extends MY_Model
{
	protected $_table = 'comment';
	
	protected $primary_key = 'cmt_id';
	
	protected $soft_delete = TRUE;
	
	public function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * 由父id获得子评论
	 */
	public function get_sub($parent_id)
	{
		$id = (int) $parent_id;
		$this->order_by('cmt_id', 'DESC');
		
		// 结果集以对象数组返回
		return $this->get_by('parent_id', $id);
	}
	
	/**
	 * 查询评论并下询子评论
	 */
	public function get_cmt($cmt_id)
	{
		$id = (int) $cmt_id;
		$result = new stdClass();
		$this->db->where('cmt_id', $id);
		$query = $this->db->get('comment');
		
		if ($query->num_rows() > 0) {
			$result->cmt = $query->result();
			$result->sub_cmt = $this->get_sub($id);
		}
		
		// 结果集以对象返回
		return $result;
	}
	
	/**
	 * 查询买家评论（非回复）条数
	 */
	public function get_num($parent_id = 0)
	{
		$id = (int) $parent_id;
		$this->db->where('parent_id', $id);
		$this->db->from('comment');
		
		return $this->db->count_all_results();
	}
	
	/**
	 * 查询指定商家下的全部评论
	 */
	public function get_shop($shop_id)
	{
		$id = (int) $shop_id;
		// 按评论先后排列
		$this->order_by('cmt_id', 'DESC');
		
		$result = $this->get_all();
		
		return $result;
	}
	
	/**
	 * 买家添加评论
	 */
	public function add($title, $user, $content)
	{
		$data = array(
				'title'		=>	$title,
				'user'		=>	$user,
				'content'	=>	$content,
				'time'		=>	time(),
			);
		
		return $this->insert($data);
	}
	
	/**
	 * 商家回复
	 */
	public function reply($cmt_id, $content)
	{
		$id = (int) $cmt_id;
		$data = array(
				'parent_id'	=>	$id,
				'content'	=>	$content,
				'time'		=>	time(),
			);
		
		return $this->insert($data);
	}
	
	/**
	 * （软）删除评论及其回复
	 */
	public function del($cmt_id)
	{
		$id = (int) $cmt_id;
		$this->db->where('cmt_id', $id);
		$this->db->or_where('parent_id', $id);
		
		return $this->delete($id);
	}
	
	/**
	 * 修改回复
	 */
	public function modify($cmt_id, $data)
	{
		$id = (int) $cmt_id;
		$this->db->where('cmt_id', $id);
		
		return $this->update($id, $data);
	}
}