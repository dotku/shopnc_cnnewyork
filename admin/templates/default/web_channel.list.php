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
    <div class="item-titleshop">
      <div class="subjectshop">
        <h3 class="ashop">频道管理</h3>
        <h5 class="bshop">商城的频道及模块内容管理</h5>
      </div>
      <?php print_r( $output['top_link']);?>
    </div>
  </div>
  <div class="explanation" id="explanation">
    <div class="title" id="checkZoom"><i class="fa fa-lightbulb-o"></i>
      <h4 class="cshop" title="<?php echo $lang['nc_prompts_title'];?>"><?php echo $lang['nc_prompts'];?></h4>
      <span id="explanationZoom" title="<?php echo $lang['nc_prompts_span'];?>"></span> </div>
    <ul class="ulshop">
      <li class="lishop">频道列表由程序按名称排序，即数字、字母、汉字顺序。</li>
      <li class="lishop">可修改频道的颜色风格、启用状态。</li>
      <li class="lishop">开启中的频道不能删除，删除频道时不删除所属模块（为了方便数据操作，一个模块可以同时在多个频道中显示）。</li>
    </ul>
  </div>
  <div id="flexigrid"></div>
</div>
<script>
function update_flex(){
    $("#flexigrid").flexigrid({
        url: 'index.php?act=web_channel&op=get_channel_xml',
        colModel : [
            {display: '操作', name : 'operation', width : 150, sortable : false, align: 'center', className: 'handle'},
            {display: '频道名称', name : 'channel_name', width : 250, sortable : false, align: 'center'},
            {display: '页面颜色', name : 'channel_style',  width : 100, sortable : false, align: 'center'},
            {display: '绑定分类', name : 'gc_name', width : 150, sortable : false, align: 'center'},
            {display: '启用状态', name : 'channel_show',  width : 100, sortable : false, align: 'center'}
            ],
        buttons : [
            {display: '<i class="fa fa-plus"></i>新增频道', name : 'add', bclass : 'add', title : '新增频道', onpress : fg_operation_add }
        ],
        searchitems : [
            {display: '频道名称', name : 'channel_name'}
            ],
        usepager: true,
        rp: 15,
        title: '频道列表'
    });
}
function fg_operation_add(name, bDiv){
    var _url = 'index.php?act=web_channel&op=add_channel';
    window.location.href = _url;
}
function fg_operation_del(channel_id){
    if(confirm('删除后将不能恢复，确认删除这项吗？')){
        var _url = 'index.php?act=web_channel&op=del_channel&channel_id='+channel_id;
        $.getJSON(_url, function(data){
            if (data.state) {
                $("#flexigrid").flexReload();
            } else {
                showError(data.msg)
            }
        });
    }
}

$(function(){
	update_flex();
});

</script>