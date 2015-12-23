$(function (){
	var goods_id = GetQueryString("goods_id");
    $.ajax({
       url:ApiUrl+"/index.php?act=buycomments&op=comments_list",
       type:"get",
       data:{goods_id:goods_id},
       dataType:"json",
       success:function(result){
          var data = result.datas;
          if(!data.error){
            //渲染模板
            var html = template.render('buy_comments', data);
            $("#buy_comments_wp").html(html);
			    var n = result.datas.goods_evaluate_info.good;
                var j = result.datas.goods_evaluate_info.normal;
                var l = result.datas.goods_evaluate_info.bad;
				var s = result.datas.goods_evaluate_info.good_percent;
				var k = result.datas.goods_evaluate_info.normal_percent;
				var p = result.datas.goods_evaluate_info.bad_percent;
                $("#_assessScale").html(s);
                $("#_goodScale").html("&#65288;" + s + "%&#65289;");
                $("#_mediumScale").html("&#65288;" + k + "%&#65289;");
                $("#_badScale").html("&#65288;" + p + "%&#65289;");
                $("#_goodScaleImg").css("width", s + "%");
                $("#_mediumScaleImg").css("width", k + "%");
                $("#_badScaleImg").css("width", p + "%")
                $("input[name=scoreCount5]").val(n);
				$("input[name=scoreCount3]").val(j);
				$("input[name=scoreCount1]").val(l);
				$("input[name=wareId]").val(goods_id);
				$("input[name=commentCount]").val(result.datas.goods_evaluate_info.all);
				$("input[name=totalPage]").val(result.datas.goods_evaluate_info.page.show_pa);
				dd();
          }else {
            var html = data.error;
            $("#buy_comments_wp").hide();
			    $.sDialog({
                content: data.error + '！<br>请返回上一页继续操作…',
                okBtn:false,
                cancelBtnText:'返回',
                cancelFn: function() { history.back(); }
            });
		  }
       }
    })
  function dd() {	
  b();				
  $(window).bind("scroll",
	function(w) {
		var z;
		var y = 50;
		var A = parseFloat($(window).height());
		var v = parseFloat($(window).scrollTop());
		var x = $(document).height();
		z = A + v;
		if (x - y <= z) {
			$("#loading").show();
			b()
		}
	});
	var h = 1;
	function b(w) {
		Zepto.getJSON(ApiUrl+"/index.php?act=buycomments&op=comments_list", {
			goods_id: goods_id,
			type: $("input[name=score]").val(),
			curpage: h
		},
		function(v) {
			h++;
			m(v, v.datas.goods_evaluate_info.page.page,c);
			$("#loading").hide()
		})
	}
	
	function m(x, E) {
		var z = "";
		var w = x.datas.comments;
		if ( !! w) {
			var D = w.length;
			for (var y = 0; y < D; y++) {
				var A = w[y];
				var C = A.geval_frommembername || "";
				if (C.length > 10) {
					C = A.geval_frommembername.substring(0, 10) + "..."
				}
/*				if(A.geval_remark == nullgeval_explain){
					}*/
				z += '<div class="detail"><p class="tit"><span></span>' + A.geval_frommembername + "\u8bc4\u8bba" + '</p><p><span>&#35780;&#20998;&#65306;</span><span class="mu-star"><span class="mu-starv star-width' + A.geval_scores + '"></span></span></p><p class="user_id"><span class="name">' + C + '</span><span class="time">' + A.geval_addtime + "</span></p>" + (A.geval_content != "" && A.geval_content != "\u6ca1\u6709\u63cf\u8ff0" ? ("<p><span>\u8bc4\u4ef7\u8be6\u60c5\uff1a</span><span>" + A.geval_content + "</span></p>") : "") + (A.geval_explain != "" && A.geval_explain != null ? ("<p><span>\u5546\u5bb6\u89e3\u91ca\uff1a</span><span>" + A.geval_explain + "</span></p>") : "") + (A.geval_remark != "" && A.geval_remark != null ? ("<p><span>\u5546\u5bb6\u5907\u6ce8\uff1a</span><span>" + A.geval_remark + "</span></p>") : "") + '<div class="parting-line"></div></div>'
			}
			$("#content").append(z);
			if (E == x.datas.goods_evaluate_info.page.show_pa) {
				$("#tips").text("\u6ca1\u6709\u66f4\u591a\u4e86")
				
			}
		}
	}
	function i(v) {
		if (v == 1) {
			$("input[name=score]").val("1");
			$("#score5").addClass("on");
			$("#score1").removeClass("on");
			$("#score3").removeClass("on")
		} else {
			if (v == 2) {
				$("input[name=score]").val("2");
				$("#score3").addClass("on");
				$("#score1").removeClass("on");
				$("#score5").removeClass("on")
			} else {
				$("input[name=score]").val("3");
				$("#score1").addClass("on");
				$("#score5").removeClass("on");
				$("#score3").removeClass("on")
			}
		}
	}
	function q(x) {

		var w = $("#comments_ul");
		var v = "";
		v += '<ul class="tab-lst"><li><a id="score5" ';
		if (x == 1) {
			v += 'class="on"'
		}
		v += ">&#22909;&#35780;" + u($("input[name=scoreCount5]").val()) + "</a></li>";
		v += '<li><a  id="score3" ';
		if (x == 2) {
			v += ' class="on"'
		}
		v += '><span class="bar"></span>&#20013;&#35780;' + u($("input[name=scoreCount3]").val()) + "</a></li>";
		v += '<li><a id="score1" ';
		if (x == 3) {
			v += 'class="on"'
		}
		v += '><span class="bar"></span>&#24046;&#35780;' + u($("input[name=scoreCount1]").val()) + "</a></li></ul>";
		w.html(v);
		$("#score5").click(bind(this, t, 1));
		$("#score3").click(bind(this, t, 2));
		$("#score1").click(bind(this, t, 3))
	}
	  function u(v) {
                if (v == "") {
                        return "0"
                }
                return v
        }
	function bind(c, a) {
    var b = Array.prototype.slice.call(arguments).slice(2);
    return function() {
        return a.apply(c, b.concat(Array.prototype.slice.call(arguments)));
    }
}
function t(w, v) {
	            var c = goods_id;
                var w = w || 1;
                $("#tips").text("\u5411\u4e0a\u6ed1\u52a8\u52a0\u8f7d\u66f4\u591a");
                $("#content").empty();
                i(w);
				h = 1;
				b();
                e();
                $.get(ApiUrl+"/index.php?act=buycomments&op=comments_list", {
                        goods_id: c,
                        type: w

                },
                function(y) {
                        o();
                        d(y, y.datas.goods_evaluate_info.page.page, c);
                        var x = y.datas.goods_evaluate_info.all;
                        if (x == 0 && y.datas.comments.length != 0) {
                                x = y.datas.comments.length
                        }
                },
                "json")
        }
        function d(x, E, B) {
                var z = "";
                var w = x.datas.comments;
                if ( !! w) {
                        var D = w.length;
                        for (var y = 0; y < D; y++) {
                                var A = w[y];
                                var C = A.geval_frommembername || "";
                                if (C.length > 10) {
                                        C = A.geval_frommembername.substring(0, 10) + "..."
                                }
                                
                                z += '<div class="detail"><p class="tit"><span></span>' + A.geval_frommembername + "\u8bc4\u8bba" +'</p><p><span>&#35780;&#20998;&#65306;</span><span class="mu-star"><span class="mu-starv star-width' + A.geval_scores + '"></span></span></p><p class="user_id"><span class="name">' + C + '</span><span class="time">' + A.geval_addtime + "</span></p>" + (A.geval_content != "" && A.geval_content != null ? ("<p><span>&#24515;&#24471;&#65306;</span><span>" + A.geval_content + "</span></p>") : "") + (A.geval_explain != "" && A.geval_explain != null ? ("<p><span>\u5546\u5bb6\u89e3\u91ca\uff1a</span><span>" + A.geval_explain + "</span></p>") : "") + (A.geval_remark != "" && A.geval_remark != null ? ("<p><span>\u5546\u5bb6\u5907\u6ce8\uff1a</span><span>" + A.geval_remark + "</span></p>") : "") + '<div class="parting-line"></div>'
                        }
                $("#content").html(z);
/*				if (x.datas.goods_evaluate_info.page.page == x.datas.goods_evaluate_info.page.show_pa) {
				alert('ssss');				
			}*/
                }
        }

        function e() {
                var v = parseInt(document.body.clientWidth);
                $("#spinnerCache").css("margin-left", (v / 2 - 50) + "px");
                $("#spinnerCache").show();
                r.spin($("#spinnerCache")[0])
        }
        function o() {
                r.stop();
                $("#spinnerCache").hide()
        }
        var r = createSpinner();
        var g = $("#sid").val();
        var c = $("#wareId").val();
        q(1);
function createSpinner() {
    var a = {
        lines: 12,
        length: 6,
        width: 4,
        radius: 10,
        color: "#333",
        speed: 1,
        trail: 60,
        shadow: false,
        hwaccel: false
    };
    return new Spinner(a)
}

}
	
	})