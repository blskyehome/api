<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2017/5/21
 * Time: 14:46
 * Description:
 */

namespace app\lib\exception;


use think\Exception;

class BaseException extends Exception
{

    /*统一描述错误：状态码、描述信息、错误代码*/
    public $code = 400;
    public $msg = 'invalid parameters';
    public $errorCode = 999;

    public $shouldToClient = true;

    /**
     * 构造函数，接收一个关联数组
     * @param array $params 关联数组只应包含code、msg和errorCode，且不应该是空值
     */
    public function __construct($params=[])
    {
        if(!is_array($params)){
            return;
        }
        if(array_key_exists('code',$params)){
            $this->code = $params['code'];
        }
        if(array_key_exists('msg',$params)){
            $this->msg = $params['msg'];
        }
        if(array_key_exists('errorCode',$params)){
            $this->errorCode = $params['errorCode'];
        }
    }
}