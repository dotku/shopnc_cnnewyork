<?php
/*******
 * 圈子话题管理 
 *
 * by shopnc.club 运维舫 二次开发联系q:76809326
 */
defined('InShopNC') or exit('Access Invalid!');
class circle_cacheControl extends SystemControl{
	public function __construct(){
		parent::__construct();
	}
	public function indexOp(){
		rcache('circle_level',true);
		showMessage(L('nc_common_op_succ'), 'index.php?act=circle_setting');
	}
}






