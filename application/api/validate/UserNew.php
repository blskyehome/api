<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2017/5/30
 * Time: 14:25
 * Description:
 */

namespace app\api\validate;


use app\lib\exception\ParameterException;
use think\Cache;
use think\Request;

class UserNew extends BaseValidate
{

    protected $rule=[
        'email'=>'require|email|unique:users|isNotEmpty',
        'user_name'=>'require|unique:users|isNotEmpty',// unique 可检测是否在数据库中存在
        'password'=>'require|isNotEmpty',
        'captcha'=>'require|isNotEmpty|isCaptchaBelongToMail'
    ];
    protected function isCaptchaBelongToMail($value, $rule='', $data='', $field=''){

        $request = Request::instance();
        $params = $request->param();

        $result=Cache::get($params['email']);

        if ($result==strtoupper($value)) {
            return true;
        } else {
            return  '验证码不正确';
        }
    }
    public function getDataByRule($arrays){
        $newArray = [];
        if (array_key_exists('password', $arrays)){
            $newArray['password']=salt_md5($arrays['password'],config('config.user_salt'));
        }
        if (array_key_exists('email', $arrays)){
            $newArray['email']=$arrays['email'];
        }
        if (array_key_exists('user_name', $arrays)){
            $newArray['user_name']=$arrays['user_name'];
        }
        return $newArray;
    }

}