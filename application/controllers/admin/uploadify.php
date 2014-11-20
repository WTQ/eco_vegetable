<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Admin端图片上传控制器
 *
 * @package		o2o_supermarket
 * @author 		lp1900
 * @copyright	Copyright (c) 2014. 云帆工作室.
 * @version		Version 1.0
 * @since		2014.5.3
 */

class Uploadify extends CI_Controller
{
	public function __construct()
	{
		
		parent::__construct();
		load_library('session');
		log_message('error', json_encode($_SERVER));
		
		log_message('error', $this->session->userdata('uid'));
		load_model(array('shop_m', 'goods_m', 'category_m', 'coupon_m'));
		load_helper('page');
	}
	
	public function index()
	{
		$targetFolder = '/uploads/goods_img/';		// 定义目标文件夹，相对于根目录
// 		$targetFolder = $this->getFolder($targetFolder);
		$targetPath = rtrim($_SERVER['DOCUMENT_ROOT'],'/') . $targetFolder;
		
		//接收令牌信息，hash处理
		$verifyToken = md5('unique_salt' . $_POST['timestamp']);
		
		//存在上传信息，且通过令牌校验
		if (!empty($_FILES) && $_POST['token'] == $verifyToken) {
			//文件被上传后在服务端储存的临时文件名
			$tempFile = $_FILES['Filedata']['tmp_name'];
			//根据客户端提交文件的原名称生成一个无重复的文件名
			$newName = $this->getNewName($_FILES['Filedata']['name']);
			//定义目标文件完全路径
			$targetFile = $targetPath . '/' . $newName;
			//校验文件类型
			$verifyTypes = array('jpg','gif','png'); //校验类型
			$fileTypes = $this->getExtName($_FILES['Filedata']['name']);	// 文件扩展名
		
			if (in_array($fileTypes,$verifyTypes)) {//校验通过
				move_uploaded_file($tempFile,$targetFile);
				//输出的字符串由表单页面onUploadSuccess方法的data参数接收，这里输出上传后的文件路径
				echo 'http://'.$_SERVER['SERVER_ADDR'].$targetFolder.'/'.$newName;
			} else {
				//输出的字符串由表单页面onUploadError方法的data参数接收
				echo '非法文件类型';
			}
		}
	}
	
	/**
	 * 生成一个无重复的文件名
	 */
	public function getNewName($filename)
	{
		//年月日时分秒格式的字符串
		$timeNow = date('YmdHis',time());
		//生成一个8位小写字母的随机字符串
		$randKey = '';
		for ($a = 0; $a < 8; $a++) {
			$randKey .= chr(mt_rand(97, 122));
		}
		//取得原文件的扩展名
		$extName = ".".$this->getExtName($filename);
		//组成新文件名
		$newName=$timeNow.$randKey.$extName;
		return $newName;
	}
	
	/**
	 * 取得文件扩展名（小写）
	 */
	public function getExtName($filename)
	{
		//取得文件关联数组信息
		$fileParts = pathinfo($filename);
		//文件扩展名转换为小写，返回
		return strtolower($fileParts['extension']);
	}
	
	/**
	 * 按照日期自动创建存储文件夹
	 */
	private function getFolder($path)
	{
		if (strrchr($path, "/") != "/") {
			$path .= "/";
		}
		$path .= date("Ymd");
		if (!file_exists($path)) {
			if ( !mkdir( $path , 0777 , true ) ) {
                return false;
            }
		}
		return $path;
	}
}
