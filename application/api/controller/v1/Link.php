<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2017/5/31
 * Time: 15:59
 * Description:
 */

namespace app\api\controller\v1;


use app\api\controller\BaseUserController;
use app\api\validate\LinkNew;

class Link extends BaseUserController
{
    public function createLink(){
        $validate=new LinkNew();
        $validate->goCheck();



    }

}