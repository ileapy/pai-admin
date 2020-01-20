<?php


namespace app\admin\controller;


use app\admin\controller\AuthController;
use app\Request;
use think\facade\Session;
use think\facade\View;

class Index extends AuthController
{
    // 无需登录的
    protected $noNeedLogin = ['test'];
    // 无需权限的
    protected $noNeedRight = [''];

    /**
     * 后台首页
     * @return string
     * @throws \Exception
     */
    public function index()
    {
        return $this->fetch();
    }

    /**
     * 控制台
     * @return string
     * @throws \Exception
     */
    public function console()
    {
        return $this->fetch();
    }

    public function test(Request $request)
    {
        event("Test",["666"]);
    }
}