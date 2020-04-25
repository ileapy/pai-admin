<?php

use think\facade\Route;

// 公众号
Route::group(function () {
    Route::any('wechat/serve', 'wechat.WechatController/serve');//公众号服务
});

// 公众号
Route::group(function () {
    Route::any('mini_program/openid', 'wechat.MiniProgramController/getOpenid');//公众号服务
});