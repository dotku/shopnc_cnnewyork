$(function() {
    var key = getcookie('key');
    if (key == '') {
        window.location.href = WapSiteUrl+'/tmpl/member/login.html';
        return;
    }
 var name = GetQueryString('name');
 var text = GetQueryString('text');
 var te = decodeURI(escape(name));
 var Url = ApiUrl+"/index.php?act=code_store&op=store_code&name="+te+"&text="+text;
 var html = template.render('product_code');
 $("#product_storecode").html(html);
 
 $(".store-name").html(te);
document.getElementById("sda").src=Url; 
    

});
