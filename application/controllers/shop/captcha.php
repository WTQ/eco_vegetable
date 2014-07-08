<?php
/**
 * 验证码
 * 
 * @package		o2o_supermarket
 * @author		风格独特
 * @copyright	Copyright (c) 2014. 云帆工作室.
 * @version		Version 1.0 2014-05-10
 */

class Captcha extends CI_Controller 
{
	public function index()
	{
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0");
		$this->output->set_header("Pragma: no-cache");
		
		load_library('captcha_np');
		$this->captcha_np->setStyle(3);
		$this->captcha_np->setFontColor(array(0, 102, 204));
		$str = $this->captcha_np->getStr();
		
		$array = array('verifytext' => $str);
		
		$this->session->set_userdata($array);
		$this->captcha_np->display();
	}
}