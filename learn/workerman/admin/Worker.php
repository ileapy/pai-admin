<?php


namespace learn\workerman\admin;


use think\worker\Server;

/**
 * 后台ws服务
 * Class worker
 * @package learn\workerman\admin
 */
class worker extends Server
{
    protected $name = "admin";
}