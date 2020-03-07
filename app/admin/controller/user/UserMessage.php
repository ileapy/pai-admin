<?php


namespace app\admin\controller\user;


use app\admin\controller\AuthController;
use app\Request;
use learn\services\UtilService as Util;
use learn\services\JsonService as Json;
use app\admin\model\user\UserMessage as UModel;

/**
 * 留言
 * Class UserMessage
 * @package app\admin\controller\user
 */
class UserMessage extends AuthController
{
    public function index()
    {
        return $this->fetch();
    }

    /**
     * 列表
     * @param Request $request
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function lst(Request $request)
    {
        $where = Util::postMore([
            ['add_time',[]],
            ['is_read',''],
            ['type',''],
            ['page',1],
            ['limit',20],
        ]);
        if ($where['add_time'] != ["",""])
        {
            $where['add_time'][0] = strtotime($where['add_time'][0]);
            $where['add_time'][1] = strtotime($where['add_time'][1]);
        }
        return Json::successlayui(UModel::systemPage($where));
    }
}