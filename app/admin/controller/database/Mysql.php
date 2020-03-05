<?php


namespace app\admin\controller\database;


use app\admin\controller\AuthController;
use think\facade\Db;

/**
 * 数据库表
 * Class Mysql
 * @package app\admin\controller\database
 */
class Mysql extends AuthController
{
    /**
     * 数据库列表
     * @return string
     * @throws \Exception
     */
    public function index()
    {
        $this->assign("tables",Db::query("SELECT TABLE_NAME,TABLE_COMMENT FROM information_schema.tables WHERE table_schema = '".config("database.connections.mysql.database")."';"));
        return $this->fetch();
    }

    /**
     * 获取表结构
     * @param $table_name
     * @return string
     * @throws \Exception
     */
    public function detail($table_name = "")
    {
        if (!$table_name) return "表名为空";
        $this->assign("table_name",$table_name);
        $this->assign("info",Db::query("select COLUMN_NAME,COLUMN_TYPE,COLUMN_COMMENT from information_schema.columns where table_schema = '".config("database.connections.mysql.database")."' and table_name = '".$table_name."';"));
        return $this->fetch();
    }
}