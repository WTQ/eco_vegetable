<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Apipay API
 */

require_once(APPPATH.'third_party/alipay/alipay_submit.class.php');
require_once(APPPATH.'third_party/alipay/alipay_notify.class.php');

class Alipay extends U_Controller
{
	public $total_fee    = 0.01;
	public $subject      = '我的订单';
	public $out_trade_no = '0000000000000';		// 商家唯一订单号

	public function __construct()
	{
		parent::__construct();

		$this->load->model(array('alipay_m', 'order_m', 'order_items_m', 'order_item_m'));
		$this->load->library('curl');
		$this->config->load('alipay_config', TRUE);
	}

	public function index()
	{
		$flow_id = (int) get('flow_id');
		$this->_set_flow($flow_id);

		$alipay_config = $this->config->item('alipay_config');

		// 返回格式（必填）
		$format = "xml";

		// 返回格式（必填）
		$v      = "2.0";

		// 请求号（必填）
		$req_id = date('Ymdhis');

		// partner ID
		$partner = trim($alipay_config['partner']);

		// 签名方式
		$sec_id = trim($alipay_config['sign_type']);

		// 页面编码
		$_input_charset = trim(strtolower($alipay_config['input_charset']));

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
			"partner"        => $partner,
			"sec_id"         => $sec_id,
			"format"         => $format,
			"v"              => $v,
			"req_id"         => $req_id,
			"req_data"       => $req_data,
			"_input_charset" => $_input_charset
		);

		// 建立请求
		$alipaySubmit   = new AlipaySubmit($alipay_config);
		$html_text      = $alipaySubmit->buildRequestHttp($para_token);

		// URLDECODE返回的信息
		$html_text      = urldecode($html_text);

		// XML解析远程模拟提交后返回的信息
		$para_html_text = $alipaySubmit->parseResponse($html_text);

		// 获取request_token
		$request_token  = $para_html_text['request_token'];

		/************根据授权码token调用交易接口 alipay.wap.auth.authAndExecute************/

		// 业务详情（必填）
		$req_data       = '<auth_and_execute_req><request_token>' . $request_token . '</request_token></auth_and_execute_req>';

		// 构造要请求的参数数组
		$parameter = array(
			"service"        => "alipay.wap.auth.authAndExecute",
			"partner"        => $partner,
			"sec_id"         => $sec_id,
			"format"         => $format,
			"v"              => $v,
			"req_id"         => $req_id,
			"req_data"       => $req_data,
			"_input_charset" => $_input_charset
		);

		// 建立请求
		$alipaySubmit = new AlipaySubmit($alipay_config);
		$html_array   = $alipaySubmit->buildRequestPara($parameter);
		$sign         = $html_array['sign'];

		$html_text    = $alipaySubmit->buildRequestForm($parameter, 'get', '确认');


		// 自组http请求链接
		$alipay_gateway_new = 'http://wappaygw.alipay.com/service/rest.htm?';

		$http_req = $alipay_gateway_new.'_input_charset='.$_input_charset.'&format='.
					$format.'&partner='.$partner.'&req_data='.$req_data.'&req_id='.
					$req_id.'&sec_id='.$sec_id.'&service=alipay.wap.auth.authAndExecute&v=2.0&sign='.$sign;
		$data = array(
			'http_req' => $http_req
		);
		$this->json_out($data);
		// echo $html_text;
	}

	/**
	 * 查询流水信息
	 */
	private function _set_flow($flow_id)
	{
		$flow = $this->alipay_m->get($flow_id);
		if (isset($flow->out_trade_no)) {
			$this->out_trade_no = $flow->out_trade_no;
			$this->total_fee    = $flow->total_fee;
			$this->subject      = '订单No.' . $flow->order_id;
		}
	}

	/**
	 * 异步通知（支付宝订单状态变更）
	 */
	public function notify()
	{
		$alipay_config = $this->config->item('alipay_config');
		$alipay_notify  = new AlipayNotify($alipay_config);
		$verify_result = $alipay_notify->verifyNotify();
		if($verify_result) {
			$out_trade_no = $_POST['out_trade_no'];
			$total_fee    = $_POST['total_fee'];
			$result       = $_POST['result'];
		}
		$out_trade_no = $_POST['out_trade_no'];
	}

	/**
	 * 同步通知（订单支付成功）
	 */
	public function callback()
	{
		$alipay_config = $this->config->item('alipay_config');
		$alipay_notify = new AlipayNotify($alipay_config);
		$verify_result = $alipay_notify->verifyReturn();

		// if ($verify_result) {
			$out_trade_no = $_GET['out_trade_no'];
			$trade_no     = $_GET['trade_no'];	// 支付宝交易号
			$result       = $_GET['result'];	// 支付结果

			if ($result == 'success') {
				// 处理商户业务逻辑
				$flow     = $this->alipay_m->get_by('out_trade_no', $out_trade_no);
				$flow_id  = $flow->flow_id;
				$order_id = $flow->order_id;
				$this->alipay_m->edit_flow($flow_id, 'ORDER_STAGE_PAYED', time());
				$this->order_m->edit($order_id, array('stage'=>8));
			}

		// }
		header('Location: http://eco/static/user/');
		exit;
	}

	/**
	 * 中断返回
	 */
	public function merchant()
	{

	}
}
