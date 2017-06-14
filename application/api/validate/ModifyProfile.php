<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2017/6/5
 * Time: 21:48
 * Description:
 */

namespace app\api\validate;


use app\lib\exception\ParameterException;

class ModifyProfile extends BaseValidate
{

    protected $rule=[
        'user_name'=>'require|isNotEmpty|chsDash|length:3,25|unique:users'
    ];
    public function getDataByRule($arrays){
        $newArray = [];
        if (array_key_exists('user_name', $arrays)){
            $newArray['user_name']=$arrays['user_name'];
        }
        if (empty($newArray)){
            throw new ParameterException();
        }
        return $newArray;
    }

}