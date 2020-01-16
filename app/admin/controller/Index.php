<?php


namespace app\admin\controller;


use app\admin\controller\AuthController;
use think\facade\View;

class Index extends AuthController
{
    // 无需登录的
    protected $noNeedLogin = ['index','test'];
    // 无需权限的
    protected $noNeedRight = [''];

    /**
     * 后台首页
     * @return string
     * @throws \Exception
     */
    public function index()
    {
        return lang('lang');
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

    public function test()
    {
        event("Test",["666"]);
    }
}