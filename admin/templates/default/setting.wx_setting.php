<?php defined('InShopNC') or exit('Access Invalid!');?>
<!--v3-v12-->
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL?>/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/flexigrid.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.mousewheel.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL?>/js/dialog/dialog.js" id="dialog_js"></script>
<link href="<?php echo ADMIN_TEMPLATES_URL?>/css/index.css" rel="stylesheet" type="text/css">
<style type="text/css">
.ncap-form-default dd.opt .onoff .cb-enable,
.ncap-form-default dd.opt .onoff .cb-disable { color: #777; font-size: 12px; line-height: 24px; background-color: #ECF0F1; height: 24px; padding:0px; border-style:none; border-color: #BEC3C7; }
</style>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <div class="subject">
        <h3><?php echo $lang['account_syn'];?></h3>
      </div>
      <?php echo $output['top_link'];?> </div>
  </div>
  <div class="fixed-empty"></div>
  <div class="explanation" id="explanation">
    <div class="title" id="checkZoom"><i class="fa fa-lightbulb-o"></i>
      <h4 class="cshop"title="<?php echo $lang['nc_prompts_title'];?>"><?php echo $lang['nc_prompts'];?></h4>
      <span id="explanationZoom" title="<?php echo $lang['nc_prompts_span'];?>"></span> </div>
    <ul>
      <li>启用前需在微信开放平台注册开发者帐号，创建网站应用并获得相应的AppID和AppSecret。</li>
      <li>网站应用的微信登录，通过微信扫描二维码来实现。</li>
    </ul>
  </div>
  <form method="post" name="settingForm">
    <input type="hidden" name="form_submit" value="ok" />
    <div class="ncap-form-default">
      <dl class="row">
        <dt class="tit">
          <label>是否启用微信登录功能</label>
        </dt>
        <dd class="opt">
          <div class="onoff">
            <label for="weixin_isuse_1" class="cb-enable <?php if($output['list_setting']['weixin_isuse'] == '1'){ ?>selected<?php } ?>" title="<?php echo $lang['open'];?>"><span><?php echo $lang['open'];?></span></label>
            <label for="weixin_isuse_0" class="cb-disable <?php if($output['list_setting']['weixin_isuse'] == '0'){ ?>selected<?php } ?>" title="<?php echo $lang['close'];?>"><span><?php echo $lang['close'];?></span></label>
            <input type="radio" id="weixin_isuse_1" name="weixin_isuse" value="1" <?php echo $output['list_setting']['weixin_isuse']==1?'checked=checked':''; ?>>
            <input type="radio" id="weixin_isuse_0" name="weixin_isuse" value="0" <?php echo $output['list_setting']['weixin_isuse']==0?'checked=checked':''; ?>>
          </div>
          <p class="notic">启用后支持使用微信帐号来登录</p>
        </dd>
      </dl>
      <dl class="row">
        <dt class="tit">
          <label for="weixin_appid">应用标识</label>
        </dt>
        <dd class="opt">
          <input id="weixin_appid" name="weixin_appid" value="<?php echo $output['list_setting']['weixin_appid'];?>" class="input-txt" type="text">
          <p class="notic"><a class="ncap-btn" target="_blank" href="https://open.weixin.qq.com/">立即在线申请</a></p>
        </dd>
      </dl>
      <dl class="row">
        <dt class="tit">
          <label for="weixin_appkey">应用密钥</label>
        </dt>
        <dd class="opt">
          <input id="weixin_appkey" name="weixin_secret" value="<?php echo $output['list_setting']['weixin_secret'];?>" class="input-txt" type="text">
          <p class="notic">&nbsp;</p>
        </dd>
      </dl>
      <div class="bot"><a href="JavaScript:void(0);" class="ncap-btn-big ncap-btn-green" onclick="document.settingForm.submit()"><?php echo $lang['nc_submit'];?></a></div>
    </div>
  </form>
</div>
