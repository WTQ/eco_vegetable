<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 区域控制器
 *
 * @package		o2o_supermarket
 * @author		Kung
 * @copyright	Copyright (c) 2014. 云帆工作室.
 * @since		Version 1.0
 */

class Zone extends U_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('zone_district_m', 'zone_block_m', 'zone_community_m', 'shop_m', 'address_m'));
	}

	public function index()
	{
		// 获取所有的地区如海淀区、朝阳区等
		$data['district'] = $this->zone_district_m->get_all();
		// 获取所有的街区如魏公村、中关村等
		$blocks = $this->zone_block_m->get_all();

		// 遍历所有的社区，并踢出没有店铺的社区
		foreach ($blocks as $row) {
			$i = 0;
			$data['community'][$row->block_id] = $this->zone_block_m->get_community($row->block_id);
			if(is_array($data['community'][$row->block_id])) {
				foreach ($data['community'][$row->block_id] as $row2) {
					$community_id = $row2->community_id;
					$result = $this->zone_community_m->get_shops($community_id);

					if (!$result) {
						array_splice($data['community'][$row->block_id], $i, 1);
					} else {
						$i++;
					}
				}
			}
		}

		// 遍历所有的街区，并踢出没有店铺的街区
		foreach ($data['district'] as $row) {
			$i = 0;
			$data['block'][$row->district_id] = $this->zone_district_m->get_block($row->district_id);
			//var_dump($data['block']);
			if(is_array($data['block'][$row->district_id])) {
				foreach ($data['block'][$row->district_id] as $row3) {
					$block_id = $row3->block_id;

					if (!$data['community'][$block_id]) {
						array_splice($data['block'][$row->district_id], $i, 1);
					} else {
						$i++;
					}
				}
			}
		}

		// 遍历所有的行政区，并踢出没有店铺的行政区
		$i = 0;
		foreach ($data['district'] as $row) {
			$district_id = $row->district_id;
			if (is_array($data['block'][$district_id])) {
				if ($data['block'][$district_id]) {
					$i++;
				} else {
					array_splice($data['district'], $i, 1);
				}
			} else {
				array_splice($data['district'], $i, 1);
			}
		}

		load_view('user/zone_index.php', $data);
	}

	public function select_district()
	{
		$province_id      = (int) get('province_id');

		$data['district'] = $this->zone_province_m->get_district($province_id);

		load_view('user/district_list.php', $data);
	}

	/**
	 * 由小区名搜索对应的商铺
	 */
	public function select_community()
	{
		$keyword         = get('name');
		$data['result']  = $this->zone_community_m->get_search($keyword, 5);
		$data['keyword'] = $keyword;

		$this->json_out($data);
	}

	public function search_shop()
	{
		$community_id = (int) get('community_id');
		$shop_id      = $this->zone_community_m->get_shops($community_id);
		$data         = array();

		if($shop_id) {
			set_cookie('community_id', $community_id, 3600 * 24 * 365);
			set_cookie('shop_id', $shop_id, 3600 * 24 * 365);
			$data['shop_id'] = $shop_id;
		} else {
			$data['shop_id'] = 0;
		}

		$this->json_out($data);
	}

	public function save_community()
	{
		$address_id   	= (int) get('address_id');
		$address      	= get('user_address');
		$user_id		= get('user_id');
		$data         = array();
		if ( ($this->address_m->add_address($user_id,$address,$address_id)) != FALSE) {
			$data['error'] = 0;
		} else {
			$data['error'] = 1;
		}

		$this->json_out($data);
	}

	public function change_address()
	{
		if ($this->check_login() == FALSE) {
			$data = array(
					'status' => 10,
					'msg'    => '用户未登录'
			);
		
			return $this->json_out($data);
		}
		
		$address_id   = (int) get('address_id');
		$result       = $this->address_m->get($address_id);

		//$community_id = $result->community_id;
		$shop_id      = 1;
		$data         = array();

		if ($shop_id > 0) {
			set_cookie('address_id', $address_id, 3600 * 24 * 365);
			set_cookie('shop_id', $shop_id, 3600 * 24 * 365);

			$this->_change_default_address($address_id);

			$data = array(
				'shop_id'        => $shop_id,
				'user_address'   => $result->name,
				'error'          => 0,
			);
		} else {
			$data = array(
				'error' => 1,
				'msg'	=> '该地址目前没有商户',
			);
		}
		$this->json_out($data);
	}

	private function _change_default_address($address_id)
	{
		$address = $this->address_m->get($address_id);
		$user_id = $address->user_id;

		$user_address = $this->address_m->get_by_uid($user_id);

		$this->db->where('user_id', $address->user_id);
		$this->db->update('address', array('default' => 0));

		$this->address_m->update($address->address_id, array('default' => 1));
	}
	
	/**
	 * 删除指定地址
	 */
	public function delete_address()
	{
		if ($this->check_login() == FALSE) {
			$data = array(
					'status' => 10,
					'msg'    => '用户未登录'
			);
		
			return $this->json_out($data);
		}
		
		$address_id = get('address_id');
		$this->db->where('address_id', $address_id);
		if($this->db->delete('address')) {
			$data['error'] = 0;
		} else {
			$data['error'] = 1;
		}
		return $this->json_out($data);
	}
}

