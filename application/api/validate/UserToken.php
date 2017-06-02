<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2017/6/1
 * Time: 17:15
 * Description:
 */

namespace app\api\validate;


use think\Validate;

class UserToken extends BaseValidate
{
    protected $rule=[
        'token'=>'require|isNotEmpty|isUserToken'
    ];


}