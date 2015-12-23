<?php
/**
 * 商城频道模型  v3-b12
 *
 *
 */
defined('InShopNC') or exit('Access Invalid!');

class web_channelModel extends Model{

    public function __construct() {
        parent::__construct();
    } 

    /**
     * 增加频道
     *
     * @param
     * @return int
     */
    public function addChannel($channel_array) {
        $channel_id = $this->table('web_channel')->insert($channel_array);
        return $channel_id;
    }

    /**
     * 增加频道模块
     *
     * @param
     * @return int
     */
    public function addWeb($web_array) {
        $web_id = $this->table('web')->insert($web_array);
        return $web_id;
    }

    /**
     * 增加模块内容
     *
     * @param
     * @return int
     */
    public function addWebCode($code_array) {
        $code_id = $this->table('web_code')->insert($code_array);
        return $code_id;
    }

    /**
     * 增加频道顶部初始化数据
     *
     * @param
     * @return int
     */
    public function addTopCode($web_id) {
        $code_array = array();
        $code_array['web_id'] = $web_id;
        $code_array['code_type'] = 'array';
        $code_array['var_name'] = 'channel_category';
        $code_array['code_info'] = '';
        $code_array['show_name'] = '频道顶部分类';
        $code_id = $this->addWebCode($code_array);
        $code_array['var_name'] = 'channel_slide';
        $code_array['show_name'] = '频道顶部切换';
        $code_id = $this->addWebCode($code_array);
        $code_array['var_name'] = 'channel_adv';
        $code_array['show_name'] = '频道顶部广告';
        $code_id = $this->addWebCode($code_array);
        return $code_id;
    }

    /**
     * 增加频道中部初始化数据
     *
     * @param
     * @return int
     */
    public function addFloorCode($web_id) {
        $code_array = array();
        $code_array['web_id'] = $web_id;
        $code_array['code_type'] = 'array';
        $code_array['var_name'] = 'channel_tit';
        $code_array['code_info'] = '';
        $code_array['show_name'] = '频道中部标题';
        $code_id = $this->addWebCode($code_array);
        $code_array['var_name'] = 'channel_act';
        $code_array['show_name'] = '频道中部活动';
        $code_id = $this->addWebCode($code_array);
        $code_array['var_name'] = 'recommend_list';
        $code_array['show_name'] = '频道中部商品';
        $code_id = $this->addWebCode($code_array);
        $code_array['var_name'] = 'adv_a';
        $code_array['show_name'] = '频道中部广告1';
        $code_id = $this->addWebCode($code_array);
        $code_array['var_name'] = 'adv_b';
        $code_array['show_name'] = '频道中部广告2';
        $code_id = $this->addWebCode($code_array);
        $code_array['var_name'] = 'adv_c';
        $code_array['show_name'] = '频道中部广告3';
        $code_id = $this->addWebCode($code_array);
        return $code_id;
    }

    /**
     * 增加频道模块
     *
     * @param
     * @return int
     */
    public function addFloor($web_array) {
        $web_id = $this->addWeb($web_array);
        if ($web_id > 0) {
            $web_page = $web_array['web_page'];
            switch ($web_page) {
                case 'channel_tp':
                    $this->addTopCode($web_id);
                    break;
                case 'channel_fl':
                    $this->addFloorCode($web_id);
                    break;
            }
        }
        return $web_id;
    }

    /**
     * 删除频道记录
     *
     * @param
     * @return bool
     */
    public function delChannel($condition) {
        if (empty($condition)) {
            return false;
        } else {
            $condition['channel_show'] = '0';//只有启用状态为否的可删除
            $result = $this->table('web_channel')->where($condition)->delete();
            return $result;
        }
    }

    /**
     * 修改频道记录
     *
     * @param
     * @return bool
     */
    public function editChannel($condition, $data) {
        if (empty($condition)) {
            return false;
        }
        if (is_array($data)) {
            $result = $this->table('web_channel')->where($condition)->update($data);
            return $result;
        } else {
            return false;
        }
    }

    /**
     * 消除已绑定商品分类的频道记录
     *
     * @param
     * @return bool
     */
    public function editChannelGoodsClass($gc_id) {
        if (empty($gc_id)) {
            return false;
        }
        $condition = array();
        $condition['gc_id'] = intval($gc_id);

        $data['gc_id'] = 0;
        $data['gc_name'] = '';
        $result = $this->editChannel($condition, $data);
        return $result;
    }
    /**
     * 频道模块html信息
     *
     */
    public function getChannelHtml($channel,$update_all = 0){
        $model_web_config = Model('web_con');
        $web_array = array();
        $condition = array();
        $condition['web_show'] = 1;
        $floor_ids = $channel['top_id'].','.$channel['floor_ids'];
        $web_list = $this->getChannelFloor($floor_ids, $condition);
        if(!empty($web_list) && is_array($web_list)) {
            foreach($web_list as $k => $v){
                if (is_array($v) && $v['web_id'] > 0) {//只处理正常显示的模块
                    $key = $v['web_page'];
                    if ($update_all == 1 || empty($v['web_html'])) {//强制更新或内容为空时查询数据库
                        $web_array[$key] .= $model_web_config->updateWebHtml($v['web_id'],$v);
                    } else {
                        $web_array[$key] .= $v['web_html'];
                    }
                }
            }
        }
        return $web_array;
    }
    /**
     * 频道模块信息
     *
     */
    public function getChannelFloor($floor_ids, $condition = array()){
        $floor_list = array();
        $floor_ids = explode(',', $floor_ids);
        if(!empty($floor_ids) && is_array($floor_ids)) {
            foreach($floor_ids as $k => $v) {
                $v = intval($v);
                if ($v > 0) {
                    $floor_list[$v] = $v;//在页面输出时保持原来的排序结果
                }
            }
        }
        $condition['web_id'] = array('in',$floor_list);
        $list = $this->getFloorList($condition);
        if(!empty($list) && is_array($list)) {
            foreach($list as $k => $v) {
                $web_id = $v['web_id'];
                $floor_list[$web_id] = $v;
            }
        }
        return $floor_list;
    }

    /**
     * 频道记录
     *
     * @param
     * @return array
     */
    public function getChannelList($condition = array(), $page = '', $limit = '', $fields = '*', $order = '') {
        if (empty($order)) {//汉字排序
            if (C('dbdriver') == 'oracle') {
                $order = "nlssort(channel_name,'NLS_SORT=SCHINESE_PINYIN_M') asc,channel_id desc";
            } else {
                $order = 'convert(channel_name using gbk) asc,channel_id desc';
            }
        }
        $result = $this->table('web_channel')->field($fields)->where($condition)->page($page)->limit($limit)->order($order)->select();
        return $result;
    }

    /**
     * 频道模块记录
     *
     * @param
     * @return array
     */
    public function getFloorList($condition = array(), $page = '', $limit = '', $fields = '*', $order = '') {
        if (empty($condition['web_page'])) {
            $condition['web_page'] = array('in', array('channel_tp','channel_fl'));
        }
        if (empty($order)) {//汉字排序
            if (C('dbdriver') == 'oracle') {
                $order = "nlssort(web_name,'NLS_SORT=SCHINESE_PINYIN_M') asc,web_id desc";
            } else {
                $order = 'convert(web_name using gbk) asc,web_id desc';
            }
        }
        $result = $this->table('web')->field($fields)->where($condition)->page($page)->limit($limit)->order($order)->select();
        return $result;
    }

    /**
     * 模块类型数组
     *
     */
    public function getFloorStyle() {
        $style_array = array(
            'channel_tp' => '顶部',
            'channel_fl' => '中部'
            );
        return $style_array;
    }
}
