//SunXJ 2015/9/18
$(function (){
	$(document).ready(function(){
	    $.ajax({
    		url:ApiUrl+"/index.php?act=hot_search&op=search_keys",
    		type:'get',
    		dataType:'json',
    		success:function(result){
    			var html = template.render('search_body', result.datas);
    			$("#search_keys").html(html);
				$('#search_keys a').click(function(){
					var keyword = $(this).children('span').html();
					//将关键字写入cookies
					var history_keys=getCookie('search_keys');
					if(history_keys){
						//去重复
						if(history_keys.indexOf(keyword)>-1){
							history_keys=history_keys.replace(keyword+',','');
							history_keys=history_keys.replace(','+keyword,'');
						}
						history_keys=',' + history_keys;
					}else{
						history_keys='';
					}
					setCookie('search_keys' , keyword + history_keys , 28);
					fill_history_keys();
					location.href = WapSiteUrl+'/tmpl/product_list.html?keyword='+keyword;
				});
    		}
    	});
		fill_history_keys();
		$('.search-btn').click(function(){
			var keyword = encodeURIComponent($('#keyword').val());
			location.href = WapSiteUrl+'/tmpl/product_list.html?keyword='+keyword;
		});
		$('#cls_search_history').click(function(){
			delCookie('search_keys');
			fill_history_keys();
		});
	});
	
	//读取cookies历史记录进行填充
	function fill_history_keys(){
		var item_html="";
		var read_keys=getCookie('search_keys');
		if(read_keys){
			var history_keys=read_keys.split(",");
			for(var i=0;i<history_keys.length;i++){
				if(history_keys[i]!=""){
					item_html+='<li style="display: block;"><a href="javascript:void(0);"><span>' + history_keys[i] + '</span></a></li>';
				}
			}
		}
		$('#history_keys').html(item_html);
	}
});