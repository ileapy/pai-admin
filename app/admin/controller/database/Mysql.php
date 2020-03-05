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

    public function index()
    {
        var_dump(config("database.connections.mysql.database"));
        $res = Db::query("SELECT TABLE_NAME,TABLE_COMMENT FROM information_schema.tables WHERE table_schema = '".config("database.connections.mysql.database")."';");
        var_dump($res);
        return $this->fetch();
    }
}