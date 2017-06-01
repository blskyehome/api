<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2017/5/31
 * Time: 11:31
 * Description:
 */

namespace app\api\controller\v1;


use app\api\service\UserToken;
use app\api\validate\TokenGet;
use app\lib\exception\SuccessMessage;
use app\model\Users;

class Token
{

    public function getToken($params=[]){
        /*
         * 用户获取token需要验证
         * 用户名是否存在
         * 用户是否被删除
         * 用户名和密码是否匹配
         *
         * 登录后更新登录时间
         * */
        //验证
        $validate=new TokenGet();
        $validate->goCheck();

        $data=$validate->getDataByRule(input('post.'));

        //生成令牌
        $token=(new UserToken)->get($data);

        return json([
          'token'=>$token
        ]);
    }

    public function getTokenBySina(){

    }

}