<?php


namespace app\admin\controller;

use app\admin\model\admin\AdminAuth;
use app\Request;
use learn\services\JsonService as Json;

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
        $this->assign("adminInfo",$this->adminInfo);
        $this->assign("menu",AdminAuth::getMenu(0,$this->auth));
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

    /**
     * @param Request $request
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function clearCache(Request $request)
    {
        $adminPath = config("runtime")."/admin/";
        $indexPath = config("runtime")."/index/";
        if (removeCache($adminPath)) return Json::success("操作成功");
        return Json::fail("操作失败");
    }
}