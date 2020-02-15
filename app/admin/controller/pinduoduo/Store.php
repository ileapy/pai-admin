<?php


namespace app\admin\controller\pinduoduo;


use app\admin\controller\AuthController;
use learn\services\JsonService as Json;
use learn\services\UtilService as Util;
use app\admin\model\pinduoduo\PinduoduoStore as sModel;
use app\admin\model\pinduoduo\PinduoduoProvider as pModel;

/**
 * 店铺信息
 * Class Store
 * @package app\admin\controller\pinduoduo
 */
class Store extends AuthController
{
    /**
     * 店铺详情
     * @return string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        $store = sModel::info($this->adminId);
        $status = 1;
        if (empty($store)) {
            $provider = pModel::getOneEnable();
            var_dump($provider);
            if ($provider)
            {
                $status = 2;
                $this->assign(compact("provider"));
                $this->assign("url","https://mms.pinduoduo.com/open.html?response_type=code&client_id={$provider['client_id']}&redirect_uri=http://learn.leapy.cn/admin/index/accessauth&state=10000");
            }
            else $status = 3;
        }
        else $this->assign(compact("store"));
        $this->assign(compact("store","status"));
        return $this->fetch();
    }
}