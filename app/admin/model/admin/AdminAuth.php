<?php


namespace app\admin\model\admin;


use app\admin\model\BaseModel;
use app\admin\model\ModelTrait;

/**
 * 操作权限
 * Class AdminAuth
 * @package app\admin\model\admin
 */
class AdminAuth extends BaseModel
{
    use ModelTrait;

    /**
     * 获取权限id 找不到是返回 -1
     * @param string $module
     * @param string $controller
     * @param string $action
     * @return int
     */
    public static function getAuthId(string $module, string $controller,string $action): int
    {
        return self::where("module",$module)->where("controller",$controller)->where("action",$action)->value('id') ?: -1;
    }

    /**
     * 获取菜单
     * @param int $pid
     * @param array $auth
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function getMenu(int $pid = 0, array $auth = []): array
    {
        $model = new self;
        $model = $model->where("is_menu",1);
        $model = $model->where("status",1);
        $model = $model->where("pid",$pid);
        if ($auth != []) $model = $model->where("id",'in',$auth);
        $model = $model->field(['name as title','path as href','icon','id','font_family as fontFamily','is_check as isCheck','spreed']);
        $model = $model->order(["rank desc","id"]);
        $data = $model->select()->each(function ($item) use ($auth)
        {
            $item['children'] = self::getMenu($item['id'],$auth);
            $item['isCheck'] = $item['isCheck'] ? true : false;
            $item['spreed'] = $item['spreed'] ? true : false;
        });
        return $data->toArray() ?: [];
    }

    /**
     * 权限列表
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function systemPage(): array
    {
        $model = new self;
        $model = $model->field(['id','name','icon','pid','module','controller','action','params','is_menu','path','rank','status']);
        $model = $model->order(["rank desc","id"]);
        $data = $model->select();
        return $data->toArray() ?: [];
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
        if ($auth != []) $model = $model->where("id",'in',$auth);
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
        $list[] = ['value'=>0,'label'=>'总后台'];
        self::myOptions(self::lst(),$list, 1, true);
        return $list;
    }

    /**
     * 横线
     * @param int $num
     * @return string
     */
    public static function cross(int $num=0): string
    {
        $str = "";
        if ($num == 1) $str .= "|--";
        elseif ($num > 1) for($i=0;$i<$num;$i++)
            if ($i==0) $str .= "|--";
            else $str .= "--";
        return $str." ";
    }

    /**
     * 生成treeData
     * @param int $pid
     * @param array $auth
     * @param array $checkedAuth
     * @param array $list
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function selectAndBuildTree(int $pid = 0, array $auth = [], array $checkedAuth = [])
    {
        $list = [];
        $model = new self;
        $model = $model->where("pid",$pid);
        if ($auth != []) $model = $model->where("id",'in',$auth);
        $model = $model->field(['name','id']);
        $model = $model->order(["rank desc","id"]);
        $model->select()->each(function ($item) use ($auth,$checkedAuth)
        {
//            var_dump(AdminRole::buildTreeData($item['id'],$item['name'],in_array($item['id'],$checkedAuth),self::selectAndBuildTree($item['id'],$auth,$checkedAuth)));
            $list[] = AdminRole::buildTreeData($item['id'],$item['name'],in_array($item['id'],$checkedAuth),self::selectAndBuildTree($item['id'],$auth,$checkedAuth));
        });
        var_dump($list);
        return $list;
    }
}