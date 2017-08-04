<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2017/7/26
 * Time: 14:50
 * Description:
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\validate\Page;
use app\model\Tag as TagModel;

class Tag extends BaseController
{
    /*获取所有标签*/
    public function getTagAll()
    {
        $link = new TagModel();
        $condition=null;
        $res = $link->getTagList($condition, ['create_time' => 'asc',]);
        return json($res);
    }

}