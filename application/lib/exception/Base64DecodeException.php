<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2017/6/7
 * Time: 11:58
 * Description:
 */

namespace app\lib\exception;


class Base64DecodeException extends BaseException
{
    public $code = 400;
    public $msg = 'base64 转文件 失败';
    public $errorCode = 10006;
}