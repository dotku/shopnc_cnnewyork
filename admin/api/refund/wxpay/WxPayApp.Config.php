<?php
/** 
* 	手机客户端微信支付退款配置信息
* 	证书设置后才能使用后台的在线退款功能
*/
class WxPayConfig
{
	//=======【证书路径设置】=====================================
	/**
	 * TODO：设置商户证书路径
	 * 证书路径,注意应该填写绝对路径（退款时需要，可登录商户平台下载，
	 * API证书下载地址：https://pay.weixin.qq.com/index.php/account/api_cert，下载之前需要安装商户操作证书）
	 * @var path
	 */
	const SSLCERT_PATH = '';//如：/home/cert/apiclient_cert.pem
	const SSLKEY_PATH = '';//如：/home/cert/apiclient_key.pem
	
	//以下参数可以不修改
	const REPORT_LEVENL = 0;//上报等级，0.关闭上报; 1.仅错误出错上报; 2.全量上报
	
	const APPID = WXPAY_APPID;//自动获取支付设置的APP号
	const MCHID = WXPAY_MCHID;//自动获取支付设置的商户号
	const KEY = WXPAY_KEY;//自动获取支付设置的密钥
}
