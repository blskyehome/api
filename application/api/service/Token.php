<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2017/5/31
 * Time: 22:41
 * Description:
 */

namespace app\api\service;


use app\lib\exception\ForbiddenException;
use app\lib\exception\TokenException;
use app\model\UserToken;
use think\Exception;
use think\Request;

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

    // 用户专有权限
    public static function needExclusiveScope()
    {
        //验证token
        $scope = self::getCurrentTokenVar();
        if ($scope){
           return true;
        } else {
            throw new TokenException(['msg'=>1]);
        }
    }
    public static function getCurrentTokenVar()
    {
        $token = Request::instance()
            ->param('token');
        $vars = UserToken::get(['token'=>$token]);
        if (!$vars)
        {
            throw new TokenException();
        }
        else {
           return true;
        }
    }

}