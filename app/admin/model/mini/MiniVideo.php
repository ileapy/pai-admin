<?php


namespace app\admin\model\mini;


use app\admin\model\BaseModel;
use app\admin\model\ModelTrait;
use learn\services\crawler\KanRankService;
use learn\services\crawler\KanService;
use learn\services\crawler\QQService;
use think\Db;

/**
 * Class MiniVideo
 * @package app\admin\model\mini
 */
class MiniVideo extends BaseModel
{
    use ModelTrait;
    /**
     * 分页
     * @param $where
     * @return array
     */
    public static function systemPage($where)
    {
        $model = new self;
        if ($where['title'] != "") $model = $model->where("title|vid","like","%$where[title]%");
        if ($where['status'] != "") $model = $model->where("status",$where['status']);
        if ($where['type'] != "") $model = $model->where("type",$where['type']);
        $count = self::counts($model);
        $model = $model->order("create_time desc");
        $model = $model->page((int)$where['page'],(int)$where['limit']);
        $data = $model->select();
        if ($data) $data = $data->toArray();
        return compact("data","count");
    }

    /**
     * 保存
     * @param array $data
     * @return bool
     */
    public static function saveByLink(array $data): bool
    {
        // 获取视频Id
        preg_match('/[\w][\w-]*\.(?:com\.cn|com|cn|co|net|org|gov|cc|biz|info)(\/|$)/isU', $data['link'], $domain);
        switch (rtrim($domain[0],"/"))
        {
            case "qq.com":
                preg_match('/https:\/\/v.qq.com\/detail\/(.*?)\/(.*?).html/', $data['link'], $vid);
                return self::saveData($vid[2],$data['type'],"qq", $data['adminId']);
            case "360kan.com":
                preg_match('/[https|http]:\/\/www.360kan.com\/(.*?)\/(.*?).html/', $data['link'], $vid);
                return self::saveData($vid[2],$data['type'],"360", $data['adminId']);
            default:
                return false;
        }
    }

    /**
     * 获取并保存数据
     * @param string $vid
     * @param string $type
     * @param string $source
     * @param int $adminId
     * @return bool
     */
    public static function saveData(string $vid, string $type, string $source, int $adminId): bool
    {
        self::startTrans();
        try {
            if ($source == "qq") $data = QQService::app($vid,$type)->message();
            else $data = KanService::app($vid,$type)->message();
            if ($type == "movie")
            {
                if (self::be($vid,"vid"))
                {
                    // 更新主表 删除标签
                    $res1 = self::where("vid",$vid)->update([
                        'source' => $source == "qq" ? $source : $data['source'],
                        'type' => $type,
                        'url' => $data['url'],
                        'title' => $data['title'],
                        'cover' => $data['cover'],
                        'actor' => $data['actor'],
                        'time' => $data['time'],
                        'desc' => $data['desc'],
                        'update_time'=>time(),
                        'update_user' => $adminId
                    ]) && MiniVideoTV::where("vid",$vid)->delete();
                }else
                {
                    // 插入主表
                    $res1 = self::insert([
                        'vid' => $vid,
                        'source' => $source == "qq" ? $source : $data['source'],
                        'type' => $type,
                        'url' => $data['url'],
                        'title' => $data['title'],
                        'cover' => $data['cover'],
                        'actor' => $data['actor'],
                        'time' => $data['time'],
                        'desc' => $data['desc'],
                        'rank' => 0,
                        'status' => 1,
                        'create_time'=>time(),
                        'create_user' => $adminId
                    ]);
                }
                // 插入标签
                $res2 = true;
                foreach ($data['tag'] as $v)
                {
                    $tid = MiniVideoTag::where("name",$v)->where("status",1)->where("type",$type)->value("id");
                    if ($tid) $res2 = $res2 && MiniVideoTV::insert(['vid'=>$vid,"tid"=>$tid,"add_time"=>time()]);
                }
                return $res1 && $res2 ? (self::commitTrans() || true) : false;
            }
            elseif ($type == "tv")
            {
                if (self::be($vid,"vid"))
                {
                    // 更新主表 删除标签 删除剧集数据
                    $res1 = self::where("vid",$vid)->update([
                            'source' => $source == "qq" ? $source : $data['source'],
                            'type' => $type,
                            'url' => $data['url'],
                            'title' => $data['title'],
                            'cover' => $data['cover'],
                            'actor' => $data['actor'],
                            'time' => $data['time'],
                            'desc' => $data['desc'],
                            'num' => $data['num'],
                            'now_num' => $data['now_num'],
                            'update_time'=>time(),
                            'update_user' => $adminId
                        ]) && MiniVideoTV::where("vid",$vid)->delete();
                    $res3 = true;
                    $i = 0;
                    foreach ($data['item'] as $k => $v)
                    {
                        preg_match('/https:\/\/v.qq.com\/x\/cover\/(.*?)\/(.*?)\.html(.*?)/', $v, $xid);
                        $xid = key_exists(2,$xid) ? $xid[2] : $k;
                        if (MiniVideoItem::where("vid",$vid)->where("name",$k)->count() > 1) MiniVideoItem::where("vid",$vid)->where("name",$k)->delete();
                        self::commitTrans();
                        if (MiniVideoItem::where("vid",$vid)->where("xid",$xid)->find())
                        {
                            $res3 = $res3 && MiniVideoItem::update([
                                    'name' => $k,
                                    'rank' => $i,
                                    'url' => $v,
                                    'status' => 1,
                                    'update_time'=>time(),
                                    'update_user' => $adminId
                                ],['xid' =>$xid,'vid' => $vid]);
                        }else
                        {
                            $res3 = $res3 && MiniVideoItem::insert([
                                    'xid' =>$xid,
                                    'vid' => $vid,
                                    'url' => $v,
                                    'name' => $k,
                                    'rank' => $i,
                                    'status' => 1,
                                    'update_time'=>time(),
                                    'update_user' => $adminId
                                ]);
                        }
                        $i++;
                    }
                }else
                {
                    // 插入主表
                    $res1 = self::insert([
                        'vid' => $vid,
                        'source' => $source == "qq" ? $source : $data['source'],
                        'type' => $type,
                        'url' => $data['url'],
                        'title' => $data['title'],
                        'cover' => $data['cover'],
                        'actor' => $data['actor'],
                        'time' => $data['time'],
                        'desc' => $data['desc'],
                        'num' => $data['num'],
                        'now_num' => $data['now_num'],
                        'rank' => 0,
                        'status' => 1,
                        'create_time'=>time(),
                        'create_user' => $adminId
                    ]);
                    $res3 = true;
                    $i = 0;
                    foreach ($data['item'] as $k => $v)
                    {
                        preg_match('/https:\/\/v.qq.com\/x\/cover\/(.*?)\/(.*?)\.html/', $v, $xid);
                        $xid = key_exists(2,$xid) ? $xid[2] : $k;
                        if (MiniVideoItem::where("vid",$vid)->where("name",$k)->count() > 1) MiniVideoItem::where("vid",$vid)->where("name",$k)->delete();
                        self::commitTrans();
                        if (MiniVideoItem::where("vid",$vid)->where("xid",$xid)->count() > 0)
                        {
                            $res3 = $res3 && MiniVideoItem::update([
                                    'name' => $k,
                                    'rank' => $i,
                                    'status' => 1,
                                    'url' => $v,
                                    'update_time'=>time(),
                                    'update_user' => $adminId
                                ],['xid' =>$xid,'vid' => $vid]);
                        }else
                        {
                            $res3 = $res3 && MiniVideoItem::insert([
                                    'xid' =>$xid,
                                    'vid' => $vid,
                                    'url' => $v,
                                    'name' => $k,
                                    'rank' => $i,
                                    'status' => 1,
                                    'update_time'=>time(),
                                    'update_user' => $adminId
                                ]);
                        }
                        $i++;
                    }
                }
                // 插入标签
                $res2  = true;
                foreach ($data['tag'] as $v)
                {
                    $tid = MiniVideoTag::where("name",$v)->where("status",1)->where("type",$type)->value("id");
                    if ($tid) $res2 = $res2 && MiniVideoTV::insert(['vid'=>$vid,"tid"=>$tid,"add_time"=>time()]);
                }
                return $res1 && $res2 && $res3 ? (self::commitTrans() || true) : false;
            }
            return false;
        }catch (\Exception $e)
        {
            var_dump($e->getMessage());
            self::rollbackTrans();
            return false;
        }
    }

    /**
     * 更新电视剧
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function UpdateTimer()
    {
        $model = new self;
        $model = $model->where("status",1);
        $model = $model->where("type","tv");
        $model = $model->where("num > now_num");
        $data = $model->select()->each(function ($item){
            self::saveData($item['vid'],$item['type'],$item['source'],0);
        });
        if ($data) $data = $data->toArray();
        event("VideoUpdateOver",[$data]);
    }

    /**
     * 从排行榜更新视频
     * @param string $type
     */
    public static function updateVideoRank(string $type = "movie")
    {
        switch ($type)
        {
            case 'movie':
                $data = KanRankService::app("movie")->run();
                foreach ($data['list'][0] as $item)
                {
                    self::saveByLink(['link'=>$item,'adminId'=>0,'type'=>'movie']);
                }
                event("VideoRankUpdateOver",[$data['list'][1]]);
                return;
            case 'tv':
                $data = KanRankService::app("tv")->run();
                foreach ($data['list'][0] as $item)
                {
                    self::saveByLink(['link'=>$item,'adminId'=>0,'type'=>'tv']);
                }
                event("VideoRankUpdateOver",[$data['list'][1]]);
                return;
        }
    }
}