<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2017/5/31
 * Time: 15:59
 * Description:
 */

namespace app\model;


class Link extends BaseModel
{

    public function getLinkList($condition, $page = 0,$size=0,$order = array(),$field = '*', $limit = 0)
    {
        return self::field($field)->where($condition)->order($order)->limit($limit)->paginate($size, false, ['page' => $page]);
    }
}