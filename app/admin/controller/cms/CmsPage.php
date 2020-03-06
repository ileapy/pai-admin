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
     * @param Request $request
     * @return string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index(Request $request)
    {
        $where = Util::postMore([
            ['name',""],
            ['page',1]
        ]);
        $this->assign("list",PModel::systemPage($where));
        return $this->fetch();
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