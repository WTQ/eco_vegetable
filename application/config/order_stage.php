<?php
/**
 * 订单状态配置
 *
 * @author 风格独特
 * @version 1.0 2014-05-11
 */

/*
 * 相关的常量定义
 */
define('ORDER_STAGE_SUBMIT',		1);
define('ORDER_STAGE_PROCESSING',	2);
define('ORDER_STAGE_SUCCESS',		3);
define('ORDER_STAGE_U_CANCEL',		4);
define('ORDER_STAGE_S_CANCEL',		5);
define('ORDER_STAGE_UNSUCCESS',		6);


$config[ORDER_STAGE_SUBMIT]			= '已下单';
$config[ORDER_STAGE_PROCESSING]		= '发货中';
$config[ORDER_STAGE_SUCCESS]		= '已完成';
$config[ORDER_STAGE_U_CANCEL]		= '已取消';
$config[ORDER_STAGE_S_CANCEL]		= '被取消';
$config[ORDER_STAGE_UNSUCCESS]		= '未完成';


/* End of file order_stage.php */
/* Location: ./application/config/order_stage.php */

