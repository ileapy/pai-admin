<?php


namespace app\admin\controller\pinduoduo;


use app\admin\controller\AuthController;
use app\admin\model\pinduoduo\PinduoduoProvider as pModel;
use app\admin\model\pinduoduo\PinduoduoStore as sModel;
use think\facade\Session;

/**
 * 订单信息
 * Class Order
 * @package app\admin\controller\pinduoduo
 */
class Order extends AuthController
{
    public function index()
    {
        $store = sModel::isBingInfo($this->adminId);
        if (!$store) $this->assign("isBind",false);
        else
        {
            if (!authIsExit($this->adminId))
            {
                $provider = pModel::get($store['pid']);
                if (!$provider) return "";
                Session::set("provider",$provider);
                return $this->redirect("https://mms.pinduoduo.com/open.html?response_type=code&client_id={$provider['client_id']}&redirect_uri=http://learn.leapy.cn/admin/pinduoduo.authorization/accessauth&state=3000");
            }
        }
        return $this->fetch();
    }
}