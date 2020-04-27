<?php

use think\facade\Route;

// 公众号
Route::group(function () {
    Route::any('wechat/serve', 'wechat.WechatController/serve');//公众号服务
});

// 小程序 登录
Route::group(function () {
    Route::post('mini_program/openid', 'wechat.MiniProgramController/getOpenid');
});

// 需要登录的接口
Route::group(function () {

})->middleware(\learn\middleware\AllowOriginMiddleware::class);