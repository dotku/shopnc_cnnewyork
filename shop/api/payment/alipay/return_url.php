<?php
/**
 * 支付宝返回地址
 *
 * 
 * by shopnc.club 运维舫 二次开发联系q:76809326
 */
$_GET['act']	= 'payment';
$_GET['op']		= 'return';
$_GET['payment_code'] = 'alipay';
require_once(dirname(__FILE__).'/../../../index.php');
?>