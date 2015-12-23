<?php  defined('InShopNC') or exit('Access Invalid!');?>
<div class="channel-focus-layout style-<?php echo $output['web_id'];?>">
  <div class="channel-category"> 
    <ul class="menu">
      <?php if (!empty($output['code_channel_category']['code_info']) && is_array($output['code_channel_category']['code_info'])) { $i = 0; ?>
      <?php foreach ($output['code_channel_category']['code_info'] as $key => $val) { $i++; ?>
      <li cat_id="<?php echo $val['gc_parent']['gc_id'];?>" class="<?php echo $i%2==1 ? 'odd':'even';?>" <?php if($i>6){?>style="display:none;"<?php }?>>
        <?php if(!empty($val['gc_parent']['gc_pic'])) { ?>
        <div class="pic"><img src="<?php echo UPLOAD_SITE_URL.'/'.$val['gc_parent']['gc_pic'];?>"></div>
        <?php } ?> 
        <h4><a href="<?php echo urlShop('search','index',array('cate_id'=> $val['gc_parent']['gc_id']));?>"><?php echo $val['gc_parent']['gc_name'];?></a></h4>
        <div class="recommend-class"></div>
        <span class="arrow"></span>
        <div class="sub-class" cat_menu_id="<?php echo $val['gc_parent']['gc_id'];?>" style="display:none;">
          <dl>
            <?php if (!empty($val['goods_class']) && is_array($val['goods_class'])) { ?>
            <dt>全部分类</dt>
            <?php foreach ($val['goods_class'] as $k => $v) { ?>
            <dd class="goods-class"> <a href="<?php echo urlShop('search','index',array('cate_id'=> $v['gc_id']));?>"><?php echo $v['gc_name'];?></a> </dd>
            <?php } ?>
            <?php } ?>
          </dl>
        </div>
      </li>
      <?php } ?>
      <?php } ?>
    </ul>
  </div>
  <ul id="fullScreenSlides" class="full-screen-slides">
    <?php if (is_array($output['code_channel_slide']['code_info']) && !empty($output['code_channel_slide']['code_info'])) { ?>
    <?php foreach ($output['code_channel_slide']['code_info'] as $key => $val) { ?>
    <li style="background: <?php echo $val['color'];?> url('<?php echo UPLOAD_SITE_URL.'/'.$val['pic_img'];?>') no-repeat center top"> <a href="<?php echo $val['pic_url'];?>" target="_blank" title="<?php echo $val['pic_name'];?>">&nbsp;</a></li>
    <?php } ?>
    <?php } ?>
  </ul>
  <div class="jfocus-trigeminy">
    <ul>
      <?php if (is_array($output['code_channel_adv']['code_info']) && !empty($output['code_channel_adv']['code_info'])) { ?>
      <?php foreach ($output['code_channel_adv']['code_info'] as $key => $val) { ?>
      <li>
        <?php foreach($val['pic_list'] as $k => $v) { ?>
        <a href="<?php echo $v['pic_url'];?>" target="_blank" title="<?php echo $v['pic_name'];?>"> <img src="<?php echo UPLOAD_SITE_URL.'/'.$v['pic_img'];?>" alt="<?php echo $v['pic_name'];?>"></a>
        <?php } ?>
      </li>
      <?php } ?>
      <?php } ?>
    </ul>
  </div>
  <div class="right-sidebar"> </div>
</div>
