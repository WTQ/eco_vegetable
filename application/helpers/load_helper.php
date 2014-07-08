<?php
/**
 * 基本的装载函数，扩张增强CI框架的load
 * 支持数组传递的多model，libraries，helper，view
 * 
 * @author 风格独特
 */

/**
 * 加载模型层
 * 
 * @param mixed $model
 */
function load_model($model, $name = '', $db_conn = FALSE) 
{
	$CI = & get_instance();
	$CI->load->model($model, $name, $db_conn);
}

/**
 * 加载视图view
 * 
 * @param mixed $view
 * @param string $data
 */
function load_view($view, $data = NULL) 
{
	$CI = & get_instance();
	if ($data !== NULL) {
		$CI->load->vars($data);
	}
	
	if(is_array($view)) {
		foreach ($view as $v) {
			$CI->load->view($v);
		}
	} else {
		$CI->load->view($view);
	}
}

/**
 * 往view里面传递数据
 * 
 * @param array $vars
 * @param string $val
 */
function load_vars($vars = array(), $val = '')
{
	$CI = & get_instance();
	$CI->load->vars($vars, $val);
}

/**
 * 加载类库
 * 
 * @param mixed $library
 */
function load_library($library = '', $params = NULL, $object_name = NULL)
{
	$CI = & get_instance();
	$CI->load->library($library, $params, $object_name);
}

/**
 * 加载helper函数库
 * 
 * @param mixed $helper
 */
function load_helper($helpers = array()) 
{
	$CI = & get_instance();
	$CI->load->helper($helpers);
}
