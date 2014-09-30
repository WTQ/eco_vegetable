<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Apipay API
 */

require_once(APPPATH.'third_party/alipay/alipay_submit.class.php');

class Alipay extends MY_Controller
{
	public $total_fee    = 0.01;
	public $subject      = '我的订单';
	public $out_trade_no = '0000000000000';

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('alipay_m', 'order_m', 'order_items_m', 'order_item_m', 'alipay_m'));
		$this->load->library('curl');
		$this->config->load('alipay_config', TRUE);		// 加载支付宝配置文件
	}

	public function index()
	{
		require_once(APPPATH.'third_party/alipay/alipay_submit.class.php');

		$alipay_config = $this->config->item('alipay_config');
		// 返回格式（必填）
		$format = "xml";
		// 返回格式（必填）
		$v      = "2.0";
		// 请求号（必填）
		$req_id = date('Ymdhis');

		$this->set_data();
		// 服务器异步通知页面路径
		$notify_url             = $alipay_config['notify_url'];
		// 需http://格式的完整路径，不允许加?id=123这类自定义参数

		// 页面跳转同步通知页面路径
		$call_back_url          = $alipay_config['call_back_url'];
		// 需http://格式的完整路径，不允许加?id=123这类自定义参数

		// 操作中断返回地址
		$merchant_url           = $alipay_config['merchant_url'];
		// 用户付款中途退出返回商户的地址。需http://格式的完整路径，不允许加?id=123这类自定义参数

		// 卖家支付宝帐户
		$seller_email           = $alipay_config['seller_email'];

		// TODO 商户网站订单系统中唯一订单号（必填）
		$out_trade_no           = $this->out_trade_no;

		// 订单名称（必填）
		$subject                = $this->subject;

		// 付款金额（必填）
		$total_fee              = $this->total_fee;

		// 请求业务参数详细（必填）
		$req_data               = '<direct_trade_create_req><notify_url>' . $notify_url . '</notify_url><call_back_url>' . $call_back_url . '</call_back_url><seller_account_name>' . $seller_email . '</seller_account_name><out_trade_no>' . $out_trade_no . '</out_trade_no><subject>' . $subject . '</subject><total_fee>' . $total_fee . '</total_fee><merchant_url>' . $merchant_url . '</merchant_url></direct_trade_create_req>';

		/****************************************/
		// 构造要请求的参数数组
		$para_token = array(
			"service"        => "alipay.wap.trade.create.direct",
			"partner"        => trim($alipay_config['partner']),
			"sec_id"         => trim($alipay_config['sign_type']),
			"format"         => $format,
			"v"              => $v,
			"req_id"         => $req_id,
			"req_data"       => $req_data,
			"_input_charset" => trim(strtolower($alipay_config['input_charset']))
		);

		// 建立请求
		$alipaySubmit   = new AlipaySubmit($alipay_config);
		$html_text      = $alipaySubmit->buildRequestHttp($para_token);var_dump($html_text);

		// URLDECODE返回的信息
		$html_text      = urldecode($html_text);var_dump($html_text);

		// XML解析远程模拟提交后返回的信息
		$para_html_text = $alipaySubmit->parseResponse($html_text);var_dump($para_html_text);

		// 获取request_token
		$request_token  = $para_html_text['request_token'];

		/************根据授权码token调用交易接口 alipay.wap.auth.authAndExecute************/

		// 业务详情（必填）
		$req_data       = '<auth_and_execute_req><request_token>' . $request_token . '</request_token></auth_and_execute_req>';

		// 构造要请求的参数数组
		$parameter = array(
			"service"        => "alipay.wap.auth.authAndExecute",
			"partner"        => trim($alipay_config['partner']),
			"sec_id"         => trim($alipay_config['sign_type']),
			"format"         => $format,
			"v"              => $v,
			"req_id"         => $req_id,
			"req_data"       => $req_data,
			"_input_charset" => trim(strtolower($alipay_config['input_charset']))
		);

		// 建立请求
		$alipaySubmit = new AlipaySubmit($alipay_config);var_dump($alipaySubmit);
		$html_text    = $alipaySubmit->buildRequestForm($parameter, 'get', '确认');var_dump($html_text);

		echo $html_text;
	}

	/**
	 * 查询流水信息
	 */
	public function set_data()
	{
		$order_id = (int) get('order_inline');
		$order_inline = $this->alipay_m->get($order_id);
		if (isset($order_inline->trade_no)) {
			$this->out_trade_no = $order_inline->trade_no;
			$this->total_fee = $order_inline->total_fee;
		}
	}

	/**
	 * 异步通知
	 */
	public function notify()
	{
		require_once(APPPATH.'third_party/alipay/alipay_notify.class.php');
	}

	/**
	 * 同步通知
	 */
	public function callback()
	{
		require_once(APPPATH.'third_party/alipay/alipay_notify.class.php');
	}
}
