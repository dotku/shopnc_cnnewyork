<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="nc-login-layout">
  <div class="left-pic"> <img src="<?php echo $output['lpic'];?>"  border="0"> </div>
  <div class="nc-login">
    <div class="arrow"></div>
    <div class="nc-password-mode">
      <ul class="tabs-nav">
        <li><a href="#default"><?php echo $lang['login_index_find_password'];?><i></i></a></li>
        <?php if (C('sms_password') == 1){?>
        <li><a href="#mobile" title="手机找回密码" class="sms_find">手机找回密码<i></i></a></li>
        <?php } ?>
      </ul>
      <div id="tabs_container" class="tabs-container">
        <div id="default" class="tabs-content">
          <form class="nc-login-form" action="<?php echo urlLogin('login', 'find_password');?>" method="POST" id="find_password_form">
            <?php Security::getToken();?>
            <input type="hidden" name="form_submit" value="ok" />
            <input name="nchash" type="hidden" value="<?php echo getNchash();?>" />
            <dl>
              <dt><?php echo $lang['login_password_you_account'];?>：</dt>
              <dd>
                <input type="text" class="text" name="username" tipMsg="输入您已注册的用户名" />
              </dd>
            </dl>
            <dl>
              <dt><?php echo $lang['login_password_you_email'];?>：</dt>
              <dd>
                <input type="text" class="text" name="email" tipMsg="输入您已注册的邮箱" />
              </dd>
            </dl>
            <div class="code-div mt15">
              <dl>
                <dt><?php echo $lang['login_register_code'];?>：</dt>
                <dd>
                  <input type="text" name="captcha" class="text w100" id="captcha" size="10" tipMsg="输入验证码" />
                </dd>
              </dl>
              <span><img src="index.php?act=seccode&op=makecode&type=50,120&nchash=<?php echo getNchash();?>" title="<?php echo $lang['login_index_change_checkcode'];?>" name="codeimage" id="codeimage"> <a class="makecode" href="javascript:void(0);" class="ml5" onclick="javascript:document.getElementById('codeimage').src='index.php?act=seccode&op=makecode&type=50,120&nchash=<?php echo getNchash();?>&t=' + Math.random();"><?php echo $lang['login_password_change_code']; ?></a></span></div>
            <div class="submit-div">
              <input type="button" class="submit" value="重置密码" name="Submit" id="Submit">
              <input type="hidden" value="<?php echo $output['ref_url']?>" name="ref_url">
            </div>
          </form>
        </div>
        <?php if (C('sms_password') == 1){?>
        <div id="mobile" class="tabs-content">
          <form id="post_form" method="post" class="nc-login-form" action="<?php echo urlLogin('connect_sms', 'find_password');?>">
            <?php Security::getToken();?>
            <input type="hidden" name="form_submit" value="ok" />
            <input name="nchash" type="hidden" value="<?php echo getNchash();?>" />
            <dl>
              <dt>手机号：</dt>
              <dd>
                <input type="text" class="text" autocomplete="off" value="" name="phone" id="phone" tipMsg="输入您已注册的手机号" >
              </dd>
            </dl>
            <div class="code-div">
              <dl>
                <dt><?php echo $lang['login_register_code'];?>：</dt>
                <dd>
                  <input type="text" name="captcha" class="text w100" id="image_captcha" size="10" tipMsg="输入验证码" />
              </dl>
              <span><img src="index.php?act=seccode&op=makecode&type=50,120&nchash=<?php echo getNchash();?>" title="<?php echo $lang['login_index_change_checkcode'];?>" name="codeimage" id="sms_codeimage"> <a class="makecode" href="javascript:void(0);" class="ml5" onclick="javascript:document.getElementById('sms_codeimage').src='index.php?act=seccode&op=makecode&type=50,120&nchash=<?php echo getNchash();?>&t=' + Math.random();"><?php echo $lang['login_password_change_code']; ?></a></span>
              </dd>
            </div>
            <div class="tiptext">正确输入上方验证码后，点击<span id="sms_text"> <a href="javascript:void(0);"  onclick="get_sms_captcha('3')"><i class="icon-mobile-phone"></i>发送短信验证</a></span>，查收短信将系统发送的“6位手机动态码”输入到下方验证后登录。</div>
            <dl>
              <dt>短信验证：</dt>
              <dd>
                <input type="text" name="sms_captcha" autocomplete="off" class="text w100" id="sms_captcha" size="15"  tipMsg="输入动态码" />
              </dd>
            </dl>
            <dl>
              <dt>新密码：</dt>
              <dd>
                <input type="text" name="password" id="password" class="text"  tipMsg="输入您修改的密码" />
              </dd>
            </dl>
            <div class="submit-div">
              <input type="submit" id="submit" class="submit" value="确认重置">
            </div>
          </form>
        </div>
        <?php } ?>
      </div>
    </div>
  </div>
  <div class="clear"></div>
</div>
<script type="text/javascript">
$(function(){
	//初始化Input的灰色提示信息  
	$('input[tipMsg]').inputTipText({pwd:'password'});
	//找回密码方式切换
	$('.nc-password-mode').tabulous({
		 effect: 'flip'//动画反转效果
	});	
	var div_form = '#default';
	$(".nc-password-mode .tabs-nav li a").click(function(){
        if($(this).attr("href") !== div_form){
            div_form = $(this).attr('href');
            $(""+div_form).find(".makecode").trigger("click");
    	}
	});
	
    $('#Submit').click(function(){
        if($("#find_password_form").valid()){
        	ajaxpost('find_password_form', '', '', 'onerror');
        } else{
        	document.getElementById('codeimage').src='index.php?act=seccode&op=makecode&type=50,120&nchash=<?php echo getNchash();?>&t=' + Math.random();
        }
    });
    $('#find_password_form').validate({
		errorPlacement: function(error, element){
            var error_td = element.parent('dd');
            error_td.append(error);
            element.parents('dl:first').addClass('error');
        },
        success: function(label) {
            label.parents('dl:first').removeClass('error').find('label').remove();
        },
        rules : {
            username : {
                required : true
            },
            email : {
                required : true,
                email : true
            },
            captcha : {
                required : true,
                minlength: 4,
                remote   : {
                    url : 'index.php?act=seccode&op=check&nchash=<?php echo getNchash();?>',
                    type: 'get',
                    data:{
                        captcha : function(){
                            return $('#captcha').val();
                        }
                    }
                }
            } 
        },
        messages : {
            username : {
                required : '<i class="icon-exclamation-sign"></i><?php echo $lang['login_usersave_login_usersave_username_isnull'];?>'
            },
            email  : {
                required : '<i class="icon-exclamation-sign"></i><?php echo $lang['login_password_input_email'];?>',
                email : '<i class="icon-exclamation-sign"></i><?php echo $lang['login_password_wrong_email'];?>'
            },
            captcha : {
                required : '<i class="icon-remove-circle" title="<?php echo $lang['login_usersave_code_isnull'];?>"></i>',
                minlength : '<i class="icon-remove-circle" title="<?php echo $lang['login_usersave_wrong_code'];?>"></i>',
                remote   : '<i class="icon-remove-circle" title="<?php echo $lang['login_usersave_wrong_code'];?>"></i>'
            }
        }
    });
});
</script>
<?php if (C('sms_password') == 1){?>
<script type="text/javascript" src="<?php echo LOGIN_RESOURCE_SITE_URL;?>/js/connect_sms.js" charset="utf-8"></script> 
<script>
$(function(){
	$("#post_form").validate({
        errorPlacement: function(error, element){
            var error_td = element.parent('dd');
            error_td.append(error);
            element.parents('dl:first').addClass('error');
        },
        success: function(label) {
            label.parents('dl:first').removeClass('error').find('label').remove();
        },
    	submitHandler:function(form){
    	    ajaxpost('post_form', '', '', 'onerror');
    	},
        onkeyup: false,
		rules: {
			phone: {
                required : true,
                mobile : true
            },
			captcha : {
                required : true,
                minlength: 4,
                remote   : {
                    url : 'index.php?act=seccode&op=check&nchash=<?php echo getNchash();?>',
                    type: 'get',
                    data:{
                        captcha : function(){
                            return $('#image_captcha').val();
                        }
                    },
                    complete: function(data) {
                        if(data.responseText == 'false') {
                        	document.getElementById('sms_codeimage').src='index.php?act=seccode&op=makecode&type=50,120&nchash=<?php echo getNchash();?>&t=' + Math.random();
                        }
                    }
                }
            },
			sms_captcha: {
                required : function(element) {
                    return $("#captcha").val().length == 4;
                },
                minlength: 6
            },
            password : {
                required : function(element) {
                    return $("#sms_captcha").val().length == 6;
                },
                minlength: 6,
				maxlength: 20
            }
		},
		messages: {
			phone: {
                required : '<i class="icon-exclamation-sign"></i>请输入正确的手机号',
                mobile : '<i class="icon-exclamation-sign"></i>请输入正确的手机号'
            },
			captcha : {
                required : '<i class="icon-remove-circle" title="请输入正确的验证码"></i>',
                minlength: '<i class="icon-remove-circle" title="请输入正确的验证码"></i>',
				remote	 : '<i class="icon-remove-circle" title="请输入正确的验证码"></i>'
            },
			sms_captcha: {
                required : '<i class="icon-exclamation-sign"></i>请输入六位短信动态码',
                minlength: '<i class="icon-exclamation-sign"></i>请输入六位短信动态码'
            },
            password  : {
                required : '<i class="icon-exclamation-sign"></i><?php echo $lang['login_register_input_password'];?>',
                minlength: '<i class="icon-exclamation-sign"></i><?php echo $lang['login_register_password_range'];?>',
				maxlength: '<i class="icon-exclamation-sign"></i><?php echo $lang['login_register_password_range'];?>'
            }
		}
	});
});
</script>
<?php } ?>
