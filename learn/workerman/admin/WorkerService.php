<?php


namespace learn\workerman\admin;


use learn\workerman\Response;
use think\worker\Server;
use Workerman\Connection\TcpConnection;
use Workerman\Worker;

/**
 * 后台ws服务
 * Class worker
 * @package learn\workerman\admin
 */
class WorkerService extends Server
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

    /**
     * @var Worker
     */
    protected $worker;

    /**
     * @var TcpConnection[]
     */
    protected $connections = [];

    /**
     * @var TcpConnection[]
     */
    protected $user = [];

    /**
     * @var WorkerHandle
     */
    protected $handle;

    /**
     * @var Response
     */
    protected $response;

    public function setUser(TcpConnection $connection)
    {
        $this->user[$connection->adminInfo['id']] = $connection;
    }

    /**
     * worker constructor.
     */
    protected function init(Worker $worker = null)
    {
        parent::init();
        $this->worker = $worker;
        $this->handle = new WorkerHandle($this);
        $this->response = new Response();
    }

    /**
     * 当获取到信息
     * @param $connection
     * @param $data
     */
    public function onMessage(TcpConnection $connection, $data)
    {
        $connection->send('receive success');
    }

    public function onConnect($connection, $data)
    {

    }
}