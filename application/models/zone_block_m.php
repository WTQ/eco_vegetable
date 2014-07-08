<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 街区处理模型层
 *
 * @author Kung
 */

class Zone_block_m extends MY_Model 
{
	protected $_table = 'zone_block';
	
	protected $primary_key = 'block_id';
	
	public function __construct() 
	{
		parent::__construct();
	}
	
	public function get_district($block_id) 
	{
		$block_id = (int) $block_id;
		$query = $this->get($block_id);
		if($query) {
			return $query->district_id;
		}
		return FALSE;
	}
	
	public function get_community($block_id)
	{
		$block_id = (int) $block_id;
		$this->load->model('zone_community_m');
		$query = $this->zone_community_m->get_many_by('block_id', $block_id);
		if($query) {
			return $query;
		}
		return FALSE;
	}
	
	public function add($name, $district_id, $sort = 100) 
	{
		$data = array(
			'name'        => $name,
			'district_id' => $district_id,
			'sort'        => $sort,
		);
		return $this->insert($data);
	}
	
	public function edit($block_id, $name, $district_id, $sort = 100) 
	{
		$data = array(
			'name'        => $name,
			'district_id' => $district_id,
			'sort'        => $sort,
		);
		return $this->update($block_id, $data);
	}
	
	public function del($block_id)
	{
		$district_id = (int) $district_id;
		$this->load->model('zone_community_m');
		$query = $this->zone_community_m->get_many_by('block_id', $district_id);
		if($query) {			
			return FALSE;
		}
		return $this->delete($block_id);
	}
}


