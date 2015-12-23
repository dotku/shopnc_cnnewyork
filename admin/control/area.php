<?php
/**
 * 地区管理
 *
 * 二十四小时在线技术Q：76809326 
 *
 * by 运维舫 www.shopnc.club 运营版
 */

defined('InShopNC') or exit('Access Invalid!');
class areaControl extends SystemControl{
	private $links = array(
		array('url'=>'act=area&op=area','lang'=>'nc_manage'),
		array('url'=>'act=area&op=area_add','lang'=>'nc_new'),
		array('url'=>'act=area&op=download','lang'=>'area_index_export'),
	);
	public function __construct(){
		parent::__construct();
		Language::read('area');
	}

	/**
	 * 地区管理
	 */
	public function areaOp(){
		require_once(BASE_DATA_PATH.DS.'cache'.DS.'area_cache.php');
		$lang	= Language::getLangContent();
		/**
		 * 实例化模型
		 */
		$model_area = Model('area');
		
		if (chksubmit()){
			//删除
			if ($_POST['submit_type'] == 'del'){
				$area_ids = implode(',', $_POST['check_area_id']);
				if (!empty($_POST['check_area_id'])){
					if (!is_array($_POST['check_area_id'])){
						$this->log(L('nc_delete,area_index').'[ID:'.$area_ids.']',0);
						showMessage($lang['nc_common_del_fail']);
					}
					
					//获取要删除的所有ID
					$delid_arr = array();
					foreach($_POST['check_area_id'] as $val){
						$delid_arr[$val] = $val;
						$id_temp_array = $model_area->getChildsByPid($val);
						foreach($id_temp_array as $v){
							$delid_arr[$v] = $v;
						}
					}
					
					//同时删除关联的store_area表
					$model_store_area->delStoreArea(array('area_id' => array('in', $delid_arr)));
					
					//删除地区
					$model_area->delArea(array('area_id' => array('in', $delid_arr)));
					
					//更新缓存操作
					area_cache::deleteCacheFile();
					area_cache::updateAreaArrayJs();
					area_cache::updateAreaPhp();
					
					$this->log(L('nc_delete,area_index_class').'[ID:'.$area_ids.']',1);
					showMessage($lang['nc_common_del_succ']);
				}else {
					$this->log(L('nc_delete,area_index_class').'[ID:'.$area_ids.']',0);
					showMessage($lang['nc_common_del_fail']);
				}
			}
		}
		
		//父ID
		$parent_id = $_GET['area_parent_id']?intval($_GET['area_parent_id']):0;
		
		if($parent_id == 0){
			$deep = 0;
		}else{
			$area = $model_area->getAreaInfo(array('area_id'=>$parent_id));
			$deep = $area['area_deep'];
		}
		
		//获取所有子地区y
		$deep = "".(intval($deep)+1);
		$all_list = area_cache::getCache('area',array('deep'=>$deep));
		
		//获取所有子地区
		$deep = "".(intval($deep)+1);
		$cache_data = area_cache::getCache('area',array('deep'=>$deep));
		
		if (is_array($cache_data)){
			foreach ($cache_data as $k => $v){
				foreach($all_list as $key =>$val){
					if ($v['area_parent_id'] == $val['area_id']){
						$all_list[$key]['have_child'] = 1;
					}
				}
			}
		}
		
		foreach($all_list as $val){
			if($val['area_parent_id'] == $parent_id){
				$area_list[] = $val;
			}
		}
		
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
			Tpl::showpage('area.index');
		}
	}

	/**
	 * 地区添加
	 */
	public function area_addOp(){
		require_once(BASE_DATA_PATH.DS.'cache'.DS.'area_cache.php');
		$lang	= Language::getLangContent();
		
		$model_area = Model('area');
		if (chksubmit()){
			$insert_array = array();
			$area_parent_id = "";
			if(empty($_POST['have_area_parent_id'])){
				$area_parent_id = $_POST['area_id'];
			}else{
				$area_parent_id = $_POST['have_area_parent_id'];
			}
			$area = $model_area->getAreaInfo(array('area_id'=>$area_parent_id));
			$insert_array['area_name']		= $_POST['area_name'];
			$insert_array['area_parent_id']	= intval($area_parent_id);
			$insert_array['area_sort']    = intval($_POST['area_sort']);
			$insert_array['area_deep']		= intval($area['area_deep'])+1;
			$insert_array['area_region']     = $_POST['area_region'];
			$result = $model_area->addArea($insert_array);
			if ($result){
				area_cache::deleteCacheFile();
				area_cache::updateAreaArrayJs();
				area_cache::updateAreaPhp();
				$url = array(
					array(
						'url'=>'index.php?act=area&op=area_add&area_parent_id='.$area_parent_id,
						'msg'=>$lang['area_add_again'],
					),
					array(
						'url'=>'index.php?act=area&op=area',
						'msg'=>$lang['area_add_back_to_list'],
					)
				);
				$this->log(L('nc_add,area_index_class').'['.$_POST['area_name'].']',1);
				showMessage($lang['nc_common_save_succ'],$url);
			}else {
				$this->log(L('nc_add,area_index_class').'['.$_POST['area_name'].']',0);
				showMessage($lang['nc_common_save_fail']);
			}
		}
		
		$area_name = $model_area->getAreaInfoById($_GET['area_parent_id']);
		Tpl::output('area_parent_id',$_GET['area_parent_id']);
		Tpl::output('area_parent_name',$area_name);
		Tpl::output('top_link',$this->sublink($this->links,'area_add'));
		Tpl::showpage('area.add');
	}

	/**
	 * 编辑
	 */
	public function area_editOp(){
		require_once(BASE_DATA_PATH.DS.'cache'.DS.'area_cache.php');
		$lang	= Language::getLangContent();
		$model_area = Model('area');
		
		if (chksubmit()){
			// 更新地区信息
			$where = array('area_id' => intval($_POST['area_old_id']));
			$update_array = array();
			$area_parent_id = $_POST['area_id'];
			if($area_parent_id == ""){
				//不改变上级地区，以及深度
			}else{
				$area = $model_area->getAreaInfo(array('area_id'=>$area_parent_id));
				$update_array['area_deep']		= intval($area['area_deep'])+1;
				$update_array['area_parent_id']	= $area_parent_id;
			}
			$update_array['area_name'] 		= $_POST['area_name'];
			$update_array['area_region'] 	= $_POST['area_region'];
			$update_array['area_sort']		= intval($_POST['area_sort']);
			$result = $model_area->editArea($update_array, $where);
			if (!$result){
				$this->log(L('nc_edit,area_index_class').'['.$_POST['area_name'].']',0);
				showMessage($lang['area_batch_edit_fail']);
			}
			area_cache::deleteCacheFile();
			area_cache::updateAreaArrayJs();
			area_cache::updateAreaPhp();
			$url = array(
				array(
					'url'=>'index.php?act=area&op=area_edit&area_id='.intval($_POST['area_old_id']),
					'msg'=>$lang['area_batch_edit_again'],
				),
				array(
					'url'=>'index.php?act=area&op=area',
					'msg'=>$lang['area_add_back_to_list'],
				)
			);
			$this->log(L('nc_edit,area_index_class').'['.$_POST['area_name'].']',1);
			showMessage($lang['area_batch_edit_ok'],$url,'html','succ',1,5000);
		}
		
		$area_array = $model_area->getAreaInfo(array('area_id'=>$_GET['area_id']));
		if (empty($area_array)){
			showMessage($lang['area_batch_edit_paramerror']);
		}
		
		Tpl::output('area_array',$area_array);
		$this->links[] = array('url'=>'act=area&op=area_edit','lang'=>'nc_edit');
		Tpl::output('top_link',$this->sublink($this->links,'area_edit'));
		Tpl::showpage('area.edit');
	}

	/**
	 * 删除地区
	 */
	public function area_delOp(){
		require_once(BASE_DATA_PATH.DS.'cache'.DS.'area_cache.php');
		$lang	= Language::getLangContent();
		$model_area = Model('area');
		$model_store_area = Model('store_area');
		if (intval($_GET['area_id']) > 0){
			//获取要删除的所有ID
			$delid_arr = array();
			$delid_arr[$_GET['area_id']] = $_GET['area_id'];
			$id_temp_array = $model_area->getChildsByPid($_GET['area_id']);
			foreach($id_temp_array as $v){
				$delid_arr[$v] = $v;
			}
			
			//同时删除关联的store_area表
			$model_store_area->delStoreArea(array('area_id' => array('in', $delid_arr)));
			
			//删除地区
			$model_area->delArea(array('area_id' => array('in', $delid_arr)));
			
			//更新缓存操作
			area_cache::deleteCacheFile();
			area_cache::updateAreaArrayJs();
			area_cache::updateAreaPhp();
			
			$this->log(L('nc_delete,area_index_class') . '[ID:' . intval($_GET['area_id']) . ']',1);
			showMessage($lang['nc_common_del_succ'],'index.php?act=area&op=area');
		}else {
			$this->log(L('nc_delete,area_index_class') . '[ID:' . intval($_GET['area_id']) . ']',0);
			showMessage($lang['nc_common_del_fail'],'index.php?act=area&op=area');
		}
	}
	
	/**
	 * ajax操作
	 */
	public function ajaxOp(){
		require_once(BASE_DATA_PATH.DS.'cache'.DS.'area_cache.php');
		switch ($_GET['branch']){
			/**
			 * 更新地区
			 */
			case 'area_name':
				$model_area = Model('area');
				$where = array('area_id' => intval($_GET['id']));
				$update_array = array();
				$update_array['area_name'] = trim($_GET['value']);
				$model_area->editArea($update_array, $where);
				
				area_cache::deleteCacheFile();
				area_cache::updateAreaArrayJs();
				area_cache::updateAreaPhp();
				echo 'true';exit;
				
				break;
			/**
			 * 地区 排序 显示 设置
			 */
			case 'area_sort':
				$model_area = Model('area');
				$where = array('area_id' => intval($_GET['id']));
				$update_array = array();
				$update_array['area_sort'] = trim($_GET['value']);
				$model_area->editArea($update_array, $where);
				
				area_cache::deleteCacheFile();
				area_cache::updateAreaArrayJs();
				area_cache::updateAreaPhp();
				echo 'true';exit;
				
			case 'area_region':
				$model_area = Model('area');
				$where = array('area_id' => intval($_GET['id']));
				$update_array = array();
				$update_array['area_region'] = trim($_GET['value']);
				$model_area->editArea($update_array, $where);
				
				area_cache::deleteCacheFile();
				area_cache::updateAreaArrayJs();
				area_cache::updateAreaPhp();
				echo 'true';exit;
				
			case 'area_index_show':
				$model_area = Model('area');
				$where = array('area_id' => intval($_GET['id']));
				$update_array = array();
				$update_array[$_GET['column']] = $_GET['value'];
				$model_area->editArea($update_array, $where);
				
				area_cache::deleteCacheFile();
				area_cache::updateAreaArrayJs();
				area_cache::updateAreaPhp();
				echo 'true';exit;
				break;
			/**
			 * 添加、修改操作中 检测类别名称是否有重复
			 */
			case 'check_class_name':
				$model_area = Model('area');
				$condition['area_name'] = trim($_GET['area_name']);
				$condition['area_parent_id'] = intval($_GET['area_parent_id']);
				$condition['area_id'] = array('neq', intval($_GET['area_id']));
				$class_list = $model_area->getAreaList($condition);
				if (empty($class_list)){
					echo 'true';exit;
				}else {
					echo 'false';exit;
				}
				break;
		}
	}

	/**
	 * 导出操作
	 */
	public function downloadOp(){
		$model_area = Model('area');
		$area_list = $model_area->getAreaList();
		
		include_once("area_to_excel.php");
		
		area_cache::deleteCacheFile();
		area_cache::updateAreaArrayJs();
		area_cache::updateAreaPhp();
	}
	
	/**
	 * 导入操作
	 */
	public function uploadOp(){
		$model_area = Model('area');
		$area_list = $model_area->getAreaList();
		
		include_once("area_from_excel.php");
		
		area_cache::deleteCacheFile();
		area_cache::updateAreaArrayJs();
		area_cache::updateAreaPhp();
	}
}
