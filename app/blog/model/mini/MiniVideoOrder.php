<?php


namespace app\api\model\mini;


use app\api\model\BaseModel;
use app\api\model\ModelTrait;

/**
 * Class MiniVideoOrder
 * @package app\api\model\mini
 */
class MiniVideoOrder extends BaseModel
{
    use ModelTrait;

    /**
     * 判断是否购买
     * @param int $uid
     * @param string $vid
     * @param string $xid
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function videoIsPay(int $uid, string $vid, string $xid):bool
    {
        return self::where("uid",$uid)->where("vid",$vid)->where("xid",$xid)->where("paid",1)->find() ? true : false;
    }

    /**
     * 视频付款成功
     * @param string $oid
     * @return MiniVideoOrder|bool
     */
    public static function orderPayOver(string $oid)
    {
        if (!$oid) return false;
        return self::where("oid",$oid)->update(['paid'=>1,'pay_time'=>time(),'status'=>1]);
    }

    /**
     * 购买记录
     * @param int $uid
     * @param array $where
     * @return array|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function buyRecord(int $uid, array $where)
    {
        $model = new self;
        $model = $model->where("paid",1);
        $model = $model->where("status",1);
        $model = $model->order("pay_time desc");
        $model = $model->where("is_refund",0);
        $model = $model->where("uid",$uid);
        $model = $model->page((int)$where['page'],(int)$where['limit']);
        $data = $model->select()->each(function ($item){
            $item['pay_time'] = date("Y-m-d H:i:s",$item['pay_time']);
            $item['info'] = MiniVideo::get(['vid'=>$item['vid']]);
            $item['item'] = MiniVideoItem::get(['vid'=>$item['vid'],'xid'=>$item['xid']]) ?: "";
        });
        if ($data) $data = $data->toArray();
        return $data;
    }
}