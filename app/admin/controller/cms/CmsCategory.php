<?php


namespace app\admin\controller\cms;


use app\admin\controller\AuthController;
use app\Request;
use learn\services\UtilService as Util;
use learn\services\JsonService as Json;
use FormBuilder\Factory\Elm;
use learn\services\FormBuilderService as Form;
use app\admin\model\cms\CmsCategory as CModel;

/**
 * Class CmsCategory
 * @package app\admin\controller\cms
 */
class CmsCategory extends AuthController
{
    /**
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
            ['name',''],
            ['status',''],
        ]);
        return Json::successlayui(CModel::systemPage($where));
    }
}