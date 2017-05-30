<?php
namespace app\index\controller;

class Index
{
    public function index()
    {
//        全局异常处理
     return config('setting.img_prefix');

    }
}
