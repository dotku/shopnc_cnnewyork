<?php
/**
 *
 * 二十四小时在线技术Q：76809326 
 *
 * by 运维舫 www.shopnc.club 运营版
 */

defined('InShopNC') or exit('Access Invalid!');

class store_areaControl extends SystemControl {
	private $links = array(
		array('url'=>'act=store_area&op=store_area','lang'=>'nc_manage'),
		array('url'=>'act=store_area&op=store_area_add','lang'=>'nc_new'),
		array('url'=>'act=store_area&op=store_area_export','lang'=>'store_area_index_export'),
		array('url'=>'act=store_area&op=store_area_import','lang'=>'store_area_index_import'),
		array('url'=>'act=store_area&op=tag','lang'=>'store_area_index_tag'),
	);
	public function __construct(){
		parent::__construct();
	}
	
	/**
	 * 自营店铺列表
	 */
	public function listOp(){
		require_once(BASE_DATA_PATH.DS.'cache'.DS.'area_cache.php');
		$lang	= Language::getLangContent();
		
		$model_store = Model('store');
		$model_area = Model('area');
		$model_store_area = Model('store_area');
		
		if (chksubmit()){
			//删除
			if ($_POST['submit_type'] == 'set'){
				$set_areas = $_POST['set_areas'];
				$set_areas = htmlspecialchars_decode($set_areas, ENT_QUOTES);
				$new_list = json_decode($set_areas,TRUE );
				
				$store_id = $_POST['store_id'];
				if (!empty($new_list)){
					$state = 1;
					if($store['store_state'] == 0 || $store['store_state'] == 2 ){
						$state = 2;
					}
					$old_list = $model_store_area->getStoreAreaList();
					
					//更新的
					$update_array = array();
					//新的
					$insert_array = array();
					
					foreach($new_list as $key=>$val){
						$new = 0;
						
						foreach($old_list as $k=>$v){
							if($v['area_id'] == $val['area_id'] && $v['store_id'] == $val['store_id']){
								if(($v['area_level'] != $val['area_level']) || ($v['state'] != $val['state'])){
									$new_arr = array();
									$new_arr = $val;
									$new_arr['store_area_id'] = $v['store_area_id'];
									$update_array[] = $new_arr;
								}
								$new = 1;
								break;
							}
						}
						
						if($new == 0){
							$insert_array[] = $val;
						}
					}
					
					$model_store_area->addStoreAreaAll($insert_array);
					
					foreach($update_array as $k=>$v){
						$update_arr = array();
						$update_arr['store_id']	= $v['store_id'];
						$update_arr['area_id']	= $v['area_id'];
						$update_arr['area_level']	= $v['area_level'];
						$update_arr['state']	= $v['state'];
						$result = $model_store_area->editStoreArea($update_arr,array('store_area_id' => $v['store_area_id']));
					}
					
					showMessage($lang['nc_common_save_succ']);
				}else {
					$this->log(L('nc_delete,area_index_class').'[ID:'.$set_areas.']',0);
					showMessage($lang['nc_common_save_fail']);
				}
			}
		}
		
		//父ID
		$parent_id = $_GET['area_parent_id']?intval($_GET['area_parent_id']):0;
		
		//获取上级ID的深度
		if($parent_id == 0){
			$deep = 0;
		}else{
			$area = $model_area->getAreaInfo(array('area_id'=>$parent_id));
			$deep = $area['area_deep'];
		}
		
		//获取当前深度的所有当前地区
		$deep = "".(intval($deep)+1);
		$all_list = area_cache::getCache('area',array('deep'=>$deep));
		
		//获取所有子地区
		$deep = "".(intval($deep)+1);
		$cache_data = area_cache::getCache('area',array('deep'=>$deep));
		
		//判断所有当前地区是否有子地区，有的则添加变量have_child=1
		if (is_array($cache_data)){
			foreach ($cache_data as $k => $v){
				foreach($all_list as $key =>$val){
					if ($v['area_parent_id'] == $val['area_id']){
						$all_list[$key]['have_child'] = 1;
					}
				}
			}
		}
		
		//筛选出当前父ID的所有相关地区
		$area_list = array();
		foreach($all_list as $val){
			if($val['area_parent_id'] == $parent_id){
				$area_list[] = $val;
			}
		}
		
		//获取所有自营店关联的地区
		$store_area_list = $model_store_area->getStoreAreaList();
		foreach($area_list as $key=>$val){
			$area_list[$key]['store'] = array();
			foreach($store_area_list as $v){
				if($val['area_id'] == $v['area_id']){
					$area_list[$key]['store'][$v['store_id']]['area_level'] = $v['area_level'];
					$area_list[$key]['store'][$v['store_id']]['state'] = $v['state'];
				}
			}
		}
		
		//获取所有自营店
		$condition = array(
			'is_own_shop' => 1,
		);
		
		$store_own_list = $model_store->getStoreList($condition);
		
		if ($_GET['ajax'] == '1'){
			//转码
			if (strtoupper(CHARSET) == 'GBK'){
				$area_list = Language::getUTF8($area_list);
			}
			$output = json_encode($area_list);
			print_r($output);
			exit;
		}else {
			Tpl::output('area_list',$area_list);
			Tpl::output('top_link',$this->sublink($this->links,'area'));
			
			Tpl::output('store_list', $store_own_list);
			Tpl::showpage('store_area.index2');
		}
	}
	
	public function getStoreAreaOp(){
		$model_store_area = Model('store_area');
		$store_area_list = $model_store_area->getStoreAreaList();
		$json_temp_list = array();
		foreach($store_area_list as $key=>$val){
			$json_temp_list[$key]['area_id'] = $val['area_id'];
			$json_temp_list[$key]['area_level'] = $val['area_level'];
			$json_temp_list[$key]['store_id'] = $val['store_id'];
			$json_temp_list[$key]['state'] = $val['state'];
		}
		$output = "var obj = eval(".json_encode($json_temp_list).");";
		print_r($output);
		exit;
	}
	
	public function getStoreOp(){
		$model_store = Model('store');
		$condition = array(
			'is_own_shop' => 1,
		);
		
		$store_own_list = $model_store->getStoreList($condition);
		
		$store_array = array();
		foreach($store_own_list as $val){
			$store['store_id'] = $val['store_id'];
			$store['store_name'] = $val['store_name'];
			$store_array[] = $store;
		}
		
		$output = "var store_obj = eval(".json_encode($store_array).");";
		print_r($output);
		exit;
	}
	
	public function downloadOp(){
		$model_store = Model('store');
		$model_store_area = Model('store_area');
		$model_area = Model('area');
		$condition = array(
			'is_own_shop' => 1,
		);
		
		$store_own_list = $model_store->getStoreList($condition);
		$store_area_list = $model_store_area->getAreaInfo(array(), ' area_id asc, store_id asc ');
		$area_list = $model_area->getAreaList();
		
		$store_array = array();
		foreach($store_own_list as $val){
			$store_array[$val['store_id']] = $val['store_name'];
		}
		
		$area_array = array();
		foreach($area_list as $val){
			$area_array[$val['area_id']] = $val['area_name'];
		}
		
		include_once(BASE_ROOT_PATH.DS."admin".DS."control".DS."store_area_to_excel.php");
	}

	
	public function uploadOp(){
		$model_store = Model('store');
		$model_store_area = Model('store_area');
		$model_area = Model('area');
		$condition = array(
			'is_own_shop' => 1,
		);
		
		$store_own_list = $model_store->getStoreList($condition);
		$store_area_list = $model_store_area->getAreaInfo(array());
		$area_list = $model_area->getAreaList();
		$store_array = array();
		foreach($store_own_list as $val){
			$store_array[$val['store_id']] = $val['store_name'];
		}
		$area_array = array();
		foreach($area_list as $val){
			$area_array[$val['area_id']] = $val['area_name'];
		}
		include_once(BASE_ROOT_PATH.DS."admin".DS."control".DS."store_area_from_excel.php");
		//include_once(BASE_ROOT_PATH.DS."admin".DS."control".DS."store_area_from_excel.php');
	}
}
