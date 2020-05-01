<?php


namespace app\api\model\mini;


use app\api\model\BaseModel;
use app\api\model\ModelTrait;
use learn\utils\Curl;
use think\facade\Cache;

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
        $model = $model->field(['title','time','image','tinyname','vid','type','num','now_num','cover']);
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
        $model = $model->field(['title','time','image','tinyname','vid','type','num','now_num','cover']);
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
    public static function getUrlByVid(string $vid,string $xid = ""):string
    {
        if ($xid == "")
        {
            if ($url =  Cache::store('redis')->get($vid)) return $url;
            $i = 0;
            while ($i<3)
            {
                $i++;
                $curl = new Curl("http://5.nmgbq.com/j1/api.php?url="."https://v.qq.com/x/cover/".$vid.".html");
                $res = json_decode($curl->run(),true);
                if ($res['code'] == 200)
                {
                    Cache::store('redis')->set($vid,$res['url'],30*60);
                    return $res['url'];
                }
            }
            return "";
        }else
        {
            if ($url =  Cache::store('redis')->get($vid.$xid)) return $url;
            $i = 0;
            while ($i<3)
            {
                $i++;
                $curl = new Curl("http://5.nmgbq.com/j1/api.php?url="."https://v.qq.com/x/cover/$vid/$xid.html");
                $res = json_decode($curl->run(),true);
                if ($res['code'] == 200)
                {
                    Cache::store('redis')->set($vid.$xid,$res['url'],30*60);
                    return $res['url'];
                }
            }
            return "";
        }
        return "";
    }

    /**
     * 获取信息
     * @param string $vid
     * @return array|\think\Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function getVideoInfo(string $vid)
    {
        $model = new self;
        $model = $model->where("vid",$vid);
        $model = $model->where("status",1);
        $data = $model->find();
        if ($data) {
            $data = $data->toArray();
            $tag = MiniVideoTV::tags($vid);
            if ($tag) $data['tag'] = implode(" ",$tag);
            if ($data['type'] == "tv") $data['list'] = MiniVideoItem::getListByVid($vid);
            if ($data['actor']) $data['actor'] = json_decode($data['actor'],true);
        }
        return $data ?: [];
    }
}