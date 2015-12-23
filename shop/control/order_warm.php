<?php
/**
 * 卖家账号日志
 *
 * 二十四小时在线技术Q：76809326 
 *
 * by 运维舫 www.shopnc.club 运营版
 */

defined('InShopNC') or exit('Access Invalid!');
class order_warmControl extends BaseSellerControl {
    public function __construct() {
        parent::__construct();
    }
	static function count_time($time){
		$d = $time / (3600*24);//天
		$d_h = $time % (3600*24);
		
		$h = $d_h / 3600;//小时
		$h_m = $time % 3600;
		
		$m = $h_m / 60;//分钟
		$s = $m % 60;//秒
		
		return intval($d)."天".intval($h)."小时".intval($m)."分".intval($s)."秒";
	}
	public function warm_listOp() {
		$store_id = isset($_GET['store_id'])?$_GET['store_id']:$_SESSION['store_id'];
		
		$model_order = Model('order');
		$model_store = Model('store');
		$store_info = $model_store->getStoreInfoByID($store_id);
		
		$condition = array();
		$condition['store_id'] = $store_id;
		$condition['order_state '] = "20";
		//$order_list = $model_order->getOrderList($condition);
		
		//$order_list = $model_order->getOrderList($condition, '', '*', 'order_id desc','', array('order_goods','order_common','member'));
		$order_list = $model_order->getOrderList($condition, '', '*', 'order_id desc','', array('order_goods','order_common'));
		
		$time = time() - ($store_info['warn_time'] * 60);
		
		//订单ID、下单时间、耽误时间、订单金额、客户名称，客户手机、所属店铺。
		//var_dump($order_list);
		$order_arry = array();
		foreach($order_list as $order){
			if($order['add_time'] < $time){
				$common = $order['extend_order_common'];
				$val = array();
				$val['store_id'] = $store_id;
				$val['store_name'] = $store_info['store_name'];
				$val['order_id'] = $order['order_id'];
				$val['add_time'] = $order['add_time'];
				$val['order_amount'] = $order['order_amount'];
				$val['buyer_name'] = $order['buyer_name'];
				$val['reciver_name'] = $common['reciver_name'];
				$val['phone'] = $common['reciver_info']['phone'];
				$val['mob_phone'] = $common['reciver_info']['mob_phone'];
				$val['step_time'] = $this->count_time(($time - $order['add_time']));
				$order_array[] = $val;
			}
		}
		
		var_dump($order_array);
		echo json_encode($order_array);
	}
}
?>
