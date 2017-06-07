<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2017/5/30
 * Time: 14:23
 * Description:
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\service\Image;
use app\api\validate\ModifyPassword;
use app\api\validate\ModifyProfile;
use app\api\validate\UploadFile;
use app\api\validate\UserNew;
use app\lib\exception\BaseException;
use app\lib\exception\FileUploadException;
use app\lib\exception\SuccessMessage;
use app\lib\tools\Base64Decode;
use app\lib\tools\SendMail;
use app\model\Users as UserModel;
use app\api\validate\SendMail as SendMailValidate;
use app\model\Users;


class User extends BaseController
{
    protected $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'updateProfile,uploadAvatar,getUserInfo']
    ];

    /*
     * 创建一个用户
     */
    public function createUser()
    {
        $validate = new UserNew();
        $validate->goCheck();

        $user = new UserModel();

        $data = $validate->getDataByRule(input('post.'));

        $result = $user->save($data);
        if (!$result) {
            throw new BaseException();
        }
        throw new SuccessMessage(
            ['msg'=>'用户创建成功']
        );
    }

    public function uploadAvatar()
    {
        (new UploadFile())->goCheck();
        $base64=input('post.file');
        $res =Image::uploadAvatar($base64,$this->user_info->id);
        if (!$res){
            throw new FileUploadException();
        }
        throw new SuccessMessage(
            ['code'=>202,'msg'=>'头像上传成功']

        );

    }

    public function updatePassword()
    {
        $validate = new ModifyPassword();
        $validate->goCheck();
        $data = $validate->getDataByRule(input('put.'));
        $res = Users::update(
            ['password' => salt_md5($data['password'],config('config.user_salt'))],
            ['email' => $data['email']]
        );
        if (!$res){
            throw new BaseException();
        }
        throw new SuccessMessage(
            ['code'=>202,'msg'=>'密码更新成功']

        );
    }

    public function updateProfile()
    {
        $validate = new ModifyProfile();
        $validate->goCheck();
        $data = $validate->getDataByRule(input('put.'));
        $res = Users::update(
            ['user_name' => $data['user_name']],
            ['id' => $this->user_info->id]
        );
        if (!$res){
            throw new BaseException();
        }
        throw new SuccessMessage(
            ['code'=>202,'msg'=>'个人信息更新成功']

        );

    }

    public function sendCaptcha()
    {
        $validate = new SendMailValidate();
        $validate->goCheck();
        $data = $validate->getDataByRule(input('post.'));
        $sendMail = new SendMail($data['email']);
        $result = $sendMail->sendCaptchaMail();
        if (!$result){
            throw new BaseException();
        }
        throw new SuccessMessage(
            ['msg'=>'邮件发送成功']
        );
    }
    public function getUserInfo(){
        $result=Users::getUserById($this->user_info->id);
        return json($result);
    }
}