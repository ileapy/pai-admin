<?php


namespace app\api\controller\mini;

use app\api\model\user\User;
use app\api\model\wechat\WechatUser;
use app\Request;
use learn\services\pay\PayService;
use learn\services\UtilService as Util;
use  app\api\model\mini\MiniVideoOrder as OModel;
use app\api\model\user\UserOrder as uoModel;
use app\api\model\mini\MiniVideo as vModel;
use app\api\model\mini\MiniVideoItem as iModel;

/**
 * 商品小程序订单
 * Class MiniVideoOrder
 * @package app\api\controller\mini
 */
class MiniVideoOrder
{
    /**
     * 生成订单
     * @param Request $request
     * @return mixed
     */
    public function order(Request $request)
    {
        $where = Util::postMore([
            ['vid',''],
            ['xid','']
        ]);
        if (!$where['vid']) return app("json")->fail("视频Id为空！");
        list($cost,$type) = vModel::info($where['vid'],$where['xid']);
        $oInfo = OModel::where("vid",$where['vid'])->where("xid",$where['xid'])->where("uid",$request->uid())->find();
        if ($oInfo['paid'] && !$oInfo['is_refund']) return app("json")->fail("您已购买，不需要重复购买");
        $oid = createOrderId();
        $res1 = OModel::insert(['oid'=>$oid,'vid'=>$where['vid'],'uid'=>$request->uid(),'type'=>$type,'cost'=>$cost,"xid"=>$where['xid']]);
        $res2 = uoModel::insert(['oid'=>$oid,'uid'=>$request->uid(),'source'=>1,'pay_price'=>$cost]);
        return $res1 && $res2 ? app("json")->success("生成订单成功",['oid'=>$oid]) : app("json")->fail("生成订单失败");
    }

    /**
     * 支付
     * @param Request $request
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function pay(Request $request)
    {
        $where = Util::postMore([
           ['oid','']
        ]);
        if (!$where['oid']) return app("json")->fail("订单编号为空！");
        $oInfo = OModel::where("oid",$where['oid'])->find();
        if (!$oInfo) return app("json")->fail("订单不存在！");
        $vInfo = vModel::where("vid",$oInfo['vid'])->find();
        if (!$vInfo) return app("json")->fail("视频不存在！");
        $iInfo = $oInfo['type'] == 'tv' ? iModel::where("vid",$oInfo['vid'])->where("xid",$oInfo['xid'])->find() : "";
        $openid = WechatUser::getOpenidByUid($request->uid());
        $title = $iInfo ? "解锁《".$vInfo['title']."第".$iInfo['name']."集》" : "解锁《".$vInfo['title']."》";
        return app("json")->success("ok",['data'=>PayService::app("wechat","miniapp")->pay([
            'out_trade_no' => $where['oid'],
            'body' => $title,
            'total_fee' => bcmul($oInfo['cost'],100,0),
            'openid' => $openid,
        ])]);
    }
}