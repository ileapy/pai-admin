<?php


namespace app\admin\controller;


use app\admin\controller\AuthController;
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
        return $this->view();
    }

    /**
     * 控制台
     * @return string
     * @throws \Exception
     */
    public function console()
    {
        return $this->view();
    }
}