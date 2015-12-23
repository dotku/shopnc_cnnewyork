<?php defined('InShopNC')  or exit('Access Invalid!');?>
<!--v3-v12-->
<dl select_class_id="<?php echo $output['gc_parent']['gc_id'];?>">
  <dt ondblclick="del_gc_parent(<?php echo $output['gc_parent']['gc_id'];?>);"> <span select_id="<?php echo $output['gc_parent']['gc_id'];?>" class="pic"> </span>
    <h4><?php echo $output['gc_parent']['gc_name'];?></h4>
    <a class="ncap-btn-mini upload-pic" title="上传分类图片" href="javascript:void(0);">
        <i id="form_<?php echo $output['gc_parent']['gc_id'];?>" class="fa fa-upload"></i></a>
    <a class="ncap-btn-mini del" title="删除该分类块" onclick="del_gc_parent(<?php echo $output['gc_parent']['gc_id'];?>);" href="javascript:void(0);"><i class="fa fa-trash"></i></a> </dt>
  <dd>
    <input name="channel_category[<?php echo $output['gc_parent']['gc_id'];?>][gc_parent][gc_id]" value="<?php echo $output['gc_parent']['gc_id'];?>" type="hidden">
    <input name="channel_category[<?php echo $output['gc_parent']['gc_id'];?>][gc_parent][gc_name]" value="<?php echo $output['gc_parent']['gc_name'];?>" type="hidden">
    <input name="channel_category[<?php echo $output['gc_parent']['gc_id'];?>][gc_parent][gc_pic]" value="" type="hidden">
    <?php if(!empty($output['goods_class']) && is_array($output['goods_class'])){ ?>
    <ul>
      <?php foreach($output['goods_class'] as $k => $v){ ?>
      <li gc_id="<?php echo $v['gc_id'];?>" ondblclick="del_goods_class(<?php echo $v['gc_id'];?>);"> <i onclick="del_goods_class(<?php echo $v['gc_id'];?>);"></i><?php echo $v['gc_name'];?>
        <input name="channel_category[<?php echo $output['gc_parent']['gc_id'];?>][goods_class][<?php echo $v['gc_id'];?>][gc_id]" value="<?php echo $v['gc_id'];?>" type="hidden">
        <input name="channel_category[<?php echo $output['gc_parent']['gc_id'];?>][goods_class][<?php echo $v['gc_id'];?>][gc_name]" value="<?php echo $v['gc_name'];?>" type="hidden">
      </li>
      <?php } ?>
    </ul>
    <?php } ?>
  </dd>
</dl>
