<?php
/**
 * 多频道 v3-b12 
 *
 */


defined('InShopNC') or exit('Access Invalid!');
class channelControl extends BaseHomeControl {
    public function __construct() {
        parent::__construct();
    }
    /**
     * 频道页
     *
     */
    public function indexOp() {
        $model_channel = Model('web_channel');
        $condition = array();
        $condition['channel_id'] = intval($_GET['id']);
        $condition['channel_show'] = 1;
        $channel_list = $model_channel->getChannelList($condition);
        $channel = $channel_list[0];
        Tpl::output('channel',$channel);
        if ($channel['gc_id'] > 0) {
            $gc_id = $channel['gc_id'];
            $model_class = Model('goods_class');
            $class_array = $model_class->getGoodsClassInfoById($gc_id);
            Tpl::output('gc_name',$class_array['gc_name']);
            Tpl::output('gc_id',$gc_id);
        }
        $web_html = $model_channel->getChannelHtml($channel);
        Tpl::output('web_html',$web_html);
        Tpl::output('html_title',$channel['channel_name'].' - '.C('site_name'));
        Tpl::output('seo_keywords',$channel['keywords'] ? $channel['keywords'] : C('site_name'));
        Tpl::output('seo_description',$channel['description'] ? $channel['description'] : C('site_name'));
        Tpl::showpage('channel');
    }
    /**
     * 促销
     *
     */
    public function get_right_listOp(){
        $gc_id = intval($_GET['gc_id']);
        $condition = array();
        $condition['gc_id'] = $gc_id;
        $condition['goods_promotion_type'] = 1;//促销类型 0无促销，1团购，2限时折扣
        $model_goods = Model('goods');
        $field = 'goods_commonid';
        $goods_list = array();
        $list = $model_goods->getGoodsListByColorDistinct($condition,$field,'goods_edittime desc',100);

        if(!empty($list) && is_array($list)) {
            foreach($list as $k => $v) {
                $goods_commonid = $v['goods_commonid'];
                $goods_list[$goods_commonid] = $goods_commonid;
            }
        }

        Language::read('member_groupbuy');
        $model_groupbuy = Model('groupbuy');
        $condition = array();
        $condition['goods_commonid'] = array('in',$goods_list);
        $condition['is_vr'] = 0;
        $group_list = $model_groupbuy->getGroupbuyOnlineList($condition, 5, 'recommended desc');
        Tpl::output('group_list', $group_list);

        if (empty($group_list)) {//无团购数据时调用限时折扣
            $condition = array();
            $condition['gc_id'] = $gc_id;
            $condition['goods_promotion_type'] = 2;//促销类型 0无促销，1团购，2限时折扣
            $model_goods = Model('goods');
            $field = 'goods_id';
            $goods_list = array();
            $list = $model_goods->getGoodsOnlineList($condition,$field,100,'goods_edittime desc');

            if(!empty($list) && is_array($list)) {
                foreach($list as $k => $v) {
                    $goods_id = $v['goods_id'];
                    $goods_list[$goods_id] = $goods_id;
                }
            }
            $model_xianshi_goods = Model('p_xianshi_goods');
            $condition = array();
            $condition['goods_id'] = array('in',$goods_list);
            $xianshi_item = $model_xianshi_goods->getXianshiGoodsExtendList($condition,5,'xianshi_recommend desc');
            Tpl::output('xianshi_item', $xianshi_item);
        }

        Tpl::showpage('channel_right','null_layout');
    }

}
