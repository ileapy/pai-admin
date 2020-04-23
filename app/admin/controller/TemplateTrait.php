<?php


namespace app\admin\controller;

use app\Request;
use learn\services\UtilService as Util;

/**
 * Trait TemplateTrait
 * @package app\admin\controller
 */
trait TemplateTrait
{
    /**
     * 删除操作
     * @param $id
     * @return mixed
     */
    public function del(Request $request)
    {
        $ids = $request->param("id",0);
        if ($ids == 0) return app("json")->fail("参数有误，Id为空！");
        if (!is_array($ids)) $ids = explode(",",$ids);
        return $this->model->where("id","in",$ids)->delete() ? app("json")->success("操作成功") : app("json")->fail("操作失败");
    }

    /**
     * 启用
     * @param int $ids
     * @return
     */
    public function enabled(Request $request)
    {
        $ids = $request->param("id",0);
        if (empty($ids) || !$ids) return app("json")->fail("参数有误，Id为空！");
        if (!is_array($ids)) $ids = [$ids];
        return $this->model->where("id","in",$ids)->update(['status'=>1]) ? app("json")->success("操作成功") : app("json")->fail("操作失败");
    }

    /**
     * 禁用
     * @param int $ids
     * @return
     */
    public function disabled(Request $request)
    {
        $ids = $request->param("id",0);
        if (empty($ids) || !$ids) return app("json")->fail("参数有误，Id为空！");
        if (!is_array($ids)) $ids = [$ids];
        return $this->model->where("id","in",$ids)->update(['status'=>0]) ? app("json")->success("操作成功") : app("json")->fail("操作失败");
    }

    /**
     * 修改字段
     * @param $id
     * @return
     */
    public function field($id)
    {
        if (!$id) return app("json")->fail("参数有误，Id为空！");
        $where = Util::postMore([['field',''],['value','']]);
        if ($where['field'] == '' || $where['value'] =='') return app("json")->fail("参数有误！");
        return $this->model::update([$where['field']=>$where['value']],['id'=>$id]) ? app("json")->success("操作成功") : app("json")->fail("操作失败");
    }
}