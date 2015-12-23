<?php defined('InShopNC') or exit('Access Invalid!');?>
 <!--v3-v12-->
<div class="login-layout">
  <div class="top">
    <h5><?php echo $lang['login_index_title_01'];?><em></em></h5>
    <h2><?php echo $lang['login_index_title_02'];?></h2>
    <h6><?php echo $lang['login_index_title_03'];?></h6>
  </div>
  <form method="post" id="form_login">
    <?php Security::getToken();?>
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="SiteUrl" id="SiteUrl" value="<?php echo SHOP_SITE_URL;?>" />
    <div class="lock-holder">
      <div class="form-group pull-left input-username">
        
          <label><?php echo $lang['login_index_username'];?></label>
          <input name="user_name" id="user_name" autocomplete="off" type="text" class="input-text" value="" required>
          
      </div>
      <i class="fa fa-ellipsis-h dot-left"></i> <i class="fa fa-ellipsis-h dot-right"></i>
      <div class="form-group pull-right input-password-box">
          <label><?php echo $lang['login_index_password'];?></label>
          <input name="password" id="password" class="input-text" autocomplete="off" type="password" required pattern="[\S]{6}[\S]*" title="<?php echo $lang['login_index_password_pattern'];?>">
      </div>
    </div>
    <div class="avatar"><img src="<?php if (cookie('admin_avatar') == '') {echo ADMIN_TEMPLATES_URL. '/images/login/admin.png';} else { echo UPLOAD_SITE_URL . '/' . ATTACH_ADMIN_AVATAR . '/' . cookie('admin_avatar');}?>" alt=""></div>
    <div class="submit"> <span>
      <div class="code">
        <div class="arrow"></div>
        <div class="code-img"><img src="index.php?act=seccode&op=makecode&admin=1&nchash=<?php echo getNchash();?>" name="codeimage" id="codeimage" border="0"/></div>
        <a href="JavaScript:void(0);" id="hide" class="close" title="<?php echo $lang['login_index_close_checkcode'];?>"><i></i></a><a href="JavaScript:void(0);" onclick="javascript:document.getElementById('codeimage').src='index.php?act=seccode&op=makecode&admin=1&nchash=<?php echo getNchash();?>&t=' + Math.random();" class="change" title="<?php echo $lang['login_index_change_checkcode'];?>"><i></i></a> </div>
      <input name="captcha" type="text" required class="input-code" id="captcha" placeholder="<?php echo $lang['login_index_checkcode'];?>" pattern="[A-z0-9]{4}" title="<?php echo $lang['login_index_checkcode_pattern'];?>" autocomplete="off" value="" >
      </span> <span>
      <input name="nchash" type="hidden" value="<?php echo getNchash();?>" />
      <input name="" class="input-button btn-submit" type="button" value="<?php echo $lang['login_index_button_login'];?>">
      </span> </div>
      <div class="submit2"></div>
  </form>
  <div class="bottom">
  </div>
</div>
