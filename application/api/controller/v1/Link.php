<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2017/5/31
 * Time: 15:59
 * Description:
 */

namespace app\api\controller\v1;


use app\api\controller\BaseUserController;
use app\api\validate\LinkNew;
use app\model\Category;
use app\model\UserToken;

class Link extends BaseUserController
{

    /**
     * 添加link
     */
    public function createLink()
    {
        $validate = new LinkNew();
        $validate->goCheck();
        $data = $validate->getDataByRule(input('post.'));
        $link = new \app\model\Link();
        $data['user_id'] = $this->user_info->id;
        $link->save($data);
    }

}