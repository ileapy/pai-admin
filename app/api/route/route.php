<?php

use think\facade\Route;

// 公众号
Route::group(function () {
    Route::any('wechat/serve', 'wechat.WechatController/serve');//公众号服务
});

// 小程序 登录
Route::group(function () {
    // 获取openid
    Route::post('mini_program/openid', 'wechat.MiniProgramController/getOpenid');
    // 通过openid 和 用户信息 来交换 token
    Route::post('mini_program/login', 'wechat.MiniProgramController/login');
    // 获取轮播信息
    Route::get('index/swipe', 'index/swipe');
    // 获取 首页推荐视频 电视剧和列表
    Route::get('index/index', 'index/index');
});

// 更新用户信息
Route::group(function () {

})->middleware(\learn\middleware\AllowOriginMiddleware::class)->middleware(\learn\middleware\AuthTokenMiddleware::class);