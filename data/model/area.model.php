<?php
/**
 * 地区模型
 *
 * 二十四小时在线技术Q：76809326 
 *
 * by 运维舫 www.shopnc.club 运营版
 */
defined('InShopNC') or exit('Access Invalid!');

class areaModel extends Model {


	public function __construct() {
		parent::__construct('area');
	}
	/**
	 * 读取系统设置列表
	 *
	 * @param array $condition 检索条件
		 * @param string $order 排序条件
	 * @return array 数组格式的返回结果
	 */
	public function getListArea($condition, $order=''){
		$condition_str = $this->_condition($condition);
		$param = array();
		$param['table'] = 'area';
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
	 * 获取地址列表
	 *
	 * @return mixed
	 */
    public function getAreaList($condition = array(), $fields = '*', $group = '', $page = null) {
        return $this->where($condition)->field($fields)->page($page)->limit(false)->group($group)->select();
    }
	
	/**
	 * 从缓存获取分类 通过分类id
	 *
	 * @param int $id 分类id
	 */
	public function getAreaInfoById($id) {
		$data = $this->getCache();
		return $data['name'][$id];
	}
	
	/**
	 * 获取地址详情
	 *
	 * @return mixed
	 */
	public function getAreaInfo($condition = array(), $fileds = '*') {
		return $this->where($condition)->field($fileds)->find();
	}

	/**
	 * 获取一级地址（省级）名称数组
	 *
	 * @return array 键为id 值为名称字符串
	 */
	public function getTopLevelAreas() {
		$data = $this->getCache();
		
		$arr = array();
		foreach ($data['children'][0] as $i) {
			$arr[$i] = $data['name'][$i];
		}
		return $arr;
	}

	/**
	 * 获取获取市级id对应省级id的数组
	 *
	 * @return array 键为市级id 值为省级id
	 */
	public function getCityProvince() {
		$data = $this->getCache();
		
		$arr = array();
		foreach ($data['parent'] as $k => $v) {
			if ($v && $data['parent'][$v] == 0) {
				$arr[$k] = $v;
			}
		}

		return $arr;
	}

	/**
	 * 获取地区缓存
	 *
	 * @return array
	 */
	public function getAreas() {
		return $this->getCache();
	}

	/**
	 * 获取全部地区名称数组
	 *
	 * @return array 键为id 值为名称字符串
	 */
	public function getAreaNames() {
		$data = $this->getCache();

		return $data['name'];
	}

	/**
	 * 获取用于前端js使用的全部地址数组
	 *
	 * @return array
	 */
    public function getAreaArrayForJson($src = 'cache') {
        if ($src == 'cache') {
            $data = $this->getCache();
        } else {
            $data = $this->_getAllArea();
        }

		$arr = array();
		foreach ($data['children'] as $k => $v) {
			foreach ($v as $vv) {
				$arr[$k][] = array($vv, $data['name'][$vv]);
			}
		}
		return $arr;
	}
	
	/**
	 * 更新信息
	 * @param unknown $data
	 * @param unknown $condition
	 */
	public function editArea($data = array(), $condition = array()) {
		// 删除缓存
		$this->dropCache();
		return $this->where($condition)->update($data);
	}
	
	/**
	 * 新增地区
	 * @param array $insert
	 * @return boolean
	 */
	public function addArea($insert) {
		// 删除缓存
		$this->dropCache();
		return $this->insert($insert);
	}
	
	/**
	 * 删除地区
	 *
	 * @param array $area_ids
	 * @return boolean
	 */
	public function delAreaByAreaIds($area_ids) {
		$area_arr = explode(',', $area_ids);
		if (empty($area_arr)) {
			return false;
		}
		
		$child_list = $this->getAreaList(array('area_parent_id' => array('in', $area_arr)));
		if(!empty($child_list)){
			foreach($child_list as $v){
				$area_child_arr[] = $v['area_id'];
			}
			
			$area_child_ids = implode(',', $area_child_arr);
			$this->delAreaByAreaIds($area_child_ids);
		}
		// 删除地区
		$this->delArea(array('area_id' => array('in', $area_arr)));
	}
	
	/**
	 * 删除地区
	 * @param unknown $condition
	 * @return boolean
	 */
	public function delArea($condition) {
		// 删除缓存
		$this->dropCache();
		return $this->where($condition)->delete();
	}
	
	
	/**
	 * 删除缓存数据
	 */
	public function dropCache() {
		$this->cachedData = null;
		
		dkcache('area');
	}
	/**
	 * 获取地区数组 格式如下
	 * array(
	 *   'name' => array(
	 *     '地区id' => '地区名称',
	 *     // ..
	 *   ),
	 *   'parent' => array(
	 *     '子地区id' => '父地区id',
	 *     // ..
	 *   ),
	 *   'children' => array(
	 *     '父地区id' => array(
	 *       '子地区id 1',
	 *       '子地区id 2',
	 *       // ..
	 *     ),
	 *     // ..
	 *   ),
	 *   'region' => array(array(
	 *     '华北区' => array(
	 *       '省级id 1',
	 *       '省级id 2',
	 *       // ..
	 *     ),
	 *     // ..
	 *   ),
	 * )
	 *
	 * @return array
	 */
	protected function getCache() {
		// 对象属性中有数据则返回
		if ($this->cachedData !== null)
			return $this->cachedData;

		// 缓存中有数据则返回
		if ($data = rkcache('area')) {
			$this->cachedData = $data;
			return $data;
		}

		// 查库
        $data = $this->_getAllArea();
        wkcache('area', $data);
        $this->cachedData = $data;

        return $data;
    }

    protected $cachedData;

    private function _getAllArea() {
		$data = array();
		$area_all_array = $this->limit(false)->select();
		foreach ((array) $area_all_array as $a) {
			$data['name'][$a['area_id']] = $a['area_name'];
			$data['parent'][$a['area_id']] = $a['area_parent_id'];
			$data['children'][$a['area_parent_id']][] = $a['area_id'];

			if ($a['area_deep'] == 1 && $a['area_region'])
				$data['region'][$a['area_region']][] = $a['area_id'];
		}

		wkcache('area', $data);
		$this->cachedData = $data;

		return $data;
	}
	
	/**
	 * 构造检索条件
	 *
	 * @param array $condition 检索条件
	 * @return string 数组形式的返回结果
	 */
	private function _condition($condition){
		$condition_str = '';
		
		if ($condition['area_parent_id'] != ''){
			$condition_str .= " and area_parent_id = '". intval($condition['area_parent_id']) ."'";
		}
		if ($condition['area_deep'] != ''){
			$condition_str .= " and area_deep = '". intval($condition['area_deep']) ."'";
		}
		if ($condition['area_deep'] != ''){
			$condition_str .= " and flea_area_deep <= 2";//一级和二级地区
		}
		return $condition_str;
	}
	
	
	/**
	 * 从缓存获取分类 通过上级分类id
	 *
	 * @param int $pid 上级分类id 若传0则返回1级分类
	 */
	public function getAreaListByParentId($pid) {
		$data = $this->getCache();
		$ret = array();
		foreach ((array) $data['children'][$pid] as $i) {
			if ($data['data'][$i]) {
				$ret[] = $data['data'][$i];
			}
		}
		return $ret;
	}
	
	 /**
     * 递归取得本地区及所有上级地区名称
     * @return string
     */
    public function getTopAreaName($area_id,$area_name = '') {
        $info_parent = $this->getAreaInfo(array('area_id'=>$area_id),'area_name,area_parent_id');
        if ($info_parent) {
            return $this->getTopAreaName($info_parent['area_parent_id'],$info_parent['area_name']).' '.$info_parent['area_name'];
        }
    }
	
    /**
     * 递归取得本地区所有孩子ID
     * @return array
     */
    public function getChildrenIDs($area_id) {
        $result = array();
        $list = $this->getAreaList(array('area_parent_id'=>$area_id),'area_id');
        if ($list) {
            foreach ($list as $v) {
                $result[] = $v['area_id'];
                $result = array_merge($result,$this->getChildrenIDs($v['area_id']));
            }
        }
        return $result;
    }
	/**
	 * 从缓存获取所有子节点 通过id
	 *
	 * @param int $pid 上级地区id 若传0则返回1级分类
	 */
	public function getChildsByPid($pid) {
		$data = $this->getCache();
		if(!is_array($data['children'][$pid])){
			return false;
		}
		$ret = array();
		foreach ((array) $data['children'][$pid] as $i) {
			$ret[] = $i;
			$ret_temp = $this->getChildsByPid($i);
			if($ret_temp != false){
				foreach($ret_temp as $v){
					$ret[] = $v;
				}
			}
		}
		return $ret;
	}
}
