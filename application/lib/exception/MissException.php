<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2017/5/28
 * Time: 17:17
 * Description:
 */

namespace app\lib\exception;


class MissException extends BaseException
{
    public $code = 404;
    public $msg = 'global:your required resource are not found';
    public $errorCode = 10001;
}