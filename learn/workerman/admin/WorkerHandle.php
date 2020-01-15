<?php


namespace learn\workerman\admin;


use learn\workerman\Response;
use learn\workerman\admin\WorkerService;
use Workerman\Connection\TcpConnection;

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

        $session = app('session',[],true);
        $session->init();
        $session->setId($sessionId);
        $session->start();

        if (!$session->has('adminId') || !$session->has('adminInfo')) {
            return $response->close([
                'msg' => '授权失败!'
            ]);
        }

        $connection->adminInfo = $session->get('adminInfo');
        $connection->sessionId = $sessionId;
        $this->service->setUser($connection);

        return $response->success();
    }
}