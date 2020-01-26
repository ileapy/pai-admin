<?php


namespace app\admin\controller\admin;


use app\admin\controller\AuthController;
use app\admin\model\admin\Admin as aModel;
use app\Request;
use learn\services\UtilService as Util;
use learn\services\JsonService as Json;

/**
 * 账号管理
 * Class Admin
 * @package app\admin\controller\admin
 */
class Admin extends AuthController
{
    /**
     * 账号列表
     * @return string
     * @throws \Exception
     */
    public function index()
    {
        return $this->fetch();
    }

    public function lst(Request $request)
    {
        $where = Util::postMore([
            ['name',''],
            ['page',1],
            ['limit',20],
        ]);
        return Json::successlayui("ok",aModel::systemPage($where));
    }
}