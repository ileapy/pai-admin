<?php

use think\facade\Route;

// 公众号
Route::group(function () {
    Route::any('wechat/serve', 'wechat.WechatController/serve');//公众号服务
    Route::any('wechat/notify', 'wechat.WechatController/notify');//公众号服务
});

// 小程序 不需要登录
Route::group(function () {
    // 小程序服务
    Route::any('mini_program/serve', 'wechat.MiniProgramController/serve');//公众号服务
    // 支付回调
    Route::post('mini_program/notify', 'wechat.MiniProgramController/notify');
    // 获取openid
    Route::post('mini_program/openid', 'wechat.MiniProgramController/getOpenid');
    // 通过openid 和 用户信息 来交换 token
    Route::post('mini_program/login', 'wechat.MiniProgramController/login');
    // 获取轮播信息
    Route::get('index/banner', 'index/banner');
    // 获取 首页推荐视频 电视剧和列表
    Route::get('index/index', 'index/index');
    // 小程序基础信息
    Route::get('index/base', 'index/base');
    // 视频搜索
    Route::post('video/lst', 'mini.mini_video/lst');
});

// 需要登录
Route::group(function () {
    // 获取视频信息
    Route::post('video/info', 'mini.mini_video/info');
    // 视频链接
    Route::post('video/url', 'mini.mini_video/url');
    // 播放时间记录
    Route::post('video/pause', 'mini.mini_video/pause');
    // 收藏
    Route::post('video/collect', 'mini.mini_video/collect');
    // 收藏记录
    Route::post('video/collect/lst', 'mini.mini_video/collect_index');
    // 记录
    Route::post('video/record', 'mini.mini_video/record');
    // 提交订单
    Route::post('order/order', 'mini.mini_video_order/order');
    // 支付调用
    Route::post('order/pay', 'mini.mini_video_order/pay');
    // 支付调用
    Route::post('order/buy', 'mini.mini_video_order/buyRecord');

})->middleware(\learn\middleware\AllowOriginMiddleware::class)->middleware(\learn\middleware\AuthTokenMiddleware::class);