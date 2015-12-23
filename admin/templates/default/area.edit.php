<?php defined('InShopNC') or exit('Access Invalid!');?>
<!--v3-v12-->
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['area_index_class'];?></h3>
      <?php echo $output['top_link'];?> </div>
  </div>
  <div class="fixed-empty"></div>
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th class="nobg" colspan="12"><div class="title">
            <h5><?php echo $lang['nc_prompts'];?></h5>
            <span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td><ul>
            <li><?php echo $lang['area_edit_prompts_one'];?></li>
            <li><?php echo $lang['area_edit_prompts_two'];?></li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <form id="area_form" name="goodsClassForm" enctype="multipart/form-data" method="post">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="area_old_id" value="<?php echo $output['area_array']['area_id'];?>" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="area_name validation" for="area_name"><?php echo $lang['area_index_name'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" maxlength="20" value="<?php echo $output['area_array']['area_name'];?>" name="area_name" id="area_name" class="txt"></td>
          <td class="vatop tips"></td>
        </tr>
		<tr class="noborder">
		  <td colspan="2"  class="required"><label for="area_name"><?php echo $lang['area_region_name'];?>:</label></td>
		</tr>
		<tr class="noborder">
		  <td class="vatop rowform"><input type="text" value="<?php echo $output['area_array']['area_region'];?>" name="area_region" id="area_region" maxlength="20" class="txt"></td>
		  <td class="vatop tips">默认只有省级地区才需要填写大区域，目前全国几大区域有：华北、东北、华东、华南、华中、西南、西北、港澳台、海外。</td>
		</tr>
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
			<span class="vatop tips"><?php echo $lang['area_batch_not_select'];?></span></td>
		</tr>
        <tr>
          <td colspan="2" class="required"><label for="area_sort"><?php echo $lang['nc_sort'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['area_array']['area_sort'] == ''?0:$output['area_array']['area_sort'];?>" name="area_sort" id="area_sort" class="txt"></td>
          <td class="vatop tips"><?php echo $lang['area_add_update_sort'];?></td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="15" ><a href="JavaScript:void(0);" class="btn" id="submitBtn"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/common_select.js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.mousewheel.js"></script> 
<script>
$(document).ready(function(){
    $('#type_div').perfectScrollbar();
	//按钮先执行验证再提交表单
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
                        return $('#area_parent_id').val();
                    },
                    area_id : '<?php echo $output['area_array']['area_id'];?>'
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

    // 类型搜索
    $("#region > select").live('change',function(){
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
