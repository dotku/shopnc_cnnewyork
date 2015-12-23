<?php
/**
 * 微信登录 v3-b12
 *
 * 好商城 v3-b12 
 */



defined('InShopNC') or exit('Access Invalid!');

class connect_wxControl extends BaseHomeControl{
    public function __construct(){
        parent::__construct();
        Language::read("home_login_register,home_login_index");
        Tpl::output('hidden_nctoolbar', 1);
		Tpl::setLayout('login_layout');
    }
    /**
     * 微信登录
     */
    public function indexOp(){
        if(empty($_GET['code'])) {
            Tpl::showpage('connect_wx.index','null_layout');
        } else {
            $this->get_infoOp();
        }
        
    }
    /**
     * 微信注册后修改密码
     */
    public function edit_infoOp(){
        if (chksubmit()) {
            $model_member = Model('member');
            $member = array();
            $member['member_passwd'] = md5($_POST["password"]);
            if(!empty($_POST["email"])) {
                $member['member_email']= $_POST["email"];
                $_SESSION['member_email']= $_POST["email"];
            }
            $model_member->editMember(array('member_id'=> $_SESSION['member_id']),$member);
			showDialog(Language::get('nc_common_save_succ'),'index.php?act=member&op=home','succ');
        }
    }
    /**
     * 回调获取信息
     */
    public function get_infoOp(){
        $code = $_GET['code'];
        if(!empty($code)) {
            $user_info = $this->get_user_info($code);
            if(!empty($user_info['unionid'])) {
                $unionid = $user_info['unionid'];
                $model_member = Model('member');
                $member = $model_member->getMemberInfo(array('weixin_unionid'=> $unionid));
                if(!empty($member)) {//会员信息存在时自动登录
                    $model_member->createSession($member);
					showDialog('登录成功','index.php?act=member&op=home','succ');
                }
                if(!empty($_SESSION['member_id'])) {//已登录时绑定微信
                    $member_id = $_SESSION['member_id'];
                    $member = array();
                    $member['weixin_unionid'] = $unionid;
                    $member['weixin_info'] = $user_info['weixin_info'];
                    $model_member->editMember(array('member_id'=> $member_id),$member);
                    showDialog('微信绑定成功','index.php?act=member&op=home','succ');
                } else {//自动注册会员并登录
                    $this->register($user_info);
                    exit;
                }
            }
        }
        showDialog('微信登录失败',urlLogin('login', 'index'),'succ');
    }
    /**
     * 注册
     */
    public function register($user_info){
        Language::read("home_login_register,home_login_index");
        $unionid = $user_info['unionid'];
        $nickname = $user_info['nickname'];
        if(!empty($unionid)) {
            $rand = rand(100, 899);
            if(strlen($nickname) < 3) $nickname = $nickname.$rand;
            $member_name = $nickname;
            $model_member = Model('member');
            $member_info = $model_member->getMemberInfo(array('member_name'=> $member_name));
            $password = rand(100000, 999999);
            $member = array();
            $member['member_passwd'] = $password;
            $member['member_email'] = '';
            $member['weixin_unionid'] = $unionid;
            $member['weixin_info'] = $user_info['weixin_info'];
            if(empty($member_info)) {
                $member['member_name'] = $member_name;
                $result = $model_member->addMember($member);
            } else {
                for ($i = 1;$i < 999;$i++) {
                    $rand += $i;
                    $member_name = $nickname.$rand;
                    $member_info = $model_member->getMemberInfo(array('member_name'=> $member_name));
                    if(empty($member_info)) {//查询为空表示当前会员名可用
                        $member['member_name'] = $member_name;
                        $result = $model_member->addMember($member);
                        break;
                    }
                }
            }
            $headimgurl = $user_info['headimgurl'];//用户头像，最后一个数值代表正方形头像大小（有0、46、64、96、132数值可选，0代表640*640正方形头像）
            $headimgurl = substr($headimgurl, 0, -1).'132';
            $avatar = @copy($headimgurl,BASE_UPLOAD_PATH.'/'.ATTACH_AVATAR."/avatar_$result.jpg");
            if($avatar) {
                $model_member->editMember(array('member_id'=> $result),array('member_avatar'=> "avatar_$result.jpg"));
            }
            $member = $model_member->getMemberInfo(array('member_name'=> $member_name));
            if(!empty($member)) {
                $model_member->createSession($member,true);//自动登录
                Tpl::output('user_info',$user_info);
                Tpl::output('headimgurl',$headimgurl);
                Tpl::output('password',$password);
                Tpl::showpage('connect_wx.register');
            }
        }
    }
    /**
     * 获取用户个人信息
     */
    public function get_user_info($code){
        $weixin_appid = C('weixin_appid');
        $weixin_secret = C('weixin_secret');
        $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$weixin_appid.'&secret='.$weixin_secret.
            '&code='.$code.'&grant_type=authorization_code';
        $access_token = $this->get_url_contents($url);//通过code获取access_token
        $code_info = json_decode($access_token, true);
        $user_info = array();
        if(!empty($code_info['access_token'])) {
            $token = $code_info['access_token'];
            $openid = $code_info['openid'];
            $url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$token.'&openid='.$openid;
            $result = $this->get_url_contents($url);//获取用户个人信息
            $user_info = json_decode($result, true);
            $weixin_info = array();
            $weixin_info['unionid'] = $user_info['unionid'];
            $weixin_info['nickname'] = $user_info['nickname'];
            $weixin_info['openid'] = $user_info['openid'];
            $user_info['weixin_info'] = serialize($weixin_info);
        }
        return $user_info;
    }
    /**
     * OAuth2.0授权认证
     */
    public function get_url_contents($url){
        if (ini_get("allow_url_fopen") == "1") {
            return file_get_contents($url);
        } else {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_URL, $url);
            $result = curl_exec($ch);
            curl_close($ch);
            return $result;
        }
    }
}