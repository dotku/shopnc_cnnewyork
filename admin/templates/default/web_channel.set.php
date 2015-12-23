<?php defined('InShopNC') or exit('Access Invalid!');?>
<!--v3-v12-->
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL?>/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/flexigrid.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.mousewheel.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL?>/js/dialog/dialog.js" id="dialog_js"></script>
<link href="<?php echo ADMIN_TEMPLATES_URL?>/css/index.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="<?php echo ADMIN_TEMPLATES_URL?>/css/font/css/font-awesome.min.css">
<link type="text/css" rel="stylesheet" href="<?php echo ADMIN_TEMPLATES_URL?>/css/jquery-ui.min.css">
<link href="<?php echo ADMIN_TEMPLATES_URL?>/css/index.css" rel="stylesheet" type="text/css">
<div class="pageshop">
  <div class="fixed-barshop">
    <div class="item-titleshop"><a class="back" href="index.php?act=web_channel&op=web_channel" title="返回频道列表"><i class="fa fa-arrow-circle-o-left"></i></a>
      <div class="subjectshop">
        <h3 class="ashop">频道管理 - 编辑“<?php echo $output['channel']['channel_name'];?>”频道模块</h3>
        <h5 class="bshop">商城的频道及模块内容管理</h5>
      </div>
    </div>
  </div>
  <form id="web_form" method="post" name="form1">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="channel_id" value="<?php echo $output['channel']['channel_id'];?>" />
    <div class="ncap-form-default">
      <dl class="row">
        <dt class="tit">
          <labe>频道绑定商品分类</label>
        </dt>
        <dd class="opt">
          <select name="gc_id" id="gc_id" class=" w200" onchange="check_goods_class();">
            <option value="0"><?php echo $lang['nc_please_choose'];?></option>
            <?php if(!empty($output['parent_goods_class']) && is_array($output['parent_goods_class'])){ ?>
            <?php foreach($output['parent_goods_class'] as $k => $v){ ?>
            <option <?php if($v['gc_id'] == $output['gc_id']){?>selected<?php }?> value="<?php echo $v['gc_id'];?>"><?php echo $v['gc_name'];?></option>
            <?php } ?>
            <?php } ?>
          </select>
          <span class="err"></span>
          <p class="notic">
            仅限一级和二级分类，绑定后前台头部菜单里的原商品链接将会变为频道链接，一个分类只能绑定一个频道（以最新提交为准）。<br/>
            选择分类后，频道顶部切换焦点大图右侧会自动调用该分类下的团购和限时折扣促销商品，团购的商品优先，无数据时不显示。<br/></p>
        </dd>
      </dl>
      <dl class="row">
        <dt class="tit">
          <labe>顶部模块</label>
        </dt>
        <dd class="opt">
          <select name="top_id" id="top_id" class=" w200">
            <option value="0"><?php echo $lang['nc_please_choose'];?></option>
            <?php if(!empty($output['top_list']) && is_array($output['top_list'])){ ?>
            <?php foreach($output['top_list'] as $k => $v){ ?>
            <option <?php if($v['web_id'] == $output['top_id']){?>selected<?php }?> value="<?php echo $v['web_id'];?>"><?php echo $v['web_name'];?></option>
            <?php } ?>
            <?php } ?>
          </select>
          <span class="err"></span>
          <p class="notic"></p>
        </dd>
      </dl>
      <dl class="row ncap-channel-floor">
        <dt class="tit">
          <label>已选择中部模块</label>
        </dt>
        <dd class="opt">
          <ul id="floor_list">
            <?php if(!empty($output['floor_list']) && is_array($output['floor_list'])){ ?>
            <?php foreach($output['floor_list'] as $k => $v){ ?>
            <?php if(!empty($v) && is_array($v)){ ?>
            <li><div class="layout-name">模块：<?php echo $v['web_name'];?></div>
                <input id="floor_<?php echo $v['web_id'];?>" type="hidden" value="<?php echo $v['web_id'];?>" name="floor_ids[]">
                <a href="JavaScript:void(0);" class="ncap-btn-mini ncap-btn-red" onclick="del_floor(<?php echo $v['web_id'];?>)"><i class="fa fa-trash"></i>删除</a></li>
            <?php } ?>
            <?php } ?>
            <?php } ?>
          </ul>
          <span class="err"></span>
          <p class="notic">频道页面最多可添加8个以内的中部类型模块，楼层模块之间可进行上下拖动排序，并可选择删除操作（并不影响模块本身，仅为频道显示删除）。</p>
        </dd>
      </dl>
      <dl class="row  ncap-channel-floor-list">
        <dt class="tit">
          <label>可选择模块</label>
        </dt>
        <dd class="opt">
          <div class="c-search"><span class="mr5">模块查找</span><input id="floor_name" name="floor_name" value="" class="w230" placeholder="请输入已建立的模块的名称作为关键字" type="text">
          <a class="ncap-btn vm" href="JavaScript:get_floor();"><i class="fa fa-search"></i></a></div>
          <div id="show_floor_list" class="block"></div>
          <p class="notic">从已建立的模块列表中选择添加至频道页面作为楼层块显示，如果已建立的模块较多，可采取输入模板名称的方式快速定位查找。</p>
        </dd>
      </dl>
      <div class="bot"><a href="JavaScript:void(0);" class="ncap-btn-big ncap-btn-green" id="submitBtn"><?php echo $lang['nc_submit'];?></a></div>
    </div>
  </form>
</div>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.ajaxContent.pack.js"></script>
<script>
$(function(){
	$("#submitBtn").click(function(){
        if($("#web_form").valid()){
            $("#web_form").submit();
		}
	});
    $("#floor_list").sortable({ items: 'li' });
    get_floor();
});

function check_goods_class() {
    var gc_id = $('#gc_id').val();
    if (gc_id>0 && gc_id!="<?php echo $output['gc_id'];?>") {
    	var get_text = $.ajax({
    		url: 'index.php?act=web_channel&op=check_goods_class&gc_id='+gc_id,
    		async: false
    		}).responseText;
    	if(get_text!='') {
    	    alert('该分类已经绑定到“'+get_text+'”频道，请选择其它分类。');
    	    $('#gc_id').val(0);
    	}
	}
}
function del_floor(floor_id) {//删除已选
	$("#floor_"+floor_id).parent().remove();
	$("[f_id='"+floor_id+"']").parent().removeClass("selected");
}
function get_floor() {
    var f_name = $.trim($('#floor_name').val());
	$("#show_floor_list").load('index.php?act=web_channel&op=get_channel_fl&'+$.param({'name':f_name }));
}
function select_floor(floor_id) {
    if($("#floor_"+floor_id).size()>0) return;//避免重复
    if($("#floor_list li").size()>=8) return;
    var obj = $("[f_id='"+floor_id+"']");
    var text_append = '';
	var f_name = obj.attr("f_name");
	text_append += '<div class="layout-name">模块：';
	text_append += f_name;
	text_append += '</div><input id="floor_'+floor_id+'" type="hidden" value="'+floor_id+'" name="floor_ids[]">';
	text_append += '<a href="JavaScript:void(0);" class="ncap-btn-mini ncap-btn-red" onclick="del_floor('+floor_id+')"><i class="fa fa-trash"></i>删除</a>';
    $("#floor_list").append('<li>'+text_append+'</li>');
    obj.parent().addClass("selected");
}
</script>
