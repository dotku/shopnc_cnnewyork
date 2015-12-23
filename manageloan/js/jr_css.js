$(function(){
	var sourceUrl = ""+window.location;//转字符串
	var url = sourceUrl.substring(sourceUrl.lastIndexOf("/")+1);
	
	/**关于我们导航切换*/
	switch (url) {
	case "about_hc":
		$(".nav-sidbar li").eq(0).addClass('nav-sidbar-cur');
		break;
	case "cooperate_hc":
		$(".nav-sidbar li").eq(1).addClass('nav-sidbar-cur');
		break;
	case "contact_us":
		$(".nav-sidbar li").eq(2).addClass('nav-sidbar-cur');
		break;
	default:
		break;
	}
	/**主导航*/
	if(sourceUrl.indexOf('product')>-1) {
		$('.nav .nav-item').eq(1).children().addClass('nav-item-link nav-nav-link');
	}else if(sourceUrl.indexOf('article')>-1) {
		$('.nav .nav-item').eq(2).children().addClass('nav-item-link nav-nav-link');
	}else if(sourceUrl.indexOf('about_hc')>-1) {
		$('.nav .nav-item').eq(3).children().addClass('nav-item-link nav-nav-link');
	}else if(sourceUrl.indexOf('exposure')>-1) {
		$('.nav .nav-item').eq(4).children().addClass('nav-item-link nav-nav-link');
	}else if(sourceUrl.indexOf('contact_us')>-1) {
		$('.nav .nav-item').eq(3).children().addClass('nav-item-link nav-nav-link');
	}else if(sourceUrl.indexOf('cooperate_hc')>-1) {
		$('.nav .nav-item').eq(3).children().addClass('nav-item-link nav-nav-link');
	}else {
		$('.nav .nav-item').eq(0).children().addClass('nav-item-link nav-nav-link');
	}
});
function SSOJudge(url) {
	$.getJSON("http://jr.hc360.com/SSOJudge.do?format=json&jsoncallback=?", function(data){
		var flag = data["status"];
		if(flag=="nolog") {//没有登录
			document.location.href='http://sso.hc360.com/ssologin?ReturnURL='+url;
		}else if(flag=="login") {
			document.location.href = url;
		}
	});
}