<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2017/5/30
 * Time: 13:25
 * Description:
 */

namespace app\model;


class Banner extends BaseModel
{
    public function items(){
        return $this->hasMany('BannerItem','banner_id','id');
    }

    public static function getBannerById($id){
        $banner=self::with(['items','items.img'])->find($id);
        return $banner;
    }
}