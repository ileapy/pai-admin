<?php


namespace app\admin\controller\cms;


use app\admin\controller\AuthController;
use app\Request;
use learn\services\JsonService as Json;
use learn\services\UtilService as Util;
use app\admin\model\cms\CmsPage as PModel;
use app\admin\model\cms\CmsCategory as CModel;

/**
 * Class CmsPage
 * @package app\admin\controller\cms
 */
class CmsPage extends AuthController
{
    /**
     * 单页
     * @return string
     * @throws \Exception
     */
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
            ['name'],
            ['page',1],
            ['limit',10]
        ]);
        return Json::successlayui(PModel::systemPage($where));
    }

    public function add(Request $request)
    {

    }

    public function edit(Request $request)
    {

    }

    public function save(Request $request)
    {

    }
}