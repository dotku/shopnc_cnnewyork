<?php
/**
 * 微信支付通知地址
 *
 * 
 * by shopnc.club 运维舫 运营版
 */
$_GET['act']	= 'payment';
$_GET['op']		= 'notify';
$_GET['payment_code'] = 'wxpay';
require_once(dirname(__FILE__).'/../../../index.php');
