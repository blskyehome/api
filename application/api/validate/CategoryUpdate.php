<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2017/7/1
 * Time: 15:26
 * Description:
 */

namespace app\api\validate;


use think\Request;
use app\model\UserToken as UserTokenModel;

class CategoryUpdate extends BaseValidate
{
    protected $rule=[
        'name'=>'require|isUserCategoryExist'
    ];

    /*user是否有此分类*/
    protected function isUserCategoryExist($value, $rule = '', $data = '', $field = ''){
        $request = Request::instance();
        $params = $request->param();
//        var_dump($params);
        //验证分类id是否存在 是否属于当前用户
        $token=UserTokenModel::with(['categories'])->where(['token'=>$params['token']])->find();
        $map['name']=['=',$params['name']];
        $map['id']=['<>',$params['id']];
        $result=$token->categories()->where($map)->find();
        if (!$result) {
            return true;
        } else {
            return $field . '已存在';
        }
    }
}