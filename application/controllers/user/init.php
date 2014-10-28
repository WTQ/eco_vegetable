<?php
/**
 * APP Client初始化时访问控制器，用来记录APP信息和反馈更新信息
 * 
 * @author 风格独特
 * @version 1.0， 2014-08-30
 */

class Init extends U_Controller 
{
	function index() 
	{
		load_model('app_client_m');
		
		if (!$this->app_client_m->init()) {
			$data = array(
				'error'		=> '1',
				'msg'		=> '客户端初始化失败'
			);
			return $this->json_out($data);
		}
		
		$upgrade_info = $this->app_client_m->upgrade_info();
		
		return $this->json_out($upgrade_info);
	}
}