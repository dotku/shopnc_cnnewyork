$(function (){
 var store_id = GetQueryString("store_id");
 var key = getcookie('key');
    var numFavor = 0;
 
    //渲染页面
    $.ajax({
       url:ApiUrl+"/index.php?act=show_store&op=index&store_id="+store_id,
       type:"post",
       data:{key:key},
       dataType:"json",
       success:function(result){
          var data = result.datas;
  
          if(!data.error){ 
		  
		  var ff = result.datas.goods_list_info;

		  var ee = ff.goods_store;       
		  document.title = ee.store_name;  
            //渲染模板
            var html = template.render('product_store', data);
            $("#product_store_wp").html(html);
            //整理数据
			store(ff.recommended_goods_list,ff.new_goods_list,ff.goods_wep_list,ff.goods_store);
			storefiv(ff.goods_store);
            }else{
                $("product_store_wp").hide();
			    $.sDialog({
                content: data.error + '！<br>请返回上一页继续操作…',
                okBtn:false,
                cancelBtnText:'返回',
                cancelFn: function() { history.back(); }
            });
            }

}});


function storefiv(AT) {
	if(AT.member_id == 1){
		$(".j-m-follow a").addClass("active");
		$(".j-m-follow").find("span").html(AT.store_collect)
		}if(AT.member_id == 0 || AT.member_id == null){
			$(".j-m-follow a").removeClass("active");
			$(".j-m-follow").find("span").html("关注");
			}
	}
function store(A,B,C,D) {
	var Z = "";
    if ( !! A) {
			var DB = A.length;
			for (var Y = 0; Y < DB; Y++) {
				var AA = A[Y];
				var CC = AA.goods_name || "";
				if (CC.length > 11 && AA.goods_jingle != "") {
					CC = AA.goods_name.substring(0, 11) + "..."
				}
			Z+='<li data-productid="' + AA.goods_id + '"><a href="product_detail.html?goods_id=' + AA.goods_id + '"><div class="p-img"><img src="' + AA.url + '" ></div><div class="p-info">' + CC + '<p class="pdlist-goods_jingle">' + AA.goods_jingle + '</p></div><div class="flag"><span class="pdlist-iwc-pdprice">￥' + AA.goods_price + '</span>'+ (AA.goods_promotion_type != 0 && AA.goods_promotion_type != 1 ? ('&nbsp;<span class="product-status bg-blue">限时折扣</span>') : "") + (AA.goods_promotion_type != 0 && AA.goods_promotion_type != 2 ? ('&nbsp;<span class="product-status bg-yf8">抢购商品</span>') : "") + (AA.goods_promotion_type != 1 && AA.goods_promotion_type != 2 ? ("") : "") +(AA.is_fcode != 0 && AA.is_fcode == 1 ? ('&nbsp;<span class="product-status bg-fcode">F码优先</span>') : "") +(AA.is_presell != 0 && AA.is_presell == 1 ? ('&nbsp;<span class="product-status bg-presell">预售</span>') : "") +(AA.is_virtual != 0 && AA.is_virtual == 1 ? ('&nbsp;<span class="product-status bg-virtual">虚拟兑换</span>') : "") +(AA.have_gift != 0 && AA.have_gift == 1 ? ('&nbsp;<span class="product-status bg-fcode">赠</span>') : "") +'<div class="stores"><s class="product-price-s">￥'+ AA.goods_marketprice + '</s><span class="flefeet">销量：<strong>' + AA.goods_salenum + '</strong>&nbsp;件</span></div></div></a></li>'	
			}
			$("#contentt").append(Z);
            }else{
		var Z = "";
		Z+='<div id="product_list"><div class="no-record">对不起！暂无商品</div></div>'
		$("#contentt").append(Z);
		}
	var ZZ = "";
    if ( !! B) {
			var DBB = B.length;
			for (var YY = 0; YY < DBB; YY++) {
				var AAA = B[YY];
				var CCC = AAA.goods_name || "";
				if (CCC.length > 11 && AA.goods_jingle != "") {
					CCC = AAA.goods_name.substring(0, 11) + "..."
				}
			ZZ+='<li data-productid="' + AAA.goods_id + '"><a href="product_detail.html?goods_id=' + AAA.goods_id + '"><div class="p-img"><img src="' + AAA.url + '"></div><div class="p-info">' + CCC + '<p class="pdlist-goods_jingle">' + AAA.goods_jingle + '</p></div><div class="flag"><span class="pdlist-iwc-pdprice">￥' + AAA.goods_price + '</span>'+ (AAA.goods_promotion_type != 0 && AAA.goods_promotion_type != 1 ? ('&nbsp;<span class="product-status bg-blue">限时折扣</span>') : "") + (AAA.goods_promotion_type != 0 && AAA.goods_promotion_type != 2 ? ('&nbsp;<span class="product-status bg-yf8">抢购商品</span>') : "") + (AAA.goods_promotion_type != 1 && AAA.goods_promotion_type != 2 ? ("") : "")+(AAA.is_fcode != 0 && AAA.is_fcode == 1 ? ('&nbsp;<span class="product-status bg-fcode">F码优先</span>') : "") +(AAA.is_presell != 0 && AAA.is_presell == 1 ? ('&nbsp;<span class="product-status bg-presell">预售</span>') : "") +(AAA.is_virtual != 0 && AAA.is_virtual == 1 ? ('&nbsp;<span class="product-status bg-virtual">虚拟兑换</span>') : "") +(AAA.have_gift != 0 && AAA.have_gift == 1 ? ('&nbsp;<span class="product-status bg-fcode">赠</span>') : "") +'<div class="stores"><s class="product-price-s">￥'+ AA.goods_marketprice + '</s><span class="flefeet">销量：<strong>' + AA.goods_salenum + '</strong>&nbsp;件</span></div></div></a></li>'	
			}
			$("#contenttt").append(ZZ);
            }else{
		var ZZ = "";
		ZZ+='<div id="product_list"><div class="no-record">对不起！暂无商品</div></div>'
		$("#contenttt").append(ZZ);
		}

$(".small-block-grid-3").append('<li><div class="key">' + D.store_credit.store_desccredit.text + '</div><div class="value"><i class="' + D.store_credit.store_desccredit.percent_class + '"></i><span>'+ D.store_credit.store_desccredit.credit + ' 分</span></div></li><li><div class="key">' + D.store_credit.store_servicecredit.text + '</div><div class="value"><i class="' + D.store_credit.store_servicecredit.percent_class + '"></i><span>'+ D.store_credit.store_servicecredit.credit + ' 分</span></div></li><li><div class="key">' + D.store_credit.store_deliverycredit.text + '</div><div class="value"><i class="' + D.store_credit.store_deliverycredit.percent_class + '"></i><span>'+ D.store_credit.store_deliverycredit.credit + ' 分</span></div></li>');
if ( !! C && C.length != 0) {
	var OO = "";
	var OOO = "";
	for (var YYY = 0; YYY < C.length; YYY++) {
		var AAAA = C[YYY];
		var ID = ("list" + YYY);
		var IDD = ("#" + ID);
		var IC = ("#" + YYY);
		var IBD = ("li" + YYY);
		var IBDD = ("#" + IBD);
		OO = '<div class="category-list" id = '+ IBD +'><div class="header"><span>' + AAAA.stc_name + '</span><i class="icon-open" id = '+ YYY +'></i></div><ul class="list" id = '+ ID +'></ul></div>'
        $(".sid_id").append(OO);
		if( !! AAAA.children){
			for (var YB = 0; YB < AAAA.children.length; YB++) {
			var AB = AAAA.children[YB];
			OOO = '<li><a href="product_goods.html?store_id='+ D.store_id +'&stc_id='+ AB.stc_id +'">' + AB.stc_name + '</a></li>'
            $(IDD).append(OOO);
			}
			}else{
				$(IC).removeClass("icon-open");
                $(IBDD).empty();
				OO = '<div class="category-list" id = '+ IBD +'><div class="header"><a href="product_goods.html?store_id='+ D.store_id +'&stc_id='+ AAAA.stc_id +'"><span>' + AAAA.stc_name + '</span></a></div></div>'
				$(".sid_id").append(OO);
				}
		}		 
	}else{
	OO = '<div class="category-list"><div class="header"><span>该店暂无分类</span></div></div>'
	$(".sid_id").append(OO);
	}
 
//搜索
$(function() {
    $(".mobile_shop_btn").on("click",
    function() {
        var c = $("#mobile_shop_search");
        var b = c.attr("url"),
        a = encodeURIComponent(c.val());
        a = encodeURIComponent(a);
        if (b) {
            if (a) {
                window.location.href = b + "&inkeyword=" + a
            } else {
                window.location.href = b
            }
        }
    })
});
//分享
var page_data = {baseUrl:SiteUrl+"/", shopId:78430,venderId:81593,projectType:0,static:WapSiteUrl+"/tmpl/member/product_code.html"};
$(function() {
    var d = $(".j-m-share"),
    b = $(".c-share-wrap"),
    a = $(".c-mask .mask"),
    c = $(".share-cancel"),
    e = $("body");
    if (location.href.indexOf("/b") > -1) {
        d.find(".icon-share").css("display", "none");
        d.find(".icon-share-1").css("display", "block")
    }
    d.unbind("click").bind("click",
    function() {
        if (top.location.href.indexOf("editor") > -1) {
            return
        }
        e.css({
            overflow: "hidden"
        });
        e.bind("wheel",
        function() {
            return false
        });
        e.bind("touchmove",
        function() {
            return false
        });
        var l = $(".store-text .store-name").html();
        var j = $(".store-logo .name").attr("shop");
        var f = l + " " + location.href;
        var i = "";
        i += "我在@+"+l+"找到超级优惠的店铺，各种新品正在热卖，快来抢吧！下载APP还有好礼相送，去看看吧！\n \n 链接：" + f;
        //var h = window.share && share.sina(i);
		var h = "http://v.t.sina.com.cn/share/share.php?title=" + i;
        try {
            var j = window.location.href
        } catch(k) {}
        var g = "javascript:;";
        try {
				var llk = encodeURIComponent(l);
                g = page_data.baseUrl + "wap/tmpl/member/product_code.html?name=" + llk + "&text=" + j
        } catch(k) {}
        $("#sina").attr("href", h);
        $("#qrcode").attr("href", g);
        a.css({
            display: "block"
        });
        b.removeClass("hide");
        b.css({
            bottom: -e.scrollTop() + "px"
        });
        return false
    });
    a.bind("click",
    function() {
		b.addClass("hide");
    });
    c.bind("click",
    function() {
        e.css({
            overflow: "auto"
        });
        e.unbind("wheel");
        e.unbind("touchmove");
        a.css({
            display: "none"
        });
        b.addClass("hide")
    })
});
//关注
$(function() {
            $(".j-m-follow").click(function (){
                var key = getcookie('key');//登录标记
                if(key==''){
                  window.location.href = WapSiteUrl+'/tmpl/member/login.html';
                 } else {
                        url = ApiUrl + '/index.php?act=member_favorites_store&op=favorites_add';
                    }
                  $.ajax({
                    type: 'post',
                        url: url,
                        data: {key: key, store_id: store_id},
                        dataType: 'json',
                        success: function(fData) {
                            if (checklogin(fData.login)) {
                                if (!fData.datas.error) {
                                    $.sDialog({
                                        skin: "green",
										content: "关注店铺成功",
                                        okBtn: false,
                                        cancelBtn: false
                                    });
                                } else {
                                    $.sDialog({
                                        skin: "red",
                                        content: fData.datas.error,
                                        okBtn: false,
                                        cancelBtn: false
                                    });
                                }
                            }
                        }
						});
                    });

function storefv(ATT) {
	if(ATT.datas){
		$(".j-m-follow a").addClass("active");
		$(".j-m-follow").find("span").html(ATT.datas);
		}
	} 
});
$('.adv_list').each(function() {
                    if ($(this).find('.item').length < 2) {
                        return;
                    }

                    Swipe(this, {
                        startSlide: 2,
                        speed: 400,
                        auto: 3000,
                        continuous: true,
                        disableScroll: false,
                        stopPropagation: false,
                        callback: function(index, elem) {},
                        transitionEnd: function(index, elem) {}
                    });
                });
//分类
$(function() {
    var m = $(".c-mask .mask");
    var a = $(".c-category-list");
    var g = (/hp-tablet/gi).test(navigator.appVersion);
    var h = "ontouchstart" in window && !g;
    var b = h ? "click": "click";
    $(".icon-nav").unbind(b).bind(b,
    function(i) {
        m.css("display", "block");
        $("body").css("overflow", "hidden");
        $("body").bind("wheel",
        function() {});
        a.addClass("category-show-1");
        return false
    });
    m.unbind(b).bind(b,
    function() {
        m.css("display", "none");
        $("body").css("overflow", "auto");
        $("body").unbind("wheel");
        a.removeClass("category-show-1");
		$(".c-share-wrap").addClass("hide");
        return false
    });
    var c = $(".score");
    var f = parseInt(c.find("span").html(), 10);
    var j = c.find("i");
    var k = Math.floor(f);
    for (var d = j.size() - 1; d >= k; d--) {
        j.eq(d).addClass("icon-empty").removeClass("icon-full");
    }
    var e = $(".category-list");
    var l = $(".c-category-list");
    e.find(".header").bind("click",
    function() {
        var n = $(this);
        var i = n.next();
        if (i.find("li").size() <= 0) {
            return
        }
        i.css({
            overflow: "hidden"
        });
        if (n.parent().hasClass("active")) {
            n.parent().removeClass("active");
            (function() {
                i.hide()
            })
        } else {
            n.parent().addClass("active");
            l.css({
                height: $(window).height(),
                overflow: "auto"
            });
         
        }
        return false
    })
})}
})