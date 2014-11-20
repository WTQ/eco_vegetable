<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Goods_img extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		define('__GOODS_IMG__', __WEB_ROOT__ . '/goods_img/');
		
		load_model(array('shop_m', 'goods_m', 'category_m'));
		load_helper(array('page', 'path'));
	}
	
	public function _remap($method = 0)  {
		$goods_id = $method;
		$goods = $this->goods_m->get($goods_id);
		if (!isset($goods->goods_id)) {
			return;
		}
		
		// 解析请求的图片和分辨率
		$img_param	= $this->uri->segment(3);													// 解析URI
		$img_arr	= explode('.', $img_param);													// 将参数以'.'做分割
		$img		= $img_arr[0];																// 图片编号
		$resolution	= $img_arr[1];																// 图片分辨率
		$img_path	= __WEB_ROOT__ . '/' . $this->img_select($goods->pic, $img);				// JSON解码后的图片路径
		$extension	= pathinfo($img_path, PATHINFO_EXTENSION);									// 获取图片的后缀名
		$img_new	= __GOODS_IMG__ . $goods_id . "/" . $img . "." . $resolution . "." . $extension;
		
		// 文件存在直接退出
		if (file_exists($img_new)) {
			header("Content-type: image/jpeg");
			echo file_get_contents($img_new);
			return;
		}
		
		if (!file_exists(__GOODS_IMG__ . $goods_id)) {
			mkdir(__GOODS_IMG__ . $goods_id);
		}
		
		$config		= array(
				'image_library'	=>	'gd2',
				'source_image'	=>	$img_path,
				'create_thumb'	=>	FALSE,
				'maintain_ratio'=>	TRUE,
				'width'			=>	$resolution,
				'height'		=>	$resolution,
				'new_image'		=>	$img_new,
		);
		
		$this->load->library('image_lib', $config);
		if (!$this->image_lib->resize()) {
			echo $this->image_lib->display_errors();
		} else {
			header("Content-type: image/jpeg");
			echo file_get_contents($img_new);
		}
	}
	
	/**
	 * 将数据库中的图片路径JSON_Decode
	 */
	public function img_select($arr, $img='0')
	{
		$img_json	= $this->goods_m->pic_dejson($arr);		// JSON解码后的图片路径
		$img_0		= $img_json->default;					// 默认图片路径
		$img_1		= $img_json->more->pic1;				// 备选图片1路径
		$img_2		= $img_json->more->pic2;				// 备选图片2路径
		$img_3		= $img_json->more->pic3;				// 备选图片3路径
		$img_4		= $img_json->more->pic4;				// 备选图片4路径
	
		$select		= $img_0;								// 默认传递为0，即默认图片
		

		switch ($img) {
			case '0':
				$select = $img_0;
				break;
			case '1':
				$select = $img_1;
				break;
			case '2':
				$select = $img_2;
				break;
			case '3':
				$select = $img_3;
				break;
			case '4':
				$select = $img_4;
				break;
			default:
				break;
		}
		
		return $select;
	}
}