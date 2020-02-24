<?php


namespace app\admin\controller\project;


use app\admin\controller\AuthController;
use app\Request;
use learn\services\UtilService as Util;
use learn\services\JsonService as Json;

/**
 * 项目管理
 * Class project
 * @package app\admin\controller\project
 */
class project extends AuthController
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
            ['page',''],
            ['limit',20],
        ]);
    }
}