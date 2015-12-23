<?php
/**
 * 账号同步 
 *
 * 二十四小时在线技术Q：76809326 
 *
 * by 运维舫 www.shopnc.club 运营版
 */

defined('InShopNC') or exit('Access Invalid!');
class accountControl extends SystemControl{
    private $links = array(
        array('url'=>'act=account&op=qq','lang'=>'qqSettings'),
        array('url'=>'act=account&op=sina','lang'=>'sinaSettings'),
        array('url'=>'act=account&op=sms','lang'=>'smsSettings'),
        array('url'=>'act=account&op=wx','lang'=>'wxSettings')
    );
    public function __construct(){
        parent::__construct();
        Language::read('setting');
    }

    public function indexOp() {
        $this->qqOp();
    }

	/**
	 * QQ互联
	 */
	public function qqOp(){
		$model_setting = Model('setting');
		if (chksubmit()){
			$obj_validate = new Validate();
			if (trim($_POST['qq_isuse']) == '1'){
				$obj_validate->validateparam = array(
					array("input"=>$_POST["qq_appid"], "require"=>"true","message"=>Language::get('qq_appid_error')),
					array("input"=>$_POST["qq_appkey"], "require"=>"true","message"=>Language::get('qq_appkey_error'))
				);
			}
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage($error);
			}else {
				$update_array = array();
				$update_array['qq_isuse'] 	= $_POST['qq_isuse'];
				$update_array['qq_appcode'] = $_POST['qq_appcode'];
				$update_array['qq_appid'] 	= $_POST['qq_appid'];
				$update_array['qq_appkey'] 	= $_POST['qq_appkey'];
				$result = $model_setting->updateSetting($update_array);
				if ($result === true){
					$this->log(L('nc_edit,qqSettings'),1);
					showMessage(Language::get('nc_common_save_succ'));
				}else {
					$this->log(L('nc_edit,qqSettings'),0);
					showMessage(Language::get('nc_common_save_fail'));
				}
			}
		}

		$list_setting = $model_setting->getListSetting();
		Tpl::output('list_setting',$list_setting);

		//输出子菜单
		Tpl::output('top_link',$this->sublink($this->links,'qq'));
		Tpl::showpage('setting.qq_setting');
	}

	/**
	 * sina微博设置
	 */
	public function sinaOp(){
		$model_setting = Model('setting');
		if (chksubmit()){
			$obj_validate = new Validate();
			if (trim($_POST['sina_isuse']) == '1'){
				$obj_validate->validateparam = array(
					array("input"=>$_POST["sina_wb_akey"], "require"=>"true","message"=>Language::get('sina_wb_akey_error')),
					array("input"=>$_POST["sina_wb_skey"], "require"=>"true","message"=>Language::get('sina_wb_skey_error'))
				);
			}
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage($error);
			}else {
				$update_array = array();
				$update_array['sina_isuse'] 	= $_POST['sina_isuse'];
				$update_array['sina_wb_akey'] 	= $_POST['sina_wb_akey'];
				$update_array['sina_wb_skey'] 	= $_POST['sina_wb_skey'];
				$update_array['sina_appcode'] 	= $_POST['sina_appcode'];
				$result = $model_setting->updateSetting($update_array);
				if ($result === true){
					$this->log(L('nc_edit,sinaSettings'),1);
					showMessage(Language::get('nc_common_save_succ'));
				}else {
					$this->log(L('nc_edit,sinaSettings'),0);
					showMessage(Language::get('nc_common_save_fail'));
				}
			}
		}
		$is_exist = function_exists('curl_init');
		if ($is_exist){
			$list_setting = $model_setting->getListSetting();
			Tpl::output('list_setting',$list_setting);
		}
		Tpl::output('is_exist',$is_exist);

		//输出子菜单
		Tpl::output('top_link',$this->sublink($this->links,'sina'));

		Tpl::showpage('setting.sina_setting');
	}
    /**
     * 手机短信设置
     */
    public function smsOp(){
        $model_setting = Model('setting');
        if (chksubmit()){
            $update_array = array();
            $update_array['sms_register']   = $_POST['sms_register'];
            $update_array['sms_login']   = $_POST['sms_login'];
            $update_array['sms_password']  = $_POST['sms_password'];
            $result = $model_setting->updateSetting($update_array);
            if ($result){
                $this->log('编辑账号同步，手机短信设置');
                showMessage(Language::get('nc_common_save_succ'));
            }else {
                showMessage(Language::get('nc_common_save_fail'));
            }
        }
        $list_setting = $model_setting->getListSetting();
        Tpl::output('list_setting',$list_setting);
        //输出子菜单
        Tpl::output('top_link',$this->sublink($this->links,'sms'));


Tpl::showpage('setting.sms_setting');
    }

    /**
     * 微信登录设置
     */
    public function wxOp(){
        $model_setting = Model('setting');
        if (chksubmit()){
            $update_array = array();
            $update_array['weixin_isuse']   = $_POST['weixin_isuse'];
            $update_array['weixin_appid']   = $_POST['weixin_appid'];
            $update_array['weixin_secret']  = $_POST['weixin_secret'];
            $result = $model_setting->updateSetting($update_array);
            if ($result){
                $this->log('编辑账号同步，微信登录设置');
                showMessage(Language::get('nc_common_save_succ'));
            }else {
                showMessage(Language::get('nc_common_save_fail'));
            }
        }
        $list_setting = $model_setting->getListSetting();
        Tpl::output('list_setting',$list_setting);
        //输出子菜单
        Tpl::output('top_link',$this->sublink($this->links,'wx'));


Tpl::showpage('setting.wx_setting');
    }
}
