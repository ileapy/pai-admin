<?php

use think\facade\Route;

Route::group(function () {
    Route::rule(':id', 'blog/read');
    Route::rule(':name', 'blog/read');
})->ext('html')->allowCrossDomain();