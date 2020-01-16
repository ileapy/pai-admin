<?php


namespace learn\workerman\admin;


use learn\workerman\Response;
use learn\workerman\admin\WorkerService;
use Workerman\Connection\TcpConnection;
use Workerman\Worker;
use think\facade\Session;

class WorkerHandle
{
    protected $service;

    public function __construct(WorkerService &$service)
    {
        $this->service = &$service;
    }

    public function login(TcpConnection &$connection, array $res, Response $response)
    {
        if (!isset($res['data']) || !$sessionId = $res['data']) {
            return $response->close([
                'msg' => '授权失败!'
            ]);
        }

//        $session = new Session();
//        $session->init();
//        $session->setId($sessionId);
//
//        if (!$session->has('adminId') || !$session->has('adminInfo')) {
//            return $response->close([
//                'msg' => '授权失败!'
//            ]);
//        }
//
//        $connection->adminInfo = $session->get('adminInfo');
//        $connection->sessionId = $sessionId;
        $connection->adminInfo = ['id'=>1];
        $connection->sessionId = $sessionId;
        $this->service->setUser($connection);

        return $response->success();
    }

    /**
     * 超时关闭
     * @param Worker $worker
     * @param Response $response
     */
    public function timeoutClose(Worker $worker,Response $response)
    {
        $time_now = time();
        foreach ($worker->connections as $connection) {
            if ($time_now - $connection->lastMessageTime > 12) {
                $response->connection($connection)->close('timeout');
            }
        }
    }
}