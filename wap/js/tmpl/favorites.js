$(function(){
	var key = getcookie('key');
	if(key==''){
		location.href = 'login.html';
	}
    var page = pagesize;
    var curpage = 1;
    var hasMore = true;
	var voucher_state = GetQueryString('voucher_state');
  if (voucher_state){
	   if(voucher_state == 1){
		   initPage(page,curpage);
		   $("[data-state='"+voucher_state+"']").addClass('curr');
		   }
		   if(voucher_state == 2){ 
		       initstore(page,curpage);
			   $("[data-state='"+voucher_state+"']").addClass('curr');
			   }
	   }else{
		   voucher_state = 1;
		   $("[data-state='"+voucher_state+"']").addClass('curr');
	       initPage(page,curpage);
	   }

       function initstore(page,curpage){
		$.ajax({
			type:'post',
			url:ApiUrl+"/index.php?act=member_favorites&op=favorites_store&page="+page+"&curpage="+curpage,	
			data:{key:key},
			dataType:'json',
			success:function(result){
				checklogin(result.login);
				var data = result.datas;
				data.hasmore = result.hasmore; //是不是可以用下一页的功能，传到页面里去判断下一页是否可以用
                data.WapSiteUrl = WapSiteUrl; //页面地址
                data.curpage = curpage; //当前页，判断是否上一页的disabled是否显示
				var html = template.render('storesfavorites_list', data);
				$("#storefavorites_list").html(html);
				                //下一页
                $(".next-page").click(storenextPage);

                //上一页
                $(".pre-page").click(storeprePage);
				//删除收藏
				$('.i-del').click(storedelFavorites);
			}
		});
	}
	
	//初始化页面
	function initPage(page,curpage){
		$.ajax({
			type:'post',
			url:ApiUrl+"/index.php?act=member_favorites&op=favorites_list&page="+page+"&curpage="+curpage,	
			data:{key:key},
			dataType:'json',
			success:function(result){
				checklogin(result.login);
				var data = result.datas;
				data.hasmore = result.hasmore; //是不是可以用下一页的功能，传到页面里去判断下一页是否可以用
                data.WapSiteUrl = WapSiteUrl; //页面地址
                data.curpage = curpage; //当前页，判断是否上一页的disabled是否显示
				var html = template.render('sfavorites_list', data);
				$("#favorites_list").html(html);
				                //下一页
                $(".next-page").click(nextPage);

                //上一页
                $(".pre-page").click(prePage);
				//删除收藏
				$('.i-del').click(delFavorites);
			}
		});
	}
	
	//删除收藏
	function delFavorites(){
		var goods_id = $(this).attr('goods_id');
		$.ajax({
			type:'post',
			url:ApiUrl+"/index.php?act=member_favorites&op=favorites_del",
			data:{fav_id:goods_id,key:key},
			dataType:'json',
			success:function(result){
				checklogin(result.login);
				if(result){
					initPage();
				}
			}
		});
		return false;
	}
	    // 下一页
    function nextPage() {
        var hasMore = $(this).attr("has_more");
        if (hasMore == "true") {
            curpage++;
            initPage(page, curpage);
        }
    }

    // 上一页
    function prePage() {
        if (curpage > 1) {
            $(this).removeClass("disabled");
            curpage--;
            initPage(page, curpage);
        }
    }
	//删除收藏
	function storedelFavorites(){
		var store_id = $(this).attr('store_id');
		$.ajax({
			type:'post',
			url:ApiUrl+"/index.php?act=member_favorites&op=favorites_delstore",
			data:{fav_id:store_id,key:key},
			dataType:'json',
			success:function(result){
				checklogin(result.login);
				if(result){
					initstore();
				}
			}
		});
		return false;
	}
	    // 下一页
    function storenextPage() {
        var hasMore = $(this).attr("has_more");
        if (hasMore == "true") {
            curpage++;
            initstore(page, curpage);
        }
    }

    // 上一页
    function storeprePage() {
        if (curpage > 1) {
            $(this).removeClass("disabled");
            curpage--;
            initstore(page, curpage);
        }
    }
	
	
});