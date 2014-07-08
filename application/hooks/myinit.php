<?php
/**
 * 初始化系统的时区等参数
 * 
 * @author 风格独特
 */
class MyInit
{
	public function __construct()
	{
		
	}
	
	public function init() 
	{
		$CI = & get_instance();
		
		// 加载基本的web_config配置文件，设置时区
		$CI->config->load('web_config');
		$time_zone = $CI->config->item('date_timezone');
		date_default_timezone_set($time_zone);
	}
}