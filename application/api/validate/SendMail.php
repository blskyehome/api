<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2017/6/5
 * Time: 9:26
 * Description:
 */

namespace app\api\validate;


class SendMail extends BaseValidate
{
    protected $rule=[
        'email'=>'require|isNotEmpty|unique:users'
    ];
}