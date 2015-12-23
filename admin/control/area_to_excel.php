<?php
/**
 *
 * 二十四小时在线技术Q：76809326 
 *
 * by 运维舫 www.shopnc.club 运营版
 */
function exportExcel($filename,$content){
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Content-Type: application/vnd.ms-execl");
	header("Content-Type: application/force-download");
	header("Content-Type: application/download");
	header("Content-Disposition: attachment; filename=".$filename);
	header("Content-Transfer-Encoding: binary");
	header("Pragma: no-cache");
	header("Expires: 0");
	
	echo $content;
}	
	$str = "地区ID\t地区名称\t上级地区ID\t排序\t深度\t大区名称\t操作(0不变,1添加,2修改,3删除)\n";
	//$str = iconv('utf-8','gb2312',$str);
	if(is_array($area_list)){
		foreach($area_list as $key=>$val){
			$str = $str. $val['area_id']."\t".$val['area_name']."\t".$val['area_parent_id']."\t".$val['area_sort']."\t".$val['area_deep']."\t".$val['area_region']."\t0\n";
		}
	}
	$filename = time().'.xls';
	exportExcel($filename,$str);
?>