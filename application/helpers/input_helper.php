<?php
/**
 * 对GET、POST、COOKIE、SESSEION的操作进行封装
 * 
 * @author 风格独特
 */

/**
 * 对GET操作进行封装，默认开启xss_clean
 */
function get($index = NULL, $xss_clean = TRUE) 
{
	$CI = & get_instance();
	return $CI->input->get($index, $xss_clean);
}

/**
 * 对POST操作进行封装，默认开启xss_clean
 */
function post($index = NULL, $xss_clean = TRUE) 
{
	$CI = & get_instance();
	return $CI->input->post($index, $xss_clean);
}

/**
 * 对get_post操作进行封装，默认开启xss_clean
 */
function get_post($index, $xss_clean = TRUE)
{
	$CI = & get_instance();
	return $CI->input->get_post($index, $xss_clean);
}

/**
 * 对COOKIE操作进行封装，，默认开启xss_clean
 */
function cookie($index, $xss_clean = TRUE) 
{
	$CI = & get_instance();
	return $CI->input->cookie($index, $xss_clean);
}

/**
 * 对SERVER操作进行封装，，默认开启xss_clean
 */
function server($index, $xss_clean = TRUE)
{
	$CI = & get_instance();
	return $CI->input->server($index, $xss_clean);
}

/**
 * 判断当前请求是否是POST
 */
function is_post() 
{
	$CI = & get_instance();
	$method = $CI->input->server('REQUEST_METHOD');
	
	if ($method == 'POST') {
		return TRUE;
	}
	return FALSE;
}

/**
 * 判断是请求是否是GET
 */
function is_get() 
{
	$CI = & get_instance();
	$method = $CI->input->server('REQUEST_METHOD');
	
	if ($method == 'GET') {
		return TRUE;
	}
	return FALSE;
}

