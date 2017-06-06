<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2017/6/6
 * Time: 14:12
 * Description:
 */

namespace app\api\service;


use app\lib\tools\Base64Decode;
use app\model\Users;
use think\Db;
use app\model\Image as ImageModel;

class Image
{

    /**
     * @param $base64
     * @param $user_id
     * @return bool
     */
    public static function uploadAvatar($base64,$user_id){
        /*转换成图片 放到规定文件夹*/
        $image=(new Base64Decode($base64,md5(time().getRandChar(5)),'avatar'))->tran();
        Db::startTrans();
        try{
            /*将路径存到数据表中*/
            $image_model=new ImageModel();
            $image_model->save(['url'=>$image,'from'=>1]);
            /*更新用户表中的 avatar*/
            $user_model=new Users();
            $user_model->update(['avatar'=>$image_model->id],['id'=>$user_id]);
            // 提交事务
            Db::commit();
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
        }
        return true;
    }

}