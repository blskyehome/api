<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2017/5/31
 * Time: 15:52
 * Description:
 */

namespace app\api\controller;


use app\api\validate\UserToken as UserTokenValidate;
use app\model\Users;
use app\model\UserToken;
use think\Request;

class BaseUserController extends BaseController
{
    protected $user_info;
    public function __construct(Request $request)
    {
        parent::__construct($request);
        /*
         * 验证器 验证token 是否传入 是否存在 如果存在则查找用户信息
         * */
//        var_dump(input('post.'));

        $validate=new UserTokenValidate();
        $validate->goCheck();

        $usertoken_model=new UserToken();

        $user_token=$usertoken_model->where(['token'=>input('post.token')])->find();
        $this->user_info=$user_token->users;
    }

}