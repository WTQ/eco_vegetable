<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 社区处理模型层
 *
 * @author Kung
*/

class Zone_community_m extends MY_Model
{
	protected $_table = 'zone_community';

	protected $primary_key = 'community_id';

	public function __construct()
	{
		parent::__construct();
		$this->load->model('zone_block_m');
		$this->load->model('zone_district_m');
	}

	public function get_block($community_id)
	{
		$community_id = (int) $community_id;
		$query = $this->get($community_id);
		if($query) {
			return $query->block_id;
		}
		return FALSE;
	}

	/**
	 * 查询community_id下的所有商家
	 * @return shop_id 或者 FALSE
	 */
	public function get_shops($community_id)
	{
		$community_id = (int) $community_id;
		$this->load->model('shop_m');
		$shop = $this->shop_m->get_by('community_id', $community_id);

		if (isset($shop->shop_id)) {
			return $shop->shop_id;
		}
		return FALSE;
	}

	public function get_search($keyword = '', $limit, $offset = 0)
	{
		$return = array();
		$i      = 0;
		$this->db->select('community_id, name');
		$this->db->like('name', $keyword);
		$this->db->order_by('community_id DESC');

		$query  = $this->db->get('zone_community', $limit, $offset);
		foreach ($query->result_array() as $row) {
			$return[$i]                 = $row;
			$return[$i]['community_id'] = $row['community_id'];
			$return[$i]['name']         = $row['name'];
			$return[$i]['name_encode']  = urlencode($row['name']);	// 中文编码为可用的url
			$return[$i]['belong']       = $this->get_district($row['community_id']);
			$return[$i]['shop_id']		= $this->get_shops($row['community_id']);
			++$i;
		}
		return $return;
	}

	// 搜索小区所属的商业区和行政区
	private function get_district($community_id)
	{
		$result = $this->get($community_id);
		if($result)
		{
			$block_id = $result->block_id;
			$result2= $this->zone_block_m->get($block_id);
			$district_id = $result2->district_id;
			$array['block_name'] = $result2->name;
			$result3 = $this->zone_district_m->get($district_id);
			$array['district_name'] = $result3->name;
			return $array;
		}
	}

	public function add($name, $block_id, $sort = 100)
	{
		$data = array(
			'name'        => $name,
			'block_id'    => $block_id,
			'sort'        => $sort,
		);
		return $this->insert($data);
	}

	public function edit($community_id, $name, $block_id, $sort = 100)
	{
		$data = array(
			'name'        => $name,
			'block_id' => $block_id,
			'sort'        => $sort,
		);
		return $this->update($community_id, $data);
	}

	public function del($community_id)
	{
		$community_id = (int) $community_id;
		$this->load->model('shop_m');
		$query = $this->shop_m->get_many_by('community_id', $community_id);
		if($query) {
			return FALSE;
		}
		return $this->delete($community_id);
	}

}


