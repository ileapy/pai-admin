<?php


namespace app\admin\model\cms;


use app\admin\model\BaseModel;
use app\admin\model\ModelTrait;

/**
 * Class CmsCategory
 * @package app\admin\model\cms
 */
class CmsCategory extends BaseModel
{
    use ModelTrait;

    /**
     * 列表
     * @param $where
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function systemPage($where)
    {
        $model = new self;
        if ($where['name']) $model = $model->where("name","like", $where['name']);
        if ($where['status']) $model = $model->where("status", $where['status']);
        $data = $model->select();
        return $data ? $data->toArray() : [];
    }

    /**
     * 获取选择数据
     * @param int $pid
     * @param array $auth
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function lst(int $pid = 0, array $auth = []): array
    {
        $model = new self;
        $model = $model->where("pid",$pid);
        $model = $model->field(['name','id']);
        $model = $model->order(["rank desc","id"]);
        $data = $model->select()->each(function ($item) use ($auth)
        {
            $item['children'] = self::lst($item['id'],$auth);
        });
        return $data->toArray() ?: [];
    }

    /**
     * 遍历选择项
     * @param array $data
     * @param $list
     * @param int $num
     * @param bool $clear
     */
    public static function myOptions(array $data, &$list, $num = 0, $clear=true)
    {
        foreach ($data as $k=>$v)
        {
            $list[] = ['value'=>$v['id'],'label'=>self::cross($num).$v['name']];
            if (is_array($v['children']) && !empty($v['children'])) {
                self::myOptions($v['children'],$list,$num+1,false);
            }
        }
    }

    /**
     * 返回选择项
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function returnOptions(): array
    {
        $list = [];
        $list[] = ['label'=>'一级菜单','value'=>0];
        self::myOptions(self::lst(),$list, 1, true);
        return $list;
    }
}