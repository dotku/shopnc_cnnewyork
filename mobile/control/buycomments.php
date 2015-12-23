<?php
/**
 * 商品
 *
 * 二十四小时在线技术Q：76809326 
 *
 * by 运维舫 www.shopnc.club 运营版
 */
defined('InShopNC') or exit('Access Invalid!');
class buycommentsControl extends mobileHomeControl{

	public function __construct() {
        parent::__construct();
    }
  /**
     * 商品评价详细页
     */
    public function comments_listOp() {
        $goods_id = intval($_GET['goods_id']);

        // 商品详细信息
        $model_goods = Model('goods');
        $goods_info = $model_goods->getGoodsInfoByID($goods_id, '*');

        // 验证商品是否存在
        if (empty($goods_info)) {
			output_error('商品不存在');
        }


        //评价信息
        $goods_evaluate_info = Model('evaluate_goods')->getEvaluateGoodsInfoByGoodsID($goods_id);
        $buy_comments['goods_evaluate_info']['good'] = $goods_evaluate_info['good'];
		$buy_comments['goods_evaluate_info']['normal'] = $goods_evaluate_info['normal'];
		$buy_comments['goods_evaluate_info']['bad'] = $goods_evaluate_info['bad'];
		$buy_comments['goods_evaluate_info']['all'] = $goods_evaluate_info['all'];
		$buy_comments['goods_evaluate_info']['good_percent'] = $goods_evaluate_info['good_percent'];
		$buy_comments['goods_evaluate_info']['normal_percent'] = $goods_evaluate_info['normal_percent'];
		$buy_comments['goods_evaluate_info']['bad_percent'] = $goods_evaluate_info['bad_percent'];
		$buy_comments['goods_evaluate_info']['good_star'] = $goods_evaluate_info['good_star'];
		$buy_comments['goods_evaluate_info']['star_average'] = $goods_evaluate_info['star_average'];

        $buy_comments['comments'] = $this->_get_comments($goods_id, $_GET['type'], 5);
		$buy_comments['goods_evaluate_info']['page'] = $this->_getcomments($goods_id, $_GET['type'], 5);
		if(empty($buy_comments['comments'])){
			output_error('暂时没有评论');};
		if($buy_comments['goods_evaluate_info']['page']['page'] >  $buy_comments['goods_evaluate_info']['page']['show_pa']){
			$buy_comments['comments'] = null;
			}
			
		output_data($buy_comments);
    }

    private function _get_comments($goods_id, $type, $page) {
        $condition = array();
        $condition['geval_goodsid'] = $goods_id;
        switch ($type) {
            case '1':
                $condition['geval_scores'] = array('in', '5,4');
				$goodsevallist['goods_evaluate_info']['type'] = '1';
                break;
            case '2':
                $condition['geval_scores'] = array('in', '3,2');
				$goodsevallist['goods_evaluate_info']['type'] = '2';
                break;
            case '3':
                $condition['geval_scores'] = array('in', '1');
				$goodsevallist['goods_evaluate_info']['type'] = '3';
                break;
        }

        //查询商品评分信息
        $model_evaluate_goods = Model("evaluate_goods");
        $goodsevallistt = $model_evaluate_goods->getEvaluateGoodsList($condition, $page);
		foreach($goodsevallistt as $k => $v){
			$v['geval_addtime'] =  date('Y-m-d H:i',$v['geval_addtime']);
			$arr[] = $v;
			}
		$goodsevallist = $arr;
		return $goodsevallist;
    }		 
    private function _getcomments($goods_id, $type, $page) {
        $condition = array();
        $condition['geval_goodsid'] = $goods_id;
        switch ($type) {
            case '1':
                $condition['geval_scores'] = array('in', '5,4');
				$goodsevallist['goods_evaluate_info']['type'] = '1';
                break;
            case '2':
                $condition['geval_scores'] = array('in', '3,2');
				$goodsevallist['goods_evaluate_info']['type'] = '2';
                break;
            case '3':
                $condition['geval_scores'] = array('in', '1');
				$goodsevallist['goods_evaluate_info']['type'] = '3';
                break;
        }

        //查询商品评分信息
        $model_evaluate_goods = Model("evaluate_goods");
        $model_evaluate_goods->getEvaluateGoodsList($condition, $page);
		//分页总数 
		$goodlist['show_page'] = $model_evaluate_goods->gettotalnum();
		//总页数
		$goodlist['show_pa'] = $model_evaluate_goods->gettotalpage();
		$goodlist['page'] = intval($_GET['curpage']);
		return $goodlist;
    }		 
}
