<?php


namespace app\admin\model\widget;


use app\admin\model\BaseModel;
use app\admin\model\ModelTrait;

/**
 * Class AttachmentCategory
 * @package app\admin\model\widget
 */
class AttachmentCategory extends BaseModel
{
    use ModelTrait;

    /**
     * 获取目录
     * @param string $type
     * @param int $pid
     * @param bool $lower
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function getCategoryLst(string $type = "image", int $pid = 0, bool $lower = false)
    {
        $model = new self;
        $model = $model->where("type",$type);
        $model = $model->where("pid",$pid);
        $model = $model->field(['id','pid','name']);
        $data = $model->select();
        if ($lower)
        {
            $data = $data->each(function ($item) use ($type){
                $item['children'] = self::getCategoryLst($type, $item['id']);
            });
        }
        return $data ? $data->toArray() : [];
    }

    /**
     * 获取目录名称
     * @param int $id
     * @return string
     */
    public static function getNameById(int $id)
    {
        return self::where("id",$id)->value("name") ?: "";
    }

    /**
     * @param string $type
     * @param int $pid
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function buildNodes(string $type = "image", int $pid = 0)
    {
        $model = new self;
        $model = $model->where("type",$type);
        $model = $model->where("pid",$pid);
        $model = $model->field(['id','pid','name as text']);
        $data = $model->select()->each(function ($item) use ($type){
            $item['nodes'] = self::buildNodes($type, $item['id']);
            if (empty($item['nodes'])) unset($item['nodes']);
        });
        return $data ? $data->toArray() : [];
    }
}