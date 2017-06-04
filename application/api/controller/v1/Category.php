<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2017/6/4
 * Time: 11:08
 * Description:
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\validate\CategoryNew;
use app\api\validate\IDMustBePositiveInt;
use app\api\validate\Page;
use app\lib\exception\MissException;
use app\model\Category as CategoryModel;
use think\Request;

class Category extends BaseController
{
    protected $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'createCategory,getCategoryByToken,deleteCategory,updateCategory']
    ];


    public function createCategory(){

        $validate = new CategoryNew();
        $validate->goCheck();
        $data = $validate->getDataByRule(input('post.'));
        $category_model = new CategoryModel();
        $data['user_id'] = $this->user_info->id;
        $res=$category_model->save($data);
        return json($res);

    }
    public function getCategoryByToken($page = 1, $size = 10, $keyword = '', $order = 'desc'){

        (new Page())->goCheck();
        $category_model = new CategoryModel();

        $condition['user_id'] = $this->user_info->id;
        $condition['name'] = ['like', '%' . $keyword . '%'];

        $res = $category_model->getCategoryList($condition, $page, $size, ['create_time' => $order,]);
        return json($res);
    }

    public function deleteCategory($id){

        (new IDMustBePositiveInt())->goCheck();
        $category_model = new CategoryModel();

        $condition = [
            'user_id' => $this->user_info->id
        ];
        $category = $category_model->where($condition)->find($id);
        if (!$category) {
            throw new MissException();
        }
        return CategoryModel::destroy($id);
    }
    public function updateCategory($id){
        $validate = new CategoryNew();
        $validate->goCheck();
        $params = Request::instance()->param();
        $data = [
           'name'=>$params['name']
        ];
        $where=['user_id' => $this->user_info->id,'id'=>$id];
        $res = CategoryModel::update($data, $where);

        return json($res);


    }
}