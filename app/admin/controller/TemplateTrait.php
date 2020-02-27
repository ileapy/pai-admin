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
    public function del($id)
    {
        var_dump($id);
        if (!$id) return app("json")->fail("参数有误，Id为空！");
        return self::del($id) ? app("json")->success("操作成功") : app("json")->fail("操作失败");
    }
}