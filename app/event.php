<?php
// 事件定义文件
return [
    'bind'      => [
    ],

    'listen'    => [
        'AppInit'  => [],
        'HttpRun'  => [],
        'HttpEnd'  => [],
        'LogLevel' => [],
        'LogWrite' => [],
        'Test' => [],  // 后台通知测试
        'AdminLog' => [], // 操作日志记录
    ],

    'subscribe' => [
        \learn\subscribes\AdminSubscribe::class, // 操作记录
        \learn\subscribes\SystemSubscribe::class, // 系统通知
    ],
];
