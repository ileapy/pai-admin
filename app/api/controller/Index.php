<?php
namespace app\api\controller;

use app\api\model\mini\MiniVideoBanner;

/**
 * Class Index
 * @package app\index\controller
 */
class Index
{
    /**
     * 轮播
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function banner()
    {
        return app("json")->success(MiniVideoBanner::lst(3),'code');
    }
}
