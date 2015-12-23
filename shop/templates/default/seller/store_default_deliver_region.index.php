<?php defined('InShopNC') or exit('Access Invalid!');?>
 
<div class="tabmenu">
  <?php include template('layout/submenu');?>
</div>
<div class="ncsc-form-default">
  <form method="post"  action="index.php?act=store_deliver_set&op=deliver_region" id="my_store_form">
    <input type="hidden" name="form_submit" value="ok" />
    <dl>
      <dt>默认配送地区<?php echo $lang['nc_colon'];?></dt>
      <dd>
        <input name="region" type="hidden"  id="region" value="<?php echo $output['deliver_region'][1];?>" />
        <input name="area_ids" type="hidden" id="_areas" value="<?php echo $output['deliver_region'][0];?>">
        <p class="hint">此处设置的地区将作为商品详情页面默认的配送地区显示</p>
      </dd>
    </dl>
    <div class="bottom">
        <label class="submit-border"><input type="submit" class="submit" value="<?php echo $lang['nc_common_button_save'];?>" /></label>
      </div>
  </form>
</div>
<script type="text/javascript">
var SITEURL = "<?php echo SHOP_SITE_URL; ?>";
$(function(){
	$('#region').nc_region();
});
</script>