<?php
/**
 * 云通讯短信验证码封装
 * 
 * @author 风格独特
 * @version 1.0 2014-05-03
 */

/**
 * 向指定手机发送验证码
 * 
 * @param string $phone
 * @param string $verify
 */
function send_verify($phone, $verify) {
	$data = array($verify);
	return send_temp_sms($phone, $data);
}

function send_sms($to, $body, $msg_type = 0) {
	// 获取配置文件
	$CI = & get_instance();
	$CI->config->load('yuntongxun', TRUE);
	$config = $CI->config->item('yuntongxun');
	
	// 加载curl类库
	load_library('curl');
	
	// 设置SSL
	$CI->curl->set_ssl();
	
	// 时间戳
	$date = date('YmdHis', time());
	
	// 拼接请求包体
	$body = array(
			'to'			=> $to,
			'body'			=> $body,
			'msgType'		=> $msg_type,
			'appId'			=> $config['app_id'],
			'subAccountSid'	=> $config['sub_account'],
			
	);
	$body = json_encode($body);
	// $body= "{'to':'{$to}','body':'{$body}','msgType':'{$msg_type}','appId':'{$config['app_id']}','subAccountSid':'{$config['sub_account']}'}";
	// 大写的sig参数 
	$sig =  strtoupper(md5($config['main_account'] . $config['main_token'] . $date));
	// 生成请求URL        
	$url="https://{$config['server_address']}/{$config['soft_version']}/Accounts/{$config['main_account']}/SMS/Messages?sig={$sig}";
	// 生成授权：主账户Id + 英文冒号 + 时间戳。
	$authen = base64_encode($config['main_account'] . ":" . $date);
	
	// 生成请求包头
	$header = array(
			"Accept:application/json",
			"Content-Type:application/json;charset=utf-8", 
			"Authorization:{$authen}",
	);
	
	$CI->curl->set_header($header);
	
	$result = $CI->curl->post($body, $url);
	if ($result === FALSE) {
		log_message('error', 'CURL请求错误');
		return FALSE;
	}
	
	$data = json_decode(trim($result," \t\n\r"));
	if ($data->statusCode != '000000') {
		log_message('error', 'error code : ' . $data->statusCode);
		return FALSE;
	}
	
	return TRUE;
}

function send_temp_sms($to, $data = array()) {
	// 获取配置文件
	$CI = & get_instance();
	$CI->config->load('yuntongxun', TRUE);
	$config = $CI->config->item('yuntongxun');
	
	// 加载curl类库
	load_library('curl');
	
	// 设置SSL
	$CI->curl->set_ssl();
	
	// 时间戳
	$date = date('YmdHis', time());
	
	// 拼接请求包体
	$body = array(
			'to'			=> $to,
			'appId'			=> $config['app_id'],
			'templateId'	=> $config['templateId'],
			'datas'			=> $data,
	);
	$body = json_encode($body);
	
	// 大写的sig参数
	$sig = strtoupper(md5($config['main_account'] . $config['main_token'] . $date));
	// 生成请求URL
	$url = "https://{$config['server_address']}/{$config['soft_version']}/Accounts/{$config['main_account']}/SMS/TemplateSMS?sig={$sig}";
	// 生成授权：主账户Id + 英文冒号 + 时间戳。
	$authen = base64_encode($config['main_account'] . ":" . $date);
	
	// 生成请求包头
	$header = array(
		"Accept:application/json",
		"Content-Type:application/json;charset=utf-8",
		"Authorization:{$authen}",
	);
	
	$CI->curl->set_header($header);
	
	$result = $CI->curl->post($body, $url);
	if ($result === FALSE) {
		log_message('error', 'CURL请求错误');
		return FALSE;
	}
	
	$data = json_decode(trim($result," \t\n\r"));
	if ($data->statusCode != '000000') {
		log_message('error', '云通讯错误：' . $data->statusMsg . ' error code : ' . $data->statusCode);
		return FALSE;
	}
	
	return TRUE;
}

