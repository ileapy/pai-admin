<?php


namespace app\admin\controller\cms;


use app\admin\controller\AuthController;
use app\Request;
use learn\services\UtilService as Util;
use FormBuilder\Factory\Elm;
use learn\services\FormBuilderService as Form;
use app\admin\model\cms\CmsTag as TModel;

/**
 * 文章标签
 * Class CmsTag
 * @package app\admin\controller\cms
 */
class CmsTag extends AuthController
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
     * @return
     */
    public function lst(Request $request)
    {
        $where = Util::postMore([
            ['name',''],
            ['status',''],
            ['page',1],
            ['limit',20],
        ]);
        return app("json")->layui(TModel::systemPage($where));
    }

    /**
     * 添加账号
     * @param Request $request
     * @return string
     * @throws \FormBuilder\Exception\FormBuilderException
     */
    public function add(Request $request)
    {
        $form = array();
        $form[] = Elm::input('name','标签名称')->col(10);
        $form[] = Elm::input('icon','图标')->col(10);
        $form[] = Elm::number('rank','排序')->col(10);
        $form[] = Elm::radio('status','状态',1)->options([['label'=>'启用','value'=>1],['label'=>'禁用','value'=>0]])->col(10);
        $form = Form::make_post_form($form, url('save')->build());
        $this->assign(compact('form'));
        return $this->fetch("public/form-builder");
    }

    /**
     * 修改账号
     * @param string $id
     * @return string
     * @throws \FormBuilder\Exception\FormBuilderException
     */
    public function edit($id="")
    {
        if (!$id) return app("json")->fail("标签id不能为空");
        $ainfo = TModel::get($id);
        if (!$ainfo) return app("json")->fail("没有该标签");
        $form = array();
        $form[] = Elm::input('name','标签名称',$ainfo['name'])->col(10);
        $form[] = Elm::input('icon','图标',$ainfo['icon'])->col(10);
        $form[] = Elm::number('rank','排序',$ainfo['rank'])->col(10);
        $form[] = Elm::radio('status','状态',$ainfo['status'])->options([['label'=>'启用','value'=>1],['label'=>'禁用','value'=>0]])->col(10);
        $form = Form::make_post_form($form, url('save',['id'=>$id])->build());
        $this->assign(compact('form'));
        return $this->fetch("public/form-builder");
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
            ['icon',''],
            ['rank',0],
            ['status',1]
        ]);
        if ($data['name'] == "") return app("json")->fail("标签名称不能为空");
        if ($id=="")
        {
            $data['create_user'] = $this->adminId;
            $data['create_time'] = time();
            $res = TModel::insert($data);
        }else
        {
            $data['update_user'] = $this->adminId;
            $data['update_time'] = time();
            $res = TModel::update($data,['id'=>$id]);
        }
        return $res ? app("json")->success("操作成功",true) : app("json")->fail("操作失败");
    }
}