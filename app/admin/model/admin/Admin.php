<?php


namespace app\admin\model\admin;

use app\admin\model\BaseModel;
use app\admin\model\ModelTrait;
use think\facade\Session;

/**
 * 管理员管理
 * Class Admin
 * @package app\admin\model
 */
class Admin extends BaseModel
{
    use ModelTrait;

    /**
     * 登录
     * @param $name
     * @param $pwd
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function login(string $name,string $pwd): bool
    {
        $info = self::where("name|tel","=", $name)->find();
        if (!$info) return self::setErrorInfo("登录账号不存在");
        if ($info['pwd'] != md5(md5($pwd))) return self::setErrorInfo("密码不正确！");
        if ($info['status'] == 2) return self::setErrorInfo("账号已被冻结！");
        self::setLoginInfo($info);
        return true;
    }

    /**
     * 设置登录信息
     * @param $info
     */
    public static function setLoginInfo($info)
    {
        Session::set("adminId",$info['id']);
        Session::set("adminInfo",$info->toArray());
        event("AdminLog",[$info->toArray(),"admin","login","login"]);
    }

    /**
     * 退出登录
     */
    public static function clearLoginInfo()
    {
        Session::delete("adminId");
        Session::delete("adminInfo");
        Session::clear();
        return true;
    }

    /**
     * 是否登录
     * @return bool
     */
    public static function isActive(): bool
    {
        return Session::has('adminId') && Session::has('adminInfo');
    }

    /**
     * 列表
     * @param array $where
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function systemPage(array $where): array
    {
        $model = new self;
        if ($where['name'] != '') $model = $model->where("name|id","like","%$where[name]%");
        if ($where['page'] && $where['limit']) $model = $model->page((int)$where['page'],(int)$where['limit']);
        $data = $model->select();
        return $data ? $data->toArray() : [];
    }
}