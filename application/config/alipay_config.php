<?php
/* *
 * 配置文件
 * 版本：3.3
 * 日期：2012-07-19
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。

 * 提示：如何获取安全校验码和合作身份者id
 * 1.用您的签约支付宝账号登录支付宝网站(www.alipay.com)
 * 2.点击“商家服务”(https://b.alipay.com/order/myorder.htm)
 * 3.点击“查询合作者身份(pid)”、“查询安全校验码(key)”

 * 安全校验码查看时，输入支付密码后，页面呈灰色的现象，怎么办？
 * 解决方法：
 * 1、检查浏览器配置，不让浏览器做弹框屏蔽设置
 * 2、更换浏览器或电脑，重新登录查询。
 */

//↓↓↓↓↓↓↓↓↓↓请在这里配置您的基本信息↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
//合作身份者id，以2088开头的16位纯数字
$config['partner']		= '2088611413212494';

//安全检验码，以数字和字母组成的32位字符
//如果签名方式设置为“MD5”时，请设置该参数
$config['key']			= 'f3yohiit93q516rxf42qu55sl7021gbe';

//商户的私钥（后缀是.pem）文件相对路径
//如果签名方式设置为“0001”时，请设置该参数
$config['private_key_path']	= APPPATH.'key/rsa_private_key.pem';

//支付宝公钥（后缀是.pem）文件相对路径
//如果签名方式设置为“0001”时，请设置该参数
$config['ali_public_key_path'] = APPPATH.'key/alipay_public_key.pem';


//↑↑↑↑↑↑↑↑↑↑请在这里配置您的基本信息↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑
// TODO 卖家支付宝账号
$config['seller_email']  = 'eco_vegetable@163.com';
// 页面跳转同步通知页面路径
$config['call_back_url'] = 'http://121.41.50.149/alipay/callback';
// 服务器异步通知页面路径
$config['notify_url']    = 'http://121.41.50.149/alipay/notify';
// 操作中断返回地址
$config['merchant_url']  = 'http://121.41.50.149/alipay/close';


//签名方式 不需修改
// $config['sign_type']    = '0001';
$config['sign_type']     = 'MD5';

//字符编码格式 目前支持 gbk 或 utf-8
$config['input_charset'] = 'utf-8';

//ca证书路径地址，用于curl中ssl校验
//请保证cacert.pem文件在当前文件夹目录中
$config['cacert']    = getcwd().'\\cacert.pem';

//访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
$config['transport']    = 'http';
