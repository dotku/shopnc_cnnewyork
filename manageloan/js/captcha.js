function loadCaptcha(imgId, ctoken) {
    $(imgId).attr("src", "https://captcha.hc360.com/captcha/service/checkcode.html?ctoken=" + ctoken + "&range=" + Math.random())
}
function clickLoadCaptcha(clickIds, imgId, ctoken) {
    $(clickIds).bind("click",
    function() {
        loadCaptcha(imgId, ctoken)
    })
}
function verifyCaptchaCode(ctoken, checkcode, func, status) {
    if (typeof(checkcode) != "undefined" && checkcode.length >= 4) {
        var curl = "https://captcha.hc360.com/captcha/service/verifycode.json?ctoken=" + ctoken + "&checkcode=" + checkcode + "&range=" + Math.random();
        $.getJSON(curl + "&callback=?",
        function(d) {
        	if(typeof(status) !='undefined'){
        		HC.UBA.sendUserlogsElement('UserBehavior_SSO_errorcode',checkcode)
        	}
            func(d.checkResult)
        })
    } else {
        func(false)
    }
}