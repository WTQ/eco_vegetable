<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 地区处理模型层
 *
 * @author Kung
 */

class Zone_district_m extends MY_Model 
{
	protected $_table = 'zone_district';
	
	protected $primary_key = 'district_id';
	
	public function __construct() 
	{
		parent::__construct();
	}
	
	public function get_province($district_id) 
	{
		$district_id = (int) $district_id;
		$query = $this->get($district_id);
		if($query) {
			return $query->province_id;
		}
		return FALSE;
	}
	
	public function get_block($district_id)
	{
		$district_id = (int) $district_id;
		$this->load->model('zone_block_m');
		$query = $this->zone_block_m->get_many_by('district_id', $district_id);
		if($query) {
			return $query;
		}
		return FALSE;
	}
	
	public function add($name, $province_id, $sort = 100) 
	{
		$data = array(
			'name'        => $name,
			'province_id' => $province_id,
			'sort'        => $sort,
		);
		return $this->insert($data);
	}
	
	public function edit($district_id, $name, $province_id, $sort = 100) 
	{
		$data = array(
			'name'        => $name,
			'province_id' => $province_id,
			'sort'        => $sort,
		);
		return $this->update($district_id, $data);
	}
	
	public function del($district_id)
	{
		$district_id = (int) $district_id;
		$this->load->model('zone_block_m');
		$query = $this->zone_block_m->get_many_by('district_id', $district_id);
		if($query) {			
			return FALSE;
		}
		return $this->delete($district_id);
	}
}


