<?php


namespace app\admin\controller\admin;


use app\admin\controller\AuthController;
use app\admin\model\admin\AdminRole as rModel;
use app\Request;
use learn\services\JsonService as Json;

class AdminRole extends AuthController
{
    public function index()
    {
        return $this->fetch();
    }

    /**
     * 角色列表
     * @param Request $request
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function lst(Request $request)
    {
        return Json::successlayui(0,rModel::systemPage());
    }
}