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
use app\model\Category;
use app\model\Link;
use app\model\Users as UserModel;
use app\api\validate\SendMail as SendMailValidate;
use app\api\validate\SendMailBase as SendMailBaseValidate;
use app\model\Users;
use app\api\service\UserToken as UserTokenService;


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

        //生成令牌
        $token=(new UserTokenService)->get(
            array(
                'flag'=>0,
                'user_name'=>$data['user_name'],
                'password'=>input('post.password') //因为data['password']是加密的
            )
        );
        //生成一个分类
        $data = [
            'name'=>'常用链接',
            'description'=>'我经常用到的链接'
        ];
        $category_model = new Category();
        $data['user_id'] = $user->id;
        $res=$category_model->save($data);
        if (!$res) {
            throw new BaseException();
        }
        throw new SuccessMessage(
            ['msg'=>array('ok',$token)]
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

    public function sendCaptchaBase()
    {
        $validate = new SendMailBaseValidate();
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

    /**
     * 获取用户信息，需要优化
     * @return \think\response\Json
     */
    public function getUserInfo(){

        $category_list=Category::getCategory('id,name',array('user_id'=>$this->user_info->id));
        $result['user']=Users::getUserById($this->user_info->id);
        $result['link_num']=Link::where('user_id', '=', $this->user_info->id)->count('id');
        $result['category_num']=Category::where('user_id', '=', $this->user_info->id)->count('id');

        foreach ($category_list as $key =>$value){
            //todo
            $category_list[$key]['link_num']=Link::where(
                array(
                    'user_id'=>$this->user_info->id,
                    'category_id'=>$value['id']
                )
            )->count('id');
            if ($result['link_num']!=0){
                $category_list[$key]['proportion']=round($category_list[$key]['link_num']/$result['link_num'],2);
            }else{
                $category_list[$key]['proportion']=0;
            }
            $category_list[$key]['color']='#'.random_color();
        }

        $result['category_list']=$category_list;
        $result['month_sum']=Link::getRecentMonthLinkSum(6,$this->user_info->id);//获取最近6个月的统计link

        return json($result);
    }
}