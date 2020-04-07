<?php


namespace app\admin\model\widget;


use app\admin\model\BaseModel;
use app\admin\model\ModelTrait;
use app\admin\model\system\SystemConfig;

/**
 * Class attachment
 * @package app\admin\model\widget
 */
class Attachment extends BaseModel
{
    use ModelTrait;

    /**
     * @param int $cid
     * @param string $name
     * @param string $path
     * @param string $type
     * @param string $mime
     * @param float $size
     */
    public static function add(int $cid, string $name, string $path, string $type, string $mime, float $size)
    {
        // 存储方式
        $storage = SystemConfig::get("");
        $upload_time = time();
    }
}