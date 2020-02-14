<?php


namespace app\admin\controller\admin;


use app\admin\controller\AuthController;
use app\admin\model\admin\AdminAuth as aModel;
use app\Request;
use learn\services\JsonService as Json;
use learn\services\UtilService as Util;
use FormBuilder\Factory\Elm;
use learn\services\FormBuilderService as Form;

/**
 * 权限管理
 * Class AdminAuth
 * @package app\admin\controller\admin
 */
class AdminAuth extends AuthController
{
    public function index()
    {
        return $this->fetch();
    }

    /**
     * 权限列表
     * @param Request $request
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function lst(Request $request)
    {
        return Json::successlayui(0,aModel::systemPage());
    }

    /**
     * 添加
     * @param Request $request
     * @return string
     * @throws \FormBuilder\Exception\FormBuilderException
     */
    public function add($pid = 0)
    {
        $form = array();
        $form[] = Elm::select('pid','上级权限',$pid)->options(function (){
            $list = aModel::lst();
            $menus=[];
            foreach ($list as $menu){
                $menus[] = ['value'=>$menu['id'],'label'=>$menu['name']];
            }
            return $menus;
        })->col(10);
        $form[] = Elm::input('name','权限名称')->col(10);
        $form[] = Elm::input('icon','图标')->col(10);
        $form[] = Elm::input('module','模块名')->col(10);
        $form[] = Elm::input('controller','控制器名')->col(10);
        $form[] = Elm::input('action','方法名')->col(10);
        $form[] = Elm::input('params','参数')->col(10);
        $form[] = Elm::number('rank','排序')->col(10);
        $form[] = Elm::radio('is_menu','是否菜单',1)->options([['label'=>'是','value'=>1],['label'=>'否','value'=>0]])->col(10);
        $form[] = Elm::radio('status','状态',1)->options([['label'=>'启用','value'=>1],['label'=>'冻结','value'=>0]])->col(10);
        return Form::make_post_form($form, url('save')->build());
    }
}