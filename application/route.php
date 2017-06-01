<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use think\Route;

//域名

//api
Route::domain('api',function (){
    Route::get(':version/sample', 'api/:version.Sample/getSample');
    //Banner
    Route::get(':version/banner/:id', 'api/:version.Banner/getBanner');

    //创建(注册)用户
    Route::post(':version/user', 'api/:version.User/createUser');
    //获取token
    Route::post(':version/token/user', 'api/:version.Token/getToken');
    //通过新浪获取token
    Route::post(':version/token/user/sina', 'api/:version.Token/getTokenBySina');
    //通过qq获取token
    Route::post(':version/token/user/qq', 'api/:version.Token/getTokenByQQ');

    //创建link
    Route::post(':version/link', 'api/:version.Link/createLink');
});
Route::get('','index/Index/index');
Route::get('test1','index/Index/test1');
