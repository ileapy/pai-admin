<?php


namespace app\api\controller\mini;

use app\api\model\mini\MiniVideoCollect;
use app\api\model\mini\MiniVideoItem;
use app\api\model\mini\MiniVideoPlan;
use app\api\model\mini\MiniVideoRecord;
use app\Request;
use learn\services\UtilService as Util;
use app\api\model\mini\MiniVideo as vModel;
use app\api\model\mini\MiniVideoItem as iModel;
use app\api\model\mini\MiniVideoOrder;
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
        $data = vModel::getVideoInfo($where['vid'],$request->uid());
        return $data ? app("json")->success($data) : app("json")->fail("获取失败");
    }

    /**
     * 获取视频链接
     * @param Request $request
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function url(Request $request)
    {
        $where = Util::postMore([
            ['vid',''],
            ['xid','']
        ]);
        if ($where['vid'] == "") return app("json")->fail("视频ID为空！");
        if (!vModel::isAllow($request->uid(),$where['vid'],$where['xid'])) return app("json")->make("2001","您不拥有该视频！");
        $url = vModel::getUrlByVid($where['vid'],$where['xid']);
        MiniVideoRecord::record($request->uid(),$where['vid'],$where['xid']);
        $curNum = $where['xid'] ? iModel::where("vid",$where['vid'])->where("xid",$where['xid'])->where("status",1)->value("name") : 1;
        $skip_sec = MiniVideoPlan::where("uid",$request->uid())->where("vid",$where['vid'])->where("xid",$where['xid'])->value("sec") ?: MiniVideoItem::where("vid",$where['vid'])->where("xid",$where['xid'])->where("status",1)->value("skip_sec") ?: vModel::where("vid",$where['vid'])->where("status",1)->value("skip_sec");
        return $url ? app("json")->success(compact("url","curNum","skip_sec")) : app("json")->fail("获取失败");
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function pause(Request $request)
    {
        $where = Util::postMore([
            ['vid',''],
            ['xid',''],
            ['sec',0],
            ['uid',$request->uid()]
        ]);
        if ($where['vid'] == "") return app("json")->fail("视频ID为空！");
        return MiniVideoPlan::pause($where['uid'],$where['vid'],$where['xid'],$where['sec']) ? app("json")->success("记录成功") : app("json")->fail("记录失败");
    }

    /**
     * 收藏
     * @param Request $request
     * @return bool|int|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function collect(Request $request)
    {
        $where = Util::postMore([
           ['vid','']
        ]);
        if ($where['vid'] == "") return app("json")->fail("视频ID为空！");
        return MiniVideoCollect::UnAndOncollect($request->uid(),$where['vid']) ? app("json")->success("操作成功") : app("json")->fail("操作失败");
    }

    /**
     * 浏览记录
     * @param Request $request
     * @return
     */
    public function record(Request $request)
    {
        $where = Util::postMore([
            ['page',1],
            ['limit',10],
        ]);
        return app("json")->success("ok",MiniVideoPlan::lst($request->uid(),$where));
    }

    /**
     * 收藏列表
     * @param Request $request
     * @return mixed
     */
    public function collect_index(Request $request)
    {
        $where = Util::postMore([
            ['page',1],
            ['limit',10],
        ]);
        return app("json")->success("ok",MiniVideoCollect::lst($request->uid(),$where));
    }

    /**
     * 视频列表
     * @param Request $request
     * @return mixed
     */
    public function lst(Request $request)
    {
        $where = Util::postMore([
            ['page',1],
            ['limit',10],
            ['title',''],
            ['type','']
        ]);
        return app("json")->success("ok",vModel::search($where));
    }
}