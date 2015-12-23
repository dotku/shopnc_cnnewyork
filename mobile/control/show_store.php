<?php
/**
 * 会员店铺
 *
 * 二十四小时在线技术Q：76809326 
 *
 * by 运维舫 www.shopnc.club 运营版
 */

defined('InShopNC') or exit('Access Invalid!');

class show_storeControl extends BaseStoreControl{
	public function __construct(){
		parent::__construct();
	}
	public function indexOp(){
            $goods_class = Model('goods');
            $condition = array();
            $condition['store_id'] = $this->store_info['store_id'];
            $model_goods = Model('goods'); // 字段
            $fieldstr = "goods_id,goods_commonid,goods_name,goods_jingle,store_id,store_name,goods_price,goods_promotion_price,goods_marketprice,goods_storage,goods_image,goods_freight,goods_salenum,color_id,evaluation_good_star,evaluation_count,goods_promotion_type";
			$fieldstr .= ',is_virtual,is_presell,is_fcode,have_gift';
            //得到最新12个商品列表
            $new_goods_list = $model_goods->getGoodsListByColorDistinct($condition, $fieldstr, 'goods_id desc', 12);
            $condition['goods_commend'] = 1;
            //得到12个推荐商品列表
            $recommended_goods_list = $model_goods->getGoodsListByColorDistinct($condition, $fieldstr, 'goods_id desc', 12);
            $goods_list = $this->getGoodsMore($new_goods_list, $recommended_goods_list);
			$show_sto['new_goods'] = $goods_list[1];
			$show_sto['recommended_goods'] = $goods_list[2];
			//获取缩略图
			foreach($show_sto['recommended_goods'] as $k => $v){
			$v['url'] =  thumb($v, 240);
			$arr[] = $v;
			}
			$show_store['goods_list_info']['recommended_goods_list'] = $arr;
            
			foreach($show_sto['new_goods'] as $kk => $vv){
			$vv['url'] =  thumb($vv, 240);
			$arrr[] = $vv;
			}
			$show_store['goods_list_info']['new_goods_list'] = $arrr;

            //幻灯片图片
            if($this->store_info['store_slide'] != '' && $this->store_info['store_slide'] != ',,,,'){
				$show_store['goods_list_info']['store_slide'] = explode(',', $this->store_info['store_slide']);
				$show_store['goods_list_info']['store_slide_url'] = explode(',', $this->store_info['store_slide_url']);
				
            }
		$condon = array();
		foreach($this->goods_wep_list as $value){
			$condon[] = $value;
			}
		if (trim($_POST['key']) != '') {
          $model_mb_user_token = Model('mb_user_token');
		  $key = trim($_POST['key']);
		  $mb_user_token_info = $model_mb_user_token->getMbUserTokenInfoByToken($key);
		  $kkyy = $mb_user_token_info['member_id'];
        }
			
		if ($kkyy > 0){
			$favorites_model = Model('favorites');
			$favorites_info = $favorites_model->getOneFavorites(array('fav_id'=>$this->store_info['store_id'],'fav_type'=>'store','member_id'=>$kkyy));
			if(!empty($favorites_info)) {
            $memberid = '1';
			$store_model = Model('store');
			$store_list = $store_model->getStoreList(array('store_id'=>array('in', $this->store_info['store_id'])));
		    }else{
				$memberid ='0';
				}
			}
		// 轮播
		if($this->store_info['mb_sliders']){
        $mbSliders = $this->getStoreMbSliders($this->store_info['store_id']);
		$mbSliderUrls = array();
        foreach ($mbSliders as $k => $v) {
            if ($v['img']) {
            $mbSliderUrls[$k]['imgUrl'] = UPLOAD_SITE_URL.DS.ATTACH_STORE.DS.$v['img'];
			$mbSliderUrls[$k]['img'] = $v['img'];
			$mbSliderUrls[$k]['link'] = $v['link'];
			$mbSliderUrls[$k]['type'] = $v['type'];
            }
        }
		}
			if($this->store_info['mb_title_img']){
				$show_store['goods_list_info']['goods_store']['mb_title_img'] = UPLOAD_SITE_URL.DS.ATTACH_STORE.DS.$this->store_info['mb_title_img'];
				}
		$show_store['goods_list_info']['goods_store']['store_collect'] = $store_list[0]['store_collect'];	
		$show_store['goods_list_info']['goods_store']['member_id'] = $memberid;
		$show_store['goods_list_info']['goods_wep_list'] = $condon;
		$show_store['goods_list_info']['goods_store']['store_id'] = $this->store_info['store_id'];
		$show_store['goods_list_info']['goods_store']['store_name'] = $this->store_info['store_name'];
		$show_store['goods_list_info']['goods_store']['store_company_name'] = $this->store_info['store_company_name'];
		$show_store['goods_list_info']['goods_store']['area_info'] = $this->store_info['area_info'];
		$show_store['goods_list_info']['goods_store']['store_address'] = $this->store_info['store_address'];
		$show_store['goods_list_info']['goods_store']['store_banner'] = $this->store_info['store_banner'];
		$show_store['goods_list_info']['goods_store']['store_avatar'] = $this->store_info['store_avatar'];
		$show_store['goods_list_info']['goods_store']['store_qq'] = $this->store_info['store_qq'];
		$show_store['goods_list_info']['goods_store']['store_ww'] = $this->store_info['store_ww'];
		$show_store['goods_list_info']['goods_store']['store_phone'] = $this->store_info['store_phone'];//mb_title_img
		
		$show_store['goods_list_info']['goods_store']['mb_sliders'] = $mbSliderUrls;
		$show_store['goods_list_info']['goods_store']['store_credit'] = $this->store_info['store_credit'];
		$show_store['goods_list_info']['goods_store']['store_labell'] = $this->store_info['store_label'];
		$show_store['goods_list_info']['goods_store']['store_credit_average'] = $this->store_info['store_credit_average'];
		$show_store['goods_list_info']['goods_store']['store_credit_percent'] = $this->store_info['store_credit_percent'];
        $show_store['goods_list_info']['goods_store']['store_label'] = getStoreLogo($show_store['goods_list_info']['goods_store']['store_labell'],'store_logo');

		output_data($show_store);
    }
    protected function getStoreMbSliders($store_id)
    {
        $store_info = Model('store')->getStoreInfoByID($store_id);

        $mbSliders = @unserialize($store_info['mb_sliders']);
        if (!$mbSliders) {
            $mbSliders = array_fill(1, self::MAX_MB_SLIDERS, array(
                'img' => '',
                'type' => 1,
                'link' => '',
            ));
        }

        return $mbSliders;
    }
    private function getGoodsMore($goods_list1, $goods_list2 = array()) {
        if (!empty($goods_list2)) {
            $goods_list = array_merge($goods_list1, $goods_list2);
        } else {
            $goods_list = $goods_list1;
        }
        // 商品多图
        if (!empty($goods_list)) {
            $goodsid_array = array();       // 商品id数组
            $commonid_array = array(); // 商品公共id数组
            $storeid_array = array();       // 店铺id数组
            foreach ($goods_list as $value) {
                $goodsid_array[] = $value['goods_id'];
                $commonid_array[] = $value['goods_commonid'];
                $storeid_array[] = $value['store_id'];
            }
            $goodsid_array = array_unique($goodsid_array);
            $commonid_array = array_unique($commonid_array);

            // 商品多图
            $goodsimage_more = Model('goods')->getGoodsImageList(array('goods_commonid' => array('in', $commonid_array)));

            foreach ($goods_list1 as $key => $value) {
                // 商品多图
                foreach ($goodsimage_more as $v) {
                    if ($value['goods_commonid'] == $v['goods_commonid'] && $value['store_id'] == $v['store_id'] && $value['color_id'] == $v['color_id']) {
                        $goods_list1[$key]['image'][] = $v;
                    }
                }
            }

            if (!empty($goods_list2)) {
                foreach ($goods_list2 as $key => $value) {
                    // 商品多图
                    foreach ($goodsimage_more as $v) {
                        if ($value['goods_commonid'] == $v['goods_commonid'] && $value['store_id'] == $v['store_id'] && $value['color_id'] == $v['color_id']) {
                            $goods_list2[$key]['image'][] = $v;
                        }
                    }
                }
            }
        }
        return array(1=>$goods_list1,2=>$goods_list2);
    }

	/**
	 * 全部商品
	 */
	public function goods_allOp(){

		$condition = array();
        $condition['store_id'] = $this->store_info['store_id'];
        if (trim($_GET['inkeyword']) != '') {
            $condition['goods_name'] = array('like', '%'.trim($_GET['inkeyword']).'%');
        }

		// 排序
        $order = $_GET['order'] == 1 ? 'asc' : 'desc';
		switch (trim($_GET['key'])){
			case '1':
				$order = 'goods_id '.$order;
				break;
			case '2':
				$order = 'goods_promotion_price '.$order;
				break;
			case '3':
				$order = 'goods_salenum '.$order;
				break;
			case '4':
				$order = 'goods_click '.$order;
				break;
			default:
				$order = 'goods_id desc';
				break;
		}

		//查询分类下的子分类
		if (intval($_GET['stc_id']) > 0){
		    $condition['goods_stcids'] = array('like', '%,' . intval($_GET['stc_id']) . ',%');
		}

		$model_goods = Model('goods');
		$fieldstr = "goods_id,goods_commonid,goods_name,goods_jingle,store_id,store_name,goods_price,goods_promotion_price,goods_marketprice,goods_storage,goods_image,goods_freight,goods_salenum,color_id,evaluation_good_star,evaluation_count,goods_promotion_type";
		$fieldstr .= ',is_virtual,is_presell,is_fcode,have_gift';

        $recommended_goods_list = $model_goods->getGoodsListByColorDistinct($condition, $fieldstr, $order, 10);
		$page_count = $model_goods->gettotalpage();
        $recommended_goods_list = $this->getGoodsMore($recommended_goods_list);
		$show_store['recommended_goods_list'] = $recommended_goods_list[1];
		//输出分页
		$stc_class = Model('store_goods_class');
		$stc_info = $stc_class->getStoreGoodsClassInfo(array('stc_id' => intval($_GET['stc_id'])));
		$show_store['stc_name'] = $stc_info['stc_name'];
		$goods_list = $this->_goods_list_extend($recommended_goods_list[1]);
		$store_name = $this->store_detail($condition['store_id']);
		
		output_data(array('goods_list' => $goods_list,'store_name' => $store_name), mobile_page($page_count));
	}
 /**
     * 处理商品列表(商品图片)
     */
    private function _goods_list_extend($goods_list) {
        foreach ($goods_list as $key => $value) {
            //商品图片url
            $goods_list[$key]['goods_image_url'] = cthumb($value['goods_image'], 360, $value['store_id']);
        }
        return $goods_list;
    }
		 /**
     * 店铺信息
     */
     private function store_detail($store_id) {
        // 店铺
        $model_store = Model('store');
        $store_info = $model_store->getStoreOnlineInfoByID($store_id);
        $store_id = $store_info['store_name'];
		return $store_id;
    }
	/**
	 * ajax获取动态数量
	 */
	function ajax_store_trend_countOp(){
		$count = Model('store_sns_tracelog')->getStoreSnsTracelogCount(array('strace_storeid'=>$this->store_info['store_id']));
		echo json_encode(array('count'=>$count));exit;
	}
	/**
	 * ajax 店铺流量统计入库
	 */
	public function ajax_flowstat_recordOp(){
	    $store_id = intval($_GET['store_id']);
	    if ($store_id <= 0 || $_SESSION['store_id'] == $store_id){
	        echo json_encode(array('done'=>true,'msg'=>'done')); die;
	    }
		//确定统计分表名称
		$last_num = $store_id % 10; //获取店铺ID的末位数字
		$tablenum = ($t = intval(C('flowstat_tablenum'))) > 1 ? $t : 1; //处理流量统计记录表数量
		$flow_tablename = ($t = ($last_num % $tablenum)) > 0 ? "flowstat_$t" : 'flowstat';
		//判断是否存在当日数据信息
		$stattime = strtotime(date('Y-m-d',time()));
		$model = Model('stat');
		//查询店铺流量统计数据是否存在
		$store_exist = $model->getoneByFlowstat($flow_tablename,array('stattime'=>$stattime,'store_id'=>$store_id,'type'=>'sum'));
		if ($_GET['act_param'] == 'goods' && $_GET['op_param'] == 'index'){//统计商品页面流量
		    $goods_id = intval($_GET['goods_id']);
		    if ($goods_id <= 0){
		        echo json_encode(array('done'=>false,'msg'=>'done')); die;
		    }
		    $goods_exist = $model->getoneByFlowstat($flow_tablename,array('stattime'=>$stattime,'goods_id'=>$goods_id,'type'=>'goods'));
		}
		//向数据库写入访问量数据
		$insert_arr = array();
		if($store_exist){
		    $model->table($flow_tablename)->where(array('stattime'=>$stattime,'store_id'=>$store_id,'type'=>'sum'))->setInc('clicknum',1);
		} else {
		    $insert_arr[] = array('stattime'=>$stattime,'clicknum'=>1,'store_id'=>$store_id,'type'=>'sum','goods_id'=>0);
		}
		if ($_GET['act_param'] == 'goods' && $_GET['op_param'] == 'index'){//已经存在数据则更新
		    if ($goods_exist){
		        $model->table($flow_tablename)->where(array('stattime'=>$stattime,'goods_id'=>$goods_id,'type'=>'goods'))->setInc('clicknum',1);
		    } else {
		        $insert_arr[] = array('stattime'=>$stattime,'clicknum'=>1,'store_id'=>$store_id,'type'=>'goods','goods_id'=>$goods_id);
		    }
		}
		if ($insert_arr){
		    $model->table($flow_tablename)->insertAll($insert_arr);
		}
		echo json_encode(array('done'=>true,'msg'=>'done'));
	}
}
?>
