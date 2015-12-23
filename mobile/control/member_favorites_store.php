<?php
/**
 * 我的收藏店铺 v3-b12 
 *
 *
 */



defined('InShopNC') or exit('Access Invalid!');

class member_favorites_storeControl extends mobileMemberControl {

    public function __construct(){
        parent::__construct();
    }

    /**
     * 收藏列表
     */
    public function favorites_listOp() {
        $model_favorites = Model('favorites');
        $model_store = Model('store');

        $favorites_list = $model_favorites->getStoreFavoritesList(array(
            'member_id'=>$this->member_info['member_id'],
        ), '*', $this->page);

        $page_count = $model_favorites->gettotalpage();

        $store_list = array();

        $favorites_list_indexed = array();
        foreach ($favorites_list as $v) {
            $item = array();
            $item['store_id'] = $v['store_id'];
            $item['store_name'] = $v['store_name'];
            $item['fav_time'] = $v['fav_time'];
            $item['fav_time_text'] = date('Y-m-d H:i', $v['fav_time']);

            $store = $model_store->getStoreInfoByID($v['store_id']);
            $item['goods_count'] = $store['goods_count'];
            $item['store_collect'] = $store['store_collect'];

            $item['store_avatar'] = $store['store_avatar'];
            if ($store['store_avatar']) {
                $item['store_avatar_url'] = UPLOAD_SITE_URL.'/'.ATTACH_STORE.'/'.$store['store_avatar'];
            } else {
                $item['store_avatar_url'] = UPLOAD_SITE_URL.'/'.ATTACH_COMMON.DS.C('default_store_avatar');
            }

            $store_list[] = $item;
        }

        output_data(array('favorites_list' => $store_list), mobile_page($page_count));
    }

    /**
     * 添加收藏
     */
    public function favorites_addOp() {

        $fav_id = intval($_POST['store_id']);
        if ($fav_id <= 0){
            output_error('参数错误');
        }

        $favorites_model = Model('favorites');

        //判断是否已经收藏
        $favorites_info = $favorites_model->getOneFavorites(array(
            'fav_id'=>$fav_id,
            'fav_type'=>'store',
            'member_id'=>$this->member_info['member_id'],
        ));
        if(!empty($favorites_info)){
            output_error('您已经收藏了该店铺');
        }

        //判断店铺是否为当前会员所有
        $seller_info = Model('seller')->getSellerInfo(array('member_id'=>$this->member_info['member_id']));
        if ($fav_id == $seller_info['store_id']) {
            output_error('您不能收藏自己发布的商品');
        }

        //添加收藏
        $insert_arr = array();
        $insert_arr['member_id'] = $this->member_info['member_id'];
        $insert_arr['member_name'] = $this->member_info['member_name'];
        $insert_arr['fav_id'] = $fav_id;
        $insert_arr['fav_type'] = 'store';
        $insert_arr['fav_time'] = time();
        $result = $favorites_model->addFavorites($insert_arr);

        if ($result) {
            //增加收藏数量
            $store_model = Model('store');
            $store_model->editStore(array('store_collect'=>array('exp', 'store_collect+1')), array('store_id' => $fav_id));
            output_data('1');
        } else {
            output_error('收藏失败');
        }
    }

    /**
     * 删除收藏
     */
    public function favorites_delOp() {
        $fav_id = intval($_POST['store_id']);
        if ($fav_id <= 0) {
            output_error('参数错误');
        }

        $model_favorites = Model('favorites');
        $model_store = Model('store');

        $condition = array();
        $condition['fav_type'] = 'store';
        $condition['fav_id'] = $fav_id;
        $condition['member_id'] = $this->member_info['member_id'];

        //判断是否已经收藏
        $favorites_info = $model_favorites->getOneFavorites($condition);
        if(empty($favorites_info)){
            output_error('收藏删除失败');
        }

        $model_favorites->delFavorites($condition);

        $model_store->editStore(array(
            'store_collect' => array('exp', 'store_collect - 1'),
        ), array(
            'store_id' => $fav_id,
            'store_collect' => array('gt', 0),
        ));

        output_data('1');
    }

}
