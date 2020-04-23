<?php


namespace app\admin\controller\wechat;


use app\admin\controller\AuthController;
use app\Request;
use learn\services\UtilService as Util;
use learn\services\WechatService;

/**
 * Class WechatMenu
 * @package app\admin\controller\wechat
 */
class WechatMenu extends AuthController
{
    /**
     * 微信菜单
     * @return mixed
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function menu()
    {
        $menu = WechatService::menuService();
        $buttons = $menu->current();
        $menus = $buttons['selfmenu_info']['button'];
        foreach ($menus as $k => $v) if (!isset($v['sub_button'])) $menus[$k]['sub_button']['list'] = [];
        $this->assign("menus",json_encode($menus));
        return $this->fetch();
    }

    /**
     * 发布菜单
     * @param Request $request
     * @return
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function send(Request $request)
    {
        try {
            $menu = WechatService::menuService();
            $menus = $request->param('menus','');
            if ($menus == '') return app("json")->fail("菜单不能为空");
            foreach ($menus as $k=>$v)
            {
                if (isset($menus[$k]['sub_button']) && isset($menus[$k]['sub_button']['list']))
                {
                    $menus[$k]['sub_button'] = $v['sub_button']['list'];
                    unset($menus[$k]['sub_button']['list']);
                }
            }
            $menu->create($menus);
            return app("json")->success("菜单发布成功",'code');
        }catch (\Exception $e)
        {
            return app("json")->fail("菜单发布失败");
        }
    }
}