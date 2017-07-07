<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2017/5/31
 * Time: 11:31
 * Description:
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\service\UserToken;
use app\api\validate\TokenGet;
use app\lib\exception\BaseException;
use app\lib\exception\MissException;
use app\lib\exception\SuccessMessage;
use app\model\Users;
use think\Request;

class Token extends BaseController
{
    protected $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'deleteToken']
    ];

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

    public function deleteToken($token){
        $validate=new \app\api\validate\UserToken();
        $validate->goCheck();
        $params = Request::instance()->param();
        $token=$params['token'];
        $condition = [
            'user_id' => $this->user_info->id,
            'token'=>$token
        ];
        $token_model=new \app\model\UserToken();
        $user_token = $token_model->where($condition)->find();
        if (!$user_token) {
            throw new MissException();
        }
        $res= \app\model\UserToken::destroy($user_token['id']);
        if (!$res){
            throw new BaseException();
        }
        throw new SuccessMessage(
            ['code'=>202,'msg'=>'删除成功']
        );
    }

}