<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Depot端商品库首页控制器
 * 
 * @package		o2o_supermarket
 * @author 		lp1900
 * @copyright	Copyright (c) 2014. 云帆工作室.
 * @version		Version 1.0
 * @since		2014.5.13
 */

class Goods extends D_Controller 
{
	public function __construct()
	{
		parent::__construct();
		load_model('goods_db_m');
		load_helper('page');
		$this->load->library('uploader_ue', 'session');
	}
	
	/**
	 * 显示后台goods页面
	 */
	public function index()
	{
		$per_page = 10;
		$p = (int) page_cur();
	
		$data['goods'] = $this->goods_db_m->limit($per_page, ($p-1) * $per_page)->get_all();	// 获取goods表里全部记录（对象形式）
		$data['page'] = page($this->goods_db_m->count_all(), $per_page);						// 分页参数
	
		load_view('depot/goods', $data);
	}
	
	/**
	 * 添加商品
	 */
	public function add_goods()
	{
		if (is_post()) {
			$name		=	post('name');
			$unit		=	post('unit');			// 商品规格
			$price		=	post('price');
			$barcode	=	post('barcode');
			$intro		=	post('intro');			// 商品介绍
				
			$make_url = $this->config->item('admin_upload');
			$config = array(
					"savePath" => "uploads/depot_img" ,		// 图片库上传目录
					"maxSize" => 100000 , 					// 单位KB
					"allowFiles" => array( ".gif" , ".png" , ".jpg" , ".jpeg" , ".bmp"  )
			);
			$pic	= array(
					'pic1'	=>	new Uploader_ue( "pic1" , $config),
					'pic2'	=>	new Uploader_ue( "pic2" , $config),
					'pic3'	=>	new Uploader_ue( "pic3" , $config),
					'pic4'	=>	new Uploader_ue( "pic4" , $config),
					'pic5'	=>	new Uploader_ue( "pic5" , $config),
			);
	
			$goods_pic = array();
				
			foreach ($pic as $key=>$value) {
				$info = $value->getFileInfo();
				if($info['state'] == 'SUCCESS') {
					$goods_pic[$key] = $make_url . $info['url'];
				} else {
					$goods_pic[$key] = '';
				}
			}
			$pic_path = $this->goods_db_m->pic_json($goods_pic);
			$data['goods'] = array(
					'name'		=>	$name,
					'unit'		=>	$unit,
					'price'		=>	$price,
					'intro'		=>	$intro,
					'barcode'	=>	$barcode,
					'pic'		=>	$pic_path,		// 全部图片路径，传到模型层，打包为JSON
			);
				
			$goods_id	= $this->goods_db_m->add_goods($data['goods']);	// 返回新添加的goods_id
				
			// 其它图片添加到图片库中，并于goods_id绑定
// 			$data['img']	=	array(
// 					'goods_id'	=>	$goods_id,
// 					'pic1'		=>	$goods_pic['pic1'],
// 					'pic2'		=>	$goods_pic['pic2'],
// 					'pic3'		=>	$goods_pic['pic3'],
// 					'pic4'		=>	$goods_pic['pic4'],
// 					'pic5'		=>	$goods_pic['pic5'],
// 			);
				
// 			$this->img_m->add_img($data['img']);
				
			redirect('depot/goods');
		} else {
			$arr_1 = array('pic1'=>'','pic2'=>'','pic3'=>'','pic4'=>'','pic5'=>'');	// 空数组
			$arr_2 = $this->goods_m->pic_json($arr_1);
			$arr_3 = $this->goods_m->pic_dejson($arr_2);
			$data['goods'] = array(
					'name'		=>	'',
					'unit'		=>	'',
					'price'		=>	'',
					'intro'		=>	'',
					'pic'		=>	$arr_3,	// 空数组
					'barcode'	=>	'',
					'form_url'	=>	'depot/goods/add_goods',
			);
				
			load_view('depot/goods_edit', $data);
		}
	}
	
	/**
	 * 编辑商品
	 */
	public function edit_goods()
	{
		$goods_id	= (int) get('goods_id');
		$goods		= $this->goods_db_m->get($goods_id);				// 获取goods信息
		$old		= $this->goods_db_m->pic_dejson($goods->pic);		// 把原来的图片路径解码
		$old_array	= array(
				'pic1'	=>	$old->default,
				'pic2'	=>	$old->more->pic1,
				'pic3'	=>	$old->more->pic2,
				'pic4'	=>	$old->more->pic3,
				'pic5'	=>	$old->more->pic4,
		);
	
		if (is_post()) {
			$name		=	post('name');
			$unit		=	post('unit');		// 商品规格
			$price		=	post('price');
			$intro		=	post('intro');		// 商品介绍
			$barcode	=	post('barcode');
				
			$make_url	=	$this->config->item('admin_upload');
			$config = array(
					"savePath" => "uploads/depot_img" ,		// 图片库上传目录
					"maxSize" => 100000 , 					// 单位KB
					"allowFiles" => array( ".gif" , ".png" , ".jpg" , ".jpeg" , ".bmp"  )
			);
			//上传图片
			
			
			$pic	= array(
					'pic1'	=>	new Uploader_ue( "pic1" , $config),
					'pic2'	=>	new Uploader_ue( "pic2" , $config),
					'pic3'	=>	new Uploader_ue( "pic3" , $config),
					'pic4'	=>	new Uploader_ue( "pic4" , $config),
					'pic5'	=>	new Uploader_ue( "pic5" , $config),
			);
			
			$goods_pic = array();
			foreach ($pic as $key=>$value) {
				$info = $value->getFileInfo();
				if($info['state'] == 'SUCCESS') {
					$goods_pic[$key] = $make_url . $info['url'];
				} else {
					$goods_pic[$key] = $old_array[$key];
				}
			}
			$pic_path = $this->goods_db_m->pic_json($goods_pic);
			$data['goods'] = array(
					'name'		=>	$name,
					'unit'		=>	$unit,
					'price'		=>	$price,
					'barcode'	=>	$barcode,
					'intro'		=>	$intro,
					'pic'		=>	$pic_path,
			);
				
			$this->goods_db_m->edit_goods($goods_id, $data['goods']);
				
			// 其它图片添加到图片库中，并于goods_id绑定
// 			$data['img']	=	array(
// 					'goods_id'	=>	$goods_id,
// 					'pic1'		=>	$goods_pic['pic1'],
// 					'pic2'		=>	$goods_pic['pic2'],
// 					'pic3'		=>	$goods_pic['pic3'],
// 					'pic4'		=>	$goods_pic['pic4'],
// 					'pic5'		=>	$goods_pic['pic5'],
// 			);
// 			$this->img_m->edit_img($goods_id, $data['img']);
				
			redirect('depot/goods');
		} else {
			$goods	=	$this->goods_db_m->get($goods_id);				// 获取goods信息
				
			$data['goods'] = array(
					'name'		=>	$goods->name,
					'unit'		=>	$goods->unit,
					'price'		=>	$goods->price,
					'intro'		=>	$goods->intro,
					'pic'		=>	$this->goods_db_m->pic_dejson($goods->pic),		// 将JSON解码
					'barcode'	=>	$goods->barcode,
					'form_url'	=>	'depot/goods/edit_goods?goods_id='.$goods_id,
			);
				
			load_view('depot/goods_edit', $data);
		}
	}
	
	/**
	 * 删除商品
	 */
	public function del_goods()
	{
		$goods_id = (int) get('goods_id');
	
		$this->goods_db_m->del_goods($goods_id);
	
		redirect('depot/goods');
	}
}