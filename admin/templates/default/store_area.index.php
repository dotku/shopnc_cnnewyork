<?php defined('InShopNC') or exit('Access Invalid!');?>
<!--v3-v12-->
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_admin_store_area_manage'];?></h3>
      <ul class="tab-base">
        <li>
		<form method='post' action="index.php" enctype="multipart/form-data" >
		<input type="hidden" name="act" value="store_area" />
		<input type="hidden" name="op" value="upload" />
		<input type="button" value="下载模版" onclick="download();">
		<input type="file" name="file" />
		<input type="submit" value="导入"><span style="color:red">（注意导入为全量导入，会将之前的数据覆盖）</span>
		</form>
		</li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method='post' name="submitFrom" id="submitFrom">
    <input type="hidden" name="store_id" id="store_id" value="<?php echo $output['store']['store_id'];?>" />
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="submit_type" id="submit_type" value="" />
	<input type="hidden" name="set_areas" id="set_areas" value="" />
    <table class="table tb-type2"  width="<?php echo (250+(count($output['store_list'])*150))."px";?>" style="table-layout:fixed;">
      <thead>
        <tr class="thead">
          <th style="width:50px;" width="50px"></th>
          <th style="width:200px;" width="200px">地区</th>
			<?php if(!empty($output['store_list']) && is_array($output['store_list'])){ ?>
			<?php foreach($output['store_list'] as $k => $v){ ?>
			<th style="width:100px;" width="100px"><?php echo $v['store_name']?></th>
			<?php } ?>
			<?php } ?>
        </tr>
        <?php if(!empty($output['area_list']) && is_array($output['area_list'])){ ?>
        <?php foreach($output['area_list'] as $k => $v){ ?>
        <tr class="hover edit">
          <td>
            <?php if($v['have_child'] == '1'){ ?>
            <img fieldid="<?php echo $v['area_id'];?>" status="open" nc_type="flex" src="<?php echo ADMIN_TEMPLATES_URL;?>/images/tv-expandable.gif">
            <?php }else{ ?>
            <img fieldid="<?php echo $v['area_id'];?>" status="close" nc_type="flex" src="<?php echo ADMIN_TEMPLATES_URL;?>/images/tv-item.gif">
            <?php } ?>
		  </td>
          <td>
          <span title="<?php echo $lang['nc_editable'];?>" required="1" fieldid="<?php echo $v['area_id'];?>" ajax_branch="area_name" fieldname="area_name" nc_type="inline_edit" class="editable "><?php echo $v['area_name'];?></span>
          </td>
		  <?php if(!empty($output['store_list']) && is_array($output['store_list'])){ ?>
			<?php foreach($output['store_list'] as $s){ ?>
			<td >
			<input type="checkbox" <?php if($v['store'][$s['store_id']]['state'] == "1"){echo "checked";}?> onclick="changeJsonByCheckbox(this);" id="store_area_<?php echo $v['area_id'];?>_<?php echo $s['store_id'];?>" />
			<input style="width:20px" type="text" id="store_level_<?php echo $v['area_id'];?>_<?php echo $s['store_id'];?>" value="<?php echo $v['store'][$s['store_id']]['area_level'];?>" datatype="number" class="editable" onchange="changeJsonByLevel(this,this.value)" />
			</td>
			<?php } ?>
			<?php } ?>
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
          <td id="batchAction" colspan="15"><span class="all_checkbox">
            </span>&nbsp;&nbsp;<a href="JavaScript:void(0);" class="btn" onclick="if(confirm('<?php echo $lang['area_index_ensure_set'];?>')){$('#submit_type').val('set');$('#submitFrom').submit();}"><span><?php echo $lang['area_set'];?></span></a>
            </td>
        </tr>
      </tfoot>
      <?php } ?>
    </table>
  </form>
</div>
<script type="text/javascript" src="index.php?act=store_area&op=getStoreArea" charset="utf-8"></script> 
<script type="text/javascript" src="index.php?act=store_area&op=getStore" charset="utf-8"></script> 
<script>
document.getElementById("set_areas").value = JSON.stringify(obj);
function changeJsonByCheckbox(o){
	var level_id = o.id;
	var arr=level_id.split("_");
	var area_id = arr[2];
	var store_id = arr[3];
	var update = false;
	
	if(o.checked == false){
		//取消
		for(i = 0;i < obj.length;i++){
			if(obj[i].area_id == area_id && obj[i].store_id == store_id){
				obj[i].state = "0";
				break;
			}
		}
	}else{
		var level_name = "store_level_"+area_id+"_"+store_id;
		var value = document.getElementById(level_name).value;
		//选择
		for(i = 0;i < obj.length;i++){
			if(obj[i].area_id == area_id && obj[i].store_id == store_id){
				obj[i].state = "1";
				obj[i].area_level = value;
				update = true;
				break;
			}
		}
		
		//不是更新
		if(update == false){
			if(value == ""){
				value = "99";
				document.getElementById(level_name).value = value;
			}
			var add= {"area_id":area_id,"area_level":value,"store_id":store_id,"state":"1"};
			obj.push(add);
		}
	}
	
	document.getElementById("set_areas").value = JSON.stringify(obj);
}

function changeJsonByLevel(o,value){
	var level_id = o.id;
	var arr=level_id.split("_");
	var area_id = arr[2];
	var store_id = arr[3];
	var update = false;
	
	//选择
	for(i = 0;i < obj.length;i++){
		if(obj[i].area_id == area_id && obj[i].store_id == store_id){
			obj[i].area_level = value;
			update = true;
			break;
		}
	}
	
	//不是更新
	if(update == false){
		var add= {"area_id":area_id,"area_level":value,"store_id":store_id,"state":"0"};
		//alert(obj[0]);
		obj.push(add);
	}
	
	document.getElementById("set_areas").value = JSON.stringify(obj);
}

</script>
<!--<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.edit.js" charset="utf-8"></script> -->
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.store_area2.js" charset="utf-8"></script> 
<script>
function download(){
	location.href="index.php?act=store_area&op=download";
}
</script>