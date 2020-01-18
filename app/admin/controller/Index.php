<?php


namespace app\admin\controller;


use app\admin\controller\AuthController;
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
        var_dump(Session::getId());
        var_dump(Session::setId("7e0dfb3d54e1c3fab7fbc8af43b2f13d"));
        var_dump(Session::getId());
        var_dump(Session::all());
//        session("id","bf69d934d7c38c0a21074d8e3493f643");
//        var_dump(session_id("bf69d934d7c38c0a21074d8e3493f643"));
//        event("Test",["666"]);
    }
}