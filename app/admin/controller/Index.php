<?php


namespace app\admin\controller;


use app\admin\AuthController;
use think\facade\View;

class Index extends AuthController
{
    /**
     * 后台首页
     * @return string
     * @throws \Exception
     */
    public function index()
    {
        return View::fetch();
    }

    /**
     * 控制台
     * @return string
     * @throws \Exception
     */
    public function console()
    {
        return View::fetch();
    }
}