<?php defined('InShopNC') or exit('Access Invalid!');?>
<!--v3-v12-->
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_pay_method'];?></h3>
      <ul class="tab-base"><li><a class="current"><span><?php echo $lang['nc_pay_method'];?></span></a></li>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="post_form" method="post" name="form1">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="payment_id" value="<?php echo $output['payment']['payment_id'];?>" />
    <table class="table tb-type2 nobdb">
      <tbody>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $output['payment']['payment_name'];?></td>
          <td class="vatop tips"></td>
        </tr>
        <?php if ($output['payment']['payment_code'] == 'chinabank') { ?>
        <tr>
          <td colspan="2" class="required"><?php echo $lang['payment_chinabank_account'];?>: </td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="hidden" name="config_name" value="chinabank_account,chinabank_key" />
            <input name="chinabank_account" id="chinabank_account" value="<?php echo $output['config_array']['chinabank_account'];?>" class="txt" type="text"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><?php echo $lang['payment_chinabank_key'];?>:
            </th></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input name="chinabank_key" id="chinabank_key" value="<?php echo $output['config_array']['chinabank_key'];?>" class="txt" type="text"></td>
          <td class="vatop tips"></td>
        </tr>
        <?php } elseif ($output['payment']['payment_code'] == 'tenpay') { ?>
        <tr>
          <td colspan="2" class="required"><?php echo $lang['payment_tenpay_account'];?>:
            </th></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="hidden" name="config_name" value="tenpay_account,tenpay_key" />
            <input name="tenpay_account" id="tenpay_account" value="<?php echo $output['config_array']['tenpay_account'];?>" class="txt" type="text"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><?php echo $lang['payment_tenpay_key'];?>: </td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input name="tenpay_key" id="tenpay_key" value="<?php echo $output['config_array']['tenpay_key'];?>" class="txt" type="text"></td>
          <td class="vatop tips"></td>
        </tr>
        <?php } elseif ($output['payment']['payment_code'] == 'alipay') { ?>
        <tr>
          <td colspan="2" class="required"><?php echo $lang['payment_alipay_account'];?>: </td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="hidden" name="config_name" value="alipay_service,alipay_account,alipay_key,alipay_partner" />
          	<input type="hidden" name="alipay_service" value="create_direct_pay_by_user" />
            <input name="alipay_account" id="alipay_account" value="<?php echo $output['config_array']['alipay_account'];?>" class="txt" type="text"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><?php echo $lang['payment_alipay_key'];?>: </td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input name="alipay_key" id="alipay_key" value="<?php echo $output['config_array']['alipay_key'];?>" class="txt" type="text"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><?php echo $lang['payment_alipay_partner'];?>: </td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input name="alipay_partner" id="alipay_partner" value="<?php echo $output['config_array']['alipay_partner'];?>" class="txt" type="text"></td>
          <td class="vatop tips"><a href="https://b.alipay.com/order/pidKey.htm?pid=2088001525694587&product=fastpay" target="_blank">get my key and partner ID</a></td>
        </tr>
        <!--微信支付 v3-b12-->
        <?php } elseif ($output['payment']['payment_code'] == 'wxpay') { ?>
        <tr>
        <td colspan="2">
        <table id="prompt" class="table tb-type2">
    <tbody>
      <tr class="space odd" style="background: rgb(255, 255, 255) none repeat scroll 0% 0%;">
        <th colspan="12"><div class="title"><h5>操作提示</h5><span class="arrow"></span></div></th>
      </tr>
      <tr class="odd" style="background: rgb(255, 255, 255) none repeat scroll 0% 0%; display: table-row;">
        <td>
        <ul>
            <li>如果启用微信在线退款功能需要在服务器设置“证书”，证书文件不能放在web服务器虚拟目录，应放在有访问权限控制的目录中，防止被他人下载。</li>
            <li>证书路径在“admin\api\refund\wxpay\WxPay.Config.php”中。退款有一定延时，用零钱支付的20分钟内到账，银行卡支付的至少3个工作日。</li>
          </ul></td>
      </tr>
    </tbody>
  </table>
        </td>
        </tr>
        <tr>
          <td colspan="2" class="required">商户公众号APPID: </td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="hidden" name="config_name" value="appid,mchid,key" />
          <input name="appid" id="appid" value="<?php echo $output['config_array']['appid'];?>" class="txt" type="text"></td>
          <td class="vatop tips">绑定支付的APPID（必须配置，开户邮件中可查看）</td>
        </tr>
        <tr>
          <td colspan="2" class="required">商户号: </td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input name="mchid" id="mchid" value="<?php echo $output['config_array']['mchid'];?>" class="txt" type="text"></td>
          <td class="vatop tips">商户号（必须配置，开户邮件中可查看）</td>
        </tr>
        <tr>
          <td colspan="2" class="required">密钥: </td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input name="key" id="key" value="<?php echo $output['config_array']['key'];?>" class="txt" type="text"></td>
          <td class="vatop tips">商户支付密钥，参考开户邮件设置（必须配置，登录商户平台自行设置）</td>
        </tr>
        <?php } ?>
        <!--微信支付end-->
        <tr>
          <td colspan="2" class="required"><?php echo $lang['payment_index_enable'];?>: </td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff"><label for="payment_state1" class="cb-enable <?php if($output['payment']['payment_state'] == '1'){ ?>selected<?php } ?>" ><span><?php echo $lang['nc_yes'];?></span></label>
            <label for="payment_state2" class="cb-disable <?php if($output['payment']['payment_state'] == '0'){ ?>selected<?php } ?>" ><span><?php echo $lang['nc_no'];?></span></label>
            <input type="radio" <?php if($output['payment']['payment_state'] == '1'){ ?>checked="checked"<?php }?> value="1" name="payment_state" id="payment_state1">
            <input type="radio" <?php if($output['payment']['payment_state'] == '0'){ ?>checked="checked"<?php }?> value="0" name="payment_state" id="payment_state2"></td>
          <td class="vatop tips"></td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="15"><a href="JavaScript:void(0);" class="btn" id="submitBtn"  onclick="document.form1.submit()"><span><?php echo $lang['nc_submit'];?></span></a> <a href="JavaScript:void(0);" class="btn" onclick="history.go(-1)"><span><?php echo $lang['nc_back'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script>
$(document).ready(function(){
	$('#post_form').validate({
		<?php if($output['payment']['payment_code'] == 'chinabank') { ?>
        rules : {
            chinabank_account : {
                required   : true
            },
            chinabank_key : {
                required   : true
            }
        },
        messages : {
            chinabank_account  : {
                required  : '<?php echo $lang['payment_chinabank_account'];?><?php echo $lang['payment_edit_not_null']; ?>'
            },
            chinabank_key  : {
                required   : '<?php echo $lang['payment_chinabank_key'];?><?php echo $lang['payment_edit_not_null']; ?>'
            }
        }
		<?php } elseif ($output['payment']['payment_code'] == 'tenpay') { ?>
        rules : {
            tenpay_account : {
                required   : true
            },
            tenpay_key : {
                required   : true
            }
        },
        messages : {
            tenpay_account  : {
                required  : '<?php echo $lang['payment_tenpay_account'];?><?php echo $lang['payment_edit_not_null']; ?>'
            },
            tenpay_key  : {
                required   : '<?php echo $lang['payment_tenpay_key'];?><?php echo $lang['payment_edit_not_null']; ?>'
            }
        }
			
		<?php } elseif ($output['payment']['payment_code'] == 'alipay') { ?>
        rules : {
            alipay_account : {
                required   : true
            },
            alipay_key : {
                required   : true
            },
            alipay_partner : {
                required   : true
            }
        },
        messages : {
            alipay_account  : {
                required  : '<?php echo $lang['payment_alipay_account'];?><?php echo $lang['payment_edit_not_null']; ?>'
            },
            alipay_key  : {
                required   : '<?php echo $lang['payment_alipay_key'];?><?php echo $lang['payment_edit_not_null']; ?>'
            },
            alipay_partner  : {
                required   : '<?php echo $lang['payment_alipay_partner'];?><?php echo $lang['payment_edit_not_null']; ?>'
            }
        }
		<?php } ?>
    });
});
</script>