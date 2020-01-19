<?php


namespace app\admin\model\admin;


use app\admin\model\BaseModel;

/**
 * 操作权限
 * Class AdminAuth
 * @package app\admin\model\admin
 */
class AdminAuth extends BaseModel
{
    /**
     * 获取权限id 找不到是返回 -1
     * @param string $module
     * @param string $controller
     * @param string $action
     * @return int
     */
    public static function getAuthId(string $module, string $controller,string $action): int
    {
        var_dump($module,$controller,$action);
        return self::where("module",$module)->where("controller",$controller)->where("action",$action)->value('id') ?: -1;
    }
}