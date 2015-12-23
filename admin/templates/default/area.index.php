<?php defined('InShopNC') or exit('Access Invalid!');?>
<!--v3-v12-->
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['area_index_class'];?></h3>
      <?php echo $output['top_link'];?>
	  <!--<ul class="tab-base">
        <li>
		<form method='post' action="index.php" enctype="multipart/form-data" >
		<input type="hidden" name="act" value="area" />
		<input type="hidden" name="op" value="upload" />
		<input type="file" name="file" />
		<input type="submit" value="导入"><span style="color:red">（注意导入为全量导入，需要重新管理）</span>
		</form>
		</li>
      </ul>-->
    </div>
  </div>
  <div class="fixed-empty"></div>
   <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th class="nobg" colspan="12"><div class="title"><h5><?php echo $lang['nc_prompts'];?></h5><span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td>
        <ul>
      <li>全站所有涉及的地区均来源于此处，强烈建议对此处谨慎操作。</li>
      <li>所属大区为默认的全国性的几大区域，只有省级地区才需要填写大区域，目前全国几大区域有：华北、东北、华东、华南、华中、西南、西北、港澳台、海外</li>
      <li>所在层级为该地区的所在的层级深度，如北京&gt;北京市&gt;朝阳区,其中北京层级为1，北京市层级为2，朝阳区层级为3</li>
            <li><?php echo $lang['area_index_help1'];?></li>
            <li><?php echo $lang['area_index_help2'];?></li>
            <li><?php echo $lang['area_index_help3'];?></li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <form method='post'>
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="submit_type" id="submit_type" value="" />
    <table class="table tb-type2">
      <thead>
        <tr class="thead">
          <th></th>
          <th><?php echo $lang['nc_sort'];?></th>
          <th><?php echo $lang['area_index_name'];?></th>
          <th><?php echo $lang['area_region_name'];?></th>
          <th><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['area_list']) && is_array($output['area_list'])){ ?>
        <?php foreach($output['area_list'] as $k => $v){ ?>
        <tr class="hover edit">
          <td class="w48"><input type="checkbox" name="check_area_id[]" value="<?php echo $v['area_id'];?>" class="checkitem">
            <?php if($v['have_child'] == '1'){ ?>
            <img fieldid="<?php echo $v['area_id'];?>" status="open" nc_type="flex" src="<?php echo ADMIN_TEMPLATES_URL;?>/images/tv-expandable.gif">
            <?php }else{ ?>
            <img fieldid="<?php echo $v['area_id'];?>" status="close" nc_type="flex" src="<?php echo ADMIN_TEMPLATES_URL;?>/images/tv-item.gif">
            <?php } ?>
		  </td>
          <td class="w48 sort">
			<span title="<?php echo $lang['nc_editable'];?>" ajax_branch="area_sort" datatype="number" fieldid="<?php echo $v['area_id'];?>" fieldname="area_sort" nc_type="inline_edit" class="editable "><?php echo $v['area_sort'];?></span>
		  </td>
          <td class="w50pre name">
          <span title="<?php echo $lang['nc_editable'];?>" required="1" fieldid="<?php echo $v['area_id'];?>" ajax_branch="area_name" fieldname="area_name" nc_type="inline_edit" class="editable "><?php echo $v['area_name'];?></span>
          </td>
		  <td class="w25pre name">
			<span title="<?php echo $lang['nc_editable'];?>" ajax_branch="area_region" required="1" fieldid="<?php echo $v['area_id'];?>" fieldname="area_region" nc_type="inline_edit" class="editable "><?php echo $v['area_region'];?></span>
		  </td>
          <td class="w96"><a href="index.php?act=area&op=area_add&area_parent_id=<?php echo $v['area_id'];?>"><?php echo $lang['area_next_add'];?></a> | <a href="index.php?act=area&op=area_edit&area_id=<?php echo $v['area_id'];?>"><?php echo $lang['nc_edit'];?></a> | <a href="javascript:if(confirm('<?php echo $lang['area_index_ensure_del'];?>'))window.location = 'index.php?act=area&op=area_del&area_id=<?php echo $v['area_id'];?>';"><?php echo $lang['nc_del'];?></a></td>
        </tr>
        <?php } ?>
        <?php }else { ?>
        <tr class="no_data">
          <td colspan="10"><?php echo $lang['nc_no_record'];?></td>
        </tr>
        <?php } ?>
      </tbody>
      <?php if(!empty($output['area_list']) && is_array($output['area_list'])){ ?>
      <tfoot>
        <tr class="tfoot">
          <td><input type="checkbox" class="checkall" id="checkall_2"></td>
          <td id="batchAction" colspan="15"><span class="all_checkbox">
            <label for="checkall_2"><?php echo $lang['nc_select_all'];?></label>
            </span>&nbsp;&nbsp;<a href="JavaScript:void(0);" class="btn" onclick="if(confirm('<?php echo $lang['area_index_ensure_del'];?>')){$('#submit_type').val('del');$('form:first').submit();}"><span><?php echo $lang['nc_del'];?></span></a>
            </td>
        </tr>
      </tfoot>
      <?php } ?>
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.edit.js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.area.js" charset="utf-8"></script> 
