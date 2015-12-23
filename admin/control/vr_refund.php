<?php
/**
 * 虚拟订单退款
 *
 * 二十四小时在线技术Q：76809326 
 *
 * by 运维舫 www.shopnc.club 运营版
 */

defined('InShopNC') or exit('Access Invalid!');
class vr_refundControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		Language::read('refund');
		$model_vr_refund = Model('vr_refund');
		$model_vr_refund->getRefundStateArray();
	}

	/**
	 * 待处理列表
	 */
	public function refund_manageOp() {
		$model_vr_refund = Model('vr_refund');
		$condition = array();
		$condition['admin_state'] = '1';//状态:1为待审核,2为同意,3为不同意

		$keyword_type = array('order_sn','refund_sn','store_name','buyer_name','goods_name');
		if (trim($_GET['key']) != '' && in_array($_GET['type'],$keyword_type)) {
			$type = $_GET['type'];
			$condition[$type] = array('like','%'.$_GET['key'].'%');
		}
		if (trim($_GET['add_time_from']) != '' || trim($_GET['add_time_to']) != '') {
			$add_time_from = strtotime(trim($_GET['add_time_from']));
			$add_time_to = strtotime(trim($_GET['add_time_to']));
			if ($add_time_from !== false || $add_time_to !== false) {
				$condition['add_time'] = array('time',array($add_time_from,$add_time_to));
			}
		}
		$refund_list = $model_vr_refund->getRefundList($condition,10);

		Tpl::output('refund_list',$refund_list);
		Tpl::output('show_page',$model_vr_refund->showpage());
		Tpl::showpage('vr_refund_manage.list');
	}

	/**
	 * 所有记录
	 */
	public function refund_allOp() {
		$model_vr_refund = Model('vr_refund');
		$condition = array();

		$keyword_type = array('order_sn','refund_sn','store_name','buyer_name','goods_name');
		if (trim($_GET['key']) != '' && in_array($_GET['type'],$keyword_type)) {
			$type = $_GET['type'];
			$condition[$type] = array('like','%'.$_GET['key'].'%');
		}
		if (trim($_GET['add_time_from']) != '' || trim($_GET['add_time_to']) != '') {
			$add_time_from = strtotime(trim($_GET['add_time_from']));
			$add_time_to = strtotime(trim($_GET['add_time_to']));
			if ($add_time_from !== false || $add_time_to !== false) {
				$condition['add_time'] = array('time',array($add_time_from,$add_time_to));
			}
		}
		$refund_list = $model_vr_refund->getRefundList($condition,10);
		Tpl::output('refund_list',$refund_list);
		Tpl::output('show_page',$model_vr_refund->showpage());
		Tpl::showpage('vr_refund_all.list');
	}

	/**
	 * 审核页
	 *
	 */
	public function editOp() {
		$model_vr_refund = Model('vr_refund');
		$condition = array();
		$condition['refund_id'] = intval($_GET['refund_id']);
		$refund_list = $model_vr_refund->getRefundList($condition);
		$refund = $refund_list[0];
		if (chksubmit()) {
			if ($refund['admin_state'] != '1') {//检查状态,防止页面刷新不及时造成数据错误
				showMessage(Language::get('nc_common_save_fail'));
			}
			$refund['admin_time'] = time();
			$refund['admin_state'] = '2';
			if ($_POST['admin_state'] == '3') {
				$refund['admin_state'] = '3';
			}
			$refund['admin_message'] = $_POST['admin_message'];
			$state = $model_vr_refund->editOrderRefund($refund);
			if ($state) {

    			// 发送买家消息
                $param = array();
                $param['code'] = 'refund_return_notice';
                $param['member_id'] = $refund['buyer_id'];
                $param['param'] = array(
                    'refund_url' => urlShop('member_vr_refund', 'view', array('refund_id' => $refund['refund_id'])),
                    'refund_sn' => $refund['refund_sn']
                );
                QueueClient::push('sendMemberMsg', $param);

			    $this->log('虚拟订单退款审核，退款编号'.$refund['refund_sn']);
				showMessage(Language::get('nc_common_save_succ'),'index.php?act=vr_refund&op=refund_manage');
			} else {
				showMessage(Language::get('nc_common_save_fail'));
			}
		}
		Tpl::output('refund',$refund);
		$code_array = explode(',', $refund['code_sn']);
		Tpl::output('code_array',$code_array);
		Tpl::showpage('vr_refund.edit');
	}

	/**
	 * 查看页
	 *
	 */
	public function viewOp() {
		$model_vr_refund = Model('vr_refund');
		$condition = array();
		$condition['refund_id'] = intval($_GET['refund_id']);
		$refund_list = $model_vr_refund->getRefundList($condition);
		$refund = $refund_list[0];
		Tpl::output('refund',$refund);
		$code_array = explode(',', $refund['code_sn']);
		Tpl::output('code_array',$code_array);
		Tpl::showpage('vr_refund.view');
	}
	
	/**
     * 微信退款 v3-b12
     *
     */
    public function wxpayOp() {
        $result = array('state'=>'false','msg'=>'参数错误，微信退款失败');
        $refund_id = intval($_GET['refund_id']);
        $model_refund = Model('vr_refund');
        $condition = array();
        $condition['refund_id'] = $refund_id;
        $condition['refund_state'] = '1';
        $detail_array = $model_refund->getDetailInfo($condition);//退款详细
        if(!empty($detail_array) && in_array($detail_array['refund_code'],array('wxpay','wx_jsapi','wx_saoma'))) {
            $order = $model_refund->getPayDetailInfo($detail_array);//退款订单详细
            $refund_amount = $order['pay_refund_amount'];//本次在线退款总金额
            if ($refund_amount > 0) {
                $wxpay = $order['payment_config'];
                define('WXPAY_APPID', $wxpay['appid']);
                define('WXPAY_MCHID', $wxpay['mchid']);
                define('WXPAY_KEY', $wxpay['key']);
                $total_fee = $order['pay_amount']*100;//微信订单实际支付总金额(在线支付金额,单位为分)
                $refund_fee = $refund_amount*100;//本次微信退款总金额(单位为分)
                $api_file = BASE_PATH.DS.'api'.DS.'refund'.DS.'wxpay'.DS.'WxPay.Api.php';
                include $api_file;
                $input = new WxPayRefund();
                $input->SetTransaction_id($order['trade_no']);//微信订单号
                $input->SetTotal_fee($total_fee);
                $input->SetRefund_fee($refund_fee);
                $input->SetOut_refund_no($detail_array['batch_no']);//退款批次号
                $input->SetOp_user_id(WxPayConfig::MCHID);
                $data = WxPayApi::refund($input);
                if(!empty($data) && $data['return_code'] == 'SUCCESS') {//请求结果
                    if($data['result_code'] == 'SUCCESS') {//业务结果
                        $detail_array = array();
                        $detail_array['pay_amount'] = ncPriceFormat($data['refund_fee']/100);
                        $detail_array['pay_time'] = time();
                        $model_refund->editDetail(array('refund_id'=> $refund_id), $detail_array);
                        $result['state'] = 'true';
                        $result['msg'] = '微信成功退款:'.$detail_array['pay_amount'];
                        
                        $refund = $model_refund->getRefundInfo(array('refund_id'=> $refund_id));
                        $consume_array = array();
                        $consume_array['member_id'] = $refund['buyer_id'];
                        $consume_array['member_name'] = $refund['buyer_name'];
                        $consume_array['consume_amount'] = $detail_array['pay_amount'];
                        $consume_array['consume_time'] = time();
                        $consume_array['consume_remark'] = '微信在线退款成功（到账有延迟），虚拟退款单号：'.$refund['refund_sn'];
                        QueueClient::push('addConsume', $consume_array);
                    } else {
                        $result['msg'] = '微信退款错误,'.$data['err_code_des'];//错误描述
                    }
                } else {
                    $result['msg'] = '微信接口错误,'.$data['return_msg'];//返回信息
                }
            }
        }
        exit(json_encode($result));
    }

    /**
     * 支付宝退款 v3-b12
     *
     */
    public function alipayOp() {
        $refund_id = intval($_GET['refund_id']);
        $model_refund = Model('vr_refund');
        $condition = array();
        $condition['refund_id'] = $refund_id;
        $condition['refund_state'] = '1';
        $detail_array = $model_refund->getDetailInfo($condition);//退款详细
        if(!empty($detail_array) && $detail_array['refund_code'] == 'alipay') {
            $order = $model_refund->getPayDetailInfo($detail_array);//退款订单详细
            $refund_amount = $order['pay_refund_amount'];//本次在线退款总金额
            if ($refund_amount > 0) {
                $payment_config = $order['payment_config'];
                $alipay_config = array();
                $alipay_config['seller_email'] = $payment_config['alipay_account'];
                $alipay_config['partner'] = $payment_config['alipay_partner'];
                $alipay_config['key'] = $payment_config['alipay_key'];
                $api_file = BASE_PATH.DS.'api'.DS.'refund'.DS.'alipay'.DS.'alipay.class.php';
                include $api_file;
                $alipaySubmit = new AlipaySubmit($alipay_config);
                $parameter = getPara($alipay_config);
                $batch_no = $detail_array['batch_no'];
                $b_date = substr($batch_no,0,8);
                if($b_date != date('Ymd')) {
                    $batch_no = date('Ymd').substr($batch_no, 8);//批次号。支付宝要求格式为：当天退款日期+流水号。
                    $model_refund->editDetail(array('refund_id'=> $refund_id), array('batch_no'=> $batch_no));
                }
                $parameter['notify_url'] = ADMIN_SITE_URL."/api/refund/alipay/vr_notify_url.php";
                $parameter['batch_no'] = $batch_no;
                $parameter['detail_data'] = $order['trade_no'].'^'.$refund_amount.'^协商退款';//数据格式为：原交易号^退款金额^理由
                $pay_url = $alipaySubmit->buildRequestParaToString($parameter);
                @header("Location: ".$pay_url);
            }
        }
    }
}
