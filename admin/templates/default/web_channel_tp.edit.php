<?php defined('InShopNC') or exit('Access Invalid!');?>
<!--v3-v12-->
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL?>/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/flexigrid.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.mousewheel.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL?>/js/dialog/dialog.js" id="dialog_js"></script>
<link href="<?php echo ADMIN_TEMPLATES_URL?>/css/index.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="<?php echo ADMIN_TEMPLATES_URL?>/css/font/css/font-awesome.min.css">
<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_TEMPLATES_URL?>/css/jquery-ui.min.css">
<link href="<?php echo ADMIN_TEMPLATES_URL?>/css/index.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
var SHOP_SITE_URL = "<?php echo SHOP_SITE_URL; ?>";
var UPLOAD_SITE_URL = "<?php echo UPLOAD_SITE_URL; ?>";
</script>
<style type="text/css"> 
.evo-colorind-ie { position: relative; *top:0/*IE6,7*/ !important;
}
</style>
<div class="pageshop">
  <div class="fixed-barshop">
    <div class="item-titleshop"><a class="back" href="index.php?act=web_channel&op=floor_list" title="返回模块列表"><i class="fa fa-arrow-circle-o-left"></i></a>
      <div class="subjectshop">
        <h3 class="ashop">频道管理 - 编辑“<?php echo $output['floor']['web_name'];?>”模块</h3>
        <h5 class="bshop">商城的频道及模块内容管理</h5>
      </div>
    </div>
  </div>
  <div class="explanation" id="explanation">
    <div class="title" id="checkZoom"><i class="fa fa-lightbulb-o"></i>
      <h4 class="cshop" title="<?php echo $lang['nc_prompts_title'];?>"><?php echo $lang['nc_prompts'];?></h4>
      <span id="explanationZoom" title="<?php echo $lang['nc_prompts_span'];?>"></span> </div>
    <ul class="ulshop">
      <li class="lishop">推荐商品分类可以上传图片，前台页面只显示6个，其它的隐藏。</li>
      <li class="lishop">所有项目编辑完成后，点击底部的“更新模块内容”，前台会自动更新数据。</li>
    </ul>
  </div>
  <div class="homepage-focus" id="homepageFocusTab">
    <div class="title">
      <h3>顶部焦点区域设置</h3>
      <ul class="tab-base nc-row">
        <li><a href="JavaScript:void(0);" class="current" form="upload_category_form">推荐商品分类</a></li>
        <li><a href="JavaScript:void(0);" form="upload_slide_form">切换焦点大图</a></li>
        <li><a href="JavaScript:void(0);" form="upload_adv_form">广告联动组图</a></li>
      </ul>
    </div>
    <form id="upload_category_form" class="tab-content" name="upload_category_form">
      <input type="hidden" name="web_id" value="<?php echo $output['code_channel_category']['web_id'];?>">
      <input type="hidden" name="code_id" value="<?php echo $output['code_channel_category']['code_id'];?>">
      <div class="ncap-form-default">
        <dl class="row">
          <dt class="tit">已选择的商品分类</dt>
          <dd class="opt">
            <div class="ncap-channel-category">
              <?php if (is_array($output['code_channel_category']['code_info']) && !empty($output['code_channel_category']['code_info'])) { ?>
              <?php foreach ($output['code_channel_category']['code_info'] as $key => $val) { ?>
              <dl select_class_id="<?php echo $val['gc_parent']['gc_id'];?>">
                <dt title="<?php echo $val['gc_parent']['gc_name'];?>">
                <span select_id="<?php echo $val['gc_parent']['gc_id'];?>" class="pic">
                <?php if(!empty($val['gc_parent']['gc_pic'])){ ?>
                <img src="<?php echo UPLOAD_SITE_URL.'/'.$val['gc_parent']['gc_pic'];?>"/>
                <?php } ?>
                </span><h4><?php echo $val['gc_parent']['gc_name'];?></h4>
                <a href="javascript:void(0);" class="ncap-btn-mini upload-pic" title="上传分类图片"><i id="form_<?php echo $val['gc_parent']['gc_id'];?>" class="fa fa-upload"></i></a>
                <a href="javascript:void(0);" class="ncap-btn-mini del" onclick="del_gc_parent(<?php echo $val['gc_parent']['gc_id'];?>);" title="删除该分类块"><i class="fa fa-trash"></i></a>
                </dt>
                <dd>
                <input name="channel_category[<?php echo $val['gc_parent']['gc_id'];?>][gc_parent][gc_id]" value="<?php echo $val['gc_parent']['gc_id'];?>" type="hidden">
                <input name="channel_category[<?php echo $val['gc_parent']['gc_id'];?>][gc_parent][gc_name]" value="<?php echo $val['gc_parent']['gc_name'];?>" type="hidden">
                <input name="channel_category[<?php echo $val['gc_parent']['gc_id'];?>][gc_parent][gc_pic]" value="<?php echo $val['gc_parent']['gc_pic'];?>" type="hidden">
                <?php if(!empty($val['goods_class']) && is_array($val['goods_class'])){ ?>
                <ul><?php foreach($val['goods_class'] as $k => $v){ ?>
                <li gc_id="<?php echo $v['gc_id'];?>" title="<?php echo $v['gc_name'];?>" ondblclick="del_goods_class(<?php echo $v['gc_id'];?>);"><i onclick="del_goods_class(<?php echo $v['gc_id'];?>);"></i><?php echo $v['gc_name'];?>
                  <input name="channel_category[<?php echo $val['gc_parent']['gc_id'];?>][goods_class][<?php echo $v['gc_id'];?>][gc_id]" value="<?php echo $v['gc_id'];?>" type="hidden">
                  <input name="channel_category[<?php echo $val['gc_parent']['gc_id'];?>][goods_class][<?php echo $v['gc_id'];?>][gc_name]" value="<?php echo $v['gc_name'];?>" type="hidden"></li>
                <?php } ?></ul>
                <?php } ?>
                </dd>
              </dl>
              <?php } ?>
              <?php } ?>
            </div>
          </dd>
        </dl>
        <dl class="row">
          <dt class="tit">添加推荐商品分类</dt>
          <dd class="opt">
            <select name="gc_parent_id" id="gc_parent_id" class=" w200" onchange="get_goods_class();">
              <option value="0"><?php echo $lang['nc_please_choose'];?></option>
              <?php if(!empty($output['parent_goods_class']) && is_array($output['parent_goods_class'])){ ?>
              <?php foreach($output['parent_goods_class'] as $k => $v){ ?>
              <option value="<?php echo $v['gc_id'];?>"><?php echo $v['gc_name'];?></option>
              <?php } ?>
              <?php } ?>
            </select>
            <p class="notic">从下拉菜单中选择要推荐的分类，选择父级分类将包含子分类。<br/>
              例如选择某一级分类则包含其二级分类；某二级分类则包含起下级三级分类。<br/>
              建议根据所建立的模块适用的频道页面进行分类添加，即同类目的二级分类作为添加选择项。</p>
          </dd>
        </dl>
      </div>
      <div class="ncap-form-default">
        <div class="bot"><a href="JavaScript:void(0);" onclick="update_channel_category();" class="ncap-btn-big ncap-btn-green"><span>保存</span></a> <a href="index.php?act=web_channel&op=html_update&web_id=<?php echo $output['code_channel_slide']['web_id'];?>" class="ncap-btn-big ncap-btn-green"><span>更新模块内容</span></a> <span class="web-save-succ" style="display:none;"><?php echo $lang['nc_common_save_succ'];?></span> </div>
      </div>
    </form>
    <form id="upload_category" enctype="multipart/form-data" method="post" style="display:none;" action="index.php?act=web_channel&op=upload_gc_pic" target="upload_">
        <input type="hidden" name="w_id" value="<?php echo $output['code_channel_category']['web_id'];?>">
        <input type="hidden" name="c_id" value="<?php echo $output['code_channel_category']['code_id'];?>">
        <input type="hidden" name="gc_id" value="">
        <input name="pic" type="file" style="opacity: 0;z-index: 2;width: 60px;position: absolute;left: 1px;filter:alpha(opacity=0);">
    </form>
    <form id="upload_slide_form" class="tab-content" name="upload_slide_form" enctype="multipart/form-data" method="post" action="index.php?act=web_channel&op=channel_slide" target="upload_pic" style="display:none;">
      <input type="hidden" name="form_submit" value="ok" />
      <input type="hidden" name="web_id" value="<?php echo $output['code_channel_slide']['web_id'];?>">
      <input type="hidden" name="code_id" value="<?php echo $output['code_channel_slide']['code_id'];?>">
      <div class="ncap-form-default">
        <dl class="row">
          <dt class="tit">切换焦点大图预览</dt>
          <dd class="opt">
            <div class="full-screen-slides">
              <ul>
                <?php if (is_array($output['code_channel_slide']['code_info']) && !empty($output['code_channel_slide']['code_info'])) { ?>
                <?php foreach ($output['code_channel_slide']['code_info'] as $key => $val) { ?>
                <li slide_id="<?php echo $val['pic_id'];?>" title="可上下拖拽更改显示顺序">
                  <div class="title">
                    <h4></h4>
                    <a class="ncap-btn-mini del" href="JavaScript:del_slide(<?php echo $val['pic_id'];?>);"><i class="fa fa-trash"></i>删除</a></div>
                  <div class="focus-thumb" onclick="select_slide(<?php echo $val['pic_id'];?>);" style="background-color:<?php echo $val['color'];?>;" title="点击编辑选中区域内容"> <img title="<?php echo $val['pic_name'];?>" src="<?php echo UPLOAD_SITE_URL.'/'.$val['pic_img'];?>"/></div>
                  <input name="channel_slide[<?php echo $val['pic_id'];?>][pic_id]" value="<?php echo $val['pic_id'];?>" type="hidden">
                  <input name="channel_slide[<?php echo $val['pic_id'];?>][pic_name]" value="<?php echo $val['pic_name'];?>" type="hidden">
                  <input name="channel_slide[<?php echo $val['pic_id'];?>][pic_url]" value="<?php echo $val['pic_url'];?>" type="hidden">
                  <input name="channel_slide[<?php echo $val['pic_id'];?>][color]" value="<?php echo $val['color'];?>" type="hidden">
                  <input name="channel_slide[<?php echo $val['pic_id'];?>][pic_img]" value="<?php echo $val['pic_img'];?>" type="hidden">
                </li>
                <?php } ?>
                <?php } ?>
              </ul>
            </div>
            <p class="notic"><?php echo '小提示：单击图片选中修改，拖动可以排序，添加最多不超过5个，保存后生效。';?></p>
            <div class="mt20"><a class="ncap-btn" href="JavaScript:add_slide();"><?php echo '图片调用';?></a> </div>
          </dd>
        </dl>
      </div>
      <div id="upload_slide" class="ncap-form-default" style="display:none; overflow: visible;">
        <div class="title">
          <h3>新增/选中区域内容设置详情</h3>
        </div>
        <dl class="row" style="z-index: 3;">
          <dt class="tit">
            <label><?php echo '背景颜色';?></label>
          </dt>
          <dd class="opt">
            <input id="slide_color" name="slide_pic[color]" value="" class="" type="text">
            <span class="err"></span>
            <p class="notic">背景色即焦点大图区域"DIV{ background-color}"值，用于页面较宽但Banner图片不能填满整个区域时背景色使用，设置请使用十六进制形式(#XXXXXX)，默认留空为白色背景。
</p>
          </dd>
        </dl>
        <dl class="row">
          <dt class="tit"><?php echo '文字标题';?></dt>
          <dd class="opt">
            <input type="hidden" name="slide_id" value="">
            <input class="input-txt" type="text" name="slide_pic[pic_name]" value="">
            <span class="err"></span>
            <p class="notic">图片标题文字将作为图片Alt形式显示。</p>
          </dd>
        </dl>
        <dl class="row">
          <dt class="tit">
            <label><?php echo $lang['web_config_upload_url'];?></label>
          </dt>
          <dd class="opt">
            <input name="slide_pic[pic_url]" value="" class="input-txt" type="text" placeholder="http://">
            <span class="err"></span>
            <p class="vatop tips">输入图片要跳转的URL地址，正确格式应以"http://"开头，点击后将以"_blank"形式另打开页面。</p>
          </dd>
        </dl>
        <dl class="row">
          <dt class="tit"><?php echo $lang['web_config_upload_adv_pic'];?></dt>
          <dd class="opt">
            <div class="input-file-show-shop"><span class="type-file-box-shop">
              <input type='text' name='textfield' id='textfield1' class='type-file-text-shop' />
              <input type='button' name='button' id='button1' value='选择上传...' class='type-file-button-shop' />
              <input name="pic" id="pic" type="file" class="type-file-file-shop" size="30">
              </span></div>
            <p class="notic">建议制作宽度为800~1920像素，高度为300像素的jpg\gif\png格式图片上传使用，尺寸请不超过1M。</p>
          </dd>
        </dl>
        
      </div>
      <div class="ncap-form-default">
        <div class="bot"><a href="JavaScript:void(0);" onclick="$('#upload_slide_form').submit();" class="ncap-btn-big ncap-btn-green"><span>保存</span></a> <a href="index.php?act=web_channel&op=html_update&web_id=<?php echo $output['code_channel_slide']['web_id'];?>" class="ncap-btn-big ncap-btn-green"><span>更新模块内容</span></a> <span class="web-save-succ" style="display:none;"><?php echo $lang['nc_common_save_succ'];?></span> </div>
      </div>
    </form>
    <form id="upload_adv_form" class="tab-content" name="upload_adv_form" enctype="multipart/form-data" method="post" action="index.php?act=web_channel&op=channel_adv" target="upload_pic" style="display:none;">
      <input type="hidden" name="form_submit" value="ok" />
      <input type="hidden" name="web_id" value="<?php echo $output['code_channel_adv']['web_id'];?>">
      <input type="hidden" name="code_id" value="<?php echo $output['code_channel_adv']['code_id'];?>">
      <div class="ncap-form-default">
        <dl class="row">
          <dt class="tit">广告联动组图预览</dt>
          <dd class="opt focus-trigeminy">
            <?php if (is_array($output['code_channel_adv']['code_info']) && !empty($output['code_channel_adv']['code_info'])) { ?>
            <?php foreach ($output['code_channel_adv']['code_info'] as $key => $val) { ?>
            <div focus_id="<?php echo $key;?>" class="focus-trigeminy-group" title="<?php echo '可上下拖拽更改图片组显示顺序';?>">
              <div class="title">
                <h4></h4>
                <a class="ncap-btn-mini del" href="JavaScript:del_adv(<?php echo $key;?>);"><i class="fa fa-trash"></i>删除</a></div>
              <ul>
                <?php foreach($val['pic_list'] as $k => $v) { ?>
                <li pic_id="<?php echo $k;?>" onclick="select_adv(<?php echo $key;?>,this);" title="<?php echo '可左右拖拽更改图片排列顺序';?>">
                  <div class="focus-thumb"><img title="<?php echo $v['pic_name'];?>" src="<?php echo UPLOAD_SITE_URL.'/'.$v['pic_img'];?>"/></div>
                  <input name="channel_adv[<?php echo $key;?>][pic_list][<?php echo $v['pic_id'];?>][pic_id]" value="<?php echo $v['pic_id'];?>" type="hidden">
                  <input name="channel_adv[<?php echo $key;?>][pic_list][<?php echo $v['pic_id'];?>][pic_name]" value="<?php echo $v['pic_name'];?>" type="hidden">
                  <input name="channel_adv[<?php echo $key;?>][pic_list][<?php echo $v['pic_id'];?>][pic_url]" value="<?php echo $v['pic_url'];?>" type="hidden">
                  <input name="channel_adv[<?php echo $key;?>][pic_list][<?php echo $v['pic_id'];?>][pic_img]" value="<?php echo $v['pic_img'];?>" type="hidden">
                </li>
                <?php } ?>
              </ul>
            </div>
            <?php } ?>
            <?php } ?>
            <p class="notic" id="add_list">小提示：可添加每组3张，最多5组，单击图片为单张编辑，拖动排序，保存生效。</p>
            <div class="mt20"> <a class="ncap-btn" href="JavaScript:add_adv();"><?php echo '图片组';?></a> </div>
          </dd>
        </dl>
      </div>
      <div id="upload_adv" class="ncap-form-default" style="display:none;">
        <div class="title">
          <h3>新增/选中区域内容设置详情</h3>
        </div>
        <dl class="row">
          <dt class="tit"> <?php echo '文字标题';?> </dt>
          <dd class="opt">
            <input type="hidden" name="slide_id" value="">
            <input type="hidden" name="pic_id" value="">
            <input class="input-txt" type="text" name="focus_pic[pic_name]" value="">
            <span class="err"></span>
            <p class="notic"> 图片标题文字将作为图片Alt形式显示。 </p>
          </dd>
        </dl>
        <dl class="row">
          <dt class="tit">
            <label> <?php echo $lang['web_config_upload_url'];?> </label>
          </dt>
          <dd class="opt">
            <input name="focus_pic[pic_url]" value="" class="input-txt" type="text">
            <span class="err"></span>
            <p class="notic"> 输入图片要跳转的URL地址，正确格式应以"http://"开头，点击后将以"_blank"形式另打开页面。 </p>
          </dd>
        </dl>
        <dl class="row">
          <dt class="tit"> <?php echo $lang['web_config_upload_adv_pic'];?> </dt>
          <dd class="opt">
            <div class="input-file-show-shop"> <span class="type-file-box-shop">
              <input type='text' name='textfield' id='textfield1' class='type-file-text-shop' />
              <input type='button' name='button' id='button1' value='选择上传...' class='type-file-button-shop' />
              <input name="pic" id="pic" type="file" class="type-file-file-shop" size="30">
              </span> </div>
            <span class="err"></span>
            <p class="notic">建议制作宽度为326像素，高度为125像素的jpg\gif\png格式图片上传使用，过大或过小的图片会被拉伸隐藏。</p>
          </dd>
        </dl>
      </div>
      <div class="ncap-form-default">
        <div class="bot"> <a href="JavaScript:void(0);" onclick="$('#upload_adv_form').submit();" class="ncap-btn-big ncap-btn-green"><span>保存</span></a> <a href="index.php?act=web_channel&op=html_update&web_id=<?php echo $output['code_channel_slide']['web_id'];?>" class="ncap-btn-big ncap-btn-green"><span>更新模块内容</span></a> <span class="web-save-succ" style="display:none;"><?php echo $lang['nc_common_save_succ'];?></span> </div>
      </div>
    </form>
  </div>
</div>
<iframe style="display:none;" src="" name="upload_pic" id="upload_0"></iframe>
<link href="<?php echo RESOURCE_SITE_URL;?>/js/colorpicker/evol.colorpicker.css" rel="stylesheet" type="text/css">
<script src="<?php echo RESOURCE_SITE_URL;?>/js/colorpicker/evol.colorpicker.min.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/waypoints.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/channel_tp.js"></script>
