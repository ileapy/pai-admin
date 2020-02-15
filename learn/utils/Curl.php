<?php


namespace learn\utils;

/**
 * Class Curl
 * @package learn\utils
 */
class Curl
{
    /**
     * 请求url
     * @var string
     */
    public $url;

    /**
     * 参数
     * @var array
     */
    public $params;

    /**
     * type
     * post get
     * @var string
     */
    public $type;

    /**
     * 请求头
     * @var array
     */
    public $header = array();

    /**
     * Curl constructor.
     * @param string $url
     * @param string $type
     * @param array $params
     */
    public function __construct(string $url, string $type = 'GET', array $params = [])
    {
        $this->url = $url;
        $this->type = $type;
        $this->params = $params;
    }

    /**
     * 设置请求头
     * @param $header
     */
    public function header($header)
    {
        $this->header = $header;
    }

    /**
     * GET 请求
     * @return bool|string
     */
    public function get()
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_TIMEOUT, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->header);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        $data = curl_exec($curl);
        if (!curl_error($curl)) {curl_close($curl);return $data;}
        else print "Error: " . curl_error($curl);
    }

    /**
     * POST 请求
     * @return bool|string
     */
    public function post()
    {
        var_dump($this->params);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->header);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE );
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE );
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $this->params);
        $data = curl_exec($curl);
        if (!curl_error($curl)) {curl_close($curl);return $data;}
        else print "Error: " . curl_error($curl);
    }

    /**
     * 自动运行
     * @return bool|string
     */
    public function run()
    {
        switch ($this->type)
        {
            case 'GET':
                return $this->get();
            case 'POST':
                return $this->post();
        }
    }
}