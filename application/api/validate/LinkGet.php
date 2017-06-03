<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2017/6/3
 * Time: 10:53
 * Description:
 */

namespace app\api\validate;


class LinkGet extends BaseValidate
{
    protected $rule=[
            'start'=>'isPositiveInteger',
            'page'=>'isPositiveInteger'
    ];

}