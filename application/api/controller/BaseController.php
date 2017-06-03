<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2017/5/30
 * Time: 22:02
 * Description:
 */

namespace app\api\controller;


use app\api\service\Token;
use app\model\UserToken;
use think\Controller;
use think\Request;
use app\api\validate\UserToken as UserTokenValidate;


class BaseController extends Controller
{
    protected $user_info;


    /*需要用户自己登录才能查看*/
    protected function checkExclusiveScope()
    {
        /*
        * 验证器 验证token 是否传入 是否存在 如果存在则查找用户信息
        * */
//        var_dump(input('post.'));

        $validate=new UserTokenValidate();
        $validate->goCheck();
        Token::needExclusiveScope();

        $usertoken_model=new UserToken();

        $request = Request::instance();
        $params = $request->param();

        $user_token=$usertoken_model->where(['token'=>$params['token']])->find();
        $this->user_info=$user_token->users;
    }

}