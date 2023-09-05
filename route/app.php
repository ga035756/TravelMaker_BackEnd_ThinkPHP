<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\facade\Route;

Route::get('think', function () {
    return 'hello,ThinkPHP6!';
});

Route::get('hello/:name', 'index/hello');

Route::post('/login', 'UserController/login')->middleware([\app\middleware\CorsMiddleware::class]);

Route::post('/register', 'UserController/register')->middleware([\app\middleware\CorsMiddleware::class]);

// Route::group('api', function () {
//     // 允许跨域请求
//     header("Access-Control-Allow-Origin: *");
//     header("Access-Control-Allow-Headers: *");
//     header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    
//     // 登录接口路由
//     Route::post('/login', 'LoginController/login');
// });

