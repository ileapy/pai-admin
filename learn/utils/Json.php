<?php


namespace learn\utils;

use think\Response;

/**
 * Class Json
 * @package learn\utils
 */
class Json
{
    /**
     * 成功返回码
     * @var int
     */
    private static $SUCCESS_CODE = 200;

    /**
     * 失败返回状态码
     * @var int
     */
    private static $FAIL_CODE = 400;

    /**
     * layui返回状态码
     * @var int
     */
    private static $LAYUI_CODE = 0;

    /**
     * 默认成功返回
     * @var string
     */
    private static $DEFAULT_SUCCESS = 'success';

    /**
     * 默认失败返回
     * @var string
     */
    private static $DEFAULT_FAIL = 'fail';

    /**
     * 实例
     * @param int $status
     * @param string $msg
     * @param array|null $data
     * @return Response
     */
    public function instance(int $status, string $msg, ?array $data = null, int $count=0, $type = 'status'): Response
    {
        $res['msg'] = $msg;
        $res[$type] = $status;
        if ($type == 'code') $res['count'] = $count;
        if (!empty($data)) $res['data'] = $data;
        return Response::create($res, 'json', 200);
    }

    /**
     * 成功返回
     * @param string $msg
     * @param array|null $data
     * @return Response
     */
    public function success(string $msg = '', ?array $data = []): Response
    {
        if (is_array($msg))
        {
            $data = $msg;
            $msg = self::$DEFAULT_SUCCESS;
        }
        if ($msg == '') $msg = self::$DEFAULT_SUCCESS;
        return $this->instance(self::$SUCCESS_CODE,$msg,$data);
    }

    /**
     * 失败返回
     * @param string $msg
     * @param array|null $data
     * @return Response
     */
    public function fail(string $msg = '', ?array $data = []): Response
    {
        if (is_array($msg))
        {
            $data = $msg;
            $msg = self::$DEFAULT_FAIL;
        }
        if ($msg == '') $msg = self::$DEFAULT_SUCCESS;
        return $this->instance(self::$FAIL_CODE,$msg,$data);
    }

    /**
     * layui返回
     * @param string $msg
     * @param array|null $data
     * @return Response
     */
    public function layui(string $msg = '', ?array $data = []): Response
    {
        $count = 0;
        if (is_array($msg))
        {
            if (isset($msg['count'])) $count = $msg['count'];
            if (isset($msg['data'])) $data = $msg['data'];
            $msg = self::$DEFAULT_SUCCESS;
        }
        if ($msg == '') $msg = self::$DEFAULT_SUCCESS;
        return $this->instance(self::$LAYUI_CODE,$msg,$data,$count,"code");
    }
}