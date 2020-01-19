<?php


namespace app\admin\model\admin;


use app\admin\model\BaseModel;

/**
 * 操作日志
 * Class AdminLog
 * @package app\admin\model\admin
 */
class AdminLog extends BaseModel
{

    /**
     * 保存日志
     * @param array $adminInfo
     * @param string $module
     * @param string $controller
     * @param string $action
     * @return AdminLog|\think\Model
     */
    public static function saveLog(array $adminInfo, string $module, string $controller, string $action)
    {
        return self::create([
            'admin_id'      => $adminInfo['id'],
            'admin_name'    => $adminInfo['name'],
            'module'        => $module,
            'controller'    => $controller,
            'action'        => $action,
            'ip'            => request()->ip(),
            'create_time'   => time(),
            'user_agent'     => substr(request()->server('HTTP_USER_AGENT'), 0, 255),
        ]);
    }
}