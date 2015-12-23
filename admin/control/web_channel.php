<?php
/**
 * 频道管理 
 * 好商城v3-v12
 */
defined('InShopNC') or exit('Access Invalid!');
class web_channelControl extends SystemControl{
    private $links = array(
        array('url'=>'act=web_channel&op=web_channel','lang'=>'web_config_web_channel'),
        array('url'=>'act=web_channel&op=floor_list','lang'=>'web_config_floor_list')
    );
    public function __construct(){
        parent::__construct();
        Language::read('web_config');
    }

    public function indexOp() {
        $this->web_channelOp();
    }

    /**
     * 频道列表
     */
    public function web_channelOp() {
        Tpl::output('top_link',$this->sublink($this->links, 'web_channel'));
        Tpl::showpage('web_channel.list');
    }

    /**
     * 输出频道列表XML数据
     */
    public function get_channel_xmlOp() {
        $model_channel = Model('web_channel');
        $model_web_config = Model('web_con');
        $style_array = $model_web_config->getStyleList();//板块样式数组

        $page = intval($_POST['rp']);
        if ($page < 1) {
            $page = 15;
        }
        $condition = array();
        if ($_POST['qtype'] == 'channel_name') {
            $condition[$_POST['qtype']] = array('like', '%' . trim($_POST['query']) . '%');
        }
        $list = $model_channel->getChannelList($condition,$page);
        $out_list = array();
        if (!empty($list) && is_array($list)){
            $fields_array = array('channel_name','channel_style','gc_name','channel_show');
            foreach ($list as $k => $v){
                $out_array = getFlexigridArray(array(),$fields_array,$v,$format_array='');
                $out_array['channel_style'] = $style_array[$v['channel_style']];
                if ($v['gc_id'] == 0) {
                    $out_array['gc_name'] = '无';
                }
                if ($v['channel_show'] == 1) {
                    $out_array['channel_show'] = '<span class="yes"><i class="fa fa-check-circle"></i>是</span>';
                } else {
                    $out_array['channel_show'] = '<span class="no"><i class="fa fa-ban"></i>否</span>';
                }
                $operation = '';
                if ($v['channel_show'] == 1) {
                    $operation .= '<a class="btn green" href="'.urlShop('channel','index',array('id'=> $v['channel_id'])).'" target="_blank"><i class="fa fa-list-alt"></i>查看</a>';
                } else {
                    $operation .= '<a class="btn red" href="javascript:fg_operation_del('.$v['channel_id'].');"><i class="fa fa-trash-o"></i>删除</a>';
                }
                $operation .= '<span class="btn"><em><i class="fa fa-cog"></i>设置<i class="arrow"></i></em><ul>';
                $operation .= '<li><a href="index.php?act=web_channel&op=edit_channel&channel_id='.$v['channel_id'].'">基本设置</a></li>';
                $operation .= '<li><a href="index.php?act=web_channel&op=set_channel&channel_id='.$v['channel_id'].'">编辑模块</a></li>';
                $operation .= '</ul></span>';

                $out_array['operation'] = $operation;
                $out_list[$v['channel_id']] = $out_array;
            }
        }

        $data = array();
        $data['now_page'] = $model_channel->gettotalpage();
        $data['total_num'] = $model_channel->gettotalnum();
        $data['list'] = $out_list;
        echo Tpl::flexigridXML($data);exit();
    }

    /**
     * 模块列表
     */
    public function floor_listOp() {
		
        Tpl::output('top_link',$this->sublink($this->links, 'floor_list'));
        Tpl::showpage('web_floor.list');
    }

    /**
     * 输出模块列表XML数据
     */
    public function get_floor_xmlOp() {
        $model_channel = Model('web_channel');
        $style_array = $model_channel->getFloorStyle();//模块类型数组

        $page = intval($_POST['rp']);
        if ($page < 1) {
            $page = 15;
        }
        $condition = array();
        if ($_POST['qtype'] == 'web_name') {
            $condition[$_POST['qtype']] = array('like', '%' . trim($_POST['query']) . '%');
        }
        $list = $model_channel->getFloorList($condition,$page);
        $out_list = array();
        if (!empty($list) && is_array($list)){
            $fields_array = array('web_name','web_page','update_time','web_show');
            foreach ($list as $k => $v){
                $out_array = getFlexigridArray(array(),$fields_array,$v,$format_array='');
                $out_array['web_page'] = $style_array[$v['web_page']];
                $out_array['update_time'] = date('Y-m-d H:i:s',$v['update_time']);
                if ($v['web_show'] == 1) {
                    $out_array['web_show'] = '<span class="yes"><i class="fa fa-check-circle"></i>是</span>';
                } else {
                    $out_array['web_show'] = '<span class="no"><i class="fa fa-ban"></i>否</span>';
                }
                $operation = '';
                $operation .= '<a class="btn purple" href="index.php?act=web_channel&op=edit_floor&web_id='.$v['web_id'].'"><i class="fa fa-cog"></i>设置</a>';
                $operation .= '<a class="btn orange" href="index.php?act=web_channel&op=edit_'.$v['web_page'].'&web_id='.$v['web_id'].'"><i class="fa fa-steam"></i>模块设计</a>';
                $out_array['operation'] = $operation;
                $out_list[$v['web_id']] = $out_array;
            }
        }

        $data = array();
        $data['now_page'] = $model_channel->gettotalpage();
        $data['total_num'] = $model_channel->gettotalnum();
        $data['list'] = $out_list;
        echo Tpl::flexigridXMLfloor($data);exit();
    }

    /**
     * 中部模块数据
     */
    public function get_channel_flOp() {
        $model_channel = Model('web_channel');
        $condition = array();
        if (!empty($_GET['name'])) {
            $condition['web_name'] = array('like', '%' . trim($_GET['name']) . '%');
        }
        $condition['web_page'] = 'channel_fl';
        $condition['web_show'] = 1;
        $floor_list = $model_channel->getFloorList($condition,8);
        Tpl::output('floor_list',$floor_list);
        Tpl::output('show_page',$model_channel->showpage());
        Tpl::showpage('web_channel_fl.list','null_layout');
    }

    /**
     * 新增频道
     */
    public function add_channelOp() {
        $model_channel = Model('web_channel');
        if (chksubmit()) {
            $channel_array = array();
            $channel_array['channel_name'] = $_POST['channel_name'];
            $channel_array['channel_style'] = $_POST['channel_style'];
            $channel_array['keywords'] = $_POST['keywords'];
            $channel_array['description'] = $_POST['description'];
            $channel_array['channel_show'] = intval($_POST['channel_show']);//是否启用,0为否,1为是
            $channel_array['update_time'] = time();

            $state = $model_channel->addChannel($channel_array);
            if ($state) {
                $this->log('新增商城频道，编号'.$state);
                showMessage(Language::get('nc_common_save_succ'),'index.php?act=web_channel&op=web_channel');
            } else {
                showMessage(Language::get('nc_common_save_fail'));
            }
        }
        Tpl::showpage('web_channel.add');
    }

    /**
     * 删除频道
     *
     */
    public function del_channelOp() {
        $id = intval($_GET['channel_id']);
        $model_channel = Model('web_channel');
        $condition = array();
        $condition['channel_id'] = $id;
        $state = $model_channel->delChannel($condition);
        if ($state) {
            $this->log('删除商城频道，编号'.$id);
            exit(json_encode(array('state'=>true,'msg'=>'删除成功')));
        } else {
            exit(json_encode(array('state'=>false,'msg'=>'删除失败')));
        }
    }


    /**
     * 新增模块
     */
    public function add_floorOp() {
        $model_channel = Model('web_channel');
        $style_array = $model_channel->getFloorStyle();//模块类型数组
        Tpl::output('style_array',$style_array);
        if (chksubmit()) {
            $web_array = array();
            $web_array['web_name'] = $_POST['web_name'];
            $web_array['web_page'] = $_POST['web_page'];
            $web_array['web_show'] = intval($_POST['web_show']);//是否启用,0为否,1为是
            $web_array['style_name'] = 'default';
            $web_array['web_sort'] = 255;
            $web_array['update_time'] = time();

            $state = $model_channel->addFloor($web_array);
            if ($state) {
                $this->log('新增商城频道模块，编号'.$state);
                showMessage(Language::get('nc_common_save_succ'),'index.php?act=web_channel&op=floor_list');
            } else {
                showMessage(Language::get('nc_common_save_fail'));
            }
        }
        Tpl::showpage('web_floor.add');
    }

    /**
     * 编辑频道
     */
    public function edit_channelOp() {
        $model_channel = Model('web_channel');
        $condition = array();
        $condition['channel_id'] = intval($_GET['channel_id']);
        $channel_list = $model_channel->getChannelList($condition);
        $channel = $channel_list[0];
        if (chksubmit()) {
            $channel_array = array();
            $channel_array['channel_name'] = $_POST['channel_name'];
            $channel_array['channel_style'] = $_POST['channel_style'];
            $channel_array['keywords'] = $_POST['keywords'];
            $channel_array['description'] = $_POST['description'];
            $channel_array['channel_show'] = intval($_POST['channel_show']);//是否启用,0为否,1为是
            $channel_array['update_time'] = time();

            $state = $model_channel->editChannel($condition, $channel_array);
            if ($state) {
                $this->log('编辑商城频道，编号'.$condition['channel_id']);
                dkcache('channel');
                showMessage(Language::get('nc_common_save_succ'),'index.php?act=web_channel&op=web_channel');
            } else {
                showMessage(Language::get('nc_common_save_fail'));
            }
        }
        Tpl::output('channel',$channel);
        Tpl::showpage('web_channel.edit');
    }

    /**
     * 编辑频道模块
     */
    public function set_channelOp() {
        $model_class = Model('goods_class');
        $parent_goods_class = $model_class->getTreeClassList(2);//商品分类父类列表，只取到第二级
        $parent_class = array();
        if (is_array($parent_goods_class) && !empty($parent_goods_class)){
            foreach ($parent_goods_class as $k => $v){
                $gc_id = $v['gc_id'];
                $parent_class[$gc_id]['parent_name'] = $v['gc_name'];
                $parent_id = $v['gc_parent_id'];
                if ($parent_id > 0) {
                    $parent_class[$gc_id]['parent_name'] = $parent_class[$parent_id]['parent_name'].' > '.$v['gc_name'];
                }
                $parent_goods_class[$k]['gc_name'] = str_repeat("&nbsp;",$v['deep']*2).$v['gc_name'];
            }
        }
        Tpl::output('parent_goods_class',$parent_goods_class);

        $model_channel = Model('web_channel');
        $condition = array();
        $condition['channel_id'] = intval($_GET['channel_id']);
        $channel_list = $model_channel->getChannelList($condition);
        $channel = $channel_list[0];
        if (chksubmit()) {
            $channel_array = array();
            $gc_name = '';
            $floor_ids = '';
            $gc_id = intval($_POST['gc_id']);
            if ($gc_id > 0) {
                $gc_name = $parent_class[$gc_id]['parent_name'];
                $model_channel->editChannelGoodsClass($gc_id);//消除分类已绑定的频道
            }
            $channel_array['gc_id'] = $gc_id;
            $channel_array['gc_name'] = $gc_name;
            $channel_array['top_id'] = $_POST['top_id'];
            if(!empty($_POST['floor_ids']) && is_array($_POST['floor_ids'])) {
                $floor_ids = implode(',', $_POST['floor_ids']);
                $floor_ids = ','.$floor_ids.',';
            }
            $channel_array['floor_ids'] = $floor_ids;
            $channel_array['update_time'] = time();

            $state = $model_channel->editChannel($condition, $channel_array);
            if ($state) {
                $this->log('编辑商城频道，编号'.$condition['channel_id']);
                dkcache('channel');
                showMessage(Language::get('nc_common_save_succ'),'index.php?act=web_channel&op=web_channel');
            } else {
                showMessage(Language::get('nc_common_save_fail'));
            }
        }
        Tpl::output('channel',$channel);

        Tpl::output('gc_id',$channel['gc_id']);
        Tpl::output('top_id',$channel['top_id']);

        $condition = array();
        $condition['web_page'] = 'channel_tp';
        $top_list = $model_channel->getFloorList($condition);
        Tpl::output('top_list',$top_list);

        $floor_list = $model_channel->getChannelFloor($channel['floor_ids']);
        Tpl::output('floor_list',$floor_list);

        Tpl::showpage('web_channel.set');
    }

    /**
     * 编辑模块
     */
    public function edit_floorOp() {
        $model_web_config = Model('web_con');
        $condition = array();
        $condition['web_id'] = intval($_GET['web_id']);
        $web_list = $model_web_config->getWebList($condition);
        $web = $web_list[0];
        if (chksubmit()) {
            $web_array = array();
            $web_array['web_name'] = $_POST['web_name'];
            $web_array['web_show'] = intval($_POST['web_show']);//是否启用,0为否,1为是
            $web_array['update_time'] = time();

            $state = $model_web_config->updateWeb($condition, $web_array);
            if ($state) {
                $model_web_config->updateWebHtml($condition['web_id']);//更新前台显示的html内容
                $this->log('编辑商城频道模块，编号'.$condition['web_id']);
                showMessage(Language::get('nc_common_save_succ'),'index.php?act=web_channel&op=floor_list');
            } else {
                showMessage(Language::get('nc_common_save_fail'));
            }
        }
        Tpl::output('web',$web);
        $model_channel = Model('web_channel');
        $style_array = $model_channel->getFloorStyle();//模块类型数组
        Tpl::output('style_array',$style_array);
        Tpl::showpage('web_floor.edit');
    }

    /**
     * 编辑顶部模块
     */
    public function edit_channel_tpOp() {
        $model_web_config = Model('web_con');
        $web_id = intval($_GET["web_id"]);
        $code_list = $model_web_config->getCodeList(array('web_id'=>"$web_id"));
        if(is_array($code_list) && !empty($code_list)) {
            $model_class = Model('goods_class');
            $parent_goods_class = $model_class->getTreeClassList(2);//商品分类父类列表，只取到第二级
            if (is_array($parent_goods_class) && !empty($parent_goods_class)){
                foreach ($parent_goods_class as $k => $v){
                    $parent_goods_class[$k]['gc_name'] = str_repeat("&nbsp;",$v['deep']*2).$v['gc_name'];
                }
            }
            Tpl::output('parent_goods_class',$parent_goods_class);
            foreach ($code_list as $key => $val) {//将变量输出到页面
                $var_name = $val['var_name'];
                $code_info = $val['code_info'];
                $code_type = $val['code_type'];
                $val['code_info'] = $model_web_config->get_array($code_info,$code_type);
                Tpl::output('code_'.$var_name,$val);
            }
        }
        $floor_list = $model_web_config->getWebList(array('web_id'=>"$web_id"));
        Tpl::output('floor',$floor_list[0]);

        Tpl::showpage('web_channel_tp.edit');
    }

    /**
     * 编辑中部模块
     */
    public function edit_channel_flOp() {
        $model_web_config = Model('web_con');
        $web_id = intval($_GET["web_id"]);
        $code_list = $model_web_config->getCodeList(array('web_id'=>"$web_id"));
        if(is_array($code_list) && !empty($code_list)) {
            $model_class = Model('goods_class');
            $goods_class = $model_class->getTreeClassList(1);//第一级商品分类
            Tpl::output('goods_class',$goods_class);

            foreach ($code_list as $key => $val) {//将变量输出到页面
                $var_name = $val['var_name'];
                $code_info = $val['code_info'];
                $code_type = $val['code_type'];
                $val['code_info'] = $model_web_config->get_array($code_info,$code_type);
                Tpl::output('code_'.$var_name,$val);
            }
        }
        $floor_list = $model_web_config->getWebList(array('web_id'=>"$web_id"));
        Tpl::output('floor',$floor_list[0]);

        Tpl::showpage('web_channel_fl.edit');
    }

    /**
     * 商品分类
     */
    public function get_category_listOp() {
        $model_class = Model('goods_class');
        $gc_parent_id = intval($_GET['id']);
        $gc_parent = $model_class->getGoodsClassInfoById($gc_parent_id);
        Tpl::output('gc_parent',$gc_parent);
        $goods_class = $model_class->getGoodsClassListByParentId($gc_parent_id);
        Tpl::output('goods_class',$goods_class);
        Tpl::showpage('web_channel_category','null_layout');
    }

    /**
     * 检查分类是否已经绑定到频道
     */
    public function check_goods_classOp() {
        $model_channel = Model('web_channel');
        $gc_id = intval($_GET['gc_id']);
        $condition = array();
        $condition['gc_id'] = $gc_id;
        $list = $model_channel->getChannelList($condition);
        if (!empty($list[0])) {
            echo $list[0]['channel_name'];exit;
        }
    }

    /**
     * 保存设置
     */
    public function code_updateOp() {
        $code_id = intval($_POST['code_id']);
        $web_id = intval($_POST['web_id']);
        $model_web_config = Model('web_config');
        $code = $model_web_config->getCodeRow($code_id,$web_id);
        if (!empty($code)) {
            $code_type = $code['code_type'];
            $var_name = $code['var_name'];
            $code_info = $_POST[$var_name];
            $code_info = $model_web_config->get_str($code_info,$code_type);
            $state = $model_web_config->updateCode(array('code_id'=> $code_id),array('code_info'=> $code_info));
        }
        if($state) {
            echo '1';exit;
        } else {
            echo '0';exit;
        }
    }

    /**
     * 更新html内容
     */
    public function html_updateOp() {
        $model_web_config = Model('web_con');
        $web_id = intval($_GET["web_id"]);
        $web_list = $model_web_config->getWebList(array('web_id'=> $web_id));
        $web_array = $web_list[0];
        if(!empty($web_array) && is_array($web_array)) {
            $model_web_config->updateWebHtml($web_id,$web_array);
            showMessage(Language::get('nc_common_op_succ'));
        } else {
            showMessage(Language::get('nc_common_op_fail'));
        }
    }

    /**
     * 商品推荐
     */
    public function recommend_listOp() {
        $model_web_config = Model('web_config');
        $condition = array();
        $gc_id = intval($_GET['id']);
        if ($gc_id > 0) {
            $condition['gc_id'] = $gc_id;
        }
        $goods_name = trim($_GET['goods_name']);
		if (!empty($goods_name)) {
			$condition['goods_name'] = array('like','%'.$goods_name.'%');
		}
        $goods_list = $model_web_config->getGoodsList($condition,'goods_id desc',6);
        Tpl::output('show_page',$model_web_config->showpage(2));
        Tpl::output('goods_list',$goods_list);
        Tpl::showpage('web_goods.list','null_layout');
    }

    /**
     * 商品分类图片
     */
    public function upload_gc_picOp() {
        $web_id = intval($_POST['w_id']);
        $code_id = intval($_POST['c_id']);
        $gc_id = intval($_POST['gc_id']);
        $file_name = 'channel-'.$web_id.'-'.$code_id.'-'.$gc_id;
        $pic_name = $this->_upload_pic($file_name);//上传图片
        if ($gc_id > 0 && !empty($pic_name)) {
            Tpl::output('pic',$pic_name);
            Tpl::output('var_name',$gc_id);
            Tpl::showpage('web_upload_pic','null_layout');
        }
    }

    /**
     * 保存焦点区切换大图
     */
    public function channel_slideOp() {
        $code_id = intval($_POST['code_id']);
        $web_id = intval($_POST['web_id']);
        $model_web_config = Model('web_config');
        $code = $model_web_config->getCodeRow($code_id,$web_id);
        if (!empty($code)) {
            $code_type = $code['code_type'];
            $var_name = $code['var_name'];
            $code_info = $_POST[$var_name];

            $pic_id = intval($_POST['slide_id']);
            if ($pic_id > 0) {
                $var_name = 'slide_pic';
                $pic_info = $_POST[$var_name];
                $pic_info['pic_id'] = $pic_id;
                if (!empty($code_info[$pic_id]['pic_img'])) {//原图片
                    $pic_info['pic_img'] = $code_info[$pic_id]['pic_img'];
                }
                $file_name = 'channel-'.$web_id.'-'.$code_id.'-'.$pic_id;
                $pic_name = $this->_upload_pic($file_name);//上传图片
                if (!empty($pic_name)) {
                    $pic_info['pic_img'] = $pic_name;
                }

                $code_info[$pic_id] = $pic_info;
                Tpl::output('pic',$pic_info);
            }
            $code_info = $model_web_config->get_str($code_info,$code_type);
            $model_web_config->updateCode(array('code_id'=> $code_id),array('code_info'=> $code_info));

            Tpl::showpage('web_upload_screen','null_layout');
        }
    }

    /**
     * 保存焦点区切换小图
     */
    public function channel_advOp() {
        $code_id = intval($_POST['code_id']);
        $web_id = intval($_POST['web_id']);
        $model_web_config = Model('web_config');
        $code = $model_web_config->getCodeRow($code_id,$web_id);
        if (!empty($code)) {
            $code_type = $code['code_type'];
            $var_name = $code['var_name'];
            $code_info = $_POST[$var_name];

            $slide_id = intval($_POST['slide_id']);
            $pic_id = intval($_POST['pic_id']);
            if ($pic_id > 0) {
                $var_name = 'focus_pic';
                $pic_info = $_POST[$var_name];
                $pic_info['pic_id'] = $pic_id;
                if (!empty($code_info[$slide_id]['pic_list'][$pic_id]['pic_img'])) {//原图片
                    $pic_info['pic_img'] = $code_info[$slide_id]['pic_list'][$pic_id]['pic_img'];
                }
                $file_name = 'channel-'.$web_id.'-'.$code_id.'-'.$slide_id.'-'.$pic_id;
                $pic_name = $this->_upload_pic($file_name);//上传图片
                if (!empty($pic_name)) {
                    $pic_info['pic_img'] = $pic_name;
                }

                $code_info[$slide_id]['pic_list'][$pic_id] = $pic_info;
                Tpl::output('pic',$pic_info);
            }
            $code_info = $model_web_config->get_str($code_info,$code_type);
            $model_web_config->updateCode(array('code_id'=> $code_id),array('code_info'=> $code_info));

            Tpl::showpage('web_upload_focus','null_layout');
        }
    }

    /**
     * 保存频道中部图片
     */
    public function upload_picOp() {
        $code_id = intval($_POST['code_id']);
        $web_id = intval($_POST['web_id']);
        $model_web_config = Model('web_config');
        $code = $model_web_config->getCodeRow($code_id,$web_id);
        if (!empty($code)) {
            $code_type = $code['code_type'];
            $var_name = $code['var_name'];
            $code_info = $_POST[$var_name];

            $file_name = 'channel-'.$web_id.'-'.$code_id;
            $pic_name = $this->_upload_pic($file_name);//上传图片
            if (!empty($pic_name)) {
                $code_info['pic'] = $pic_name;
            }

            Tpl::output('var_name',$var_name);
            Tpl::output('pic',$code_info['pic']);
            $code_info = $model_web_config->get_str($code_info,$code_type);
            $state = $model_web_config->updateCode(array('code_id'=> $code_id),array('code_info'=> $code_info));
            Tpl::showpage('web_upload_pic','null_layout');
        }
    }

    /**
     * 上传图片
     */
    private function _upload_pic($file_name) {
        $pic_name = '';
        if (!empty($file_name)) {
            if (!empty($_FILES['pic']['name'])) {//上传图片
                $upload = new UploadFile();
                $filename_tmparr = explode('.', $_FILES['pic']['name']);
                $ext = end($filename_tmparr);
                $upload->set('default_dir',ATTACH_EDITOR);
                $upload->set('file_name',$file_name.'.'.$ext);
                $result = $upload->upfile('pic');
                if ($result) {
                    $pic_name = ATTACH_EDITOR.'/'.$upload->file_name.'?'.mt_rand(100,999);//加随机数防止浏览器缓存图片
                }
            }
        }
        return $pic_name;
    }
}
