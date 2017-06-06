<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2017/6/6
 * Time: 12:11
 * Description:
 */

namespace app\api\validate;


class UploadFile extends BaseValidate
{
    protected $rule=[
        'file'=>'require|isNotEmpty'
    ];

}