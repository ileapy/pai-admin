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
}