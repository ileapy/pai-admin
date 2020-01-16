<?php


namespace learn\workerman\channel;


use Channel\Server;
use Workerman\Connection\TcpConnection;
use Workerman\Worker;

class ChannelService
{

    /**
     * @var Server
     */
    private static $service;

    /**
     * 监听地址
     * @var string
     */
    const LISTENHOST = '0.0.0.0';

    /**
     * 监听端口
     * @var string
     */
    const LISTENPORT = 1995;

    /**
     * Worker instance.
     * @var Worker
     */
    protected $_worker = null;

    /**
     * 进程数
     * @var int
     */
    protected $count = 1;

    /**
     * 名称
     * @var string
     */
    protected $name = "ChannelServer";

    /**
     * Construct.
     * @param string $ip
     * @param int $port
     */
    public function __construct()
    {
        $this->instance();
    }

    public function instance()
    {
        $worker = new Worker("frame://".self::LISTENHOST.":".self::LISTENPORT);
        $worker->count = $this->count;
        $worker->name = $this->name;
        $worker->channels = array();
        $worker->onMessage = array($this, 'onMessage') ;
        $worker->onClose = array($this, 'onClose');
        $this->_worker = $worker;
    }
    /**
     * onClose
     * @return void
     */
    public function onClose($connection)
    {
        if(empty($connection->channels))
        {
            return;
        }
        foreach($connection->channels as $channel)
        {
            unset($this->_worker->channels[$channel][$connection->id]);
            if(empty($this->_worker->channels[$channel]))
            {
                unset($this->_worker->channels[$channel]);
            }
        }
    }

    /**
     * onMessage.
     * @param TcpConnection $connection
     * @param string $data
     */
    public function onMessage($connection, $data)
    {
        if(!$data)
        {
            return;
        }
        $worker = $this->_worker;
        $data = unserialize($data);
        $type = $data['type'];
        $channels = $data['channels'];
        switch($type)
        {
            case 'subscribe':
                foreach($channels as $channel)
                {
                    $connection->channels[$channel] = $channel;
                    $worker->channels[$channel][$connection->id] = $connection;
                }
                break;
            case 'unsubscribe':
                foreach($channels as $channel)
                {
                    if(isset($connection->channels[$channel]))
                    {
                        unset($connection->channels[$channel]);
                    }
                    if(isset($worker->channels[$channel][$connection->id]))
                    {
                        unset($worker->channels[$channel][$connection->id]);
                        if(empty($worker->channels[$channel]))
                        {
                            unset($worker->channels[$channel]);
                        }
                    }
                }
                break;
            case 'publish':
                foreach($channels as $channel)
                {
                    if(empty($worker->channels[$channel]))
                    {
                        continue;
                    }
                    $buffer = serialize(array('channel'=>$channel, 'data' => $data['data']))."\n";
                    foreach($worker->channels[$channel] as $connection)
                    {
                        $connection->send($buffer);
                    }
                }
                break;
        }
    }
}