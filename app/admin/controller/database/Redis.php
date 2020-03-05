<?php


namespace app\admin\controller\database;


use app\admin\controller\AuthController;


/**
 * Class Redis
 * @package app\admin\controller\database
 */
class Redis extends AuthController
{

    public function index()
    {
        $redis = app("redis");
        $redis->connect("127.0.0.1",6379);
        var_dump($redis->keys('*'));
    }
}