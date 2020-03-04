<?php


namespace app\admin\model\user;


use app\admin\model\BaseModel;
use app\admin\model\ModelTrait;

class User extends BaseModel
{
    use ModelTrait;

    /**
     * 添加用户
     * @param array $data
     * @return int|string
     */
    public static function addUser(array $data)
    {
        file_put_contents("addus.log",json_encode($data));
        return self::insertGetId([
            'nickname' => $data['nickname'],
            'avatar' => $data['avatar'],
            'sex' => $data['sex'],
            'register_ip' => request()->ip(),
            'register_time' => time(),
            'register_type' => 1,
            'status'=>1,
            'level'=>1,
            'integral'=>0,
            'money'=>0,
        ]);
    }

    /**
     * 更新用户
     * @param array $data
     * @param int $uid 用户id
     * @param int $type 注册类型
     * @return User
     */
    public static function updateUser(array $data,int $uid, int $type = 0)
    {
        $model = new self;
        $model = $model->where("uid",$uid);
        if ($type != 0) $model = $model->where("register_type",$type);
        return $model->update([
            'nickname' => $data['nickname'],
            'avatar' => $data['avatar'],
            'sex' => $data['sex'],
        ]);
    }

}