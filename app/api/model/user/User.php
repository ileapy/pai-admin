<?php


namespace app\api\model\user;


use app\api\model\BaseModel;
use app\api\model\ModelTrait;
use learn\exceptions\AuthException;
use learn\utils\Jwt;

/**
 * Class User
 * @package app\api\model\user
 */
class User extends BaseModel
{
    use ModelTrait;

    /**
     * 获取授权信息
     * @param string $token
     * @return array
     * @throws AuthException
     */
    public static function parseToken($token): array
    {
        if (!$token)
            throw new AuthException('请登录', 410000);
        try {
            $user = Jwt::checkToken($token);
        } catch (\Throwable $e) {
            throw new AuthException('登录已过期,请重新登录', 410001);
        }
        if (!$user) {
            throw new AuthException('登录状态有误,请重新登录', 410002);
        }
        return $user;
    }

    /**
     * 添加用户
     * @param array $data
     * @param int $type
     * @return int|string
     */
    public static function addUser(array $data,int $type = 1)
    {
        return self::insertGetId([
            'nickname' => $data['nickname'],
            'avatar' => $data['avatar'],
            'sex' => $data['sex'],
            'register_ip' => request()->ip(),
            'register_time' => time(),
            'register_type' => $type,
            'status'=>1,
            'level'=>1,
            'integral'=>0,
            'money'=>0,
        ]);
    }

    /**
     * 更新用户
     * @param array $data
     * @param int|string $uid 用户id
     * @param int $type 注册类型
     * @return User
     */
    public static function updateUser(array $data, int $uid, int $type = 0)
    {
        $model = new self;
        $model = $model->where("uid",$uid);
        return $model->update([
            'nickname' => $data['nickname'],
            'avatar' => $data['avatar'],
            'sex' => $data['sex'],
            'register_type' => $type
        ]);
    }
}