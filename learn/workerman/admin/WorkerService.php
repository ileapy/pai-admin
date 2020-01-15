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
     * @param Worker|null $worker
     */
    protected function init(Worker $worker = null)
    {
        parent::init();
        $this->worker = $worker;
        $this->handle = new WorkerHandle($this);
        $this->response = new Response();
    }

    /**
     * 连接
     * @param TcpConnection $connection
     */
    public function onConnect(TcpConnection $connection)
    {
        $this->connections[$connection->id] = $connection;
        $connection->lastMessageTime = time();
    }

    /**
     * 当获取到信息
     * @param $connection
     * @param $data
     */
    public function onMessage(TcpConnection $connection, $data)
    {
        var_dump($data);
        $connection->send('receive success');
    }

    /**
     * 连接关闭
     * @param TcpConnection $connection
     */
    public function onClose(TcpConnection $connection)
    {
        unset($this->connections[$connection->id]);
    }
}