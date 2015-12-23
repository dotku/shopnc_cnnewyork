var controlVersion = 3.0;
var downUrl = "http://sso.hc360.com/resources/hcsafecontrol.exe";
function PasswordSecurityControl(container,param) {
	if (!param) {
		param = {};
	}
	this.param = $.extend({},{
		css:'fl-pos wd140 pw-srk1'
	},param);
	this.pwd = {enabled:false};
	this.container = $(container);
	if(navigator.userAgent.indexOf("Windows NT")<=0) {
		this.initNormalPassword();
		return this;
	}
	if(navigator.userAgent.indexOf("MSIE")>0||navigator.userAgent.indexOf("Trident")>0){
		this.securityIEPassword();
	}else{
		this.securityNotIEPassword();
	}
	return this; 
};
PasswordSecurityControl.prototype.initNormalPassword = function() {
	var passwordControl = $(document.createElement('input'));
	passwordControl.attr('type','password');
	if (this.param && this.param.css) {
		passwordControl.addClass(this.param.css);
	}
	this.container.empty().append(passwordControl);
	this.pwdControl = passwordControl;
	
	this.pwd = {};
	this.pwd.getPassword = function () {
		var val = passwordControl.val();
		if (!val) {
			val = '';
		}
		if(val!=''){
				return hex_md5(val);
		}else{
				return val;	
		}
	}
	this.pwd.getMacAddress = function () {
		return '';
	}
	this.pwd.clearPassword = function () {
		try{
			passwordControl.val("");
		}catch(e){}
	}
	this.pwd.getVersion = function() {
		return '0.0';
	};
	this.pwd.getLength = function() {
		return passwordControl.val().length;
	};
	this.pwd.checkPassword = function() {
		var val = passwordControl.val();
		if (!val) {
			val = '';
		}
		var result = 0;
		if (/[0-9]/g.test(val)) {
			result ++;
		}
		if (/[a-z]/gi.test(val)) {
			result ++;
		}
		if (/[`~!@#$^&*()=|{}':;',\[\].<>/?~]/g.test(val)) {
			result ++;
		}
		return result;
	};
	this.pwd.enabled = true;
};
PasswordSecurityControl.prototype.securityIEPassword = function() {
	try{
		new ActiveXObject("hcsafecontrolNew.safeEdit");
		var css = '';
		if (this.param && this.param.css) {
			css = this.param.css;
		}
		var html = "<object class='"+css+"' id='safePassEdit' style='padding:0 0px' classid='CLSID:3BD09CFF-6AAF-44D7-9E5D-A9006A8A303E' codebase='"+downUrl+"#version=3.0' ></object>";
		this.container.empty().append(html);
		this.pwdControl = this.container.find('object')[0];
		this.securityHC360Control();
		var version = this.pwd.getVersion();
		if(controlVersion>version){
			var html="<a href='"+downUrl+"' target='_blank' class='fl hqyzm wd146'>&nbsp;&nbsp;请点此升级控件</a>";
			this.container.empty().append(html);
			$(".mg-l5").attr("style","display:none");
			return false;
		}
	}catch(e){
//		var html="<a href='"+downUrl+"' target='_blank' class='fl hqyzm wd146'>请点此安装控件</a>";
//		this.container.empty().append(html);
		//$(".mg-l5").attr("style","display:none");
		return false;
	}
	
};
PasswordSecurityControl.prototype.securityNotIEPassword = function() {
	try{
		var a = navigator.plugins["nphcsafecontrol"];
		if(typeof a == 'undefined' || a == null){
			throw new Error();
		}
		var css = '';
		if (this.param && this.param.css) {
			css = this.param.css;
		}
		var html = "<embed class='"+css+"' style='padding:0 0px' tabIndex='0' type='application/nphcsafecontrol' codebase='"+downUrl+"#version=3.0'></embed>";
		this.container.empty().append(html);
		this.pwdControl = this.container.find('embed')[0];
		this.securityHC360Control();
		var version = this.pwd.getVersion();
		if(controlVersion>version){
			var html="<a href='"+downUrl+"' target='_blank' class='fl hqyzm wd146'>&nbsp;&nbsp;请点此升级控件</a>";
			this.container.empty().append(html);
			$(".mg-l5").attr("style","display:none");
			return false;
		}
	}catch(e){
//		var html="<a href='"+downUrl+"' class='fl hqyzm wd146'>请点此安装控件</a>";
//		this.container.empty().append(html);
		//$(".mg-l5").attr("style","display:none");
		return false;
	}
};

PasswordSecurityControl.prototype.securityHC360Control = function() {
	var pwdControl = this.pwdControl;
	this.pwd = {};
	this.pwd.getPassword = function () {
		try{
			return pwdControl.GetText();
		}catch(e){
			return "";
		}
	};
	this.pwd.getMacAddress = function() {
		return pwdControl.mac_addr;
	};
	this.pwd.clearPassword = function() {
		try{
			pwdControl.clear();
		}catch(e){}
	};
	this.pwd.getVersion = function() {
		var version = pwdControl.version;
		if(typeof version == 'undefined' || version == null){
			return 0;
		}else{
			return pwdControl.version;
		}
	};
	this.pwd.getLength = function() {
		return pwdControl.GetLength();
	};
	this.pwd.checkPassword = function() {
		return pwdControl.checkPass();
	};
	this.pwd.enabled = true;
};
PasswordSecurityControl.prototype.getPassword = function() {
	try{
		return this.pwd.getPassword();
	}catch(e){
		return "";
	}
};
PasswordSecurityControl.prototype.getMacAddress = function() {
	return this.pwd.getMacAddress();
};
PasswordSecurityControl.prototype.getVersion = function() {
	return this.pwd.getVersion();
};
PasswordSecurityControl.prototype.clearPassword = function() {
	try{
		return this.pwd.clearPassword();
	}catch(e){}
};
PasswordSecurityControl.prototype.getLength = function() {
	return this.pwd.getLength();
};
PasswordSecurityControl.prototype.checkPassword = function() {
	return this.pwd.checkPassword();
};