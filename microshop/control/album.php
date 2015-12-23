<?php
/**
 * 默认展示页面
 *
 *
 *
 *by shopnc.club 运维舫 专注运维 开发修正
 */
defined('InShopNC') or exit('Access Invalid!');
class albumControl extends MircroShopControl{

	public function __construct() {
		parent::__construct();
        Tpl::output('index_sign','album');
    }

	//首页
	public function indexOp(){
		Tpl::showpage('album');
	}
}
