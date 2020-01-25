<?php


namespace app\admin\controller;

use app\admin\model\admin\AdminAuth;
use app\Request;

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

    /**
     * 菜单
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function menu()
    {
        AdminAuth::getMenu();
    }

    public function test(Request $request)
    {
        event("Test",["666"]);
    }
}