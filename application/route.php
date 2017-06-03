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
    //获取link
    Route::get(':version/user/:user_id/link','api/:version.Link/getLink');//获取某个用户的公共link
    Route::get(':version/link','api/:version.Link/getLinkAll');//所有的公共link
    Route::get(':version/user/link','api/:version.Link/getLinkByToken');//用户自己的link
    //删除link
    Route::delete(':version/link/:id','api/:version.Link/deleteLink');



});
Route::get('','index/Index/index');
Route::get('test1','index/Index/test1');
