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
        ''
    ],

    'subscribe' => [
        \learn\subscribes\AdminSubscribe::class, // 操作记录
        \learn\subscribes\SystemSubscribe::class, // 系统通知
    ],
];
