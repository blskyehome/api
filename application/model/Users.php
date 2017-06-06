<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2017/5/30
 * Time: 14:53
 * Description:
 */

namespace app\model;


class Users extends BaseModel
{

    protected $hidden=['id','last_login','password','delete_time','update_time','create_time'];
    public function avatarImage()
    {
        return $this->hasOne('Image','id','avatar');
    }
    /**
     * 手机号、用户名、邮箱 是否存在
     * @param $data
     * @return array|null|static
     */
    public function isUsernameExist($data){
        $user=[];
        if (array_key_exists('flag', $data)){
            switch ($data['flag']){
                case 1:
                    $user=self::get(
                        ['mobile'=>$data['user_name'],]
                    );
                    break;
                case 2:
                    $user=self::get(
                        ['email'=>$data['user_name'],]
                    );
                    break;
                default:
                    $user=self::get(
                        ['user_name'=>$data['user_name']]
                    );
            }
        }
        return $user;
    }

    /**
     * 验证用户密码正误
     * @param $data
     * @return array|null|static
     */
    public function isPasswordRight($data){
        $user=[];
        if (array_key_exists('flag', $data)){
            $arrays=[];
            $arrays['password']=salt_md5($data['password'],config('config.user_salt'));
            switch ($data['flag']){
                case 1:
                    $arrays['mobile']=$data['user_name'];
                    $user=self::get($arrays);
                    break;
                case 2:
                    $arrays['email']=$data['user_name'];
                    $user=self::get($arrays);
                    break;
                default:
                    $arrays['user_name']=$data['user_name'];
                    $user=self::get($arrays);
            }
        }
        return $user;
    }
    public static function getUserById($id){
        $user=self::with(['avatarImage'])->find($id);
        return $user;
    }

}