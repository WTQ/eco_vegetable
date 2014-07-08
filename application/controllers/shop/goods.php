<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Shop端商品管理控制类
 *
 * @package		o2o_supermarket
 * @author 		lp1900
 * @copyright	Copyright (c) 2014. 云帆工作室.
 * @version		Version 1.0
 * @since		2014.5.9
 */

class Goods extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('goods_m', 'shop_m', 'catagory_m'));
		$this->load->helper('page');
	}

	/**
	 * 显示Shop端goods页面
	 */
	public function index()
	{
		$shop_id	=	(int) cookie('shop_id');
		$p			=	(int) page_cur();
		$per_page	=	10;

		$data['goods']	=	$this->goods_m->limit($per_page, ($p-1) * $per_page)->get_many_by($shop_id);	// 获取该商店下goods表中全部记录（对象形式）
		$data['page']	=	page($this->goods_m->count_by($shop_id), $per_page);							// 分页参数

		foreach ($data['goods'] as $row) {
			$data['category'][$row->class_id] = $this->catagory_m->get($row->class_id);						// 获取所属分类信息
		}

		$this->json_out($data);
	}

	/**
	 * 页面初始化
	 */
	public function _page_init()
	{

	}

	/**
	 * 添加商品
	 */
	public function add_goods()
	{
		$this->load->library('Upload');
		$shop_id	=	(int) cookie('shop_id');

		if (is_post()) {
			$class_id	=	$this->input->post('class_id');
			$name		=	$this->input->post('name');
			$unit		=	$this->input->post('unit');		// 商品规格
			$price		=	$this->input->post('price');
			$stock		=	$this->input->post('stock');
			$intro		=	$this->input->post('intro');	// 商品介绍
			$pic		=	$this->input->post('pic');

			$data['goods'] = array(
					'shop_id'	=>	$shop_id,
					'class_id'	=>	$class_id,
					'name'		=>	$name,
					'unit'		=>	$unit,
					'price'		=>	$price,
					'stock'		=>	$stock,
					'intro'		=>	$intro,
					'pic'		=>	$pic,
			);

			$this->goods_m->add_goods($data['goods']);
			// TODO 页面跳转
		} else {
			$data['goods'] = array(
					'class_id'	=>	'',
					'name'		=>	'',
					'unit'		=>	'',
					'price'		=>	'',
					'stock'		=>	'',
					'intro'		=>	'',
					'pic'		=>	'',
					'form_url'	=>	'shop/goods/add_goods',
			);
			$this->json_out($data);
		}
	}

	/**
	 * 编辑商品
	 */
	public function edit_goods()
	{
		$this->load->library('Upload');
		$shop_id	=	(int) cookie('shop_id');

		if (is_post()) {
			$class_id	=	$this->input->post('class_id');
			$name		=	$this->input->post('name');
			$unit		=	$this->input->post('unit');		// 商品规格
			$price		=	$this->input->post('price');
			$stock		=	$this->input->post('stock');
			$intro		=	$this->input->post('intro');	// 商品介绍
			$pic		=	$this->input->post('pic');
		}
	}

	/**
	 * 删除商品
	 */
	public function del_goods()
	{

	}

	/**
	 * 今日推荐
	 */
	public function recomand()
	{

	}

}
