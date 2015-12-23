<?php
/**
 *
 * 二十四小时在线技术Q：76809326 
 *
 * by 运维舫 www.shopnc.club 运营版
 */
include_once(BASE_DATA_PATH.DS."excel".DS."reader.php");
$tmp = $_FILES['file']['tmp_name'];
if (empty ($tmp)) { 
	echo '请选择要导入的Excel文件！'; 
	exit; 
}

$save_path = BASE_DATA_PATH.DS."upload".DS."admin".DS."excel".DS;
$file_name = $save_path.date('Ymdhis') . ".xls"; //上传后的文件保存路径和名称 

$error_str = "";
$flag = false;

$insert_array = array();
$del_array = array();
$edit_array = array();

if (copy($tmp, $file_name)) {
	$xls = new Spreadsheet_Excel_Reader();
	$xls->setOutputEncoding('utf-8');
	$xls->read($file_name);
	$data_array = array();
	for ($i=2; $i<=count($xls->sheets[0]['cells']); $i++) {
		//地区ID	地区名称	上级地区ID	排序	深度	大区名称	操作(0不变,1添加,2修改,3删除)
		
		$data['area_id']	= $xls->sheets[0]['cells'][$i][1];//地区id
		$data['area_name']		= $xls->sheets[0]['cells'][$i][2];//地区名称
		$data['area_parent_id']		= $xls->sheets[0]['cells'][$i][3];//父ID
		$data['area_sort']		= $xls->sheets[0]['cells'][$i][4];//顺序 0
		$data['area_deep']		= $xls->sheets[0]['cells'][$i][5];//深度 1
		$data['area_region']	= $xls->sheets[0]['cells'][$i][6];//大区名称
		$data['action']	= $xls->sheets[0]['cells'][$i][7];//状态
		
		if($data['action'] == "1" ){
			//添加操作
			if($data['area_name'] == "" ){
				$errar_array[$i][] = "地区名称不能为空";
				$flag = true;
			}
			
			if($data['area_parent_id'] == "" ){
				$errar_array[$i][] = "上级地区ID不能为空";
				$flag = true;
			}
		}
		else if($data['action'] == "2" ){
			//修改操作
			if($data['area_id'] == "" ){
				$errar_array[$i][] = "地区ID不能为空";
				$flag = true;
			}
			
			if($data['area_name'] == "" ){
				$errar_array[$i][] = "地区名称不能为空";
				$flag = true;
			}
			
			if($data['area_parent_id'] == "" ){
				$errar_array[$i][] = "上级地区ID不能为空";
				$flag = true;
			}
		}
		else if($data['action'] == "3" ){
			//删除操作
			if($data['area_id'] == "" ){
				$errar_array[$i][] = "地区ID不能为空";
				$flag = true;
			}
		}
		
		if($flag){
			continue;
		}
		
		if($data['area_sort'] == ""){
			$data['area_sort'] = '0';
		}
		if($data['area_deep'] == ""){
			$data['area_sort'] = '1';
		}
		
		if($data['action'] == "1" ){
			$insert_arr = array();
			$insert_arr['area_name'] = $data['area_name'];
			$insert_arr['area_parent_id'] = $data['area_parent_id'];
			$insert_arr['area_sort'] = $data['area_sort'];
			$insert_arr['area_deep'] = $data['area_deep'];
			$insert_arr['area_region'] = $data['area_region'];
			$insert_array[] = $insert_arr;
		}
		else if($data['action'] == "2" ){
			$edit_array[] = $data;
		}
		else if($data['action'] == "3" ){
			$del_arr = array();
			$del_arr['area_id'] = $data['area_id'];
			$del_array[] = $del_arr;
		}
	}
	if($flag){
		$str = "导入错误<br />";
		foreach($errar_array as $key=>$error){
			foreach($error as $v){
				$str .= "第".$key."行 ".$v."<br />";
			}
		}
		echo $str;
	}else{
		if(count($del_array)>0){
			foreach($del_array as $val){
				$result = $model_area->delArea($del_ids);
			}
		}
		if(count($insert_array)>0){
			$result = $model_area->addAreaAll($insert_array);
		}
		if(count($edit_array)>0){
			foreach($edit_array as $val){
				$model_area->editArea($val,$val['area_id']);
			}
		}
		//清除上传的缓存文件
		@unlink($file_name);
		showMessage("操作成功");
	}
}

?> 