<?php


namespace app\admin\controller\database;


use app\admin\controller\AuthController;
use think\Db;

/**
 * 数据库表
 * Class Mysql
 * @package app\admin\controller\database
 */
class Mysql extends AuthController
{

    public function index()
    {
        $res = Db::query("SELECT TABLE_NAME,TABLE_COMMENT FROM information_schema.tables WHERE table_schema = '".config("database.connections.mysql.database")."';");
        var_dump($res);
        return $this->fetch();
    }
}