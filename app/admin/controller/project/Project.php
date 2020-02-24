<?php


namespace app\admin\controller\project;


use app\admin\controller\AuthController;
use app\admin\model\admin\Admin as aModel;
use app\Request;
use FormBuilder\Factory\Elm;
use learn\services\FormBuilderService as Form;
use learn\services\UtilService as Util;
use learn\services\JsonService as Json;
use app\admin\model\project\project as pModel;

/**
 * 项目管理
 * Class project
 * @package app\admin\controller\project
 */
class project extends AuthController
{
    public function index()
    {
        return $this->fetch();
    }

    /**
     * 列表
     * @param Request $request
     * @return mixed
     */
    public function lst(Request $request)
    {
        $where = Util::postMore([
            ['page',1],
            ['limit',20],
        ]);
        return Json::successlayui(pModel::lst($where));
    }

    /**
     * 添加
     * @param Request $request
     * @return string
     * @throws \FormBuilder\Exception\FormBuilderException
     */
    public function add(Request $request)
    {
        $form = array();
        $form[] = Elm::input('name','项目名称')->col(10);
        $form[] = Elm::select('manager','项目负责人')->options(function(){
            $list = aModel::lst();
            $menus=[];
            foreach ($list as $menu){
                $menus[] = ['value'=>$menu['id'],'label'=>$menu['realname']];//,'disabled'=>$menu['pid']== 0];
            }
            return $menus;
        })->col(10);
        $form[] = Elm::input('nickname','')->col(10);
        $form[] = Elm::password('pwd','密码')->col(10);
        $form[] = Elm::input('realname','真实姓名')->col(10);

        $form[] = Elm::input('tel','电话')->col(10);
        $form[] = Elm::email('mail','邮箱')->col(10);
        $form[] = Elm::radio('status','状态',1)->options([['label'=>'启用','value'=>1],['label'=>'冻结','value'=>0]])->col(10);
        return Form::make_post_form($form, url('save')->build());
    }
}