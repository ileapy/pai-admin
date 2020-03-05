<?php


namespace app\admin\controller\database;


use app\admin\controller\AuthController;


/**
 * Class Redis
 * @package app\admin\controller\database
 */
class Redis extends AuthController
{
    /**
     * keys列表
     * @return string
     * @throws \Exception
     */
    public function index()
    {
        $redis = app("redis");
        $redis->connect(config("cache.stores.redis.host"),config("cache.stores.redis.port"));
        if (config("cache.stores.redis.password")) $redis->auth(config("cache.stores.redis.password"));
        $redis->select(config("cache.stores.redis.select"));
        $this->assign("keys",$redis->keys('*'));
        return $this->fetch();
    }
}