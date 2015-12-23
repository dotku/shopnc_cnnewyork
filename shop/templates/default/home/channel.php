<?php defined('InShopNC') or exit('Access Invalid!');?> 
<!--v3-b12 多频道-->
<link href="<?php echo SHOP_TEMPLATES_URL;?>/css/channel.css" rel="stylesheet" type="text/css">

<!-- Layout Begin-->
<div class="channel-<?php echo $output['channel']['channel_id'];?> style-<?php echo $output['channel']['channel_style'];?>"> <?php echo $output['web_html']['channel_tp'];?>

  <!--StandardLayout Begin-->
  <?php echo $output['web_html']['channel_fl'];?>
  <!--StandardLayout End-->
</div>
<!--Layout End-->
<script type="text/javascript">
    var gc_id = "<?php echo $output['gc_id'];?>";
    var gc_name = "<?php echo $output['gc_name'];?>";
</script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/home_channel.js" charset="utf-8"></script>