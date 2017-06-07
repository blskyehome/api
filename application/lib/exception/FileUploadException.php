<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2017/6/7
 * Time: 14:03
 * Description:
 */

namespace app\lib\exception;


class FileUploadException extends BaseException
{
    public $code = 400;
    public $msg = '文件上传失败';
    public $errorCode = 10007;
}