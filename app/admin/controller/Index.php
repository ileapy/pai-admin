<?php


namespace app\admin\controller;


use app\admin\BaseController;
use think\facade\View;

class Index extends BaseController
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