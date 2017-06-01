<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2017/5/31
 * Time: 16:00
 * Description:
 */

namespace app\api\validate;

class LinkNew extends BaseValidate
{
    /*
     * 验证必填选项
     *
     * 验证传来的分类id 是否存在 且
     * */
    protected $rule=[
        'category_id'=>'require|isNotEmpty',
        'title'=>'require|isNotEmpty',// unique 可检测是否在数据库中存在
        'url'=>'require|isNotEmpty',
    ];
}