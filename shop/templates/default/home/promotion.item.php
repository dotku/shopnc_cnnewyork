<?php defined('InShopNC') or exit('Access Invalid!');?> 
<?php foreach($output['goods_list'] as $goods_info) { ?>

<div class="item">
  <div class="scope">
    <dl class="goods">
      <dt class="goods-thumb"> <a title="<?php echo $goods_info['goods_name'];?>" target="_blank" href="<?php echo $goods_info['goods_url'];?>"><img src="<?php echo $goods_info['image_url_240'];?>" /></a> </dt>
      <dd class="goods-name"><span><strong><?php echo $goods_info['xianshi_title'];?></strong></span> <a target="_blank" href="<?php echo $goods_info['goods_url'];?>"><?php echo $goods_info['goods_name'];?></a></dd>
    </dl>
    <div class="goods-price"><span class="sale">促销价<em><?php echo ncPriceFormatForList($goods_info['xianshi_price']);?></em>元</span><span class="depreciate"><i class="icon-long-arrow-down"></i>直降：¥<?php echo $goods_info['down_price'];?></span></div>
    <div class="goods-buy"><a href="javascript:void(0);" nctype="add_cart" data-param="{goods_id:<?php echo $goods_info['goods_id'];?>}" class="btn">立即抢购</a> <span class="raty" data-score="<?php echo $goods_info['evaluation_good_star'];?>" style="width: 100px;"></span> <span class="mt5"><a href="<?php echo urlShop('show_store','index',array('store_id'=>$goods_info['store_id']));?>"><?php echo $goods_info['store_name'];?></a></span> </div>
    <ul class="goodseval">
      <?php if (is_array($output['goodsevallist'][$goods_info['goods_id']])) { ?>
      <?php foreach($output['goodsevallist'][$goods_info['goods_id']] as $k=>$v){ ?>
      <li>
        <div class="user-avatar"> <a <?php if($v['geval_isanonymous'] != 1){?>href="index.php?act=member_snshome&mid=<?php echo $v['geval_frommemberid'];?>" target="_blank" data-param="{'id':<?php echo $v['geval_frommemberid'];?>}" nctype="mcard"<?php }?>> <img src="<?php echo getMemberAvatarForID($v['geval_frommemberid']);?>"> </a> </div>
        <div class="eval"><i class="icon-quote-left"></i><?php echo $v['geval_content'];?><i class="icon-quote-right"></i></div>
      </li>
      <?php } ?>
      <?php } ?>
    </ul>
  </div>
</div>
<?php } ?>
