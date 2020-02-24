<?php


namespace app\admin\controller;

use app\admin\model\admin\AdminAuth;
use app\admin\model\project\project;
use app\Request;
use learn\services\UtilService as Util;

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
        $where = Util::postMore([
            ['page',1],
            ['limit',20],
        ]);
        $this->assign("project",project::lst($where));
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
     * @return
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function clearCache(Request $request)
    {
        $adminPath = config("cache.runtime")."/admin/";
        $indexPath = config("cache.runtime")."/index/";
        if (removeCache($adminPath) && removeCache($indexPath)) return app("json")->success("操作成功");
        return app("json")->fail("操作失败");
    }
}