<?php


namespace app\admin\model\admin;


use app\admin\model\BaseModel;

/**
 * 消息通知
 * Class AdminNotify
 * @package app\admin\model\admin
 */
class AdminNotify extends BaseModel
{
    /**
     * 系统分页
     * @param array $where
     * @return array
     */
    public static function systemPage(array $where)
    {
        $model = new self;
        if ($where['is_read'] != '') $model = $model->where("is_read",$where['is_read']);
        $model = $model->order("add_time desc");
        $model = $model->page((int)$where['page'], (int)$where['limit']);
        $data = $model->select();
        return $data ? $data->toArray() : [];
    }
}