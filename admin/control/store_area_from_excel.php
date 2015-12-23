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

$area_array_keys = array_keys($area_array);
$store_array_keys = array_keys($store_array);
if (copy($tmp, $file_name)) {
	$xls = new Spreadsheet_Excel_Reader();
	$xls->setOutputEncoding('utf-8');
	$xls->read($file_name);
	$data_array = array();
	for ($i=2; $i<=count($xls->sheets[0]['cells']); $i++) {
		//地区ID	地区名称	自营店ID	自营店名称	级别	是否有效(0无效1有效)
		
		$data['area_id']	= $xls->sheets[0]['cells'][$i][1];//地区id
		//$data['area_name']		= $xls->sheets[0]['cells'][$i][2];//地区名称
		$data['store_id']		= $xls->sheets[0]['cells'][$i][3];//自营店ID
		//$data['store_name']		= $xls->sheets[0]['cells'][$i][4];//自营店名称
		$data['area_level']		= $xls->sheets[0]['cells'][$i][5];//级别
		$data['state']	= $xls->sheets[0]['cells'][$i][6];//状态
		
		if($data['area_id'] == "" ){
			$errar_array[$i][] = "地区ID不能为空";
			$flag = true;
		}
		if($data['store_id'] == "" ){
			$errar_array[$i][] = "自营店ID不能为空";
			$flag = true;
		}
		if(!in_array($data['area_id'],$area_array_keys)){
			$errar_array[$i][] = "地区ID不存在";
			$flag = true;
		}
		if(!in_array($data['store_id'],$store_array_keys)){
			$errar_array[$i][] = "自营店ID不存在";
			$flag = true;
		}
		
		if($flag){
			continue;
		}
		
		foreach($data as $key=>$val){
			if($data['area_level'] == "" ){
				$data['area_level'] = "99";
			}
			if($data['state'] == "" ){
				$data['state'] = "0";
			}
			
			if($key == "area_id"){$data[$key] = intval($val);}
			if($key == "store_id"){$data[$key] = intval($val);}
			if($key == "area_level"){$data[$key] = intval($val);}
			if($key == "state"){$data[$key] = intval($val);}
			
		}
		
		$data_array[] = $data;
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
		$result = $model_store_area->delAllStoreArea();
		
		$model_store_area->addStoreAreaAll($data_array);
		
		//清除上传的缓存文件
		@unlink($file_name);
		showMessage("操作成功");
	}
}

?> 