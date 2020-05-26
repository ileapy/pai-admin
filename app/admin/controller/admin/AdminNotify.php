<?php


namespace app\admin\controller\admin;


use app\admin\controller\AuthController;
use learn\services\UtilService as Util;
use app\admin\model\admin\AdminNotify as nModel;
/**
 * 消息提醒
 * Class AdminNotify
 * @package app\admin\controller\admin
 */
class AdminNotify extends AuthController
{
    /**
     * 列表
     * @return mixed
     */
    public function lst()
    {
        $where = Util::postMore([
            ['title',''],
            ['is_read',''],
            ['page',1],
            ['limit',20],
        ]);
        return app("json")->layui(nModel::systemPage($where));
    }
}