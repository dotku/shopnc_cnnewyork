<?php defined('InShopNC') or exit('Access Invalid!');?> 
<style type="text/css">
#box { background: #FFF; width: 238px; height: 410px; margin: -390px 0 0 0; display: block; border: solid 4px #D93600; position: absolute; z-index: 999; opacity: .5 }
#infscr-loading { display: none; }
</style>
<script src="<?php echo SHOP_RESOURCE_SITE_URL.'/js/search_goods.js';?>"></script>
<link href="<?php echo SHOP_TEMPLATES_URL;?>/css/layout.css" rel="stylesheet" type="text/css">

<div class="nch-container wrapper">
  <div class="ncp-category">
    <ul>
      <input type="hidden" id="sc_id" value="<?php echo intval($_GET['sc_id'])>0?intval($_GET['sc_id']):'';?>"/>
      <li><a class="<?php echo intval($_GET['gc_id']) <= 0?'selected':'';?>" href="<?php echo urlShop('promotion','index');?>">所有分类</a></li>
      <?php foreach ($output['goods_class'] as $k=>$v){?>
      <li><a class="<?php echo intval($_GET['gc_id']) == $v['gc_id']?'selected':'';?>" href="<?php echo urlShop('promotion','index',array('gc_id'=>$v['gc_id']));?>"}'><?php echo $v['gc_name'];?></a></li>
      <?php } ?>
    </ul>
  </div>
  <div id="promotionGoods">
    <?php require(BASE_TPL_PATH.'/home/promotion.item.php');?>
  </div>
  <div class="tc mt20 mb20">
    <div class="pagination" id="page-nav"></div>
  </div>
</div>
<div id="page-more"><a href="index.php?act=promotion&gc_id=<?php echo $_GET['gc_id'];?>&curpage=2"></a></div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.raty/jquery.raty.min.js"></script> 
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.masonry.js" type="text/javascript"></script> 
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.infinitescroll.js" type="text/javascript"></script> 
<script>
var $container = $('#promotionGoods');
$container.masonry({
    columnWidth: 305,
    itemSelector: '.item'
});
$(function(){
	$container.infinitescroll({  
        navSelector : '#page-more',
        nextSelector : '#page-more a',
        itemSelector : '.item',
        loading: {
        	selector:'#page-nav',
            img: '<?php echo SHOP_TEMPLATES_URL;?>/images/loading.gif',
            msgText:'努力加载中...',
            maxPage : <?php echo $output['total_page'];?>,
            finishedMsg : '没有记录了',
            finished : function() {
            	$('.raty').raty({
                    path: "<?php echo RESOURCE_SITE_URL;?>/js/jquery.raty/img",
                    readOnly: true,
                    width: 100,
                    score: function() {
                      return $(this).attr('data-score');
                    }
                });
            }
        }
    },function(newElements){
		var $newElems = $(newElements);
		$container.masonry('appended', $newElems, true);
	});

	$('.raty').raty({
        path: "<?php echo RESOURCE_SITE_URL;?>/js/jquery.raty/img",
        readOnly: true,
        width: 100,
        score: function() {
          return $(this).attr('data-score');
        }
    });
});
</script> 