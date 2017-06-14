<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2017/5/31
 * Time: 16:00
 * Description:
 */

namespace app\api\validate;

use app\lib\exception\ParameterException;

class LinkNew extends BaseValidate
{
    /*
     * 验证必填选项
     *
     * 验证传来的分类id 是否存在 且
     * */
    protected $rule = [
//        'token'=>'require',
        'openness' => 'require|isPositiveInteger',
        'category_id' => 'require|isNotEmpty|isPositiveInteger|isCategoryBelongToUser',
        'title' => 'max:100',// unique 可检测是否在数据库中存在
        'url' => 'require|isNotEmpty|url',
        'comment' => 'require'
    ];

    public function getDataByRule($arrays)
    {
        if (array_key_exists('user_id', $arrays) | array_key_exists('uid', $arrays)) {
            // 不允许包含user_id或者uid，防止恶意覆盖user_id外键
            throw new ParameterException([
                'msg' => '参数中包含有非法的参数名user_id或者uid'
            ]);
        }
        $newArray = [];
//        var_dump($arrays);
        foreach ($this->rule as $key => $value) {
            $newArray[$key] = $arrays[$key];
            if (array_key_exists('title', $arrays)) {
                if ($this->isNotEmpty($arrays['title']) !== true) {
                    $newArray['title'] = get_url_title($arrays['url']);
                }
            }
        }
        return $newArray;
    }


}