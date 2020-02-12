<?php


namespace app\admin\controller;

use app\admin\model\admin\AdminAuth;
use app\Request;

class Index extends AuthController
{
    // 无需登录的
    protected $noNeedLogin = ['test','accessauth','pddlogin'];
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
    public function main()
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
        return app("json")->success(AdminAuth::getMenu(0,$this->auth));
    }

    public function test(Request $request)
    {
        event("Test",["666"]);
    }

    public function pddlogin()
    {
        return $this->fetch();
    }

    public function accessauth()
    {
        var_dump($this->request->param());
        file_put_contents("pdd.log",serialize($this->request->param()));
    }
}