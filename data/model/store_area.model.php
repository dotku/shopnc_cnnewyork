<?php
/**
 * 地区模型 
 *
 * 二十四小时在线技术Q：76809326 
 *
 * by 运维舫 www.shopnc.club 运营版
 */
defined('InShopNC') or exit('Access Invalid!');

class store_areaModel extends Model {

	protected $cachedData;

	public function __construct() {
		parent::__construct('store_area');
	}
	
	/**
	 * 获取店铺地区
	 *
	 * @return mixed
	 */
	public function getAreaInfo($condition = array(), $order = '') {
		$condition_str = $this->_condition($condition);
		$param = array();
		$param['table'] = 'store_area';
		$param['field'] = $condition['field']?$condition['field']:'*';
		$param['limit'] = $condition['limit']?$condition['limit']:'';
		$param['order'] = $condition['order']?$condition['order']:'';
		$param['where'] = $condition_str;
		if( !empty($order) )
		{
			$param['order'] = $order;
		}
		$result = Db::select($param);
		return $result;
	}
	
	/**
	 * 构造检索条件
	 *
	 * @param array $condition 检索条件
	 * @return string 数组形式的返回结果
	 */
	private function _condition($condition){
		$condition_str = '';
		
		if ($condition['store_in'] != ''){
			$condition_str .= " and store_id in (". $condition['store_in'] .")";
		}
		if ($condition['area_id'] != ''){
			$condition_str .= " and area_id ='". $condition['area_id'] ."'";
		}
		if ($condition['state'] != ''){
			$condition_str .= " and state ='". $condition['state'] ."'";
		}
		return $condition_str;
	}
	
	/*
	 * 添加店铺地区
	 *
	 * @param array $param 店铺信息
	 * @return bool
	 */
	public function addStoreArea($param){
		return $this->insert($param);
	}

	/*
	 * 添加店铺地区
	 *
	 * @param array $param 店铺信息
	 * @return bool
	 */
	public function addStoreAreaAll($param){
		return $this->insertAll($param);
	}
	/**
	 * 更新信息
	 * @param unknown $data
	 * @param unknown $condition
	 */
	public function editStoreArea($data = array(), $condition = array()) {
		return $this->where($condition)->update($data);
	}
	
	/*
	 * 删除店铺地区
	 *
	 * @param array $condition 条件
	 * @return bool
	 */
	public function delStoreArea($condition = array()){
		return $this->where($condition)->delete();
	}
	
	/*
	 * 清空店铺地区
	 *
	 * @param array $condition 条件
	 * @return bool
	 */
	public function delAllStoreArea(){
		return $this->clear();
	}
	
	/**
	 * 获取店铺地区列表
	 *
	 * @return mixed
	 */
	public function getStoreAreaList($condition = array(), $fields = '*', $group = '') {
		return $this->where($condition)->field($fields)->limit(false)->group($group)->select();
	}
	
}
