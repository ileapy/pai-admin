<?php


namespace app\admin\controller;

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
    public function del($ids = 0)
    {
        if (empty($ids) || !$ids) return app("json")->fail("参数有误，Id为空！");
        if (!is_array($ids)) $ids = [$ids];
        return $this->model->where("id","in",$ids)->delete() ? app("json")->success("操作成功") : app("json")->fail("操作失败");
    }

    /**
     * 启用
     * @param int $ids
     * @return
     */
    public function enabled($ids = 0)
    {
        if (empty($ids) || !$ids) return app("json")->fail("参数有误，Id为空！");
        if (!is_array($ids)) $ids = [$ids];
        return $this->model->where("id","in",$ids)->update(['status'=>1]) ? app("json")->success("操作成功") : app("json")->fail("操作失败");
    }

    /**
     * 禁用
     * @param int $ids
     * @return
     */
    public function disabled($ids = 0)
    {
        if (empty($ids) || !$ids) return app("json")->fail("参数有误，Id为空！");
        if (!is_array($ids)) $ids = [$ids];
        return $this->model->where("id","in",$ids)->update(['status'=>0]) ? app("json")->success("操作成功") : app("json")->fail("操作失败");
    }
}