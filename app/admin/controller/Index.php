<?php


namespace app\admin\controller;

use app\admin\model\admin\AdminAuth;
use app\admin\model\admin\AdminNotify;
use app\admin\model\project\project;
use app\admin\model\user\User;
use app\admin\model\user\UserBill;
use app\admin\model\user\UserMessage;
use app\admin\model\wechat\WechatMessage;
use app\Request;
use learn\services\UtilService as Util;

class Index extends AuthController
{
    // 无需登录的
    protected $noNeedLogin = [''];
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
        $this->assign("message",AdminNotify::pageList(5));
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
        $this->assign("billMoney",UserBill::getAllEarn()); //全部收入
        $this->assign("userNum",User::count()); //用户总数
        $this->assign("wechatMessageNum",WechatMessage::where("add_time","between",[mktime(0,0,0,date('m'),date('d'),date('Y')),mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1])->count()); //今日公众号操作数量
        $this->assign("messageNum",UserMessage::where("is_read",0)->count()); //新增留言
        $this->assign("user",User::statistics()); // 最近14天用户注册统计
        $this->assign("bill",UserBill::statistics());// 最近14天交易统计
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
        $apiPath = config("cache.runtime")."/api/";
        if (removeCache($adminPath) && removeCache($indexPath) && removeCache($apiPath)) return app("json")->success("操作成功");
        return app("json")->fail("操作失败");
    }
}
