<?php


namespace app\api\controller\mini;


use app\api\model\mini\MiniVideoRecord;
use app\Request;
use learn\services\UtilService as Util;
use app\api\model\mini\MiniVideo as vModel;
/**
 * Class MiniVideo
 * @package app\api\controller\mini
 */
class MiniVideo
{
    /**
     * @param Request $request
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function info(Request $request)
    {
        $where = Util::postMore([
            ['vid','']
        ]);
        if ($where['vid'] == "") return app("json")->fail("视频ID为空！");
        $data = vModel::getVideoInfo($where['vid']);
        if ($data['type'] === "tv" && isset($data['list']) && count($data['list']) > 0) $data['url'] = vModel::getUrlByVid($where['vid'],$data['list'][0]['xid']);
        else $data['url'] = vModel::getUrlByVid($where['vid']);
        return $data['url'] ? app("json")->success($data) : app("json")->fail("获取失败");
    }
}