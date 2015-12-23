<?php defined('InShopNC') or exit('Access Invalid!');?> 
<div class="nc-login-layout">
  <div class="left-pic"><img src="<?php echo $output['lpic'];?>"  border="0"></div>
  <div class="nc-login">
  <div class="arrow"></div>
    <div class="nc-login-mode">
      <ul class="tabs-nav">
        <li><a href="#default"><?php echo $lang['login_index_user_login'];?><i></i></a></li>
        <?php if (C('sms_login') == 1){?>
        <li><a href="#mobile">手机动态码登录<i></i></a></li>
        <?php } ?>
      </ul>
      <div id="tabs_container" class="tabs-container">
        <div id="default" class="tabs-content">
          <form id="login_form" class="nc-login-form" method="post" action="<?php echo SHOP_SITE_URL;?>/index.php?act=login&op=login">
            <?php Security::getToken();?>
            <input type="hidden" name="form_submit" value="ok" />
            <input name="nchash" type="hidden" value="<?php echo getNchash();?>" />
            <dl>
              <dt>账&nbsp;&nbsp;&nbsp;号：</dt>
              <dd>
                <input type="text" class="text" autocomplete="off"  name="user_name" tipMsg="可使用已注册的用户名或手机号登录" id="user_name"  >
              </dd>
            </dl>
            <dl>
              <dt><?php echo $lang['login_index_password'];?>：</dt>
              <dd>
                <input type="password" class="text" name="password" autocomplete="off" tipMsg="<?php echo $lang['login_register_password_to_login'];?>" id="password">
              </dd>
            </dl>
            <?php if(C('captcha_status_login') == '1') { ?>
            <div class="code-div mt15">
              <dl>
                <dt><?php echo $lang['login_index_checkcode'];?>：</dt>
                <dd>
                  <input type="text" name="captcha" autocomplete="off" class="text w100" tipMsg="<?php echo $lang['login_register_input_code'];?>" id="captcha" size="10" />                  
                </dd>
              </dl>
              <span><img src="index.php?act=seccode&op=makecode&type=50,120&nchash=<?php echo getNchash();?>" name="codeimage" id="codeimage"> <a class="makecode" href="javascript:void(0)" onclick="javascript:document.getElementById('codeimage').src='index.php?act=seccode&op=makecode&type=50,120&nchash=<?php echo getNchash();?>&t=' + Math.random();"><?php echo $lang['login_index_change_checkcode'];?></a></span></div>
            <?php } ?>
            <div class="handle-div">
            <span class="auto"><input type="checkbox" class="checkbox" name="auto_login" value="1">七天自动登录<em style="display: none;">请勿在公用电脑上使用</em></span>
            <a class="forget" href="index.php?act=login&op=forget_password"><?php echo $lang['login_index_forget_password'];?></a></div>
            <div class="submit-div">
              <input type="submit" class="submit" value="<?php echo $lang['login_index_login'];?>">
              <input type="hidden" value="<?php echo $_GET['ref_url']?>" name="ref_url">
            </div>
          </form>
        </div>
        <?php if (C('sms_login') == 1){?>
        <div id="mobile" class="tabs-content">
          <form id="post_form" method="post" class="nc-login-form" action="<?php echo SHOP_SITE_URL;?>/index.php?act=connect_sms&op=login">
            <?php Security::getToken();?>
            <input type="hidden" name="form_submit" value="ok" />
            <input name="nchash" type="hidden" value="<?php echo getNchash();?>" />
            <dl>
              <dt>手机号：</dt>
              <dd>
                <input name="phone" type="text" class="text" id="phone" tipMsg="可填写已注册的手机号接收短信" autocomplete="off" value="" >              
              </dd>
            </dl>
            <div class="code-div">
              <dl>
                <dt><?php echo $lang['login_register_code'];?>：</dt>
                <dd>
                  <input type="text" name="captcha" class="text w100" tipMsg="<?php echo $lang['login_register_input_code'];?>" id="image_captcha" size="10" />
                 
                </dd>
              </dl>
              <span><img src="index.php?act=seccode&op=makecode&type=50,120&nchash=<?php echo getNchash();?>" title="<?php echo $lang['login_index_change_checkcode'];?>" name="codeimage" id="sms_codeimage"> <a class="makecode" href="javascript:void(0);" onclick="javascript:document.getElementById('sms_codeimage').src='index.php?act=seccode&op=makecode&type=50,120&nchash=<?php echo getNchash();?>&t=' + Math.random();"><?php echo $lang['login_password_change_code']; ?></a></span> </div>
            
            <div class="tiptext" id="sms_text">正确输入上方验证码后，点击<span> <a href="javascript:void(0);" onclick="get_sms_captcha('2')"><i class="icon-mobile-phone"></i>发送手机动态码</a></span>，查收短信将系统发送的“6位手机动态码”输入到下方验证后登录。</div>
            <dl>
              <dt>动态码：</dt>
              <dd>
                <input type="text" name="sms_captcha" autocomplete="off" class="text" tipMsg="输入6位手机动态码" id="sms_captcha" size="15" />
                
              </dd>
            </dl>
            <div class="submit-div">
                <input type="submit" id="submit" class="submit" value="<?php echo $lang['login_index_login'];?>">
                <input type="hidden" value="<?php echo $_GET['ref_url']?>" name="ref_url">
              </div>
          </form>
        </div>
        <?php } ?>
      </div>
    </div>
    <div class="nc-login-api" id="demo-form-site">
      <?php if (C('qq_isuse') == 1 || C('sina_isuse') == 1 || C('weixin_isuse') == 1){?>
      <h4><?php echo $lang['nc_otherlogintip'];?></h4>
      <?php if (C('qq_isuse') == 1){?>
      <a href="<?php echo SHOP_SITE_URL;?>/api.php?act=toqq" title="QQ账号登录" class="qq"><i></i>QQ</a>
      <?php } ?>
      <?php if (C('sina_isuse') == 1){?>
      <a href="<?php echo SHOP_SITE_URL;?>/api.php?act=tosina" title="新浪微博账号登录" class="sina"><i></i>新浪微博</a>
      <?php } ?>
      <?php if (C('weixin_isuse') == 1){?>
      <a href="javascript:void(0);" onclick="ajax_form('weixin_form', '微信账号登录', '<?php echo SHOP_SITE_URL;?>/index.php?act=connect_wx&op=index', 360);" title="微信账号登录" class="wx"><i></i>微信</a>
      <?php } ?>
      <?php } ?>
    </div>
  </div>
  <div class="clear"></div>
</div>
<script>
$(function(){
	//初始化Input的灰色提示信息  
	$('input[tipMsg]').inputTipText({pwd:'password'});
	//登录方式切换
	$('.nc-login-mode').tabulous({
		 effect: 'flip'//动画反转效果
	});	
	var div_form = '#default';
	$(".nc-login-mode .tabs-nav li a").click(function(){
        if($(this).attr("href") !== div_form){
            div_form = $(this).attr('href');
            $(""+div_form).find(".makecode").trigger("click");
    	}
	});
	
	$("#login_form").validate({
        errorPlacement: function(error, element){
            var error_td = element.parent('dd');
            error_td.append(error);
            element.parents('dl:first').addClass('error');
        },
        success: function(label) {
            label.parents('dl:first').removeClass('error').find('label').remove();
        },
    	submitHandler:function(form){
    	    ajaxpost('login_form', '', '', 'onerror');
    	},
        onkeyup: false,
		rules: {
			user_name: "required",
			password: "required"
			<?php if(C('captcha_status_login') == '1') { ?>
            ,captcha : {
                required : true,
                remote   : {
                    url : 'index.php?act=seccode&op=check&nchash=<?php echo getNchash();?>',
                    type: 'get',
                    data:{
                        captcha : function(){
                            return $('#captcha').val();
                        }
                    },
                    complete: function(data) {
                        if(data.responseText == 'false') {
                        	document.getElementById('codeimage').src='index.php?act=seccode&op=makecode&type=50,120&nchash=<?php echo getNchash();?>&t=' + Math.random();
                        }
                    }
                }
            }
			<?php } ?>
		},
		messages: {
			user_name: "<i class='icon-exclamation-sign'></i>请输入已注册的用户名或手机号",
			password: "<i class='icon-exclamation-sign'></i><?php echo $lang['login_index_input_password'];?>"
			<?php if(C('captcha_status_login') == '1') { ?>
            ,captcha : {
                required : '<i class="icon-remove-circle" title="<?php echo $lang['login_index_input_checkcode'];?>"></i>',
				remote	 : '<i class="icon-remove-circle" title="<?php echo $lang['login_index_input_checkcode'];?>"></i>'
            }
			<?php } ?>
		}
	});

    // 勾选自动登录显示隐藏文字
    $('input[name="auto_login"]').click(function(){
        if ($(this).attr('checked')){
            $(this).attr('checked', true).next().show();
        } else {
            $(this).attr('checked', false).next().hide();
        }
    });
});
</script>
<?php if (C('sms_login') == 1){?>
<script type="text/javascript" src="<?php echo SHOP_RESOURCE_SITE_URL;?>/js/connect_sms.js" charset="utf-8"></script>
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
                    return $("#image_captcha").val().length == 4;
                },
                minlength: 6
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
            }
		}
	});
});
</script>
<?php } ?>