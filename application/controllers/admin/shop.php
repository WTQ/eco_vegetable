<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Admin端店铺管理控制器sansa clip 配什么耳机
 *
 * @package		o2o_supermarket
 * @author 		lp1900
 * @copyright	Copyright (c) 2014. 云帆工作室.
 * @version		Version 1.0
 * @since		2014.5.3
 */

class Shop extends A_Controller
{
	public function __construct()
	{
		parent::__construct();
		load_model( array('admin_user_m', 'shop_m', 'zone_community_m', 'zone_block_m', 'zone_district_m', 'zone_province_m'));
		load_helper('page');
	}
	
	/**
	 * 显示后台shop_tab商铺列表
	 */
	public function index()
	{
		$per_page		=	10;
		$p				=	(int) page_cur();	// 获取当前页码
		
		$data['shop']	=	$this->shop_m->limit($per_page, ($p-1) * $per_page)->get_all();
		$data['page']	=	page($this->shop_m->count_all(), $per_page); 
		
		/*foreach ($data['shop'] as $row) {
			$data['community'][$row->community_id] = $this->zone_community_m->get($row->community_id);	// 查询community信息
			$data['block'][$row->community_id] = $this->zone_block_m->get($data['community'][$row->community_id]->block_id);	// 查询block信息
			$data['district'][$row->community_id] = $this->zone_district_m->get($data['block'][$row->community_id]->district_id);	// 查询district信息
		}*/
		if ($data !== NULL) {
			load_view('admin/shop_tab', $data);
		} else {
			redirect('admin/manager');
		}
	}
	

	
	/**
	 * 添加店铺
	 */
	public function add_shop()
	{
		if ( is_post()) {
			$start_time		= $this->input->post('start_time');	// 接收开门时间
			$close_time		= $this->input->post('close_time');	// 接收关门时间
			$shop_hours		= $this->shop_m->time_format($start_time, $close_time);
			
			$hours			= $shop_hours;						// JSON编码后的营业时间
			$district		= $this->input->post('district');	// 接收到的是id
			$block			= $this->input->post('block');		// 接收到的是id
			$community		= $this->input->post('community');
			$name			= $this->input->post('shop_name');
			$manager		= $this->input->post('manager');
			$address		= $this->input->post('address');
			$phone			= $this->input->post('phone');
			$discript		= $this->input->post('discript');
			$on_business    = $this->input->post('on_business');
			
			$data['shop'] = array(
							'community_id'	=>	$community,
							'name'			=>	$name,
							'manager'		=>	$manager,
							'address'		=>	$address,
							'phone'			=>	$phone,
							'shop_hours'	=>	$hours,
							'discript'		=>	$discript,	
							'on_business'   =>  $on_business,
			);
			
			$this->shop_m->add($data['shop']);
			
			redirect('admin/shop');
		} else {
			$data['shop'] = array(
					'district'		=> '',
					'block'			=> '',
					'community'		=> '',
					'name'			=> '',
					'manager'		=> '',
					'address'		=> '',
					'phone'			=> '',
					'shop_hours'	=> $this->shop_m->time_format(),
					'discript'		=> '',
					'on_business'   =>  0,
					'form_url'		=> 'admin/shop/add_shop',
			);
			$data['district']	= $this->zone_district_m->get_all();
			$data['block']		= $this->zone_block_m->get_all();
			$data['community']	= $this->zone_community_m->get_all();
			
			load_view('admin/shop_edit', $data);
		}	
	}
	
	/**
	 * 编辑店铺
	 */
	public function edit_shop()
	{
		$shop_id	= (int) get('shop_id');

		if ( is_post()) {
			$start_time		= $this->input->post('start_time');	// 接收开门时间
			$close_time		= $this->input->post('close_time');	// 接收关门时间
			$shop_hours		= $this->shop_m->time_format($start_time, $close_time);	
			
			$hours			= $shop_hours;						// JSON编码后的营业时间
//			$district		= $this->input->post('district');	// 接收到的是id
//			$block			= $this->input->post('block');		// 接收到的是id
//			$community		= $this->input->post('community');
			$name			= $this->input->post('shop_name');
			$manager		= $this->input->post('manager');
			$address		= $this->input->post('address');
			$phone			= $this->input->post('phone');
			$discript		= $this->input->post('discript');
			$on_business    = $this->input->post('on_business');
			
			$data['shop']	= array(
//								'community_id'	=>	$community,
								'name'			=>	$name,
								'manager'		=>	$manager,
								'address'		=>	$address,
								'phone'			=>	$phone,
								'shop_hours'	=>	$hours,
//								'discript'		=>	$discript,
					            'on_business'   =>  $on_business,
			);
			
			$this->shop_m->edit($shop_id, $data['shop']);
			redirect('admin/shop');
		} else {
			$shop		= $this->shop_m->get($shop_id);							// 获取shop信息
//			$community	= $this->zone_community_m->get($shop->community_id);	// 获取community信息
//			$block		= $this->zone_block_m->get($community->block_id);		// 获取block信息
//			$district	= $this->zone_district_m->get($block->district_id);		// 获取district信息
			
			$data['shop'] = array(
//					'district'		=> $district,
//					'block'			=> $block,
//					'community'		=> $community->name,
					'name'			=> $shop->name,
					'manager'		=> $shop->manager,
					'address'		=> $shop->address,
					'phone'			=> $shop->phone,
					'shop_hours'	=> $shop->shop_hours,
					'discript'		=> $shop->discript,
					'on_business'   => $shop->on_business,
					'form_url'		=> 'admin/shop/edit_shop?shop_id='.$shop_id,
			);
//			$data['district']	= $this->zone_district_m->get_all();
//			$data['block']		= $this->zone_block_m->get_all();
//			$data['community']	= $this->zone_community_m->get_all();
			load_view('admin/shop_edit', $data);
		}
	}
	
	/**
	 * 删除店铺
	 */
	public function del_shop()
	{
		$shop_id = (int) get('shop_id');
		
		$this->shop_m->del($shop_id);
		
		redirect('admin/shop');
	}
	
	/**
	 * 添加/编辑商铺首页推荐信息（图片）
	 */
	public function edit_ad()
	{
		$shop_id	= (int) get('shop_id');
		
		if (is_post()) {
			$data['shop_ad']	=	$this->input->post('ue_content');	// 获取ueditor里编辑的内容（html代码）
			$this->shop_m->edit($shop_id, $data);
			redirect('admin/shop');
		} else {
			$shop				=	$this->shop_m->get($shop_id);		// 获取shop信息
			$data['shop_ad']	=	$shop->shop_ad;						// 获取首页推荐信息
			$data['form_url']	=	'admin/shop/edit_ad?shop_id='.$shop_id;
			
			load_view('admin/shop_ad', $data);
		}
	}
	
	/**
	 * 查看店铺
	 */
	public function check_shop()
	{
		
	}
	
	/**
	 * 关闭店铺
	 */
	public function close_shop()
	{
		
	}
	
	/**
	 * 开放店铺
	 */
	public function open_shop()
	{
		
	}
}