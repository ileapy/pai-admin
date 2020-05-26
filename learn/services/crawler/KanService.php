<?php


namespace learn\services\crawler;

use learn\utils\Curl;

/**
 * 360看视频
 * Class KanService
 * @package learn\services\crawler
 */
class KanService
{
    /**
     * 实例
     * @var null
     */
    private static $instance = null;

    /**
     * 视频地址
     * @var
     */
    public $url = null;

    /**
     * QQService constructor.
     * @param string $vid
     * @param string|null $type
     */
    public function __construct(string $vid, string $type = null)
    {
        $this->url = $this->detail_url.$vid.".html";
        if ($type !== null) $this->type = $type;
    }

    /**
     * @param string $vid
     * @param string|null $type
     * @return QQService|null
     */
    public static function app(string $vid,string $type = null)
    {
        (self::$instance == null) && (self::$instance = new self($vid,$type));
        return self::$instance;
    }

    /**
     * 获取链接内容
     * 去掉空格换行等
     */
    public function openUrl()
    {
        $this->html = Curl::app($this->url)->run();
        $this->html = preg_replace("/[\t\n\r]+/","",$this->html);
    }
}