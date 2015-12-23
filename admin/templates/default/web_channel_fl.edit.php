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

<div class="pageshop">
  <div class="fixed-barshop">
    <div class="item-titleshop"><a class="back" href="index.php?act=web_channel&op=floor_list" title="返回模块列表"><i class="fa fa-arrow-circle-o-left"></i></a>
      <div class="subjectshop">
        <h3 class="ashop">频道管理 - 编辑“<?php echo $output['floor']['web_name'];?>”模块</h3>
        <h5 class="bshop">商城的频道及模块内容管理</h5>
      </div>
    </div>
  </div>
  <!-- 操作说明 -->
  <div class="explanation" id="explanation">
    <div class="title" id="checkZoom"><i class="fa fa-lightbulb-o"></i>
      <h4 class="cshop"title="<?php echo $lang['nc_prompts_title'];?>"><?php echo $lang['nc_prompts'];?></h4>
      <span id="explanationZoom" title="<?php echo $lang['nc_prompts_span'];?>"></span> </div>
    <ul  class="ulshop">
      <li class="lishop">所有相关设置完成，使用底部的“更新模块内容”前台展示页面才会变化。</li>
      <li class="lishop">中部的“商品推荐模块”由于页面宽度只能加4个，商品数为8个(已选择的可以拖动进行排序，单击选中，双击删除)。</li>
    </ul>
  </div>
  <div class="ncap-form-all">
    <dl class="row">
      <dd class="opt">
        <div class="channel-templates-board-layout">
          <div class="left">
            <dl id="left_tit">
              <dt>
                <h4>模块标题</h4>
                <a href="JavaScript:show_dialog('channel_tit');"><i class="fa fa-pencil-square-o"></i><?php echo $lang['nc_edit'];?></a></dt>
              <dd class="tit-txt">
                <div id="channel_tit" class="txt-type">
                  <h2><?php echo $output['code_channel_tit']['code_info']['title'];?></h2>
                </div>
              </dd>
            </dl>
            <dl>
              <dt>
                <h4><?php echo $lang['web_config_picture_act'];?></h4>
                <a href="JavaScript:show_dialog('upload_channel_act');"><i class="fa fa-picture-o"></i><?php echo $lang['nc_edit'];?></a></dt>
              <dd class="act-pic">
                <div id="picture_channel_act" class="picture">
                  <?php if(!empty($output['code_channel_act']['code_info']['pic'])) { ?>
                  <img src="<?php echo UPLOAD_SITE_URL.'/'.$output['code_channel_act']['code_info']['pic'];?>"/>
                  <?php } ?>
                </div>
              </dd>
            </dl>
          </div>
          <div class="middle">
            <div>
              <?php if (is_array($output['code_recommend_list']['code_info']) && !empty($output['code_recommend_list']['code_info'])) { ?>
              <?php foreach ($output['code_recommend_list']['code_info'] as $key => $val) { ?>
              <dl recommend_id="<?php echo $key;?>">
                <dt>
                  <h4><?php echo $val['recommend']['name'];?></h4>
                  <a href="JavaScript:del_recommend(<?php echo $key;?>);"><i class="fa fa-trash"></i><?php echo $lang['nc_del'];?></a> <a href="JavaScript:show_recommend_dialog(<?php echo $key;?>);"><i class="fa fa-shopping-cart"></i><?php echo '商品块';?></a></dt>
                <dd>
                  <?php if(!empty($val['goods_list']) && is_array($val['goods_list'])) { ?>
                  <ul class="goods-list">
                    <?php foreach($val['goods_list'] as $k => $v) { ?>
                    <li><span><a href="javascript:void(0);"> <img title="<?php echo $v['goods_name'];?>" src="<?php echo strpos($v['goods_pic'],'http')===0 ? $v['goods_pic']:UPLOAD_SITE_URL."/".$v['goods_pic'];?>"/></a></span> </li>
                    <?php } ?>
                  </ul>
                  <?php }else { ?>
                  <ul class="goods-list">
                    <li><span><i class="icon-gift"></i></span></li>
                    <li><span><i class="icon-gift"></i></span></li>
                    <li><span><i class="icon-gift"></i></span></li>
                    <li><span><i class="icon-gift"></i></span></li>
                    <li><span><i class="icon-gift"></i></span></li>
                    <li><span><i class="icon-gift"></i></span></li>
                    <li><span><i class="icon-gift"></i></span></li>
                    <li><span><i class="icon-gift"></i></span></li>
                  </ul>
                  <?php } ?>
                </dd>
              </dl>
              <?php } ?>
              <?php } ?>
              <div class="add-tab" id="btn_add_list"><a href="JavaScript:add_recommend();"><i class="icon-plus-sign-alt"></i><?php echo $lang['web_config_add_recommend'];?></a><?php echo $lang['web_config_recommend_max'];?></div>
            </div>
          </div>
          <div class="right">
            <dl>
              <dt>
                <h4>广告图片1</h4>
                <a href="JavaScript:show_dialog('upload_adv_a');"><i class="fa fa-picture-o"></i><?php echo $lang['nc_edit'];?></a></dt>
              <dd class="adv-pic">
                <div id="picture_adv_a" class="picture">
                  <?php if(!empty($output['code_adv_a']['code_info']['pic'])) { ?>
                  <img src="<?php echo UPLOAD_SITE_URL.'/'.$output['code_adv_a']['code_info']['pic'];?>"/>
                  <?php } ?>
                </div>
              </dd>
            </dl>
            <dl>
              <dt>
                <h4>广告图片2</h4>
                <a href="JavaScript:show_dialog('upload_adv_b');"><i class="fa fa-picture-o"></i><?php echo $lang['nc_edit'];?></a></dt>
              <dd class="adv-pic">
                <div id="picture_adv_b" class="picture">
                  <?php if(!empty($output['code_adv_b']['code_info']['pic'])) { ?>
                  <img src="<?php echo UPLOAD_SITE_URL.'/'.$output['code_adv_b']['code_info']['pic'];?>"/>
                  <?php } ?>
                </div>
              </dd>
            </dl>
            <dl>
              <dt>
                <h4>广告图片3</h4>
                <a href="JavaScript:show_dialog('upload_adv_c');"><i class="fa fa-picture-o"></i><?php echo $lang['nc_edit'];?></a></dt>
              <dd class="adv-pic">
                <div id="picture_adv_c" class="picture">
                  <?php if(!empty($output['code_adv_c']['code_info']['pic'])) { ?>
                  <img src="<?php echo UPLOAD_SITE_URL.'/'.$output['code_adv_c']['code_info']['pic'];?>"/>
                  <?php } ?>
                </div>
              </dd>
            </dl>
          </div>
        </div>
      </dd>
    </dl>
  </div>
  <div class="bot"><a href="index.php?act=web_channel&op=html_update&web_id=<?php echo $_GET['web_id'];?>" class="ncap-btn-big ncap-btn-green" id="submitBtn">更新模块内容</a> </div>
</div>

<!-- 标题图片 -->
<div id="channel_tit_dialog" style="display:none;">
  <form id="channel_tit_form" name="channel_tit_form">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="web_id" value="<?php echo $output['code_channel_tit']['web_id'];?>">
    <input type="hidden" name="code_id" value="<?php echo $output['code_channel_tit']['code_id'];?>">
    <input type="hidden" name="channel_tit[pic]" value="<?php echo $output['code_channel_tit']['code_info']['pic'];?>">
    <input type="hidden" name="channel_tit[url]" value="">
    <div class="ncap-form-default">
      <div>
        <dl class="row">
          <dt class="tit"><?php echo '版块标题';?></dt>
          <dd class="opt">
            <input class="input-txt" type="text" name="channel_tit[title]" id="tit_title" value="<?php echo $output['code_channel_tit']['code_info']['title'];?>">
            <p class="notic"><?php echo '如鞋包配饰、男女服装、运动户外。';?></p>
          </dd>
        </dl>
      </div>
      <div class="bot"><a href="JavaScript:void(0);" onclick="update_channel_tit();" class="ncap-btn-big ncap-btn-green"><?php echo $lang['nc_submit'];?></a></div>
    </div>
  </form>
</div>
<!-- 活动图片 -->
<div id="upload_channel_act_dialog" class="upload_channel_act_dialog" style="display:none;">
  <form id="upload_channel_act_form" name="upload_channel_act_form" enctype="multipart/form-data" method="post" action="index.php?act=web_channel&op=upload_pic" target="upload_pic">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="web_id" value="<?php echo $output['code_channel_act']['web_id'];?>">
    <input type="hidden" name="code_id" value="<?php echo $output['code_channel_act']['code_id'];?>">
    <input type="hidden" name="channel_act[pic]" value="<?php echo $output['code_channel_act']['code_info']['pic'];?>">
    <input type="hidden" name="channel_act[type]" value="pic">
    <div class="ncap-form-default">
      <dl class="row">
        <dt class="tit"><?php echo '活动名称';?></dt>
        <dd class="opt">
          <input class="input-txt" type="text" name="channel_act[title]" value="<?php echo $output['code_channel_act']['code_info']['title'];?>">
          <p class="notic">该位置填写图片名称，生成后为图片ALT内容鼠标触及显示形式。</p>
        </dd>
      </dl>
      <dl class="row">
        <dt class="tit">
          <label><?php echo $lang['web_config_upload_url'];?></label>
        </dt>
        <dd class="opt">
          <input name="channel_act[url]" value="<?php echo $output['code_channel_act']['code_info']['url'];?>" class="input-txt" type="text">
          <p class="notic"><?php echo $lang['web_config_upload_act_url'];?></p>
        </dd>
      </dl>
      <dl class="row">
        <dt class="tit">
          <label><?php echo $lang['web_config_upload_act'];?></label>
        </dt>
        <dd class="opt">
          <div class="input-file-show-shop"><span class="type-file-box-shop">
            <input type='text' name='textfield' id='textfield1' class='type-file-text-shop' />
            <input type='button' name='button' id='button1' value='选择上传...' class='type-file-button-shop' />
            <input name="pic" id="pic" type="file" class="type-file-file-shop" size="30">
            </span></div>
          <p class="notic">该位置图片要求上传宽220*高390像素GIF\JPG\PNG格式文件，不符合规定尺寸的图片将被拉伸或隐藏。</p>
        </dd>
      </dl>
      <div class="bot"><a href="JavaScript:void(0);" onclick="$('#upload_channel_act_form').submit();" class="ncap-btn-big ncap-btn-green"><?php echo $lang['nc_submit'];?></a></div>
    </div>
  </form>
</div>
<!-- 商品推荐模块 -->
<div id="recommend_list_dialog" style="display:none;">
  <div class="s-tips"><i></i><?php echo $lang['web_config_recommend_goods_tips'];?></div>
  <form id="recommend_list_form">
    <input type="hidden" name="web_id" value="<?php echo $output['code_recommend_list']['web_id'];?>">
    <input type="hidden" name="code_id" value="<?php echo $output['code_recommend_list']['code_id'];?>">
    <div id="recommend_input_list" style="display:none;"><!-- 推荐拖动排序 --></div>
    <?php if (is_array($output['code_recommend_list']['code_info']) && !empty($output['code_recommend_list']['code_info'])) { ?>
    <?php foreach ($output['code_recommend_list']['code_info'] as $key => $val) { ?>
    <div class="ncap-form-default" select_recommend_id="<?php echo $key;?>">
      <dl class="row">
        <dt class="tit"> <?php echo $lang['web_config_recommend_title'];?></dt>
        <dd class="opt">
          <input name="recommend_list[<?php echo $key;?>][recommend][name]" value="<?php echo $val['recommend']['name'];?>" type="text" class="input-txt">
          <p class="notic"><?php echo $lang['web_config_recommend_tips'];?></p>
        </dd>
      </dl>
    </div>
    <div class="ncap-form-all" select_recommend_id="<?php echo $key;?>">
      <dl class="row">
        <dt class="tit"><?php echo $lang['web_config_recommend_goods'];?></dt>
        <dd class="opt">
          <ul class="dialog-goodslist-s1 goods-list">
            <?php if(!empty($val['goods_list']) && is_array($val['goods_list'])) { ?>
            <?php foreach($val['goods_list'] as $k => $v) { ?>
            <li id="select_recommend_<?php echo $key;?>_goods_<?php echo $k;?>">
              <div ondblclick="del_recommend_goods(<?php echo $v['goods_id'];?>);" class="goods-pic"> <span class="ac-ico" onclick="del_recommend_goods(<?php echo $v['goods_id'];?>);"></span> <span class="thumb size-72x72"><i></i><img select_goods_id="<?php echo $v['goods_id'];?>" title="<?php echo $v['goods_name'];?>" goods_name="<?php echo $v['goods_name'];?>" src="<?php echo strpos($v['goods_pic'],'http')===0 ? $v['goods_pic']:UPLOAD_SITE_URL."/".$v['goods_pic'];?>" onload="javascript:DrawImage(this,72,72);" /></span></div>
              <div class="goods-name"><a href="<?php echo SHOP_SITE_URL."/index.php?act=goods&goods_id=".$v['goods_id'];?>" target="_blank"><?php echo $v['goods_name'];?></a></div>
              <input name="recommend_list[<?php echo $key;?>][goods_list][<?php echo $v['goods_id'];?>][goods_id]" value="<?php echo $v['goods_id'];?>" type="hidden">
              <input name="recommend_list[<?php echo $key;?>][goods_list][<?php echo $v['goods_id'];?>][market_price]" value="<?php echo $v['market_price'];?>" type="hidden">
              <input name="recommend_list[<?php echo $key;?>][goods_list][<?php echo $v['goods_id'];?>][goods_name]" value="<?php echo $v['goods_name'];?>" type="hidden">
              <input name="recommend_list[<?php echo $key;?>][goods_list][<?php echo $v['goods_id'];?>][goods_price]" value="<?php echo $v['goods_price'];?>" type="hidden">
              <input name="recommend_list[<?php echo $key;?>][goods_list][<?php echo $v['goods_id'];?>][goods_pic]" value="<?php echo $v['goods_pic'];?>" type="hidden">
            </li>
            <?php } ?>
            <?php } ?>
          </ul>
        </dd>
      </dl>
    </div>
    <?php } ?>
    <?php } ?>
    <div id="add_recommend_list" style="display:none;"></div>
    <div class="ncap-form-all">
      <dl class="row">
        <dt class="tit"><?php echo $lang['web_config_recommend_add_goods'];?></dt>
        <dd class="opt">
          <div class="search-bar">
            <label id="recommend_gcategory">商品分类
              <input type="hidden" id="cate_id" name="cate_id" value="0" class="mls_id" />
              <input type="hidden" id="cate_name" name="cate_name" value="" class="mls_names" />
              <select>
                <option value="0"><?php echo $lang['nc_please_choose'];?></option>
                <?php if(!empty($output['goods_class']) && is_array($output['goods_class'])) { ?>
                <?php foreach($output['goods_class'] as $k => $v) { ?>
                <option value="<?php echo $v['gc_id'];?>"><?php echo $v['gc_name'];?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </label>
            <label for="recommend_goods_name"></label>
            <input type="text" value="" name="recommend_goods_name" id="recommend_goods_name" placeholder="输入商品名称或SKU编号" class="txt w150">
            <a href="JavaScript:void(0);" onclick="get_recommend_goods();" class="ncap-btn"><?php echo $lang['nc_query'];?></a></div>
          <div id="show_recommend_goods_list" class="show-recommend-goods-list"></div>
        </dd>
      </dl>
    </div>
    <div class="bot"><a href="JavaScript:void(0);" onclick="update_recommend();" class="ncap-btn-big ncap-btn-green"><span><?php echo $lang['web_config_save'];?></span></a></div>
  </form>
</div>
<!-- 广告图片1 -->
<div id="upload_adv_a_dialog" class="upload_adv_a_dialog" style="display:none;">
  <form id="upload_adv_a_form" name="upload_adv_a_form" enctype="multipart/form-data" method="post" action="index.php?act=web_channel&op=upload_pic" target="upload_pic">
    <input type="hidden" name="web_id" value="<?php echo $output['code_adv_a']['web_id'];?>">
    <input type="hidden" name="code_id" value="<?php echo $output['code_adv_a']['code_id'];?>">
    <div class="ncap-form-default">
      <dl class="row">
        <dt class="tit"><?php echo '文字标题';?></dt>
        <dd class="opt">
          <input class="input-txt" type="text" name="adv_a[pic_name]" value="<?php echo $output['code_adv_a']['code_info']['pic_name'];?>">
          <input type="hidden" name="adv_a[pic]" value="<?php echo $output['code_adv_a']['code_info']['pic'];?>">
          <p class="notic"></p>
        </dd>
      </dl>
      <dl class="row">
        <dt class="tit">
          <label><?php echo $lang['web_config_upload_url'];?></label>
        </dt>
        <dd class="opt">
          <input name="adv_a[pic_url]" value="<?php echo $output['code_adv_a']['code_info']['pic_url'];?>" class="input-txt" type="text">
          <p class="notic"><?php echo $lang['web_config_adv_url_tips'];?></p>
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
          <p class="notic">该位置图片要求上传宽250*高150像素GIF\JPG\PNG格式文件，不符合规定尺寸的图片将被拉伸或隐藏。</p>
        </dd>
      </dl>
      <div class="bot"><a href="JavaScript:void(0);" onclick="$('#upload_adv_a_form').submit();" class="ncap-btn-big ncap-btn-green"><?php echo $lang['web_config_save'];?></a></div>
    </div>
  </form>
</div>
<!-- 广告图片2 -->
<div id="upload_adv_b_dialog" class="upload_adv_b_dialog" style="display:none;">
  <form id="upload_adv_b_form" name="upload_adv_b_form" enctype="multipart/form-data" method="post" action="index.php?act=web_channel&op=upload_pic" target="upload_pic">
    <input type="hidden" name="web_id" value="<?php echo $output['code_adv_b']['web_id'];?>">
    <input type="hidden" name="code_id" value="<?php echo $output['code_adv_b']['code_id'];?>">
    <div class="ncap-form-default">
      <dl class="row">
        <dt class="tit"><?php echo '文字标题';?></dt>
        <dd class="opt">
          <input class="input-txt" type="text" name="adv_b[pic_name]" value="<?php echo $output['code_adv_b']['code_info']['pic_name'];?>">
          <input type="hidden" name="adv_b[pic]" value="<?php echo $output['code_adv_b']['code_info']['pic'];?>">
          <p class="notic"></p>
        </dd>
      </dl>
      <dl class="row">
        <dt class="tit">
          <label><?php echo $lang['web_config_upload_url'];?></label>
        </dt>
        <dd class="opt">
          <input name="adv_b[pic_url]" value="<?php echo $output['code_adv_b']['code_info']['pic_url'];?>" class="input-txt" type="text">
          <p class="notic"><?php echo $lang['web_config_adv_url_tips'];?></p>
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
          <p class="notic">该位置图片要求上传宽250*高150像素GIF\JPG\PNG格式文件，不符合规定尺寸的图片将被拉伸或隐藏。</p>
        </dd>
      </dl>
      <div class="bot"><a href="JavaScript:void(0);" onclick="$('#upload_adv_b_form').submit();" class="ncap-btn-big ncap-btn-green"><?php echo $lang['web_config_save'];?></a></div>
    </div>
  </form>
</div>
<!-- 广告图片3 -->
<div id="upload_adv_c_dialog" class="upload_adv_c_dialog" style="display:none;">
  <form id="upload_adv_c_form" name="upload_adv_c_form" enctype="multipart/form-data" method="post" action="index.php?act=web_channel&op=upload_pic" target="upload_pic">
    <input type="hidden" name="web_id" value="<?php echo $output['code_adv_c']['web_id'];?>">
    <input type="hidden" name="code_id" value="<?php echo $output['code_adv_c']['code_id'];?>">
    <div class="ncap-form-default">
      <dl class="row">
        <dt class="tit"><?php echo '文字标题';?></dt>
        <dd class="opt">
          <input class="input-txt" type="text" name="adv_c[pic_name]" value="<?php echo $output['code_adv_c']['code_info']['pic_name'];?>">
          <input type="hidden" name="adv_c[pic]" value="<?php echo $output['code_adv_c']['code_info']['pic'];?>">
          <p class="notic"></p>
        </dd>
      </dl>
      <dl class="row">
        <dt class="tit">
          <label><?php echo $lang['web_config_upload_url'];?></label>
        </dt>
        <dd class="opt">
          <input name="adv_c[pic_url]" value="<?php echo $output['code_adv_c']['code_info']['pic_url'];?>" class="input-txt" type="text">
          <p class="notic"><?php echo $lang['web_config_adv_url_tips'];?></p>
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
          <p class="notic">该位置图片要求上传宽250*高150像素GIF\JPG\PNG格式文件，不符合规定尺寸的图片将被拉伸或隐藏。</p>
        </dd>
      </dl>
      <div class="bot"><a href="JavaScript:void(0);" onclick="$('#upload_adv_c_form').submit();" class="ncap-btn-big ncap-btn-green"><?php echo $lang['web_config_save'];?></a></div>
    </div>
  </form>
</div>
<iframe style="display:none;" src="" name="upload_pic"></iframe>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.ajaxContent.pack.js"></script> 
<script src="<?php echo RESOURCE_SITE_URL;?>/js/common_select.js"></script> 
<script src="<?php echo RESOURCE_SITE_URL;?>/js/waypoints.js"></script> 
<script src="<?php echo RESOURCE_SITE_URL;?>/js/channel_fl.js"></script>