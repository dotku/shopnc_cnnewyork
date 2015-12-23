<?php
/**
 * mobile父类
 *
 * 二十四小时在线技术Q：76809326 
 *
 * by 运维舫 www.shopnc.club 运营版
 */

defined('InShopNC') or exit('Access Invalid!');

/********************************** 前台control父类 **********************************************/

class mobileControl{

    //客户端类型
    protected $client_type_array = array('android', 'wap', 'wechat', 'ios');
    //列表默认分页数
    protected $page = 5;


	public function __construct() {
        Language::read('mobile');

        //分页数处理
        $page = intval($_GET['page']);
        if($page > 0) {
            $this->page = $page;
        }
    }
}

class mobileHomeControl extends mobileControl{
	public function __construct() {
        parent::__construct();
    }
}
class mobileSearchControl extends mobileControl{
	protected $member_id = 0;
	public function __construct() {
        parent::__construct();
		//判断是否登陆
		$key = $_COOKIE['key'];
        if(!empty($key)) {
		  $mb_user_token_info =  Model('mb_user_token')->getMbUserTokenInfoByToken($key);
        if(empty($mb_user_token_info)) {
            output_error('非法参数', array('qunashop' => '0'));
        }else{
        $this->member_id = $mb_user_token_info['member_id']; 	
        }
		}
		
		
    }
}
class mobileMemberControl extends mobileControl{

    protected $member_info = array();

	public function __construct() {
        parent::__construct();

        $model_mb_user_token = Model('mb_user_token');
        $key = $_POST['key'];
        if(empty($key)) {
            $key = $_GET['key'];
        }
        $mb_user_token_info = $model_mb_user_token->getMbUserTokenInfoByToken($key);
        if(empty($mb_user_token_info)) {
            output_error('请登录', array('login' => '0'));
        }

        $model_member = Model('member');
        $this->member_info = $model_member->getMemberInfoByID($mb_user_token_info['member_id']);
        $this->member_info['client_type'] = $mb_user_token_info['client_type'];
        if(empty($this->member_info)) {
            output_error('请登录', array('login' => '0'));
        } else {
            //读取卖家信息
            $seller_info = Model('seller')->getSellerInfo(array('member_id'=>$this->member_info['member_id']));
            $this->member_info['store_id'] = $seller_info['store_id'];
        }
    }
}

class Control extends mobileControl{
    /**
     * 检查短消息数量
     *
     */
	 	public function __construct() {
        parent::__construct();
    
}
    protected function checkMessage() {
        if($_SESSION['member_id'] == '') return ;
        //判断cookie是否存在
        $cookie_name = 'msgnewnum'.$_SESSION['member_id'];
        if (cookie($cookie_name) != null){
            $countnum = intval(cookie($cookie_name));
        }else {
            $message_model = Model('message');
            $countnum = $message_model->countNewMessage($_SESSION['member_id']);
            setNcCookie($cookie_name,"$countnum",2*3600);//保存2小时
        }
    }

    /**
     *  输出头部的公用信息
     *
     */
    protected function showLayout() {
        $this->checkMessage();//短消息检查
        $this->article();//文章输出

        $this->showCartCount();

        $model_class = Model('goods_class');
        $goods_class = $model_class->get_all_category();
    }

    /**
     * 显示购物车数量
     */
    protected function showCartCount() {
        if (cookie('cart_goods_num') != null){
            $cart_num = intval(cookie('cart_goods_num'));
        }else {
            //已登录状态，存入数据库,未登录时，优先存入缓存，否则存入COOKIE
            if($_SESSION['member_id']) {
                $save_type = 'db';
            } else {
                $save_type = 'cookie';
            }
            $cart_num = Model('cart')->getCartNum($save_type,array('buyer_id'=>$_SESSION['member_id']));//查询购物车商品种类
        }
    }

    /**
     * 输出会员等级
     * @param bool $is_return 是否返回会员信息，返回为true，输出会员信息为false
     */
    protected function getMemberAndGradeInfo($is_return = false){
        $member_info = array();
        //会员详情及会员级别处理
        if($_SESSION['member_id']) {
            $model_member = Model('member');
            $member_info = $model_member->getMemberInfoByID($_SESSION['member_id']);
            if ($member_info){
                $member_gradeinfo = $model_member->getOneMemberGrade(intval($member_info['member_exppoints']));
                $member_info = array_merge($member_info,$member_gradeinfo);
            }
        }
        if ($is_return == true){//返回会员信息
            return $member_info;
        } else {//输出会员信息
            //output('member_info',$member_info);
        }
    }

    /**
     * 验证会员是否登录
     *
     */
    protected function checkLogin(){
        if ($_SESSION['is_login'] !== '1'){
            if (trim($_GET['op']) == 'favoritesgoods' || trim($_GET['op']) == 'favoritesstore'){
                $lang = Language::getLangContent('UTF-8');
                echo json_encode(array('done'=>false,'msg'=>$lang['no_login']));
                die;
            }
            $ref_url = request_uri();
            if ($_GET['inajax']){
                showDialog('','','js',"login_dialog();",200);
            }else {
                @header("location: index.php?act=login&ref_url=".urlencode($ref_url));
            }
            exit;
        }
    }

    /**
     * 添加到任务队列
     *
     * @param array $goods_array
     * @param boolean $ifdel 是否删除以原记录
     */
    protected function addcron($data = array(), $ifdel = false) {
        $model_cron = Model('cron');
        if (isset($data[0])) { // 批量插入
            $where = array();
            foreach ($data as $k => $v) {
                if (isset($v['content'])) {
                    $data[$k]['content'] = serialize($v['content']);
                }
                // 删除原纪录条件
                if ($ifdel) {
                    $where[] = '(type = ' . $data['type'] . ' and exeid = ' . $data['exeid'] . ')';
                }
            }
            // 删除原纪录
            if ($ifdel) {
                $model_cron->delCron(implode(',', $where));
            }
            $model_cron->addCronAll($data);
        } else { // 单条插入
            if (isset($data['content'])) {
                $data['content'] = serialize($data['content']);
            }
            // 删除原纪录
            if ($ifdel) {
                $model_cron->delCron(array('type' => $data['type'], 'exeid' => $data['exeid']));
            }
            $model_cron->addCron($data);
        }
    }

    //文章输出
    protected function article() {

        if (C('cache_open')) {
            if ($article = rkcache("index/article")) {
                return;
            }
        } else {
            if (file_exists(BASE_DATA_PATH.'/cache/index/article.php')){
                include(BASE_DATA_PATH.'/cache/index/article.php');
                return;
            }
        }

        $model_article_class	= Model('article_class');
        $model_article	= Model('article');
        $show_article = array();//商城公告
        $article_list	= array();//下方文章
        $notice_class	= array('notice');
        $code_array	= array('member','store','payment','sold','service','about');
        $notice_limit	= 5;
        $faq_limit	= 5;

        $class_condition	= array();
        $class_condition['home_index'] = 'home_index';
        $class_condition['order'] = 'ac_sort asc';
        $article_class	= $model_article_class->getClassList($class_condition);
        $class_list	= array();
        if(!empty($article_class) && is_array($article_class)){
            foreach ($article_class as $key => $val){
                $ac_code = $val['ac_code'];
                $ac_id = $val['ac_id'];
                $val['list']	= array();//文章
                $class_list[$ac_id]	= $val;
            }
        }

        $condition	= array();
        $condition['article_show'] = '1';
        $condition['home_index'] = 'home_index';
        $condition['field'] = 'article.article_id,article.ac_id,article.article_url,article.article_title,article.article_time,article_class.ac_name,article_class.ac_parent_id';
        $condition['order'] = 'article_sort asc,article_time desc';
        $condition['limit'] = '300';
        $article_array	= $model_article->getJoinList($condition);
        if(!empty($article_array) && is_array($article_array)){
            foreach ($article_array as $key => $val){
                $ac_id = $val['ac_id'];
                $ac_parent_id = $val['ac_parent_id'];
                if($ac_parent_id == 0) {//顶级分类
                    $class_list[$ac_id]['list'][] = $val;
                } else {
                    $class_list[$ac_parent_id]['list'][] = $val;
                }
            }
        }
        if(!empty($class_list) && is_array($class_list)){
            foreach ($class_list as $key => $val){
                $ac_code = $val['ac_code'];
                if(in_array($ac_code,$notice_class)) {
                    $list = $val['list'];
                    array_splice($list, $notice_limit);
                    $val['list'] = $list;
                    $show_article[$ac_code] = $val;
                }
                if (in_array($ac_code,$code_array)){
                    $list = $val['list'];
                    $val['class']['ac_name']	= $val['ac_name'];
                    array_splice($list, $faq_limit);
                    $val['list'] = $list;
                    $article_list[] = $val;
                }
            }
        }

        if (C('cache_open')) {
            wkcache('index/article', array(
                'show_article' => $show_article,
                'article_list' => $article_list,
            ));
        } else {
            $string = "<?php\n\$show_article=".var_export($show_article,true).";\n";
            $string .= "\$article_list=".var_export($article_list,true).";\n?>";
            file_put_contents(BASE_DATA_PATH.'/cache/index/article.php',($string));
        }
    }
}


class BaseStoreControl extends Control {
    protected $goods_wep_list;
    protected $store_info;
    protected $store_decoration_only = false;
  
    public function __construct(){
    parent::__construct();
        //输出会员信息
        $this->getMemberAndGradeInfo(false);

        $store_id = intval($_GET['store_id']);
        if($store_id <= 0) {
            //showMessage(L('nc_store_close'), '', '', 'error');
			output_error('该店铺已关闭');
        }

        $model_store = Model('store');
        $store_info = $model_store->getStoreOnlineInfoByID($store_id);
        if(empty($store_info)) {
		   output_error('该店铺已关闭');
        } else {
            $this->store_info = $store_info;
        }
        if($store_info['store_decoration_switch'] > 0 & $store_info['store_decoration_only'] == 1) {
            $this->store_decoration_only = true;
        }

        //店铺装修
        $this->outputStoreInfo($store_info);
    }

    /**
     * 输出店铺装修
     */
    protected function outputStoreDecoration($decoration_id, $store_id) {
        if($decoration_id > 0 ) {
            $model_store_decoration = Model('store_decoration');

            $decoration_info = $model_store_decoration->getStoreDecorationInfoDetail($decoration_id, $store_id);
            if($decoration_info) {
                $decoration_background_style = $model_store_decoration->getDecorationBackgroundStyle($decoration_info['decoration_setting']);

                $html_file = BASE_UPLOAD_PATH.DS.ATTACH_STORE.DS.'decoration'.DS.'html'.DS.md5($store_id).'.html';
                if(is_file($html_file)) {
                }

            }
        } else {
            //output('store_theme', $this->store_info['store_theme']);
        }
    }

    /**
     * 检查店铺开启状态
     *
     * @param int $store_id 店铺编号
     * @param string $msg 警告信息
     */
    protected function outputStoreInfo($store_info){
            //店铺分类
            $goodsclass_model = Model('store_goods_class');
            $goods_class_list = $goodsclass_model->getShowTreeList($store_info['store_id']);
			$this->goods_wep_list = $goods_class_list;
    }


}

class BaseHomeControl extends mobileControl {
    	public function __construct() {
        parent::__construct();		
        if ($_GET['column'] && strtoupper(CHARSET) == 'GBK'){
            $_GET = Language::getGBK($_GET);
        }
        if(!C('site_status')) halt(C('closed_reason'));
    }
}