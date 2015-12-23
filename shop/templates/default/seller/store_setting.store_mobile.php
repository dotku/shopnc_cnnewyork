<?php defined('InShopNC') or exit('Access Invalid!');?>
<style type="text/css">
.mb-sliders li { width: 225px; height: 168px; display: inline-block; padding: 3px; margin: 3px; border: 1px solid #ccc; }
.mb-sliders img { max-width: 100%; max-height: 100%; display: block; margin: 3px auto; }
.img-wrapper { width: 220px; height: 80px; overflow: hidden; }
</style>

<div class="tabmenu">
  <?php include template('layout/submenu');?>
</div>
<div class="alert alert-block mt10">
  <ul>
    <li>1、可以在此处对手机店铺进行设置，修改后的设置需要点击“保存修改”按钮进行保存</li>
    <li>2、可以拖拽“轮播”图片以调整顺序，无图片的不予轮播显示</li>
    <li>3、跳转URL必须带有“http://”，商品ID必须为数字且为本店发布的商品，非法数据将被自动过滤掉</li>
    <li>4、默认手机店铺页面显示的最多20条推荐商品，可以在“出售中的商品”中进行设置</li>
  </ul>
</div>
<div class="ncsc-form-default">
  <form method="post" action="index.php?act=store_setting&op=store_mobile" enctype="multipart/form-data" id="my_store_form">
    <input type="hidden" name="form_submit" value="ok" />
    <dl>
      <dt>页头背景图<?php echo $lang['nc_colon']; ?></dt>
      <dd class="mb-sliders">
        <?php if ($output['mb_title_img']) { ?>
        <div class="img-wrapper"> <img alt="" src="<?php echo $output['mb_title_img']; ?>" /> </div>
        <p>
          <label>
            <input type="checkbox" name="mb_title_img_del" value="1" />
            标记为删除 </label>
        </p>
        <?php } else { ?>
        <p>暂无图片</p>
        <?php } ?>
        <p>
          <input type="file" name="mb_title_img" />
        </p>
        <p class="hint">手机店铺页面头部背景图片，默认为白色纯色背景，推荐图片大小640x100</p>
      </dd>
    </dl>
    <dl>
      <dt>轮播<?php echo $lang['nc_colon']; ?></dt>
      <dd>
        <p class="hint">手机店铺页面头部区域下方的轮播图片展示，最多可上传<?php echo $output['max_mb_sliders']; ?>张图片，推荐图片大小640x240</p>
      </dd>
    </dl>
    <?php if ($output['mbSliderUrls']) { ?>
    <div class="flexslider">
      <ul class="slides">
        <?php foreach ((array) $output['mbSliderUrls'] as $v) { ?>
        <li> <img alt="" src="<?php echo $v; ?>" /> </li>
        <?php } ?>
      </ul>
    </div>
    <?php } ?>
    <ul class="ncsc-store-slider sortable">
      <?php $mbSliders = (array) $output['mbSliders'];
for ($k = 1; $k <= $output['max_mb_sliders']; $k++) { $v = $mbSliders[$k]; ?>
      <li>
        <input type="hidden" name="mb_sliders_sort[]" value="<?php echo $k; ?>" />
        <div class="picture" nctype="file_<?php echo $k; ?>">
          <?php if ($v['img']) { ?>
          <img nctype="file_<?php echo $k; ?>" alt="" src="<?php echo UPLOAD_SITE_URL.DS.ATTACH_STORE.DS.$v['img']; ?>" />
          <?php } else { ?>
          <i class="icon-picture"></i>
          <?php } ?>
          <a href="javascript:;" data-slider-drop="<?php echo $k; ?>" class="del" title="移除">&#215;</a> </div>
        <div class="url">
          <label>
            <input type="radio" name="mb_sliders_type[<?php echo $k; ?>]" value="1" <?php if ($v['type'] == 1) echo 'checked="checked"'; ?> />
            跳转URL </label>
          <label>
            <input type="radio" name="mb_sliders_type[<?php echo $k; ?>]" value="2" <?php if ($v['type'] == 2) echo 'checked="checked"'; ?> />
            商品ID </label>
          <input type="text" class="text w150" name="mb_sliders_links[<?php echo $k; ?>]" value="<?php echo $v['link']; ?>" />
        </div>
        <div class="ncsc-upload-btn"> <a href="javascript:;"> <span>
          <input type="file" hidefocus="true" size="1" class="input-file" name="file_<?php echo $k; ?>" id="file_<?php echo $k; ?>" />
          </span>
          <p> <i class="icon-upload-alt"></i> 图片上传 </p>
          </a> </div>
      </li>
      <?php } ?>
    </ul>
    <div class="bottom">
      <label class="submit-border">
        <input type="submit" class="submit" value="保存修改" />
      </label>
    </div>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.flexslider-min.js"></script> 
<script src="<?php echo RESOURCE_SITE_URL;?>/js/ajaxfileupload/ajaxfileupload.js" charset="utf-8"></script> 
<script>
$(function() {
    $('.flexslider').flexslider();

    $(".sortable").sortable();

    var DEFAULT_GOODS_IMAGE = '<?php echo UPLOAD_SITE_URL.DS.ATTACH_COMMON; ?>/default_goods_image.gif';
    var LOADING_IMAGE = '<?php echo SHOP_TEMPLATES_URL; ?>/images/loading.gif';

    $('input.input-file').change(function() {
        var id = this.id;

        $('div[nctype="'+id+'"]').find('i,img').remove().end()
            .prepend('<img nctype="'+id+'" src="'+LOADING_IMAGE+'">');

        $.ajaxFileUpload({
            url: 'index.php?act=store_setting&op=store_mb_sliders',
            secureuri: false,
            fileElementId: id,
            dataType: 'json',
            data: {id: id},
            success: function(data, status) {
                if (data.error) {
                    alert(data.error);
                    $('img[nctype="'+id+'"]').attr('src', DEFAULT_GOODS_IMAGE);
                    return;
                }
                $('img[nctype="'+id+'"]').attr('src', data.uploadedUrl);
            },
            error: function(data, status, e) {
                alert(e);
            }
        });
    });

    $("a[data-slider-drop]").click(function() {
        var id = $(this).attr('data-slider-drop');
        var $this = $(this);

        $.getJSON('index.php?act=store_setting&op=store_mb_sliders_drop', {id: id}, function(d) {
            if (!d.success) {
                alert(d.error);
                return;
            }
            $this.parents('div.picture').find('img,i').remove().end()
                .prepend('<i class="icon-picture"></i>');
        });
    });


});
</script> 
