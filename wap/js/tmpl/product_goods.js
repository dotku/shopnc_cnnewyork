function gosearch(){
	var inkeyword = $("input[name=inkeyword]").val();
	$("input[name=inkeyword]").val(inkeyword);
	product_list(1);
	return false;
}

function product_list(curpage){
	var store_id = parseInt($("input[name=store_id]").val());
	var key = parseInt($("input[name=key]").val());
	var order = parseInt($("input[name=order]").val());
	var stc_id = parseInt($("input[name=stc_id]").val());
	var inkeyword = $("input[name=inkeyword]").val();
	var hasmore = $("input[name=hasmore]").val();

	var url = ApiUrl+"/index.php?act=show_store&op=goods_all&store_id="+store_id+"&key="+key+"&order="+order+"&curpage="+curpage;
	if(stc_id>0){
		url+="&stc_id="+stc_id;
	}
	if(inkeyword!=''){
		url+="&inkeyword="+inkeyword;
	}
	
	$.ajax({
		url:url,
		type:'get',
		dataType:'json',
		success:function(result){
			if(result.datas.error){
            $(".content").empty();
			    $.sDialog({
                content: result.datas.error + '！<br>请返回上一页继续操作…',
                okBtn:false,
                cancelBtnText:'返回',
                cancelFn: function() { history.back(); }
            });
				return;
			}
			    var data = result.datas;
			    document.title = data.store_name;
				var headTitle = data.store_name;
	            var tmpl = '<div class="header-wrap">'
	        		+'<a href="javascript:history.back();" class="header-back"><span>返回</span></a>'
						+'<h2>'+headTitle+'</h2>'
						+'<a href="javascript:void(0)" id="btn-opera" class="i-main-opera">'
					 	+'<span></span>'
				 	+'</a>'
    			+'</div>'
		    	+'<div class="main-opera-pannel">'
		    		+'<div class="main-op-table main-op-warp">'
		    			+'<a href="'+WapSiteUrl+'/index.html" class="quarter">'
		    				+'<span class="i-home"></span>'
		    				+'<p>首页</p>'
		    			+'</a>'
		    			+'<a href="'+WapSiteUrl+'/tmpl/product_first_categroy.html" class="quarter">'
		    				+'<span class="i-categroy"></span>'
		    				+'<p>分类</p>'
		    			+'</a>'
		    			+'<a href="'+WapSiteUrl+'/tmpl/cart_list.html" class="quarter">'
		    				+'<span class="i-cart"></span>'
		    				+'<p>购物车</p>'
		    			+'</a>'
		    			+'<a href="'+WapSiteUrl+'/tmpl/member/member.html?act=member" class="quarter">'
		    				+'<span class="i-mine"></span>'
		    				+'<p>我的商城</p>'
		    			+'</a>'
		    		+'</div>'
		    	+'</div>';
    //渲染页面
	var html = template.compile(tmpl);
	$("#header").html(html);
	$("#btn-opera").click(function (){
		$(".main-opera-pannel").toggle();
	});
	//当前页面
	if(headTitle == "商品分类"){
		$(".i-categroy").parent().addClass("current");
	}else if(headTitle == "购物车列表"){
		$(".i-cart").parent().addClass("current");
	}else if(headTitle == "我的商城"){
		$(".i-mine").parent().addClass("current");
	}
	
	
			$("input[name=hasmore]").val(result.hasmore);
			if(curpage>1){
				$('.pre-page').removeClass('disabled');
			}else{
				$('.pre-page').addClass('disabled');
			}			
			if(curpage<result.page_total){
				$('.next-page').removeClass('disabled');	
			}else{
				$('.next-page').addClass('disabled');
			}
			var html = template('home_body', result.datas);
			$("#product_goods").empty();
			$("#product_goods").append(html);		
			$("input[name=curpage]").val(curpage);
			
			var page_total = result.page_total;
			var page_html = '';
			for(var i=1;i<=result.page_total;i++){
				if(i==curpage){
					page_html+='<option value="'+i+'" selected>'+i+'</option>';
				}else{
					page_html+='<option value="'+i+'">'+i+'</option>';
				}	
			}
			$('select[name=page_list]').empty();
			$('select[name=page_list]').append(page_html);

			$(window).scrollTop(0);
		}
	});
}

$(function(){
	var tmp;
	tmp=GetQueryString('inkeyword');
	if(tmp==null) tmp='';
	$("input[name=inkeyword]").val(decodeURI(decodeURI(tmp)));
	tmp=GetQueryString('stc_id');
	if(tmp==null) tmp='0';
	$("input[name=stc_id]").val(tmp);
	tmp=GetQueryString('store_id');
	if(tmp==null) tmp='0';
	$("input[name=store_id]").val(tmp);
    if(!escape(GetQueryString('inkeyword'))){
    $("input[name=inkeyword]").val(escape(GetQueryString('inkeyword')));alert('222222');
	$("input[name=store_id]").val(GetQueryString('store_id'));
		}
	
	

	product_list(1);
    
    $("select[name=page_list]").change(function(){
    	var curpage = $('select[name=page_list]').val();
		product_list(curpage);    	
    });    
    
	$('.keyorder').click(function(){
		var key = parseInt($("input[name=key]").val());
		var order = parseInt($("input[name=order]").val());

		var curkey = $(this).attr('key');//1.销量 2.浏览量 3.价格 4.最新排序
		if(curkey == key){
			if(order == 1){
				var curorder = 2;
			}else{
				var curorder = 1;
			}
		}else{
			var curorder = 1;
		}
		$("input[name=key]").val(curkey);
		$("input[name=order]").val(curorder);
		
		$(this).addClass("current").siblings().removeClass("current");

		product_list(1);
	});
	
	$('.pre-page').click(function(){//上一页
		var curpage = eval(parseInt($("input[name=curpage]").val())-1);
		if(curpage<1){
			return false;
		}
		product_list(curpage);
	});
	
	$('.next-page').click(function(){//下一页
		var hasmore = $('input[name=hasmore]').val();
		if(hasmore == 'false'){
			return false;
		}
		var curpage = eval(parseInt($("input[name=curpage]").val())+1);
		product_list(curpage);
	});

    $("select[name=page_list]").change(function(){
    	var curpage = $('select[name=page_list]').val();
		product_list(curpage);    	
    });    

});