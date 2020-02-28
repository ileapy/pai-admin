<?php


namespace app\admin\controller\system;


use app\admin\controller\AuthController;
use app\Request;
use FormBuilder\Factory\Elm;
use learn\services\FormBuilderService as Form;
use learn\services\JsonService as Json;
use learn\services\UtilService as Util;
use app\admin\model\system\SystemConfigTab as tModel;

/**
 * 管理员配置
 * Class SystemConfigTab
 * @package app\admin\controller\system
 */
class SystemConfigTab extends AuthController
{
    public function index()
    {
        return $this->fetch();
    }

    /**
     * 列表
     * @param Request $request
     */
    public function lst(Request $request)
    {
        $where = Util::postMore([
            ['page',1],
            ['limit',20],
        ]);
        return Json::successlayui(tModel::lst($where));
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
        $form[] = Elm::input('name','分类名称')->col(10);
        $form[] = Elm::number('rank','排序',0)->col(24);
        $form[] = Elm::radio('status','状态',1)->options([['label'=>'禁用','value'=>0],['label'=>'启用','value'=>1]])->col(24);
        return Form::make_post_form($form, url('save')->build());
    }

    /**
     * 修改
     * @param Request $request
     * @return string
     * @throws \FormBuilder\Exception\FormBuilderException
     */
    public function edit($id='')
    {
        if (!$id) return app("json")->fail("项目id不能为空");
        $info = tModel::get($id);
        if (!$info) return app("json")->fail("没有该项目");
        $form = array();
        $form[] = Elm::input('name','分类名称',$info['name'])->col(10);
        $form[] = Elm::number('rank','排序',$info['rank'])->col(24);
        $form[] = Elm::radio('status','状态',$info['status'])->options([['label'=>'禁用','value'=>0],['label'=>'启用','value'=>1]])->col(24);
        return Form::make_post_form($form, url('save',["id"=>$id])->build());
    }

    /**
     * 保存修改
     * @param string $id
     * @return mixed
     */
    public function save($id="")
    {
        $data = Util::postMore([
            ['name',''],
            ['rank',0],
            ['status',1]
        ]);
        if ($data['name'] == "") return app("json")->fail("分类名称不能为空");
        if ($id=="")
        {
            $data['create_user'] = $this->adminId;
            $data['create_time'] = time();
            $res = tModel::insert($data);
        }else
        {
            $data['update_user'] = $this->adminId;
            $data['update_time'] = time();
            $res = tModel::update($data,['id'=>$id]);
        }
        return $res ? app("json")->success("操作成功") : app("json")->fail("操作失败");
    }
}