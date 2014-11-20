<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 省/市 处理模型层
 *
 * @author Kung
 */

class Zone_province_m extends MY_Model 
{
	protected $_table = 'zone_province';
	
	protected $primary_key = 'province_id';
	
	public function __construct() 
	{
		parent::__construct();
	}
	
	public function get_district($province_id) 
	{
		$province_id = (int) $province_id;
		$this->load->model('zone_district_m');
		$query = $this->zone_district_m->get_many_by('province_id', $province_id);
		if($query) {
			return $query;
		}
		return FALSE;
	}
	
	public function add($name, $sort = 100) 
	{
		$data = array(
			'name' => $name,
			'sort' => $sort,
		);
		return $this->insert($data);
	}
	
	public function edit($province_id, $name, $sort = 100) 
	{
		$data = array(
			'name' => $name,
			'sort' => $sort,
		);
		return $this->update($province_id, $data);
	}
	
	public function del($province_id)
	{
		$province_id = (int) $province_id;
		$this->load->model('zone_district_m');
		$query = $this->zone_district_m->get_many_by('province_id', $province_id);
		if($query) {			
			return FALSE;
		}
		return $this->delete($province_id);
	}
	
}


