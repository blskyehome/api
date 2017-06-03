<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2017/5/31
 * Time: 15:59
 * Description:
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\controller\BaseUserController;
use app\api\validate\IDMustBePositiveInt;
use app\api\validate\LinkGet;
use app\api\validate\LinkNew;
use app\lib\exception\MissException;
use app\model\BaseModel;
use app\model\Category;
use app\model\UserToken;
use app\model\Link as LinkModel;
use think\Request;

class Link extends BaseController
{
    protected $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'createLink,getLinkByToken,deleteLink']
    ];

    /**
     * 添加link
     */
    public function createLink()
    {
        $validate = new LinkNew();
        $validate->goCheck();
        $data = $validate->getDataByRule(input('post.'));
        $link = new LinkModel();
        $data['user_id'] = $this->user_info->id;
        $link->save($data);
        return json($this->user_info);
    }

    /*获取某个用户的公共link*/
    public function getLink($page = 1, $size = 3, $keyword = '', $order = 'desc',$user_id)
    {
        (new LinkGet())->goCheck();
        $link = new LinkModel();

        $condition['openness'] = 1;
        $condition['user_id']=$user_id;
        $condition['comment|title'] = ['like', '%' . $keyword . '%'];

        $res = $link->getLinkList($condition, $page, $size, ['create_time' => $order,]);

        return json($res);
    }

    /*获取某个用户所有的link*/
    public function getLinkByToken($page = 1, $size = 10, $keyword = '', $order = 'desc')
    {
        (new LinkGet())->goCheck();
        $link = new LinkModel();

        $condition['user_id']=$this->user_info->id;
        $condition['comment|title'] = ['like', '%' . $keyword . '%'];

        $res = $link->getLinkList($condition, $page, $size, ['create_time' => $order,]);
        return json($res);
    }

    /*获取所有公共link*/
    public function getLinkAll($page = 1, $size = 10, $keyword = '', $order = 'desc')
    {

        (new LinkGet())->goCheck();

        $link = new LinkModel();

        $condition['openness'] = 1;
        $condition['comment|title'] = ['like', '%' . $keyword . '%'];

        $res = $link->getLinkList($condition, $page, $size, ['create_time' => $order,]);
        return json($res);
    }

    /*删除link*/
    public function deleteLink($id){

        (new IDMustBePositiveInt())->goCheck();
       $link_model=new LinkModel();
       $condition=[
           'user_id'=>$this->user_info->id
       ];
       $link=$link_model->where($condition)->find($id);
       if (!$link){
           throw new MissException();
       }
        return LinkModel::destroy($id);
    }

}