<?php


namespace app\admin\controller\admin;


use app\admin\controller\AuthController;
use app\admin\model\admin\AdminAuth as aModel;
use app\Request;
use learn\services\JsonService as Json;
use learn\services\UtilService as Util;

/**
 * 权限管理
 * Class AdminAuth
 * @package app\admin\controller\admin
 */
class AdminAuth extends AuthController
{
    public function index()
    {
        return $this->fetch();
    }

    /**
     * 权限列表
     * @param Request $request
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function lst(Request $request)
    {
        return Json::successlayui(0,aModel::systemPage());
    }
}