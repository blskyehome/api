<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2017/6/1
 * Time: 16:29
 * Description:
 */

namespace app\model;


class UserToken extends BaseModel
{
    public function  categories()
    {
        return $this->hasMany('Category','user_id','user_id');
    }

    public function users()
    {
        return $this->hasOne('Users','id','user_id');
    }
}