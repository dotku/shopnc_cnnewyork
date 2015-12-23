<?php defined('InShopNC') or exit('Access Invalid!');?> 
<?php if(!empty($output['group_list']) && is_array($output['group_list'])) { ?>
<!--v3-b12 多频道 -->
<div class="sale">
  <ul>
    <?php foreach($output['group_list'] as $val) { ?>
    <li>
      <div class="goods-thumb" style=" background-image:url(<?php echo gthumb($val['groupbuy_image1'], 'small');?>);"><a href="<?php echo urlShop('show_groupbuy','groupbuy_detail',array('group_id'=> $val['groupbuy_id']));?>" target="_blank">&nbsp;</a></div>
      <dl>
        <dt class="goods-name"><?php echo $val['groupbuy_name']; ?></dt>
        <dd class="goods-price"><strong><?php echo ncPriceFormatForList($val['groupbuy_price']); ?></strong><span class="sell">已售<em><?php echo $val['buy_quantity']+$val['virtual_quantity'];?></em></span></dd>
      </dl>
      <div class="time-remain" count_down="<?php echo $val['end_time']-TIMESTAMP; ?>"><em time_id="d">0</em><?php echo $lang['text_tian'];?><em time_id="h">0</em><?php echo $lang['text_hour'];?> <em time_id="m">0</em><?php echo $lang['text_minute'];?><em time_id="s">0</em><?php echo $lang['text_second'];?></div>
    </li>
    <?php } ?>
  </ul>
</div>
<?php } ?>
<?php if(!empty($output['xianshi_item']) && is_array($output['xianshi_item'])) { ?>
<div class="sale">
  <ul>
    <?php foreach($output['xianshi_item'] as $val) { ?>
    <li>
      <div class="goods-thumb" style=" background-image: url(<?php echo thumb($val, 240);?>);"><a href="<?php echo urlShop('goods','index',array('goods_id'=> $val['goods_id']));?>" target="_blank">&nbsp;</a></div>
      <dl>
        <dt class="goods-name"><?php echo $val['goods_name']; ?></dt>
        <dd class="goods-price"><strong><?php echo ncPriceFormatForList($val['xianshi_price']); ?></strong><span class="original"><?php echo ncPriceFormatForList($val['goods_price']);?></span></dd>
        <dd class="goods-price-discount"><em><?php echo $val['xianshi_discount']; ?></em></dd>
      </dl>
      <div class="time-remain" count_down="<?php echo $val['end_time']-TIMESTAMP;?>"><em time_id="d">0</em><?php echo $lang['text_tian'];?><em time_id="h">0</em><?php echo $lang['text_hour'];?><em time_id="m">0</em><?php echo $lang['text_minute'];?><em time_id="s">0</em><?php echo $lang['text_second'];?></div>
    </li>
    <?php } ?>
  </ul>
</div>
<?php } ?>
