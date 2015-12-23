<?php
/**
 * 买家收藏
 *
 * 二十四小时在线技术Q：76809326 
 *
 * by 运维舫 www.shopnc.club 运营版
 */
defined('InShopNC') or exit('Access Invalid!');
class favoritesModel extends Model{

    /**
     * 收藏列表
     *
     * @param array $condition
     * @param treing $field
     * @param int $page
     * @param string $order
     * @return array
     */
    public function getFavoritesList($condition, $field = '*', $page = 0 , $order = 'log_id desc', $limit = 0) {
        return $this->table('favorites')->where($condition)->order($order)->page($page)->limit($limit)->select();
    }

    /**
     * 收藏商品列表
     * @param array $condition
     * @param treing $field
     * @param int $page
     * @param string $order
     * @return array
     */
    public function getGoodsFavoritesList($condition, $field = '*', $page = 0, $order = 'log_id desc') {
        $condition['fav_type'] = 'goods';
        return $this->getFavoritesList($condition, $field, $page, $order);
    }

    /**
     * 收藏店铺列表
     * @param array $condition
     * @param treing $field
     * @param int $page
     * @param string $order
     * @return array
     */
    public function getStoreFavoritesList($condition, $field = '*', $page = 0, $order = 'log_id desc', $limit = 0) {
        $condition['fav_type'] = 'store';
        return $this->getFavoritesList($condition, $field, $page, $order, $limit);
    }

    /**
     * 取单个收藏的内容
     *
     * @param array $condition 查询条件
     * @return array 数组类型的返回结果
     */
    public function getOneFavorites($condition) {
        return $this->table('favorites')->where($condition)->find();
    }

    /**
     * 获取店铺收藏数
     *
     * @param int $storeId
     *
     * @return int
     */
    public function getStoreFavoritesCountByStoreId($storeId, $memberId = 0)
    {
        $where = array(
            'fav_type' => 'store',
            'fav_id' => $storeId,
        );

        if ($memberId > 0) {
            $where['member_id'] = (int) $memberId;
        }

        return (int) $this->table('favorites')->where($where)->count();
    }

    /**
     * 获取商品收藏数
     *
     * @param int $storeId
     *
     * @return int
     */
    public function getGoodsFavoritesCountByGoodsId($goodsId, $memberId = 0)
    {
        $where = array(
            'fav_type' => 'goods',
            'fav_id' => $goodsId,
        );

        if ($memberId > 0) {
            $where['member_id'] = (int) $memberId;
        }

        return (int) $this->table('favorites')->where($where)->count();
    }

    /**
     * 新增收藏
     *
     * @param array $param 参数内容
     * @return bool 布尔类型的返回结果
     */
    public function addFavorites($param) {
        if (empty($param)) {
            return false;
        }
        if ($param['fav_type'] == 'store') {
            $store_id = intval($param['fav_id']);
            $model_store = Model('store');
            $store = $model_store->getStoreInfoByID($store_id);
            $param['store_name'] = $store['store_name'];
            $param['store_id'] = $store['store_id'];
            $param['sc_id'] = $store['sc_id'];
        }
        if ($param['fav_type'] == 'goods') {
            $goods_id = intval($param['fav_id']);
            $model_goods = Model('goods');
            $fields = 'goods_id,store_id,goods_name,goods_image,goods_price,goods_promotion_price';
            $goods = $model_goods->getGoodsInfoByID($goods_id,$fields);
            $param['goods_name'] = $goods['goods_name'];
            $param['goods_image'] = $goods['goods_image'];
            $param['log_price'] = $goods['goods_promotion_price'];//商品收藏时价格
            $param['log_msg'] = $goods['goods_promotion_price'];//收藏备注，默认为收藏时价格，可修改
            $param['gc_id'] = $goods['gc_id'];

            $store_id = intval($goods['store_id']);
            $model_store = Model('store');
            $store = $model_store->getStoreInfoByID($store_id);
            $param['store_name'] = $store['store_name'];
            $param['store_id'] = $store['store_id'];
            $param['sc_id'] = $store['sc_id'];
        }
        return $this->table('favorites')->insert($param);
    }

    /**
     * 修改记录
     *
     * @param
     * @return bool
     */
    public function editFavorites($condition, $data) {
        if (empty($condition)) {
            return false;
        }
        if (is_array($data)) {
            $result = $this->table('favorites')->where($condition)->update($data);
            return $result;
        } else {
            return false;
        }
    }

    /**
     * 删除
     *
     * @param array $condition 查询条件
     * @return bool 布尔类型的返回结果
     */
    public function delFavorites($condition) {
        if (empty($condition)) {
            return false;
        }
        return $this->table('favorites')->where($condition)->delete();
    }
}
