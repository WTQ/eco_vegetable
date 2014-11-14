<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Admin端商品管理控制器
 *
 * @package		o2o_supermarket
 * @author 		lp1900
 * @copyright	Copyright (c) 2014. 云帆工作室.
 * @version		Version 1.0
 * @since		2014.5.3
 */

class Goods extends A_Controller
{
	public function __construct()
	{
		parent::__construct();
		load_model( array('shop_m', 'goods_m', 'category_m', 'coupon_m') );
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
		$data['p'] = $p;
		$stage = (int)$this->input->get('stage', TRUE);
		if (isset($stage)) {
			$data['stage'] = $stage;
		} else {
			$data['stage'] = 0;
		}
		$data['keywords'] = '';
		$data['goods'] = $this->goods_m->limit($per_page, ($p-1) * $per_page)->get_bycategory($stage);	// 获取goods表里对应分类的记录（对象形式）
		$data['number'] = sizeof($this->goods_m->order_by('goods_id', 'desc')->get_bycategory($stage));
		$data['page'] = page($data['number'], $per_page);						// 分页参数
		foreach ($data['goods'] as $row) {
				$data['shop'][$row->shop_id] = $this->shop_m->get($row->shop_id);			// 获取shop信息
				$data['category'][$row->class_id] = $this->category_m->get($row->class_id);	// 获取category信息
		}
		load_view('admin/goods', $data);
	}
	
	/**
	 * 添加商品
	 */
	public function add_goods()
	{	
		if (is_post()) {
			$shop_id	=	post('shop_id');
			$class_id	=	post('class_id');
			$name		=	post('name');
			$unit		=	post('unit');			// 商品规格
			$price		=	post('price');
			$stock		=	post('stock');
			$intro		=	post('intro');			// 商品介绍
			$is_today	=	post('is_today');		// 今日推荐
			$sold		=	post('sold');			// 上下架

			$make_url = $this->config->item('admin_upload');
			$config = array(
					"savePath" => "uploads/goods_img" ,
					"maxSize" => 100000 , //单位KB
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
			$pic_path = $this->goods_m->pic_json($goods_pic);
			$data['goods'] = array(
					'shop_id'	=>	$shop_id,
					'class_id'	=>	$class_id,
					'name'		=>	$name,
					'unit'		=>	$unit,
					'price'		=>	$price,
					'stock'		=>	$stock,
					'intro'		=>	$intro,
					'pic'		=>	$pic_path,		// 全部图片路径，传到模型层，打包为JSON
					'is_today'	=>	$is_today,
					'sold'		=>	$sold,
			);
			
			$goods_id	= $this->goods_m->add_goods($data['goods']);	// 返回新添加的goods_id
			
			redirect('admin/goods');
		} else {
			$arr_1 = array('pic1'=>'','pic2'=>'','pic3'=>'','pic4'=>'','pic5'=>'');	// 空数组
			$arr_2 = $this->goods_m->pic_json($arr_1);
			$arr_3 = $this->goods_m->pic_dejson($arr_2);
			$data['goods'] = array(
					'shop_id'	=>	'',
					'class_id'	=>	'',
					'name'		=>	'',
					'unit'		=>	'',
					'price'		=>	'',
					'stock'		=>	1,
					'intro'		=>	'',
					'pic'		=>	$arr_3,	// 空数组
					'is_today'	=>	'',
					'sold'		=>	1,
					'form_url'	=>	'admin/goods/add_goods',
			);
			$data['shop']	=	$this->shop_m->get_all();		// 获取shop表全部记录用于下拉列表中的选项
			$data['class']	=	$this->category_m->get_all();	// 获取category表全部记录用于下拉列表中的选项
			
			load_view('admin/goods_edit', $data);
		}
	}
	
	/**
	 * 编辑商品
	 */
	public function edit_goods()
	{
		$goods_id = (int) get('goods_id');
		$p        = (int) get('p');
		$goods	  = $this->goods_m->get($goods_id);				// 获取goods信息
		$old	  = $this->goods_m->pic_dejson($goods->pic);		// 把原来的图片路径解码
		$old_array	= array(
				'pic1'	=>	$old->default,
				'pic2'	=>	$old->more->pic1,
				'pic3'	=>	$old->more->pic2,
				'pic4'	=>	$old->more->pic3,
				'pic5'	=>	$old->more->pic4,
		);
		$stage  = (int) get('stage');    
		if (is_post()) {
			$shop_id	=	$this->input->post('shop_id');
			$class_id	=	$this->input->post('class_id');
			$name		=	$this->input->post('name');
			$unit		=	$this->input->post('unit');		// 商品规格
			$price		=	$this->input->post('price');
			$stock		=	$this->input->post('stock');
			$intro		=	$this->input->post('intro');	// 商品介绍
			$is_today	=	$this->input->post('is_today');	//今日推荐
			$sold		=	post('sold');					// 上下架
			$make_url	=	$this->config->item('admin_upload');
			$config = array(
					"savePath" => "uploads/goods_img" ,
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
			$pic_path = $this->goods_m->pic_json($goods_pic);
			$data['goods'] = array(
					'shop_id'	=>	$shop_id,
					'class_id'	=>	$class_id,
					'name'		=>	$name,
					'unit'		=>	$unit,
					'price'		=>	$price,
					'stock'		=>	$stock,
					'intro'		=>	$intro,
					'pic'		=>	$pic_path,
					'is_today'	=>	$is_today,
					'sold'		=>	$sold,
			);
			$this->goods_m->edit_goods($goods_id, $data['goods']);
			redirect('admin/goods?p='.$p.'&stage='.$stage);
		} else {
			$goods	=	$this->goods_m->get($goods_id);				// 获取goods信息
			$shop	=	$this->shop_m->get($goods->shop_id);		// 获取shop信息
			$class	=	$this->category_m->get($goods->class_id);	// 获取category信息
			
			$data['goods'] = array(
					'shop_id'	=>	$shop->shop_id,
					'class_id'	=>	$class->class_id,
					'name'		=>	$goods->name,
					'unit'		=>	$goods->unit,
					'price'		=>	$goods->price,
					'stock'		=>	$goods->stock,
					'intro'		=>	$goods->intro,
					'pic'		=>	$this->goods_m->pic_dejson($goods->pic),		// 将JSON解码
					'is_today'	=>	$goods->is_today,
					'sold'		=>	$goods->sold,
					'form_url'	=>	'admin/goods/edit_goods?p='.$p.'&goods_id='.$goods_id.'&stage='.$stage,
			);
			$data['shop']	=	$this->shop_m->get_all();		// 获取shop表全部记录用于下拉列表中的选项
			$data['class']	=	$this->category_m->get_all();	// 获取category表全部记录用于下拉列表中的选项
			$data['p']      =   $p;
			$data['stage']  =   $stage;
			load_view('admin/goods_edit', $data);
		}
	}
	
	/**
	 * 商品在首页置顶
	 */
	public function edit_top_goods()
	{
		$p = (int)get('p');
		$goods_id = (int)get('goods_id');
		$is_top = $this->goods_m->get_top($goods_id);
		$stage  = (int) get('stage');
		if ($is_top == '0') {
			$data = array(
					'is_top'    =>  time(),
			);
		} else {
			$data = array(
					'is_top'    =>  '0',
			);
		}
		$this->goods_m->edit_goods($goods_id, $data);
		redirect('admin/goods?p='.$p.'&stage='.$stage);
	}
	
	/**
	 * 商品在所选分类中置顶
	 */
	public function edit_parttop_goods()
	{
		$p = (int)get('p');
		$goods_id = (int)get('goods_id');
		$is_parttop = $this->goods_m->get_parttop($goods_id);
		$stage  = (int) get('stage');
		if ($is_parttop == '0') {
			$data = array(
					'is_parttop'    =>  time(),
			);
		} else {
			$data = array(
					'is_parttop'    =>  '0',
			);
		}
		$this->goods_m->edit_goods($goods_id, $data);
		redirect('admin/goods?p='.$p.'&stage='.$stage);
	}
	
	/**
	 * 删除商品
	 */
	public function del_goods()
	{
		$goods_id = (int) get('goods_id');
		$p = (int)get ('p');
		$stage = (int)get ('stage');
		
		$this->goods_m->del_goods($goods_id);
		
		redirect('admin/goods?p='.$p.'&stage='.$stage);
	}
	
	/**
	 * 标记缺货/有货
	 */
	public function in_out_stock()
	{
		$goods_id	= (int) get('goods_id');
		$goods		= $this->goods_m->get($goods_id);				// 获取goods信息
		$stock		= $goods->stock;
		$stock		= !$stock;
		$p        = (int) get('p');
		$stage  = (int) get('stage');
		$this->goods_m->mark_stock($goods_id, $stock);
		
		redirect('admin/goods?p='.$p.'&stage='.$stage);
	}
	/**
	 * 按照商品名称搜索
	 */
	public function goods_search()
	{
		$keywords = get('search');
		$data['stage'] = 0;
		$per_page = 10;
		$data['keywords'] = $keywords;
		$p = (int) page_cur();
		$data['p'] = $p;
		$data['goods'] = $this->goods_m->order_by('goods_id', 'desc')->limit($per_page, ($p-1) * $per_page)->search_many_by($keywords);	// 获取goods表里全部记录（对象形式）
		$data['number'] = $this->goods_m->search_many_num($keywords);
		$data['page'] = page($data['number'], $per_page); // 分页参数
		foreach ($data['goods'] as $row) {
			$data['shop'][$row->shop_id] = $this->shop_m->get($row->shop_id);			// 获取shop信息
			$data['category'][$row->class_id] = $this->category_m->get($row->class_id);	// 获取category信息
		}
		load_view('admin/goods', $data);
	}
	
	/**
	 * uploadify控件上传图片
	 */
	public function uploadify()
	{
		$targetFolder = '/uploads/goods_img/';		// 定义目标文件夹，相对于根目录
// 		$targetFolder = $this->getFolder($targetFolder);	//添加日期命名的文件夹
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
	private function getNewName($filename)
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
	private function getExtName($filename)
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
