<?php


namespace learn\workerman;


use Channel\Client;

class ChannelService
{
    /**
     * @var Client
     */
    protected $channel;

    /**
     * @var ChannelService
     */
    protected static $instance;

    /**
     * 监听地址
     * @var string
     */
    const LISTENHOST = '0.0.0.0';

    /**
     * 监听端口
     * @var string
     */
    const LISTENPORT = 1996;

    public function __construct()
    {
        self::connet();
    }

    public static function instance()
    {
        if (is_null(self::$instance))
            self::$instance = new self();

        return self::$instance;
    }

    public static function connet()
    {
        try {
            Client::connect(self::LISTENHOST, self::LISTENPORT);
        } catch (\Exception $e) {
        }
    }

    /**
     * 发送消息
     * @param string $type 类型
     * @param array|null $data 数据
     * @param array|null $ids 用户 id,不传为全部用户
     */
    public function send(string $type, ?array $data = null, ?array $ids = null)
    {
        $res = compact('type');
        if (!is_null($data))
            $res['data'] = $data;

        if (!is_null($ids) && count($ids))
            $res['ids'] = $ids;

        $this->trigger('LEARN', $res);
    }

    public function trigger(string $type, ?array $data = null)
    {
        Client::publish($type, $data);
    }
}