<?php


namespace app\api\controller\wechat;

use app\Request;
use learn\services\MiniProgramService;
use learn\services\UtilService as Util;

/**
 * 小程序
 * Class MiniProgramController
 * @package app\api\controller\wechat
 */
class MiniProgramController
{
    /**
     * 获取 openId, sessionKey, unionId
     * @param Request $request
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException|\EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function getOpenid(Request $request)
    {
        $where = Util::getMore([
           ['code','']
        ]);
        if ($where['code'] == "") return app("json")->fail("参数有误！code为空！");
        $data = MiniProgramService::session($where['code']);
        return empty($data) ? app("json")->fail("获取失败") : app("json")->success("ok",$data);
    }
}