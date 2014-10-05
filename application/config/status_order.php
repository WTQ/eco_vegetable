<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


define('ORDER_ADD'         , 1);
define('ORDER_SEND'        , 2);
define('ORDER_RECIEVED'    , 3);
define('ORDER_CANCELED'    , 4);
define('ORDER_CONFIRMED'   , 5);
define('ORDER_STAGE_SUBMIT', 6);
define('ORDER_STAGE_PAYED' , 7);

$config[ORDER_ADD]          = '已提交';
$config[ORDER_SEND]         = '已发货';
$config[ORDER_RECIEVED]     = '已完成';
$config[ORDER_CANCELED]     = '已取消';
$config[ORDER_CONFIRMED]    = '已确认';
$config[ORDER_STAGE_SUBMIT] = '未支付';		// 仅限支付宝支付方式
$config[ORDER_STAGE_PAYED]  = '已支付';		// 仅限支付宝支付方式
