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

class LinksNew extends BaseValidate
{
    /*
     * 验证必填选项
     *
     * 验证传来的分类id 是否存在 且
     * */
    protected $rule = [
//        'openness' => 'require|isPositiveInteger',
        'category_id' => 'require|isNotEmpty|isPositiveInteger|isCategoryBelongToUser',
        'link_list'=>'require|isNotEmpty'
    ];

}