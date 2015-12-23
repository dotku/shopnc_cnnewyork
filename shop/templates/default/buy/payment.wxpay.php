<?php defined('InShopNC') or exit('Access Invalid!');?> 
<style>
.wxpayment { border-top: 2px solid #4b5b78; padding: 12px 30px 0; border: 1px solid #eee; color: #777; }
.p-w-bd::after,
.pay-weixin::after { clear: both; content: ""; display: table; }
.p-w-hd { font-family: "Microsoft Yahei"; font-size: 18px; margin-bottom: 20px; }
.p-w-bd { margin-bottom: 30px; padding-left: 130px; }
.pw-box-hd img { border: 1px solid #ddd; }
.p-w-box { float: left; width: 300px; }
.payment-change .pc-wrap { display: block; height: 56px; line-height: 56px; padding: 0 20px; transition: all 0.1s ease 0s; }
.payment-change .pc-wrap .pc-w-arrow-left { float: left; margin-right: 15px; }
.payment-change .pc-wrap .pc-w-arrow-left,
.payment-change .pc-wrap .pc-w-arrow-right { color: #2fa1dd; float: right; font-family: "宋体"; font-size: 22px; font-style: normal; text-align: center; width: 20px; }
.pw-box-ft { background: url("<?php echo SHOP_SITE_URL?>/templates/default/images/payment/icon-red.png") no-repeat scroll 50px 8px #ff7674; height: 44px; padding: 8px 0 8px 125px; }
.p-w-sidebar { background: url("<?php echo SHOP_SITE_URL?>/templates/default/images/payment/phone-bg.png") no-repeat scroll 50px 0 rgba(0, 0, 0, 0); float: left; height: 421px; margin-top: -20px; padding-left: 50px; width: 379px; }
.pw-box-ft p { color: #fff; font-size: 14px; font-weight: 700; line-height: 22px; margin: 0; }
.payment-change .pc-wrap .pc-w-arrow-left { float: left; margin-right: 15px; }
.payment-change .pc-wrap strong { color: #2ea7e7; cursor: pointer; float: left; font-size: 14px; margin-right: 30px; }
</style>
<div class="ncc-main">
  <div class="ncc-title">
    <h3><?php echo $lang['cart_index_payment'];?></h3>
    <h5>订单详情内容可通过查看<a href="index.php?act=member_order" target="_blank">我的订单</a>进行核对处理。</h5>
  </div>
  <div class="ncc-receipt-info">
    <div class="ncc-receipt-info-title">
      <h3> 订单提交成功，请您尽快付款。 应付金额：<strong><?php echo ncPriceFormat($output['api_pay_amount']);?></strong>元 </h3>
    </div>
  </div>
      <table class="ncc-table-style">
        <thead>
          <tr>
            <th class="w50"></th>
            <th class="w200 tl">订单号</th>
            <th class="tl">金额(元)</th>
          </tr>
        </thead>
        <tbody>
          <?php if (count($output['order_list']) > 1) { ?>
          <tr>
            <th colspan="20">由于您的商品由不同商家发出，此单将分为<?php echo count($output['order_list']);?>个不同子订单配送！</th>
          </tr>
          <?php } ?>
          <?php foreach ($output['order_list'] as $key => $order_info) { ?>
          <tr>
            <td></td>
            <td class="tl"><?php echo $order_info['order_sn']; ?></td>
            <td class="tl"><?php echo $order_info['order_amount'];?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
  <div class="wxpayment"> 
    <!-- 微信支付 -->
    <div class="pay-weixin">
      <div class="p-w-hd">微信支付</div>
      <div class="p-w-bd">
        <div class="p-w-box">
          <div class="pw-box-hd"> <img width="298" src="<?php echo SHOP_SITE_URL?>/index.php?act=payment&op=qrcode&data=<?php echo urlencode($output['pay_url']);?>"> </div>
          <div class="pw-box-ft">
            <p>请使用微信扫一扫</p>
            <p>扫描二维码支付</p>
          </div>
        </div>
        <div class="p-w-sidebar"></div>
      </div>
    </div>
    <!-- 微信支付 end --> 
    <!-- payment-change 变更支付方式 -->
    <div class="payment-change"> <a href="javascript:history.back(-1)" id="reChooseUrl" class="pc-wrap"> <i class="pc-w-arrow-left">&lt;</i> <strong>选择其他支付方式</strong> </a> </div>
    <!-- payment-change 变更支付方式 end --> 
  </div>
</div>
<script>
$(document).ready(function(){
    setInterval(queryOrderState, 3000);
});

function queryOrderState(){
    $.ajax({
        type: "GET",
        url: "<?php echo SHOP_SITE_URL?>/index.php?act=payment&op=query_state&<?php echo $output['args'];?>",
        data: "",
        dataType: "json",
        timeout: 4000,
        async:false,
        success: function(result) {
            if(result.state==1){
                if (result.type == 'r') {
                	window.location.href = '<?php echo SHOP_SITE_URL.'/index.php?act=member_order'?>';
                } else {
                	window.location.href = '<?php echo SHOP_SITE_URL.'/index.php?act=member_vr_order&op=index'?>';
                }
            }
        }
    });
}
</script>
