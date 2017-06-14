<?php
namespace app\api\controller\v1;
use app\api\controller\BaseController;
use app\model\Link;

/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2017/5/28
 * Time: 16:12
 * Description:
 */
class Sample extends BaseController
{

    public function getSample(){
        $link = new Link();

        $condition['openness'] = 1;
        $condition['user_id'] = 1;

        $res = $link->getLinkList($condition, true);

       return json($res);
    }
}