<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function get_stage($stage_id) 
{
	$CI = &get_instance();	
	$CI->config->load('status_order', TRUE);
	$status = $CI->config->item('status_order');
	
	if(isset($status[$stage_id])) {
		return $status[$stage_id];
	}
	return '';
}
