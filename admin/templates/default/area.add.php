<?php defined('InShopNC') or exit('Access Invalid!');?>
<!--v3-v12-->
<div class="page">
  <div class="fixed-bar">
	<div class="item-title">
	  <h3><?php echo $lang['area_index_class'];?></h3>
	  <?php echo $output['top_link'];?> </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="area_form" method="post">
	<input type="hidden" name="form_submit" value="ok" />
	<input type="hidden" name="have_area_parent_id" value="<?php echo $output['area_parent_id']?>" />
	<table class="table tb-type2">
	  <tbody>
		<tr class="noborder">
		  <td colspan="2" class="required"><label class="validation" for="area_name"><?php echo $lang['area_index_name'];?>:</label></td>
		</tr>
		<tr class="noborder">
		  <td class="vatop rowform"><input type="text" value="" name="area_name" id="area_name" maxlength="20" class="txt"></td>
		  <td class="vatop tips">请认真填写地区名称，地区设定后将直接影响订单、收货地址等重要信息，请谨慎操作。</td>
		</tr>
		<tr class="noborder">
		  <td colspan="2"  class="required"><label for="area_name"><?php echo $lang['area_region_name'];?>:</label></td>
		</tr>
		<tr class="noborder">
		  <td class="vatop rowform"><input type="text" value="" name="area_region" id="area_region" maxlength="20" class="txt"></td>
		  <td class="vatop tips">默认只有省级地区才需要填写大区域，目前全国几大区域有：华北、东北、华东、华南、华中、西南、西北、港澳台、海外。</td>
		</tr>
		<?php if(empty($output['area_parent_id'])){?>
		<tr>
		  <td colspan="2" class="required"><label for="area_name"><?php echo $lang['area_parent_id'];?>:</label></td>
		</tr>
		<tr class="noborder">
		  <td colspan="2" id="region">
			<select class="class-select">
			</select>
			<input type="hidden" name="area_id_2" id="area_id_2" value="">&nbsp;
			<input type="hidden" name="area_info" id="area_info" value="" class="area_names" />&nbsp;
			<input type="hidden" name="area_id" id="area_id" value="" class="area_ids" />&nbsp;
			<span></span>
			系统将根据所选择的上级菜单层级决定新增项的所在级，即选择上级菜单为“北京”，则新增项为北京地区的下级区域，以此类推。</td>
		</tr>
		<?php }else{?>
		<tr>
		  <td colspan="2" class="required"><label for="area_name"><?php echo $lang['area_parent_id'];?>:</label></td>
		</tr>
		<tr class="noborder">
		  <td colspan="2" id="region">
			<?php echo $output['area_parent_name'];?>
		  </td>
		</tr>
		<?php }?>
		<tr>
		  <td colspan="2" class="required"><label><?php echo $lang['nc_sort'];?>:</label></td>
		</tr>
		<tr class="noborder">
		  <td class="vatop rowform"><input type="text" value="0" name="area_sort" id="area_sort" class="txt"></td>
		  <td class="vatop tips"><?php echo $lang['area_add_update_sort'];?></td>
		</tr>
	  </tbody>
	  <tfoot>
		<tr>
		  <td colspan="2"><a href="JavaScript:void(0);" class="btn" id="submitBtn"><span><?php echo $lang['nc_submit'];?></span></a></td>
		</tr>
	  </tfoot>
	</table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/common_select.js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.mousewheel.js"></script> 
<script>
//按钮先执行验证再提交表单
$(function(){

	$('#type_div').perfectScrollbar();
	
	$("#submitBtn").click(function(){
		if($("#area_form").valid()){
			$("#area_form").submit();
		}
	});
	
	$('#area_form').validate({
		errorPlacement: function(error, element){
			error.appendTo(element.parent().parent().prev().find('td:first'));
		},
		rules : {
			area_name : {
				required : true,
				remote   : {                
				url :'index.php?act=area&op=ajax&branch=check_class_name',
				type:'get',
				data:{
					area_name : function(){
						return $('#area_name').val();
					},
					area_parent_id : function() {
						return $('#city_id').val($('#region').find('select').eq(1).val());
					},
					area_id : ''
				  }
				}
			},
			commis_rate : {
				required :true,
				max :100,
				min :0,
				digits :true
			},
			area_sort : {
				number   : true
			}
		},
		messages : {
			area_name : {
				required : '<?php echo $lang['area_add_name_null'];?>',
				remote   : '<?php echo $lang['area_add_name_exists'];?>'
			},
			area_sort  : {
				number   : '<?php echo $lang['area_add_sort_int'];?>'
			}
		}
	});
	
	// 所属分类
	$("#area_parent_id").live('change',function(){
		type_scroll($(this));
	});
});
var typeScroll = 0;
function type_scroll(o){
	var id = o.val();
	if(!$('#type_dt_'+id).is('dt')){
		return false;
	}
	$('#type_div').scrollTop(-typeScroll);
	var sp_top = $('#type_dt_'+id).offset().top;
	var div_top = $('#type_div').offset().top;
	$('#type_div').scrollTop(sp_top-div_top);
	typeScroll = sp_top-div_top;
}
regionInit("region");
</script> 
