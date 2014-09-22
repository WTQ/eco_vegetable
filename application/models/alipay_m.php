<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 支付宝模型层
 */
class Alipay_m extends MY_Model
{
	protected $_table = 'goods';

	protected $primary_key = 'goods_id';

	public function __construct()
	{
		parent::__construct();

		// 加载商品分类模型和商家模型
		$this->load->model(array('category_m', 'shop_m'));
	}
}
