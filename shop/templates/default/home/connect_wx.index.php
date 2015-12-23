<?php defined('InShopNC') or exit('Access Invalid!');?> 
<div class="nc-login-content tc" id="login_container"></div>
<script>
$(function(){
    $.getScript("<?php echo C('https')?'https':'http';?>://res.wx.qq.com/connect/zh_CN/htmledition/js/wxLogin.js", function(){
        var obj = new WxLogin({
            id:"login_container", 
            appid: "<?php echo C('weixin_appid');?>", 
            scope: "snsapi_login", 
            redirect_uri: "<?php echo SHOP_SITE_URL.'/index.php?act=connect_wx&op=get_info';?>",
            state: "",
            style: "",
            href: ""
        });
    });
});
</script>
