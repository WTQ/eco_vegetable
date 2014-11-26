<?php
/**
 * APP client模型层
 * 
 * @author 风格独特
 * @version 1.0, 2014-09-01
 */

class App_client_m extends MY_Model 
{
	protected $_table = 'app_client';

	protected $primary_key = 'client_id';
	
	private $client;
	
	public function __construct() 
	{
		parent::__construct();
		$this->load->model('app_version_m');
	}
	
	/**
	 * 初始化
	 */
	public function init()
	{
		$uuid = post('uuid');
		$client = $this->get_by('uuid', (string) $uuid);
		
		// 获取版本信息
		$version_code = post('version_code');
		$platform = strtolower(trim(post('platform')));
			
		$where = array(
				'version_code'	=> $version_code,
				'platform'		=> $platform,
		);
		$version = $this->app_version_m->get_by($where);
		
		if (!isset($version->version_id)) {
			return FALSE;
		}
		
		// 如果uuid在库中，则更新客户端，如uuid不在库中则新建
		if (isset($client->client_id)) {
			// 获取client的信息
			$this->client = $client;
			$this->client->version = $version;
			
			// 更新客户端时间
			$update = array(
				'lastuse_time'	=> time(),
				'version_id'	=> $version->version_id,
			);
			return $this->update($client->client_id, $update);
		} else {
			// 将客户端信息更新至数据库
			$time = time();
			$data = array(
				'version_id'	=> $version->version_id,
				'model'			=> post('model'),
				'os_version'	=> post('os_version'),
				'platform'		=> strtolower(post('platform')),
				'uuid'			=> $uuid,
				'create_time'	=> $time,
				'update_time'	=> $time,
				'lastuse_time'	=> $time,
				'status'		=> 0,
			);
			$client_id = $this->insert($data);
			
			$this->client = $this->get($client_id);
			$this->client->version = $version;
			return TRUE;
		}
	}
	
	/**
	 * 获取client信息
	 * @return object
	 */
	public function get_client() 
	{
		return $this->client;
	}
	
	/**
	 * 获取client upgrade信息
	 */
	public function upgrade_info()
	{
		// upgrade_type为0不升级、1提示升级、2强制升级
		if ($this->client->version->upgrade_type > 0) {
			// 寻找需要升级的版本
			$upgrade_version = $this->app_version_m->get($this->client->version->upgrade_version);
			
			// 返回升级版本信息
			if (isset($upgrade_version->version_id)) {
				$data = array(
					'upgrade_type'		=> $this->client->version->upgrade_type,
					'upgrade_version'	=> $upgrade_version->version_code,
					'upgrade_desc'		=> $upgrade_version->upgrade_desc,
					'upgrade_url'		=> $upgrade_version->upgrade_url,
				);
				return $data;
			}
		} else {
			$data = array(
				'upgrade_type'	=> 0
			);
			return $data;
		}
	}
}