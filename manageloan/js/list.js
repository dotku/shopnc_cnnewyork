/**
 * @Author lipengfei
 * @Date 2015-03-26
 */
(function($) {
	
	$(document).ready(function(){
		//为顶部栏添加事件
		topBarListener();
	});
	
	
	function topBarListener(){
		$(".searchBarListener").each(function(){
			
			var limit = 0;
			window.setInterval(function(){
				limit=0;
			},500);
			
			//代表当前的searchBar对象
			var that = $(this);
			
				$(this).mouseout(function(event){
					
						var toggleObject = that.find("[toggleDisplay='true']");
						
						var ifHidden = ifOutRegion(event,that,toggleObject);
						if(ifHidden){
							toggleObject.fadeOut();
						}
				});
				
//				$(this).mouseover(function(event){
//					//此时计算鼠标所在的坐标，如果坐标超出组件的范围， 则进行隐藏操作
//					
//						var toggleObject = $(this).find("[toggleDisplay='true']");
//						toggleObject.fadeIn();
//					
//					
//				});
		});
	}
	//判断是否超出了区域
	function ifOutRegion(event,that,toggleObject){
		
		var mousePostion = determinMouseCoordinate(event);
		//获得鼠标限制的矩形区域起始坐标
		var limitRegion = caculateListenerRegion(that,toggleObject);
		var ifHidden = false;
		
		if(mousePostion.X<limitRegion.startX || mousePostion.X>limitRegion.endX){
			ifHidden = true;
		}
		
		if(mousePostion.Y<limitRegion.startY || mousePostion.Y>limitRegion.endY){
			ifHidden = true;
		}
		
		return ifHidden;
		
	}
	
	//计算元素占用的区域的高度和宽度
	//绝对路径的元素对象,因为绝对路径的元素不受父元素管辖。故而整体区域大小是父元素高加上绝对路径元素的高度
	//得到鼠标所能触发的矩形区域
	function caculateListenerRegion(jqueryObject,absoluteObject){
		var jHeight = jqueryObject.height();
		var jWidth = jqueryObject.width();
		var abHeight = absoluteObject.height();
		var abWidth = absoluteObject.width();
		
		//得到当前组件的起始坐标,坐标轴为标准html二维坐标
		var startX = jqueryObject.offset().left;
		var startY = jqueryObject.offset().top;
		
		//
		var totalHeight = abHeight+jHeight;
		var maxWidth =0;
		if(jWidth>=abWidth){
			maxWidth= jWidth;
		}else{
			maxWidth= abWidth;
		}
		
		var endX = startX+maxWidth;
		var endY = startY+totalHeight;
		
		return {startX:startX,startY:startY,endX:endX,endY:endY};
	}

	//获取鼠标当前位置
	function determinMouseCoordinate(event){
		var arr ={X:event.pageX,Y:event.pageY};
		return arr;
	}
	
	function toggleDisplay(jqueryObj){
		if(!jqueryObj.is(":visible")){
			jqueryObj.fadeIn();
		}else{
			jqueryObj.fadeOut();
		}
	}
	
})(jQuery);

