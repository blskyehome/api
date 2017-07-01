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
use app\api\validate\Page;
use app\api\validate\LinkNew;
use app\api\validate\LinkUpdate;
use app\lib\exception\BaseException;
use app\lib\exception\MissException;

use app\lib\exception\SuccessMessage;
use app\model\Link as LinkModel;
use think\Request;
use app\model\Category as CategoryModel;

class Link extends BaseController
{
    protected $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'createLink,getLinkByToken,deleteLink,updateLink,getUserLinkByCategoryIDAndToken,getLinkByCategory']
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
        $res = $link->save($data);
        if (!$res) {
            throw new BaseException();
        }
        throw new SuccessMessage(
            ['msg'=>$link]
        );
    }

    /*获取某个用户的公共link*/
    public function getLink($page = 1, $size = 3, $keyword = '', $orderby='create_time', $order = 'desc', $user_id)
    {
        (new Page())->goCheck();
        $link = new LinkModel();

        $condition['openness'] = 1;
        $condition['user_id'] = $user_id;
        $condition['comment|title'] = ['like', '%' . $keyword . '%'];

        $res = $link->getLinkList($condition, true, $page, $size, [$orderby => $order,]);

        return json($res);
    }


    /*获取某个用户所有的link*/
    public function getLinkByToken($page = 1, $size = 10, $keyword = '',$orderby='create_time', $order = 'desc')
    {
        (new Page())->goCheck();
        $link = new LinkModel();

        $condition['user_id'] = $this->user_info->id;
        $condition['comment|title'] = ['like', '%' . $keyword . '%'];

        $res = $link->getLinkList($condition, true, $page, $size, [$orderby => $order,]);
        return json($res);
    }


    public function getLinkByCategory(
        $page = 1, $size = 10, $keyword = '',$orderby='create_time', $order = 'desc',
        $page_link = 1, $size_link = 10, $keyword_link = '',$orderby_link='create_time', $order_link = 'desc'

    ){
        (new Page())->goCheck();
        $category_model = new CategoryModel();

        $condition['user_id'] = $this->user_info->id;
        $condition['name'] = ['like', '%' . $keyword . '%'];

        $category_list = $category_model->getCategoryList($condition, $page, $size, ['create_time' => $order,]);
        $link = new LinkModel();
        foreach ($category_list as $category){
            $condition_link['category_id']=$category['id'];
            $link_list = $link->getLinkList($condition_link, true, $page_link, $size_link, [$orderby_link => $order,]);
            $category['link_list']=$link_list;
        }
        return json($category_list);

    }

    /*获取所有公共link*/
    public function getLinkAll($page = 1, $size = 10, $keyword = '',$orderby='create_time', $order = 'desc')
    {

        (new Page())->goCheck();

        $link = new LinkModel();

        $condition['openness'] = 1;
        $condition['comment|title'] = ['like', '%' . $keyword . '%'];

        $res = $link->getLinkList($condition, true, $page, $size, [$orderby => $order,]);

        return json($res);
    }

    /*通过用户分类查看link*/
    /*查看共有*/
    public function getUserLinkByCategoryID($user_id, $category_id, $page = 1, $size = 10, $keyword = '',$orderby='create_time', $order = 'desc')
    {
//        (new IDMustBePositiveInt())->goCheck();
        (new Page())->goCheck();

        $link = new LinkModel();

        $condition['openness'] = 1;
        $condition['category_id'] = $category_id;
        $condition['user_id'] = $user_id;
        $condition['comment|title'] = ['like', '%' . $keyword . '%'];

        $res = $link->getLinkList($condition, true, $page, $size, [$orderby => $order,]);
        return json($res);

    }

    /*查看全部*/
    public function getUserLinkByCategoryIDAndToken($category_id, $page = 1, $size = 10, $keyword = '',$orderby='create_time', $order = 'desc')
    {
//        (new IDMustBePositiveInt())->goCheck();
        (new Page())->goCheck();

        $link = new LinkModel();

        $condition['category_id'] = $category_id;
        $condition['user_id'] = $this->user_info->id;

        $condition['comment|title'] = ['like', '%' . $keyword . '%'];

        $res = $link->getLinkList($condition, true, $page, $size, [$orderby => $order,]);
        return json($res);

    }

    /*删除link*/
    public function deleteLink($id)
    {

        (new IDMustBePositiveInt())->goCheck();
        $link_model = new LinkModel();
        $condition = [
            'user_id' => $this->user_info->id
        ];
        $link = $link_model->where($condition)->find($id);
        if (!$link) {
            throw new MissException();
        }
        $res= LinkModel::destroy($id);
        if (!$res){
            throw new BaseException();
        }
        throw new SuccessMessage(
            ['code'=>202,'msg'=>'删除成功']
        );
    }

    /*更改*/
    public function updateLink($id)
    {

        $validate = new LinkUpdate();
        $validate->goCheck();

        $params = Request::instance()->param();
        $data = [
            'category_id' => $params['category_id'],
            'comment' => $params['comment'],
            'openness' => $params['openness'],
            'title' => $params['title'],
            'url' => $params['url']
        ];
        $where = ['user_id' => $this->user_info->id, 'id' => $id];
        $res = LinkModel::update($data, $where);
        if (!$res){
            throw new BaseException();
        }
        throw new SuccessMessage(
            ['code'=>202,'msg'=>'更新成功']
        );
    }


    /*clicks*/
    public function updateLinkClicks($id)
    {

        $validate = new IDMustBePositiveInt();
        $validate->goCheck();
        $link_model = new LinkModel();
        $res=$link_model->where('id','=',$id)->setInc('clicks');
        if (!$res){
            throw new BaseException();
        }
        throw new SuccessMessage(
            ['code'=>202,'msg'=>'更新成功']
        );
    }



}