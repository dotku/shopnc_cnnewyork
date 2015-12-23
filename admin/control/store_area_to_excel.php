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
	$str = "地区ID\t地区名称\t自营店ID\t自营店名称\t级别\t是否有效(0无效1有效)\n";
	//$str = iconv('utf-8','gb2312',$str);
	if(is_array($store_area_list)){
		foreach($store_area_list as $key=>$val){
			$str = $str. $val['area_id']."\t".$area_array[$val['area_id']]."\t".$val['store_id']."\t".$store_array[$val['store_id']]."\t".$val['area_level']."\t".$val['state']."\n";
		}
	}
	$filename = time().'.xls';
	exportExcel($filename,$str);
?>