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
use app\api\validate\UserNew;
use app\lib\exception\BaseException;
use app\lib\exception\SuccessMessage;
use app\model\Users as UserModel;

class User extends BaseController
{

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
}