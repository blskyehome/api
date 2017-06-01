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

class UserNew extends BaseValidate
{

    protected $rule=[
        'email'=>'require|email|unique:users|isNotEmpty',
        'user_name'=>'require|unique:users|isNotEmpty',// unique 可检测是否在数据库中存在
        'password'=>'require|isNotEmpty'
    ];
}