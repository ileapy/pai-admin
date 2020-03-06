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

    /**
     * 添加
     * @param Request $request
     * @return string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function add(Request $request)
    {
        $this->assign("category",CModel::selectByType(1,PModel::column("cid")));
        return $this->fetch();
    }

    /**
     * 修改
     * @param Request $request
     * @return string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function edit(Request $request)
    {
        $this->assign("category",CModel::selectByType(1));
        $this->assign("info",PModel::get($request->param(['cid'])));
        return $this->fetch();
    }

    /**
     * 保存
     * @param int $id
     * @return void
     */
    public function save($id=0)
    {
        $data = Util::postMore([
            ['cid',0],
            ['content',''],
            ['show_time',''],
            ['status',1],
        ]);
        if ($data['show_time']) $data['show_time'] = strtotime($data['show_time']);
        if ($data['content']) $data['content'] = htmlentities($data['content']);
        if ($id==0)
        {
            $data['create_user'] = $this->adminId;
            $data['create_time'] = time();
            $res = PModel::insert($data);
        }else
        {
            $data['update_user'] = $this->adminId;
            $data['update_time'] = time();
            $res = PModel::update($data,['cid'=>$id]);
        }
        return $res ? Json::success("操作成功") : app("json")->fail("操作失败");
    }

    /**
     * 删除
     * @param Request $cid
     * @return mixed|void
     */
    public function del($cid)
    {
        if (!is_array($cid)) $cid = [$cid];
        return $this->model->where("cid","in",$cid)->delete() ? app("json")->success("操作成功") : app("json")->fail("操作失败");
    }
}