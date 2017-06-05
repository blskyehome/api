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
use app\api\validate\ModifyPassword;
use app\api\validate\ModifyProfile;
use app\api\validate\UserNew;
use app\lib\exception\BaseException;
use app\lib\exception\SuccessMessage;
use app\lib\tools\SendMail;
use app\model\Users as UserModel;
use app\api\validate\SendMail as SendMailValidate;
use app\model\Users;


class User extends BaseController
{
    protected $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'updateProfile']
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

        throw new SuccessMessage();
    }

    public function uploadAvatar()
    {

        var_dump($_POST);
        exit();

        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('image');
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->validate(['size' => 156789, 'ext' => 'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'uploads');
        if ($info) {
            // 成功上传后 获取上传信息
            // 输出 jpg
            echo $info->getExtension();
            // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
            echo $info->getSaveName();
            // 输出 42a79759f284b767dfcb2a0197904287.jpg
            echo $info->getFilename();
        } else {
            // 上传失败获取错误信息
            echo $file->getError();
        }
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
        return json($res);
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
        return json($res);
    }

    public function sendCaptcha()
    {
        $validate = new SendMailValidate();
        $validate->goCheck();
        $data = $validate->getDataByRule(input('post.'));
        $sendMail = new SendMail($data['email']);
        $result = $sendMail->sendCaptchaMail();
        return json($result);
    }
}