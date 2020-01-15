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
    /**
     * 协议
     * @var string
     */
    protected $protocol = "websocket";

    /**
     * 监听地址
     * @var string
     */
    protected $host = '0.0.0.0';

    /**
     * 端口
     * @var string
     */
    protected $port = 1996;

    /**
     * 基础配置
     * @var array
     */
    protected $option = [
        'count'		=> 1,
        'name'		=> 'admin'
    ];


}