/**
 * 检测是否手机注册用户
 */
function checkMpRegUser(serverdomain, loginId){
	var mob = /^0?1(3|5|8)\d{9}$/;
	var ajaxLock = jQuery('#ajaxLock');
	//标记是否启动异步请求，解决IE多次请求问题
	if(ajaxLock.val()!="0"){
		if(typeof(loginId)!="undefined"){
			if(new RegExp(mob).test(loginId)){
				ajaxLock.val("0");//加上标记
				jQuery.ajax({
					url: serverdomain + "/TempLogin.jsp?tempuser="+loginId,
					async:true,
					dataType:"jsonp",
					jsonp: "callback",
					jsonpCallback:"success_jsonpCallback",
					success:  function(d){
						ajaxLock.val("");//删除标记
						if(d.msg=="1"){
							jQuery('#regType').val(d.msg);
							randIdHandle(true, loginId);
						}
						else{
							jQuery('#regType').val("");
							randIdHandle(false, loginId);
						}
						jQuery(this).val(loginId);//防止异常返回输入框内容修改
					}
				});
				/** jQuery.getJSON(serverdomain + "/TempLogin.jsp?tempuser="+loginId+"&callback=?", function(d){
					ajaxLock.val("");//删除标记
					if(d.msg=="1"){
						jQuery('#regType').val(d.msg);
						randIdHandle(true, loginId);
					}
					else{
						jQuery('#regType').val("");
						randIdHandle(false, loginId);
					}
					jQuery(this).val(loginId);//防止异常返回输入框内容修改
				});	*/			
			} else {
				jQuery('#regType').val("");
				randIdHandle(false, loginId);
				
			}
			
		}
			
	}
	
}
function stopTimer(){
	var stop=false;
	if(jQuery('#stopTimer').val()=="0"){stop=true;}
	return stop;
}
function callback(){
	jQuery('#timeDown').hide();
	jQuery('#mpCode').show();
}
function randIdHandle(isTempUser, loginId){
	var mpCode=jQuery('#mpCode');
	var forgetUname = jQuery('#forgetUname');
    if(isTempUser){
    	forgetUname.hide();
   	 	mpCode.show();
	}else{
		jQuery('#timeDown').hide();
		forgetUname.show();
		mpCode.hide();
		
		stopTimer();
	}
}

function sendTempCode(serverdomain, loginId){
	var ajaxLock = jQuery('#ajaxLock');
	jQuery('#error_pwd_tip').hide();
	if(ajaxLock.val()!="0"){//标记是否启动异步请求，解决IE多次请求问题
		jQuery('#mpCode').hide();
		jQuery("#timeDown").show().trigger('click');
		ajaxLock.val("0");//加上标记
		jQuery.ajax({
			url: serverdomain + "/TempPwd.jsp?tempuser="+loginId,
			async:true,
			dataType:"jsonp",
			jsonp: "callback",
			jsonpCallback:"success_jsonpCallback",
			success:  function(d){
				ajaxLock.val("");//删除标记
				jQuery('div[rel=error_tip]').hide();
				if(d.msg=="1"){
					jQuery('#validateLogin').val("4");
			   	  	jQuery('#error_pwd_tip').show().html('<span>请接听400-636-0888电话,播报随机密码</span>');
				}else if(d.msg=="2"){
					jQuery('#validateLogin').val("");
			   	  	jQuery('#stopTimer').val('0');
			   	  	jQuery('#error_pwd_tip').show().html('<span>随机密码获取次数已达上限,请明天再试</span>');
			   	  	stopTimer();
			   	  	callback();
				}
			}
		});
		/**jQuery.getJSON(serverdomain + "/TempPwd.jsp?tempuser="+loginId+"&callback=?",function(d) {
		   ajaxLock.val("");//删除标记
		   jQuery('div[rel=error_tip]').hide();
		   if(d.msg=="1"){
			  jQuery('#validateLogin').val("4");
		   	  jQuery('#error_pwd_tip').show().html('<span>动态密码已发送至您的手机,请查收</span>');
		   }else if(d.msg=="2"){
			  jQuery('#validateLogin').val("");
		   	  jQuery('#stopTimer').val('0');
		   	  jQuery('#error_pwd_tip').show().html('<span>随机密码获取次数已达上限,请明天再试</span>');
		   	  stopTimer();
		   	  callback();
		   }
		});*/
	}
}

function readCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}

function createCookie(name,value,days) {
	if (days) {
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
	}
	else var expires = "";
	document.cookie = name+"="+value+expires+"; path=/";
}
