<?php
/**
 * 入口
 *
 *
 *
 * by shopnc.club 运维舫 二次开发联系q:76809326
 */
$site_url = strtolower('http://'.$_SERVER['HTTP_HOST'].substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['PHP_SELF'], '/index.php')).'/shop/index.php');
//@header('Location: '.$site_url);
include('shop/index.php');

