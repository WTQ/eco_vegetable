<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 地址管理模型层
 *
 * @author Kung
 */

class Address_m extends MY_Model
{
	protected $_table      = 'yf_address';

	protected $primary_key = 'address_id';

	function __construct()
	{
		parent::__construct();
	}

	public function get_by_uid($user_id)
	{
		$address = $this->get_many_by('user_id', $user_id);

		return $address;
	}

	/**
	 * 获取用户默认地址
	 */
	public function get_default($user_id)
	{
		$user_id = (int) $user_id;
		$where   = "default = 1 AND user_id = $user_id";
		$result  = $this->get_by($where);

		return $result;
	}

	/**
	 * 添加用户地址
	 */
	public function add_address($user_id, $address='', $default=1)
	{
		$user_id      = (int) $user_id;
		//$community_id = (int) $community_id;
		// 先将其它的默认标志default置0
		$this->update_by(array('user_id' => $user_id), array('default' => 0));
		
		$data         = array(
			'user_id'        => $user_id,
			'name'           => $address,
			//'community_id'   => $community_id,
			//'community_name' => $community_name,
			'default'        => $default,
		);

		return $this->insert($data);
	}

	/**
	 * 更新地址，或完成add_address()未写入的address字段
	 * @return [type]          [description]
	 */
	public function update_address($address_id, $address='')
	{
		// 只更新add_address()未写入的address字段
		$data = array(
			'name'	=> $address,
		);
		return $this->update($address_id, $data);
	}
}

