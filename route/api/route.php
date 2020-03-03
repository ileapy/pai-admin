<?php

use think\facade\Route;

Route::any('wechat/serve', 'wechat.WechatController/serve');//公众号服务