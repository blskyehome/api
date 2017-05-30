<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2017/5/30
 * Time: 13:42
 * Description:
 */

namespace app\model;



use think\Model;
use traits\model\SoftDelete;

class BaseModel extends Model
{
        use SoftDelete;
        protected $hidden=['update_time'];
}