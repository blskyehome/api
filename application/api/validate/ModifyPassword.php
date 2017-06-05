<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2017/6/5
 * Time: 21:16
 * Description:
 */

namespace app\api\validate;


class ModifyPassword extends BaseValidate
{

    protected $rule=[
        'email'=>'require|email|isNotEmpty',
        'password'=>'require|isNotEmpty',
        'captcha'=>'require|isNotEmpty|isCaptchaBelongToMail'
    ];
    public function getDataByRule($arrays){
        $newArray = [];
        if (array_key_exists('email', $arrays)){
            $newArray['email']=$arrays['email'];
        }
        if (array_key_exists('password', $arrays)){
            $newArray['password']=$arrays['password'];
        }
        return $newArray;
    }
}