<?php


namespace app\api\controller\mini;


use learn\services\UtilService as Util;
use app\api\model\mini\MiniVideo as vModel;
/**
 * Class MiniVideo
 * @package app\api\controller\mini
 */
class MiniVideo
{
    /**
     * @return mixed
     */
    public function url()
    {
        $where = Util::postMore([
            ['vid','']
        ]);
        if ($where['vid'] == "") return app("json")->fail("视频ID为空！");
        $url = vModel::getUrlByVid($where['vid']);
        return $url ? app("json")->success(compact("url")) : app("json")->fail("获取失败");
    }
}