<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 用户模型层
 *
 * @package		o2o_supermarket
 * @author		Kung
 * @copyright	Copyright (c) 2014. 云帆工作室.
 * @since		Version 1.0
*/

class Article_type_m extends MY_Model
{
	/**
	 * cid树
	 *
	 * @var array
	 */
	private $type_tree = array();

	/**
	 * 所有cid节点
	 *
	 * @var array
	*/
	private $tids = array();
	
	protected $_table = 'article_type';
	
	protected $primary_key = 'tid';

	public function __construct()
	{
		parent::__construct();
		$this->_init_type();
	}

	public function get_parent($tid)
	{
		if(isset($this->tids[$tid])) {
			return $this->tids[$tid]['pid'];
		}
		return -1;
	}

	public function get_child($tid, & $cids_child)
	{
		$i = 0;
		$cids_child = array();
		if(!isset($this->tids[$tid])) {
			return 0;
		}

		$pid = $this->get_parent($tid);
		if($pid > 0) {
			$ppid = $this->get_parent($pid);
			if($ppid > 0) {
				$childs = array();
			} else {
				$childs = $this->type_tree[$pid]['cids'][$tid]['cids'];
			}
		} else {
			$childs = $this->type_tree[$tid]['cids'];
		}

		foreach ($childs as $key => $value) {
			$cids_child[$i] = $key;
			++$i;
		}
		return $i;
	}

	public function get_name($tid)
	{
		if(isset($this->tids[$tid])) {
			return $this->tids[$tid]['name'];
		}
		return '';
	}

	public function add_type($name, $pid = 0)
	{
		$pid = (int) $pid;
		if($pid != 0 && !isset($this->tids[$pid])) {
			return FALSE;
		}
		$ppid = $this->get_parent($pid);
		$pppid = $this->get_parent($ppid);
		if($pid == 0 || $ppid == 0 ||  $pppid == 0) {
			$data = array(
					'pid'	=>	$pid,
					'name'	=>	$name,
			);
			if($this->db->insert('article_type', $data) === FALSE) {
				return FALSE;
			}
			$tid = $this->db->insert_id();
			$this->tids[$tid] = array(
					'pid'	=>	$pid,
					'name'	=>	$name,
			);
			if($pid == 0) {
				// 一级类别
				$this->type_tree[$tid] = $this->tids[$tid];
				$this->type_tree[$tid]['cids'] = array();
			} elseif ($ppid == 0) {
				// 二级类别
				$this->type_tree[$ppid]['cids'][$tid] = $this->tids[$tid];
				$this->type_tree[$ppid]['cids'][$tid]['cids'] = array();
			} else {
				// 三级类别
				$this->type_tree[$pppid]['cids'][$ppid]['cids'][$tid] = $this->tids[$tid];
			}
			return $tid;
		}
		return FALSE;
	}

	public function edit_type($tid, $name, $pid = 0)
	{
		$data = array(
				'pid'	=>	$pid,
				'name'	=>	$name,
		);
		if($this->update($tid, $data) === FALSE) {
			return FALSE;
		}
		return TRUE;
	}

	public function del_type($tid)
	{
		$cids = array();
		if($this->get_child($tid, $cids) > 0) {
			return FALSE;
		}
		if($this->delete($tid) === FALSE) {
			return FALSE;
		}
		return TRUE;
	}

	private function _init_type()
	{
		$this->db->order_by('pid ASC, tid ASC');
		$query = $this->db->get('article_type');
		if($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$key = $row['tid'];
				$this->tids[$key] = array(
						'pid'	=>	$row['pid'],
						'name'	=>	$row['name'],
				);

				if($row['pid'] == 0) {
					// 一级类别
					$this->type_tree[$key] = $this->tids[$key];
					$this->type_tree[$key]['cids'] = array();
				} else if($this->get_parent($row['pid']) == 0) {
					// 二级类别
					$key_2 = $row['pid'];
					$this->type_tree[$key_2]['cids'][$key] = $this->tids[$key];
					$this->type_tree[$key_2]['cids'][$key]['cids'] = array();
				} else {
					// 三级类别
					$key_2 = $row['pid'];
					$key_3 = $this->get_parent($row['pid']);
					$this->type_tree[$key_3]['cids'][$key_2]['cids'][$key] = $this->tids[$key];
				}
			}
		}
	}

	public function get_option()
	{
		$return = array();
		$i = 0;
		foreach ($this->type_tree as $key_1 => $type_1) {
			$return[$i]['tid'] = $key_1;
			$return[$i]['name'] = $type_1['name'];
			$return[$i]['pid'] = $type_1['pid'];
			$return[$i]['level'] = 1;
			++$i;
			foreach ($type_1['cids'] as $key_2 => $type_2) {
				$return[$i]['tid'] = $key_2;
				$return[$i]['name'] = $type_2['name'];
				$return[$i]['pid'] = $type_2['pid'];
				$return[$i]['level'] = 2;
				++$i;
				foreach ($type_2['cids'] as $key_3 => $type_3) {
					$return[$i]['tid'] = $key_3;
					$return[$i]['name'] = $type_3['name'];
					$return[$i]['pid'] = $type_3['pid'];
					$return[$i]['level'] = 3;
					++$i;
				}
			}
		}
		return $return;
	}
}