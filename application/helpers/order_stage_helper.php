<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function get_stage($stage_id)
{
	$CI = &get_instance();
	$CI->config->load('order_stage', TRUE);
	$status = $CI->config->item('order_stage');

	if(isset($status[$stage_id])) {
		return $status[$stage_id];
	}
	return '';
}
