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
      <h3><?php echo $lang['account_syn'];?></h3>
	<?php echo $output['top_link'];?>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <div class="explanation" id="explanation">
    <div class="title" id="checkZoom"><i class="fa fa-lightbulb-o"></i>
      <h4 class="cshop"title="<?php echo $lang['nc_prompts_title'];?>"><?php echo $lang['nc_prompts'];?></h4>
      <span id="explanationZoom" title="<?php echo $lang['nc_prompts_span'];?>"></span> </div>
    <ul>
      <li>启用前需打通短信平台，路经：后台-设置-短信设置-短信平台设置</li>
      <li>各项功能默认为关闭状态，根据实际情况选择是否开启。</li>
    </ul>
  </div>
  <form method="post" name="settingForm">
    <input type="hidden" name="form_submit" value="ok" />
    <div class="ncap-form-default">
      <dl class="row">
        <dt class="tit">
          <label>手机注册</label>
        </dt>
        <dd class="opt">
          <div class="onoff">
            <label for="sms_register_1" class="cb-enable <?php if($output['list_setting']['sms_register'] == '1'){ ?>selected<?php } ?>" title="<?php echo $lang['open'];?>"><span><?php echo $lang['open'];?></span></label>
            <label for="sms_register_0" class="cb-disable <?php if($output['list_setting']['sms_register'] == '0'){ ?>selected<?php } ?>" title="<?php echo $lang['close'];?>"><span><?php echo $lang['close'];?></span></label>
            <input type="radio" id="sms_register_1" name="sms_register" value="1" <?php echo $output['list_setting']['sms_register']==1?'checked=checked':''; ?>>
            <input type="radio" id="sms_register_0" name="sms_register" value="0" <?php echo $output['list_setting']['sms_register']==0?'checked=checked':''; ?>>
          </div>
          <p class="notic">开启后可使用手机短信动态码来注册商城会员</p>
        </dd>
      </dl>
      <dl class="row">
        <dt class="tit">
          <label>手机登录</label>
        </dt>
        <dd class="opt">
          <div class="onoff">
            <label for="sms_login_1" class="cb-enable <?php if($output['list_setting']['sms_login'] == '1'){ ?>selected<?php } ?>" title="<?php echo $lang['open'];?>"><span><?php echo $lang['open'];?></span></label>
            <label for="sms_login_0" class="cb-disable <?php if($output['list_setting']['sms_login'] == '0'){ ?>selected<?php } ?>" title="<?php echo $lang['close'];?>"><span><?php echo $lang['close'];?></span></label>
            <input type="radio" id="sms_login_1" name="sms_login" value="1" <?php echo $output['list_setting']['sms_login']==1?'checked=checked':''; ?>>
            <input type="radio" id="sms_login_0" name="sms_login" value="0" <?php echo $output['list_setting']['sms_login']==0?'checked=checked':''; ?>>
          </div>
          <p class="notic">开启后可使用手机短信动态码来登录商城，如果用户量较大建议关闭</p>
        </dd>
      </dl>
      <dl class="row">
        <dt class="tit">
          <label>找回密码</label>
        </dt>
        <dd class="opt">
          <div class="onoff">
            <label for="sms_password_1" class="cb-enable <?php if($output['list_setting']['sms_password'] == '1'){ ?>selected<?php } ?>" title="<?php echo $lang['open'];?>"><span><?php echo $lang['open'];?></span></label>
            <label for="sms_password_0" class="cb-disable <?php if($output['list_setting']['sms_password'] == '0'){ ?>selected<?php } ?>" title="<?php echo $lang['close'];?>"><span><?php echo $lang['close'];?></span></label>
            <input type="radio" id="sms_password_1" name="sms_password" value="1" <?php echo $output['list_setting']['sms_password']==1?'checked=checked':''; ?>>
            <input type="radio" id="sms_password_0" name="sms_password" value="0" <?php echo $output['list_setting']['sms_password']==0?'checked=checked':''; ?>>
          </div>
          <p class="notic">开启后可使用手机短信来找回登录密码</p>
        </dd>
      </dl>
      <div class="bot"><a href="JavaScript:void(0);" class="ncap-btn-big ncap-btn-green" onclick="document.settingForm.submit()"><?php echo $lang['nc_submit'];?></a></div>
    </div>
  </form>
</div>
