<?php
// 应用公共文件

if (!function_exists('systemConfigMore'))
{
    /**
     * 获取系统配置值
     * @param array $formNames
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    function systemConfigMore(array $formNames): array
    {
        $res = \app\admin\model\system\SystemConfig::getValuesByFormNames($formNames);
        $data = [];
        foreach ($res as $k=>$v) $data[$v['form_name']] = $v['value'];
        return $data;
    }
}

if (!function_exists('paramToArray'))
{
    /**
     * 参数分割成数组
     * @param string $param
     * @param string $delimiter
     * @return array
     */
    function paramToArray(string $param, string $delimiter = "&"): array
    {
        $arr = [];
        foreach (explode($delimiter,$param) as $value)
        {
            $tmp = explode("=",$value);
            $arr[$tmp[0]] = $tmp[1];
        }
    }
}