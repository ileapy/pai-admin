<?php


namespace app\admin\controller\wechat;

use app\admin\controller\AuthController;
use app\admin\model\wechat\WechatNewsList;
use learn\services\UtilService as Util;

/**
 * 图文管理
 * Class WechatNews
 * @package app\admin\controller\wechat
 */
class WechatNews extends AuthController
{
    public function index()
    {
        $where = Util::postMore([
            ['page',1],
            ['limit',12],
        ]);
        $this->assign("item",WechatNewsList::system($where));
        return $this->fetch();
    }
}