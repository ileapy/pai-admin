<?php


namespace app\admin\controller\system;


use app\admin\controller\AuthController;
use app\Request;
use learn\services\JsonService as Json;
use learn\services\UtilService as Util;
use app\admin\model\system\SystemConfigTab as tModel;

/**
 * 管理员配置
 * Class SystemConfigTab
 * @package app\admin\controller\system
 */
class SystemConfigTab extends AuthController
{
    public function index()
    {
        return $this->fetch();
    }

    /**
     * 列表
     * @param Request $request
     */
    public function lst(Request $request)
    {
        $where = Util::postMore([
            ['page',1],
            ['limit',20],
        ]);
        return Json::successlayui(tModel::lst($where));
    }
}