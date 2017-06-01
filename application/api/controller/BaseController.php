<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2017/5/30
 * Time: 22:02
 * Description:
 */

namespace app\api\controller;


use think\Controller;
use think\Request;

class BaseController extends Controller
{
 public function __construct(Request $request)
 {
     parent::__construct($request);
     header('Access-Control-Allow-Origin: *');
     header("Access-Control-Allow-Headers: token,Origin, X-Requested-With, Content-Type, Accept");
     header('Access-Control-Allow-Methods: POST,GET');
     echo 123;
     if(request()->isOptions()){
         exit();
     }
 }
}