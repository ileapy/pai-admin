<?php


namespace app\api\controller\user;

use app\Request;
use learn\services\UtilService as Util;
use app\api\model\user\UserMessage as mModel;
/**
 * Class UserMessage
 * @package app\api\controller\user
 */
class UserMessage
{
    /**
     * 留言
     * @param Request $request
     * @return bool
     */
    public function message(Request $request)
    {
        $data = Util::postMore([
            ['email', ''],
            ['tel', ''],
            ['content', ''],
        ]);
        if (!$data['email']) return app("json")->fail("邮箱不能为空！");
        if (!$data['tel']) return app("json")->fail("电话不能为空！");
        if (!$data['content']) return app("json")->fail("留言内容不能为空！");
        return mModel::add($request->uid(),$data['email'],$data['tel'],$data['content']) ? app("json")->success("留言成功") : app("json")->fail("留言失败");
    }
}