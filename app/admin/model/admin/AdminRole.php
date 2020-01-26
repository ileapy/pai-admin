<?php


namespace app\admin\model\admin;


use app\admin\model\BaseModel;

/**
 * 操作角色
 * Class AdminRole
 * @package app\admin\model\admin
 */
class AdminRole extends BaseModel
{
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
}