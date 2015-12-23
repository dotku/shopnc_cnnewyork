<?php defined('InShopNC') or exit('Access Invalid!');?> 
<div class="nch-module nch-module-style01">
  <div class="title">
    <h3>热门推荐</h3>
  </div>
  <div class="content">
    <?php if(!empty($output['goods_list']) && is_array($output['goods_list'])){?>
    <ul class="v_module_recommend">
      <?php foreach($output['goods_list'] as $value){?>
      <li>
        <div class="goods-pic"> <a href="<?php echo urlShop('goods','index',array('goods_id'=>$value['goods_id']));?>" target="_blank"><img alt="<?php echo $value['goods_name'];?>" src="<?php echo thumb($value, 240);?>"></a> </div>
        <dl class="goods-info">
          <dt><a href="<?php echo urlShop('goods','index',array('goods_id'=>$value['goods_id']));?>" title="<?php echo $value['goods_name'];?>" target="_blank">
            <?php if (C('groupbuy_allow') && $value['goods_promotion_type'] == 1) {?>
            <span>抢购商品</span>
            <?php } elseif (C('promotion_allow') && $value['goods_promotion_type'] == 2)  {?>
            <span>限时折扣</span>
            <?php }?>
            <?php echo $value['goods_name'];?></a></dt>
          <dd class="goods-price">商城价：<em><?php echo $lang['currency'];?><?php echo $value['goods_promotion_price'];?></em></dd>
          <dd class="buy-btn"><a href="<?php echo urlShop('goods','index',array('goods_id'=>$value['goods_id']));?>" target="_blank">立即抢购</a></dd>
        </dl>
      </li>
      <?php }?>
    </ul>
    <?php }?>
  </div>
</div>
