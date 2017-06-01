<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2017/5/31
 * Time: 22:41
 * Description:
 */

namespace app\api\service;


class Token
{
    /**
     * 生成令牌
     * @return string
     */
    public static function generateToken()
    {
        $randChar = getRandChar(32);
        $timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
        $tokenSalt = config('config.token_salt');
        return md5($randChar . $timestamp . $tokenSalt);
    }

}