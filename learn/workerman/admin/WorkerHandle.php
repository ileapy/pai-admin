<?php


namespace learn\workerman\admin;

use learn\services\WechatService;
use learn\workerman\Response;
use learn\workerman\admin\WorkerService;
use Workerman\Connection\TcpConnection;
use Workerman\Worker;
use think\facade\Session;

/**
 * Class WorkerHandle
 * @package learn\workerman\admin
 */
class WorkerHandle
{
    protected $service;

    public function __construct(WorkerService &$service)
    {
        $this->service = &$service;
    }

    /**
     * 后台登录
     * @param TcpConnection $connection
     * @param array $res
     * @param Response $response
     * @return bool|null
     */
    public function login(TcpConnection &$connection, array $res, Response $response)
    {
        if (!isset($res['data']) || !$sessionId = $res['data']) {
            return $response->close([
                'msg' => '授权失败!'
            ]);
        }
        Session::setId($sessionId);
        Session::init();
        Session::save();
        if (!Session::has('adminId') || !Session::has('adminInfo')) {
            return $response->close([
                'msg' => '授权失败!'
            ]);
        }

        $connection->adminInfo = Session::get('adminInfo');
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
            if ($time_now - $connection->lastMessageTime > 28) {
                $response->connection($connection)->close('timeout');
            }
        }
    }

    /**
     * 后台微信扫码登录
     * @param TcpConnection $connection
     * @param array $res
     * @param Response $response
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function qrcode(TcpConnection &$connection, array $res, Response $response)
    {
        $response->connection($connection)->send('qrcode',['src'=>WechatService::temporary("type=login;method=wechat;token=$res[token]")]);
    }
}