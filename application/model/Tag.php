<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2017/7/26
 * Time: 14:48
 * Description:
 */

namespace app\model;


class Tag extends BaseModel
{
    public function getTagList($condition,$order = array(),$field = '*', $limit = 0)
    {
        $query= self::field($field)->where($condition)->order($order)->limit($limit);
        $res= $query->select();
        return $res;
    }
}