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
        return Json::successlayui(0, CModel::systemPage($where));
    }

    /**
     * 添加
     * @param int $pid
     * @return string
     * @throws FormBuilderException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \FormBuilder\Exception\FormBuilderException
     */
    public function add($pid = 0)
    {
        $form = array();
        $form[] = Elm::select('pid','上级栏目',(int)$pid)->options(CModel::returnOptions())->filterable(true)->col(18);
        $form[] = Elm::input('name','栏目名称')->col(18);
        $form[] = Elm::radio('type','菜单类型',1)->options([['label'=>'单页','value'=>1],['label'=>'列表','value'=>2],['label'=>'链接','value'=>3]])->col(18);
        $form[] = Elm::input('link','链接')->col(18);
        $form[] = Elm::number('rank','排序')->col(18);
        $form[] = Elm::radio('is_menu','是否菜单',1)->options([['label'=>'是','value'=>1],['label'=>'否','value'=>0]])->col(18);
        $form[] = Elm::radio('status','状态',1)->options([['label'=>'启用','value'=>1],['label'=>'禁用','value'=>0]])->col(18);
        $form =  Form::make_post_form($form, url('save')->build());
        $this->assign(compact('form'));
        return $this->fetch("public/form-builder");
    }

    /**
     * 添加
     * @param int $id
     * @return string
     * @throws FormBuilderException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \FormBuilder\Exception\FormBuilderException
     */
    public function edit($id = 0)
    {
        if (!$id) return app("json")->fail("权限id不能为空");
        $info = CModel::get($id);
        if (!$info) return app("json")->fail("没有该权限");
        $form = array();
        $form[] = Elm::select('pid','上级栏目',$info['pid'])->options(CModel::returnOptions())->filterable(true)->col(18);
        $form[] = Elm::input('name','栏目名称',$info['name'])->col(18);
        $form[] = Elm::radio('type','菜单类型',$info['type'])->options([['label'=>'单页','value'=>1],['label'=>'列表','value'=>2],['label'=>'链接','value'=>3]])->col(18);
        $form[] = Elm::input('link','链接',$info['link'])->col(18);
        $form[] = Elm::number('rank','排序',$info['rank'])->col(18);
        $form[] = Elm::radio('is_menu','是否菜单',$info['is_menu'])->options([['label'=>'是','value'=>1],['label'=>'否','value'=>0]])->col(18);
        $form[] = Elm::radio('status','状态',$info['status'])->options([['label'=>'启用','value'=>1],['label'=>'禁用','value'=>0]])->col(18);
        $form = Form::make_post_form($form, url('save',['id'=>$id])->build());
        $this->assign(compact('form'));
        return $this->fetch("public/form-builder");
    }

    /**
     * 保存
     * @param $id
     */
    public function save($id="")
    {
        $data = Util::postMore([
            ['name',''],
            ['pid',0],
            ['type',1],
            ['link',''],
            ['rank',0],
            ['status',1],
            ['is_menu',1]
        ]);
        if ($data['name'] == "") return app("json")->fail("栏目名称不能为空");
        if ($id=="")
        {
            $data['create_user'] = $this->adminId;
            $data['create_time'] = time();
            $res = CModel::insert($data);
        }else
        {
            $data['update_user'] = $this->adminId;
            $data['update_time'] = time();
            $res = CModel::update($data,['id'=>$id]);
        }
        return $res ? Json::success("操作成功") : app("json")->fail("操作失败");
    }
}