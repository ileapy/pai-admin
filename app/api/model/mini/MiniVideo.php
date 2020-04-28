<?php


namespace app\api\model\mini;


use app\api\model\BaseModel;
use app\api\model\ModelTrait;
use learn\utils\Curl;

/**
 * Class MiniVideo
 * @package app\api\model\mini
 */
class MiniVideo extends BaseModel
{
    use ModelTrait;

    // 隐藏的字段
    protected $hidden = ['create_time','create_user','update_time','update_user','status','rank'];

    /**
     * 视频列表
     * @param string $type
     * @param int $num
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function lst(string $type, int $num):array
    {
        $model = new self;
        $model = $model->where("type",$type);
        $model = $model->where("status",1);
        $model = $model->where("recommend",1);
        $model = $model->order("rank desc");
        $model = $model->order("vid desc");
        $model = $model->limit($num);
        $model = $model->field(['title','time','image','tinyname','vid','type','num','now_num']);
        $data = $model->select();
        return $data ? $data->toArray() : [];
    }

    /**
     * 推荐
     * @param int $num
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function love(int $num):array
    {
        $model = new self;
        $model = $model->where("status",1);
        $model = $model->where("love",1);
        $model = $model->order("rank desc");
        $model = $model->order("vid desc");
        $model = $model->limit($num);
        $model = $model->field(['title','time','image','tinyname','vid','type','num','now_num']);
        $data = $model->select();
        return $data ? $data->toArray() : [];
    }

    /**
     * 获取视频url
     * @param string $vid
     * @return string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function getUrlByVid(string $vid):string
    {
        $info = self::where("vid",$vid)->where("status",1)->find();
        if ($info && $info['type'] == 'movie')
        {
            $curl = new Curl("http://5.nmgbq.com/j1/api.php?url="."https://v.qq.com/x/cover/".$info['vid'].".html");
            $res = json_decode($curl->run(),true);
            if ($res['code'] == 200) return $res['url'];
            else return "";
        }
        return "";
    }
}