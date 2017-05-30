<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2017/5/28
 * Time: 16:38
 * Description:
 */

namespace app\api\controller\v1;


use app\api\validate\IDMustBePositiveInt;
use app\lib\exception\BaseException;
use app\lib\exception\MissException;
use think\Exception;

use app\model\Banner as BannerModel;

class Banner
{

    public function getBanner($id){
        //验证
        $validate = new IDMustBePositiveInt();
        $validate->goCheck();

        //查询
        $banner=BannerModel::getBannerById($id);

        //返回
        if (!$banner){
            throw new MissException([
                'msg'=>'请求的banner不存在',
                'errorCode'=>40000
            ]);
        }
        return $banner;
    }
}