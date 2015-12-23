<?php defined('InShopNC') or exit('Access Invalid!');?>
<style type="text/css">.nc-regist-now { display:none;}</style>
<div class="nc-login-layout">
  <div class="openid"><span class="avatar"><img src="<?php echo $output['qquser_info']['figureurl_qq_1'];?>" /></span><span>您使用QQ账号<a href="#register_form"><?php echo $output['qquser_info']['nickname']; ?></a>注册成功，系统为您随机新建商城用户名<br/>
    及密码，请牢记或自行修改；也可<a href="index.php">跳过该步骤</a>直接登录。</span></div>
  <div class="left-pic"><img src="<?php echo SHOP_TEMPLATES_URL;?>/images/login_openid.jpg" /> </div>
  <div class="nc-login">
    <div class="arrow"></div>
    <div class="nc-qq-mode">
      <ul class="tabs-nav">
        <li><a href="#register"><?php echo $lang['home_qqconnect_register_title']; ?><i></i></a></li>
      </ul>
      <div id="tabs_container" class="tabs-container">
        <div id="register" class="tabs-content">
          <form name="register_form" id="register_form" class="nc-login-form" method="post" action="index.php?act=connect&op=register">
            <input type="hidden" value="ok" name="form_submit">
            <dl>
              <dt><?php echo $lang['login_register_username']; ?>：</dt>
              <dd>
                <input type="text" value="<?php echo $_SESSION['member_name'];?>" id="user" name="user" class="text" readOnly/>
              </dd>
            </dl>
            <dl>
              <dt><?php echo $lang['login_register_pwd']; ?>：</dt>
              <dd>
                <input type="text" value="<?php echo $output['user_passwd'];?>" id="password" name="password" class="text" tipMsg="<?php echo $lang['login_register_password_to_login'];?>"/>
              </dd>
            </dl>
            <dl class="mt15">
              <dt><?php echo $lang['login_register_email']; ?>：</dt>
              <dd>
                <input type="text" id="email" name="email" class="text" tipMsg="<?php echo $lang['login_register_input_valid_email'];?>"/>
              </dd>
            </dl>
            <div class="submit-div">
              <input type="submit" name="submit" value="<?php echo $lang['login_register_enter_now'];?>" class="submit"/>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
$(function(){
	//初始化Input的灰色提示信息  
	$('input[tipMsg]').inputTipText();
	//登录方式切换
	$('.nc-qq-mode').tabulous({
		 effect: 'flip'//动画反转效果
	});
    //注册表单验证
        $('#register_form').validate({
         errorPlacement: function(error, element){
            var error_td = element.parent('dd');
            error_td.append(error);
            element.parents('dl:first').addClass('error');
        },
        success: function(label) {
            label.parents('dl:first').removeClass('error').find('label').remove();
        },
            rules: {
                password: {
                    required: true,
                    minlength: 6,
                    maxlength: 20
                },
                email: {
                    required: true,
                    email: true,
                    remote: {
                        url: 'index.php?act=login&op=check_email',
                        type: 'get',
                        data: {
                            email: function() {
                                return $('#email').val();
                            }
                        }
                    }
                }
        },
        messages : {
            password  : {
                required : '<i class="icon-exclamation-sign"></i><?php echo $lang['login_register_input_password'];?>',
                minlength: '<i class="icon-exclamation-sign"></i><?php echo $lang['login_register_password_range'];?>',
				maxlength: '<i class="icon-exclamation-sign"></i><?php echo $lang['login_register_password_range'];?>'
            },
            email : {
                required : '<i class="icon-exclamation-sign"></i><?php echo $lang['login_register_input_email'];?>',
                email    : '<i class="icon-exclamation-sign"></i><?php echo $lang['login_register_invalid_email'];?>',
				remote	 : '<i class="icon-exclamation-sign"></i><?php echo $lang['login_register_email_exists'];?>'
            }
        }
    });
});
</script>