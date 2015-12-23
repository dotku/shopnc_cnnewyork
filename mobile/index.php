<?php
/**
 * 手机接口初始化文件
 *
 * 二十四小时在线技术Q：76809326 
 *
 * by 运维舫 www.shopnc.club 运营版
 */

define('APP_ID','mobile');
define('IGNORE_EXCEPTION', true);
define('BASE_PATH',str_replace('\\','/',dirname(__FILE__)));

if (!@include(dirname(dirname(__FILE__)).'/global.php')) exit('global.php isn\'t exists!');
if (!@include(BASE_CORE_PATH.'/ywf.php')) exit('ywf.php isn\'t exists!');
define('MOBILE_RESOURCE_SITE_URL',MOBILE_SITE_URL.DS.'resource');

if (!@include(BASE_PATH.'/config/config.ini.php')){
    exit('config.ini.php isn\'t exists!');
}

//框架扩展
require(BASE_PATH.'/framework/function/function.php');
if (!@include(BASE_PATH.'/control/control.php')) exit('control.php isn\'t exists!');

Base::run();
