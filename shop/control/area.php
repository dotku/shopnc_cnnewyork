<?php
/**
 * 地区
 *
 * 二十四小时在线技术Q：76809326 
 *
 * by 运维舫 www.shopnc.club 运营版
 */
defined('InShopNC') or exit('Access Invalid!');
class areaControl extends BaseHomeControl{
	//json输出商品分类
	public function josn_classOp() {
		/**
		 * 实例化商品分类模型
		 */
		$model_area = Model('area');
		$area		= $model_area->getAreaListByParentId(intval($_GET['area_id']));
		$array				= array();
		if(is_array($area) and count($area)>0) {
			foreach ($area as $val) {
				$array[$val['area_id']] = array('area_id'=>$val['area_id'],'area_name'=>htmlspecialchars($val['area_name']),'area_parent_id'=>$val['area_parent_id'],'area_region'=>htmlspecialchars($val['area_region']),'area_sort'=>$val['area_sort'],'area_deep'=>$val['area_deep']);
			}
		}
		/**
		 * 转码
		 */
		if (strtoupper(CHARSET) == 'GBK'){
			$array = Language::getUTF8(array_values($array));//网站GBK使用编码时,转换为UTF-8,防止json输出汉字问题
		} else {
			$array = array_values($array);
		}
		echo $_GET['callback'].'('.json_encode($array).')';
	}

	/**
	 * json输出地址数组 原data/resource/js/area_array.js
	 */
	public function json_area_showOp()
	{
		echo $_GET['callback'].'('.json_encode(Model('area')->getAreaArrayForJson()).')';
	}
	
	/**
	 * json输出地址数组 v3-b12
	 */
	public function json_area_showOp()
	{
		echo $_GET['callback'].'('.json_encode(Model('area')->getAreaArrayForJson()).')';
	}
	
}
