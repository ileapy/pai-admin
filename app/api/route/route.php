<?php

use think\facade\Route;

// 公众号
Route::group(function () {
    Route::any('wechat/serve', 'wechat.WechatController/serve');//公众号服务
});

Route::get('think', function () {
    return 'hello,ThinkPHP6!';
});