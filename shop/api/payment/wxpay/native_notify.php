<?php
// ini_set('date.timezone','Asia/Shanghai');
// error_reporting(E_ERROR);

/**
 * 接收微信请求，接收productid和用户的openid等参数，执行（【统一下单API】返回prepay_id交易会话标识
 */

defined('InShopNC') or exit('Access Invalid!');

require_once BASE_PATH.'/api/payment/wxpay/lib/WxPay.Api.php';
require_once BASE_PATH.'/api/payment/wxpay/lib/WxPay.Notify.php';
require_once BASE_PATH.'/api/payment/wxpay/log.php';

//初始化日志
$logHandler= new CLogFileHandler(BASE_DATA_PATH.'/log/wxpay/'.date('Y-m-d').'.log');
$logwx = logwx::Init($logHandler, 15);

class NativeNotifyCallBack extends WxPayNotify
{
	public function unifiedorder($openId, $product_id)
	{
	    //得到支付金额
	    $order_pay_info = Model('order')->getOrderPayInfo(array('pay_sn'=> $product_id));
	    if(empty($order_pay_info)){
	        $condition = array();
	        $condition['order_sn'] = $product_id;
	        $condition['order_state'] = ORDER_STATE_NEW;
	        $order_info = Model('vr_order')->getOrderInfo($condition,'sum(order_amount-rcb_amount-pd_amount) as order_amount');
	        $attach = 'v';
	    } else {
	        $condition = array();
	        $condition['pay_sn'] = $product_id;
	        $condition['order_state'] = ORDER_STATE_NEW;
	        $order_info = Model('order')->getOrderInfo($condition,array(),'sum(order_amount-rcb_amount-pd_amount) as order_amount');
	        $attach = 'r';
	    }

		//统一下单
		$input = new WxPayUnifiedOrder();
		$input->SetBody($product_id.'订单');
// 		$input->SetBody(C('site_name').'订单');
		$input->SetAttach($attach);
		$input->SetOut_trade_no($product_id);
		$input->SetTotal_fee($order_info['order_amount']*100);
		$input->SetTime_start(date("YmdHis"));
		$input->SetTime_expire(date("YmdHis", time() + 3600));
		$input->SetGoods_tag('');
		$input->SetNotify_url(SHOP_SITE_URL.'/api/payment/wxpay/notify_url.php');
		$input->SetTrade_type("NATIVE");
// 		$input->SetOpenid($openId);
		$input->SetProduct_id($product_id);
		$result = WxPayApi::unifiedOrder($input);
		Log::DEBUG("unifiedorder:" . json_encode($result));
		return $result;
	}

	public function NotifyProcess($data, &$msg)
	{
		//echo "处理回调";
		Log::DEBUG("call back:" . json_encode($data));

		if(!array_key_exists("openid", $data) ||
			!array_key_exists("product_id", $data))
		{
			$msg = "回调数据异常";
			return false;
		}
		 
		$openid = $data["openid"];
		$product_id = $data["product_id"];
		
		//统一下单
		$result = $this->unifiedorder($openid, $product_id);
		if(!array_key_exists("appid", $result) ||
			 !array_key_exists("mch_id", $result) ||
			 !array_key_exists("prepay_id", $result))
		{
		 	$msg = "统一下单失败";
		 	return false;
		 }
		
		$this->SetData("appid", $result["appid"]);
		$this->SetData("mch_id", $result["mch_id"]);
		$this->SetData("nonce_str", WxPayApi::getNonceStr());
		$this->SetData("prepay_id", $result["prepay_id"]);
		$this->SetData("result_code", "SUCCESS");
		$this->SetData("err_code_des", "OK");
		return true;
	}
}

Log::DEBUG("begin notify!");
$notify = new NativeNotifyCallBack();
$notify->Handle(true);
