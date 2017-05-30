<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2017/5/30
 * Time: 13:47
 * Description:
 */

namespace app\model;


class BannerItem extends BaseModel
{
    protected $hidden =['img_id','create_time','banner_id','update_time'];
    public function img(){
        return $this->belongsTo('Image','img_id','id');
    }
}