<?php
// 事件定义文件
return [
    'bind'      => [
    ],

    'listen'    => [
        'task_1'=>[],//1秒钟执行的方法
        'task_5'=>[],//5秒钟执行的方法
        'task_10'=>[],//10秒钟执行的方法
        'task_30'=>[],//30秒钟执行的方法
        'task_60'=>[],//60秒钟执行的方法
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
        \learn\subscribes\TimerSubscribe::class, // 定时器
    ],
];
