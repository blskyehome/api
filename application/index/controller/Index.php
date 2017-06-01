<?php
namespace app\index\controller;

use app\model\Users;
use think\Db;
use think\Exception;

class Index
{
    public function index()
    {
//        全局异常处理
     return config('setting.img_prefix');

    }
    public function test(){
        Db::transaction(function(){
            Db::table('bl_users')->find(2);
            Db::table('bl_users')->delete(2);
        });
    }

    public function test1(){
        Db::startTrans();
        try {
            Users::get(5)->delete();


            Db::commit();
        } catch (Exception $ex) {
            echo(1);
//            Db::rollback();
            // 如果出现异常，向微信返回false，请求重新发送通知

            return false;
        }
    }
}
