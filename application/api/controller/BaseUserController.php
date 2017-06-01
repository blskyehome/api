<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2017/5/31
 * Time: 15:52
 * Description:
 */

namespace app\api\controller;


use think\Request;

class BaseUserController extends BaseController
{
    protected $user_info;
    public function __construct(Request $request)
    {
        parent::__construct($request);
        /*伪代码*/
        $this->user_info=array(
            'user_id'=>'1'
        );

    }

}