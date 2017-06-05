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
Route::domain('api', function () {
    Route::get(':version/sample', 'api/:version.Sample/getSample');
    //Banner
    Route::get(':version/banner/:id', 'api/:version.Banner/getBanner');

    //创建(注册)用户
    Route::post(':version/user', 'api/:version.User/createUser');
    //发送验证码
    Route::post(':version/user/captcha', 'api/:version.User/sendCaptcha');
    //获取token
    Route::post(':version/token/user', 'api/:version.Token/getToken');
    //通过新浪获取token
    Route::post(':version/token/user/sina', 'api/:version.Token/getTokenBySina');
    //通过qq获取token
    Route::post(':version/token/user/qq', 'api/:version.Token/getTokenByQQ');

    //user上传头像
    Route::post(':version/avatar', 'api/:version.User/uploadAvatar');
    //user更改用户名
    Route::put(':version/user/profile','api/:version.User/updateProfile');
    //更改密码
    Route::put(':version/user/password','api/:version.User/updatePassword');

    //创建分类
    Route::post(':version/category', 'api/:version.Category/createCategory');
    //分类查询
    /*http://api.blskye.dev/v1/link?page=1&size=4&orderby=clicks&order=acs*/
    Route::get(':version/user/category', 'api/:version.Category/getCategoryByToken');
    //删除分类
    Route::delete(':version/category/:id', 'api/:version.Category/deleteCategory');

    //修改分类
    Route::put(':version/category/:id','api/:version.Category/updateCategory');


    //创建link
    Route::post(':version/link', 'api/:version.Link/createLink');

    //获取link
    Route::get(':version/user/:user_id/link', 'api/:version.Link/getLink');//获取某个用户的公共link
    Route::get(':version/link', 'api/:version.Link/getLinkAll');//所有的公共link

    Route::get(':version/user/link', 'api/:version.Link/getLinkByToken');//用户自己的link

    Route::get(':version/user/:user_id/category/:category_id/link', 'api/:version.Link/getUserLinkByCategoryID');//分类下公共的link
    Route::get(':version/user/category/:category_id/link', 'api/:version.Link/getUserLinkByCategoryIDAndToken');//分类下所有的


    //修改link
    Route::put(':version/link/:id','api/:version.Link/updateLink');
    Route::put(':version/link/:id/clicks','api/:version.Link/updateLinkClicks');

    //删除link
    Route::delete(':version/link/:id', 'api/:version.Link/deleteLink');
    Route::get(':version/email','api/:version.User/sendEMail');

});
Route::get('', 'index/Index/index');
Route::get('test1', 'index/Index/test1');
