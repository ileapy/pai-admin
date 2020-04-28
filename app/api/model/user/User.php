<?php


namespace app\api\model\user;


use app\api\model\BaseModel;
use app\api\model\ModelTrait;
use learn\exceptions\AuthException;

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
        if (!$token || !$tokenData = UserToken::where('token', $token)->find())
            throw new AuthException('请登录', 410000);
        try {
            [$user, $type] = User::parseToken($token);
        } catch (\Throwable $e) {
            $tokenData->delete();
            throw new AuthException('登录已过期,请重新登录', 410001);
        }

        if (!$user || $user->uid != $tokenData->uid) {
            $tokenData->delete();
            throw new AuthException('登录状态有误,请重新登录', 410002);
        }
        $tokenData->type = $type;
        return compact('user', 'tokenData');
    }
}