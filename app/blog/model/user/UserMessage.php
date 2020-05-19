<?php


namespace app\api\model\user;


use app\api\model\BaseModel;
use app\api\model\ModelTrait;

/**
 * Class UserMessage
 * @package app\api\model\user
 */
class UserMessage extends BaseModel
{
    use ModelTrait;

    /**
     * 添加留言
     * @param int $uid
     * @param string $email
     * @param string $tel
     * @param string $content
     * @return bool
     */
    public static function add(int $uid, string $email, string $tel, string $content):bool
    {
        return self::insert([
            'type' => 2,
            'uid' => $uid,
            'email' => $email,
            'tel' => $tel,
            'content' => $content,
            'add_time' => time(),
            'ip' => request()->ip(),
            'user_agent' => substr(request()->server('HTTP_USER_AGENT'), 0, 255),
            'is_read' => 0
        ]) ? true : false;
    }
}