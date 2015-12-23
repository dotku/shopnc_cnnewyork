<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="eject_con">
  <div id="warning" class="alert alert-error"></div>
  <form method="post" action="index.php?act=store_deliver_set&op=daddress_add" id="address_form" target="_parent">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" value="<?php echo $output['address_info']['city_id'];?>" name="city_id" id="_area_2">
    <input type="hidden" value="<?php echo $output['address_info']['area_id'];?>" name="area_id" id="_area">
    <input type="hidden" name="address_id" value="<?php echo $output['address_info']['address_id'];?>" />
    <dl>
      <dt><i class="required">*</i><?php echo $lang['store_daddress_receiver_name'].$lang['nc_colon'];?></dt>
      <dd>
        <input type="text" class="text" name="seller_name" value="<?php echo $output['address_info']['seller_name'];?>"/>
      </dd>
    </dl>
    <dl>
      <dt><i class="required">*</i><?php echo $lang['store_daddress_location'].$lang['nc_colon'];?></dt>
      <dd>
        <div>
          <input type="hidden" name="region" id="region" value="<?php echo $output['address_info']['area_info'];?>"/>
        </div>
      </dd>
    </dl>
    <dl>
      <dt><i class="required">*</i><?php echo $lang['store_daddress_address'].$lang['nc_colon'];?></dt>
      <dd>
        <input class="text w300" type="text" name="address" value="<?php echo $output['address_info']['address'];?>"/>
        <p class="hint"><?php echo $lang['store_daddress_not_repeat'];?></p>
      </dd>
    </dl>
    <dl>
      <dt><i class="required">*</i><?php echo $lang['store_daddress_phone_num'].$lang['nc_colon'];?></dt>
      <dd>
        <input type="text" class="text" name="telphone" value="<?php echo $output['address_info']['telphone'];?>"/>
      </dd>
    </dl>
    <dl>
      <dt class="required"><?php echo $lang['store_daddress_company'].$lang['nc_colon'];?></dt>
      <dd>
        <input type="text" class="text" name="company" value="<?php echo $output['address_info']['company'];?>"/>
      </dd>
    </dl>
    <div class="bottom">
      <label class="submit-border"><input type="submit" nctype="address_add_submit" class="submit" value="<?php echo $lang['nc_common_button_save'];?>" /></label>
    </div>
  </form>
</div>
<script>
var SITEURL = "<?php echo SHOP_SITE_URL; ?>";
$(document).ready(function(){
	$("#region").nc_region();
	$('input[nctype="address_add_submit" ]').click(function(){
		if ($('#address_form').valid()) {
			ajaxpost('address_form', '', '', 'onerror');
		}
	});
    $('#address_form').validate({
        errorLabelContainer: $('#warning'),
        invalidHandler: function(form, validator) {
           var errors = validator.numberOfInvalids();
           if(errors)
           {
               $('#warning').show();
           }
           else
           {
               $('#warning').hide();
           }
        },
        rules : {
            seller_name : {
                required : true
            },
            region : {
            	checklast: true
            },
            address : {
                required : true
            },
            telphone : {
                required : true,
                minlength : 6
            }
        },
        messages : {
            seller_name : {
                required : '<i class="icon-exclamation-sign"></i><?php echo $lang['store_daddress_input_receiver'];?>'
            },
            region : {
                checklast : '<i class="icon-exclamation-sign"></i>请将地区选择完整'
            },
            address : {
                required : '<i class="icon-exclamation-sign"></i><?php echo $lang['store_daddress_input_address'];?>'
            },
            telphone : {
                required : '<i class="icon-exclamation-sign"></i><?php echo $lang['store_daddress_phone_rule'];?>',
                minlength: '<i class="icon-exclamation-sign"></i><?php echo $lang['store_daddress_phone_rule'];?>'
            }
        }
    });
});
</script> 
