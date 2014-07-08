<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 商品分类模型层
 * 
 * @package		o2o_supermarket
 * @author 		lp1900
 * @copyright	Copyright (c) 2014. 云帆工作室.
 * @version		Version 1.1
 */
class Category_m extends MY_Model
{
	protected $_table = 'category';
	
	protected $primary_key = 'class_id';
	
	protected $soft_delete = TRUE;
	
	public function __construct()
	{
		parent::__construct();

		$this->load->library('pagination');
	}
	
	/**
	 * 获得分类表中全部记录
	 * 调用My_Model中get_all()
	 */
	
	/**
	 * 获得分类表中单条记录
	 * 调用My_Model中get()
	 */
	
	/**
	 * 获得分类表中单条class_name
	 */
	public function get_name($class_id)
	{
		$id = (int) $class_id;
		
		$result = $this->get_by('class_id', $id);
		
		// 以对象的形式返回结果集
		if (isset($result))
		{
			return $result->class_name;
		}
		return FALSE;
	}
	
	/**
	 * 添加分类
	 */
	public function add($parent_id, $class_name)
	{
		$id = (int) $parent_id;
		$data = array(
				'parent_id'		=>	$id,
				'class_name'	=>	$class_name
		);
		
		//插入新分类，成功则返回分类id，失败则返回FALSE
		return $this->insert($data);
	}
	
	/**
	 * 删除分类
	 */
	public function del($class_id)
	{
		$id = (int) $class_id;
		$this->db->where('class_id', $id);
		
		return $this->delete($id);
	}
	
	/**
	 * 编辑分类
	 */
	 public function modify($class_id, $class_name)
	{
		$id = (int) $class_id;
		$data = array(
				'class_id'		=>	$id,
				'class_name'	=>	$class_name
		);
		
		return $this->update($id, $data);
	}

}