<?php


namespace app\admin\model\wechat;


use app\admin\model\BaseModel;
use app\admin\model\ModelTrait;
use learn\services\WechatService;

/**
 * 文章管理
 * Class WechatNews
 * @package app\admin\model\wechat
 */
class WechatNews extends BaseModel
{
    use ModelTrait;

    /**
     * 图文同步
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function sync()
    {
        try {
            $data = WechatService::materialService()->list("news");
            if (isset($data['item']) && !empty($data['item']))
            {
                foreach ($data['item'] as $k => $v)
                {
                    $news = [];
                    foreach ($v['content']['news_item'] as $k2 => $v2)
                    {
                        $new = self::where("title",$v2['title'])->where('author',$v2['author'])->where('thumb_media_id',$v2['thumb_media_id'])->find();
                        if ($new) $news[] = $new['id'];
                        else $news[] = self::insert([
                            'title' => $v2['title'],
                            'author' => $v2['author'],
                            'digest' => $v2['digest'],
                            'content' => $v2['content'],
                            'content_source_url' => $v2['content_source_url'],
                            'thumb_media_id' => $v2['thumb_media_id'],
                            'show_cover_pic' => $v2['show_cover_pic'],
                            'thumb_url' => $v2['thumb_url'],
                            'url' => $v2['url'],
                            'need_open_comment' => $v2['need_open_comment'],
                            'only_fans_can_comment' => $v2['only_fans_can_comment']
                        ]);
                    }
                    $list = WechatNewsList::where("media_id",$v['media_id'])->find();
                    if ($list) WechatNewsList::where("media_id",$v['media_id'])->update(['item'=>implode(",",$news),'content'=>json_encode($v['content'],true),'create_time'=>$v['content']['create_time'],'update_time'=>$v['content']['update_time']]);
                    else WechatNewsList::insert(['media_id'=>$v['media_id'],'item'=>implode(",",$news),'content'=>json_encode($v['content'],true),'create_time'=>$v['content']['create_time'],'update_time'=>$v['content']['update_time']]);
                }
            }
            return true;
        }catch (\Exception $exception)
        {
            return false;
        }
    }

    /**
     * @param int $id
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function del2(int $id)
    {
        self::startTrans();
        try {
            $material = WechatService::materialService();
            $artice = WechatNewsList::get($id);
            $material->delete($artice['media_id']);
            self::where("id","in",explode(",",$artice['item']))->delete();
            WechatNewsList::del($id);
            self::commit();
            return true;
        }catch (\Exception $e)
        {
            self::rollback();
            return false;
        }
    }
}