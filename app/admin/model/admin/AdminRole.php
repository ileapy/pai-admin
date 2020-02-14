<?php


namespace app\admin\model\admin;


use app\admin\model\BaseModel;
use app\admin\model\ModelTrait;

/**
 * 操作角色
 * Class AdminRole
 * @package app\admin\model\admin
 */
class AdminRole extends BaseModel
{
    use ModelTrait;

    /**
     * 获取权限
     * @param int $id
     * @return string
     */
    public static function getAuth(int $id): string
    {
        return self::where("id",$id)->value("auth") ?: '';
    }

    /**
     * 获取所有角色ids
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function getAuthLst(): array
    {
        $data = self::where("status",1)->field("id,name")->select();
        return $data ? $data->toArray() : [];
    }

    /**
     * 获取角色名称
     * @param int $id
     * @return string
     */
    public static function getAuthNameById(int $id): string
    {
        return self::where("id",$id)->value("name") ?: (string)$id;
    }

    /**
     * 角色列表
     * @param int $pid
     * @param array $auth
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function systemPage(int $pid = -1): array
    {
        $model = new self;
        if ($pid != -1) $model = $model->where("pid",$pid);
        $model = $model->field(['id','name','pid','auth','rank','status']);
        $model = $model->order(["rank desc","id"]);
        $data = $model->select();
        return $data->toArray() ?: [];
    }
}