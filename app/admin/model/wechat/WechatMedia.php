<?php


namespace app\admin\model\wechat;


use app\admin\model\BaseModel;
use app\admin\model\ModelTrait;

/**
 * Class WechatMedia
 * @package app\admin\model\wechat
 */
class WechatMedia extends BaseModel
{
    use ModelTrait;

    /**
     * 保存素材数据
     * @param $data
     * @return int|string
     */
    public static function saveData($data)
    {
        return self::insert($data);
    }

    /**
     * 获取MediaId
     * @param string $path
     * @return mixed
     */
    public static function getMediaIdByPath(string $path)
    {
        return self::where("path",$path)->value("media_id");
    }
}