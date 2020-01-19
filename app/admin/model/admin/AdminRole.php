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
        return self::where("id",$id)->field("auth") ?: '';
    }
}