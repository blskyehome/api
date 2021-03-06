<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2017/5/31
 * Time: 15:01
 * Description:
 */

namespace app\api\service;


use app\lib\exception\UserException;
use app\model\Users;
use app\model\UserToken as UserTokenModel;
use think\Db;

class UserToken extends Token
{
    /**
     * 获取用户令牌
     * @param $data
     * @return string
     * @throws UserException
     */
    public function get($data)
    {

        $user_model = new Users();

        $user = $user_model->isUsernameExist($data);
        if (!$user) {
            throw new UserException();
        }

        $user = $user_model->isPasswordRight($data);

        if (!$user) {
            throw new UserException(
                [
                    'code' => 403,
                    'msg' => '密码错误',
                    'errorCode' => 60001
                ]
            );
        }

        $token = $this->generateToken();

        /*记录token 修改用户最后一次登录时间*/
        Db::startTrans();
        try{
            $this->createUserToken($user->id, $token);
            $this->updateUserLastLogin($user->id);
            // 提交事务
            Db::commit();
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
        }
        return $token;

    }

    /**
     *
     * 在user_token 表中添加一条记录
     * @param $user_id
     * @param $token
     * @param string $client_type
     * @return false|int
     */
    private function createUserToken($user_id, $token, $client_type = 'chrome')
    {
        $user_token_model = new UserTokenModel();
        $res = $user_token_model->save(
            [
                'user_id' => $user_id,
                'token' => $token,
                'client_type' => $client_type
            ]
        );
        return $res;
    }

    /**
     * 更新最后一次获取令牌的时间（最后一次登录）
     * @param $user_id
     * @return $this
     */
    private function updateUserLastLogin($user_id){
        $res=Users::where('id', $user_id)
            ->update(['last_login' => time()]);
        return $res;
    }

}