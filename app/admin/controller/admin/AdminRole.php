<?php


namespace app\admin\controller\admin;


use app\admin\controller\AuthController;
use app\admin\model\admin\AdminRole as rModel;
use app\admin\model\admin\AdminAuth as aModel;
use app\Request;
use FormBuilder\Exception\FormBuilderException;
use learn\services\JsonService as Json;
use learn\services\UtilService as Util;
use FormBuilder\Factory\Elm;
use learn\services\FormBuilderService as Form;

class AdminRole extends AuthController
{
    public function index()
    {
        return $this->fetch();
    }

    /**
     * 角色列表
     * @param Request $request
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function lst(Request $request)
    {
        return Json::successlayui(0,rModel::systemPage());
    }

    /**
     * 添加
     * @param int $pid
     * @return string
     * @throws FormBuilderException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function add($pid = 0)
    {
        $form = array();
        $form[] = Elm::select('pid','所属上级',(int)$pid)->options(rModel::returnOptions())->col(18);
        $form[] = Elm::input('name','角色名称')->col(18);
        $form[] = Elm::treeChecked('auth','选择权限',[2])->data(aModel::selectAndBuildTree(0,$pid ? explode(",",rModel::get($pid)['auth']) : aModel::getIds()))
            ->type("checked")
            ->showCheckbox(true)->col(18);
        $form[] = Elm::number('rank','排序')->col(18);
        $form[] = Elm::radio('status','状态',1)->options([['label'=>'启用','value'=>1],['label'=>'冻结','value'=>0]])->col(18);
        return Form::make_post_form($form, url('save')->build());
    }

    /**
     * 添加
     * @param int $id
     * @return string
     * @throws FormBuilderException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function edit($id = 0)
    {
        if (!$id) return app("json")->fail("权限id不能为空");
        $rinfo = rModel::get($id);
        if (!$rinfo) return app("json")->fail("没有该权限");
        $form = array();
        $form[] = Elm::select('pid','所属上级',$rinfo['pid'])->options(rModel::returnOptions())->col(18);
        $form[] = Elm::input('name','角色名称',$rinfo['name'])->col(18);
        $form[] = Elm::treeChecked('auth','选择权限',explode(",",$rinfo['auth']))->data(aModel::selectAndBuildTree(0,aModel::getIds()))->col(18);
        $form[] = Elm::number('rank','排序',$rinfo['rank'])->col(18);
        $form[] = Elm::radio('status','状态',$rinfo['status'])->options([['label'=>'启用','value'=>1],['label'=>'冻结','value'=>0]])->col(18);
        return Form::make_post_form($form, url('save',['id'=>$id])->build());
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
            ['auth',''],
            ['rank',0],
            ['status',1]
        ]);
        if ($data['name'] == "") return app("json")->fail("角色名称不能为空");
        if ($data['pid'] == "") return app("json")->fail("上级归属不能为空");
        if ($data['auth'] == "") return app("json")->fail("权限不能为空");
        $data['auth'] = aModel::getIds($data['auth']);
        $data['auth'] = implode(",",array_diff(array_unique($data['auth']),[0]));
        if ($id=="")
        {
            $data['create_user'] = $this->adminId;
            $data['create_time'] = time();
            $res = rModel::insert($data);
        }else
        {
            $data['update_user'] = $this->adminId;
            $data['update_time'] = time();
            $res = rModel::update($data,['id'=>$id]);
        }
        return $res ? Json::success("操作成功") : app("json")->fail("操作失败");
    }

    /**
     * 删除账号
     * @param $id
     * @return
     */
    public function del($id)
    {
        if (!$id) return app("json")->fail("参数有误，Id为空！");
        return rModel::del($id) ? app("json")->success("操作成功") : app("json")->fail("操作失败");
    }

    /**
     * 修改字段
     * @param $id
     * @return rModel
     */
    public function field($id)
    {
        if (!$id) return app("json")->fail("参数有误，Id为空！");
        $where = Util::postMore([['field',''],['value','']]);
        if ($where['field'] == '' || $where['value'] =='') return app("json")->fail("参数有误！");
        return rModel::update([$where['field']=>$where['value']],['id'=>$id]) ? app("json")->success("操作成功") : app("json")->fail("操作失败");
    }
}