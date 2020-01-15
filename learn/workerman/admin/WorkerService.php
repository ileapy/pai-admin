<?php


namespace learn\workerman\admin;


use learn\workerman\ChannelService;
use learn\workerman\Response;
use think\worker\Server;
use Workerman\Connection\TcpConnection;
use Workerman\Lib\Timer;
use Workerman\Worker;
use Channel\Client;

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
     * 定时程序
     * @var null
     */
    protected $time;

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
        $connection->send('receive success');
    }

    public function onWorkerStart(Worker $worker)
    {
//        ChannelService::connet();

//        Client::on('crmeb', function ($eventData) use ($worker) {
//            if (!isset($eventData['type']) || !$eventData['type']) return;
//            $ids = isset($eventData['ids']) && count($eventData['ids']) ? $eventData['ids'] : array_keys($this->user);
//            foreach ($ids as $id) {
//                if (isset($this->user[$id]))
//                    $this->response->connection($this->user[$id])->success($eventData['type'], $eventData['data'] ?? null);
//            }
//        });
        $task = new Worker();
        $task->count = 1;
        $this->timer = Timer::add(15, function () use (&$worker) {
            var_dump(time());
//            $time_now = time();
//            foreach ($worker->connections as $connection) {
//                if ($time_now - $connection->lastMessageTime > 12) {
//                    var_dump($time_now);
//                    var_dump($connection->lastMessageTime);
//                    $this->response->connection($connection)->close('timeout');
//                }
//            }
        });
        $task->runAll();
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