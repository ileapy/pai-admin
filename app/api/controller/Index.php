<?php
namespace app\api\controller;

use app\api\model\mini\MiniVideo;
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

    /**
     * 视频列表
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        $recommend = MiniVideo::love(10);
        $movie = MiniVideo::lst("movie",6);
        $tv = MiniVideo::lst("tv",6);
        return app("json")->success(compact("movie","tv","recommend"));
    }

    /**
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function base()
    {
        $icon = systemConfig("miniprogram_logo");
        $name = systemConfig("miniprogram_name");
        return app("json")->success(compact("name","icon"));
    }
}
