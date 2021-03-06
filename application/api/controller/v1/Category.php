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
use app\api\validate\CategoryUpdate;
use app\api\validate\IDMustBePositiveInt;
use app\api\validate\Page;
use app\lib\exception\BaseException;
use app\lib\exception\MissException;
use app\lib\exception\SuccessMessage;
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
        $params = Request::instance()->param();
        $data = [
           'name'=>$params['name'],
		   'description'=>$params['description']
        ];
        $category_model = new CategoryModel();
        $data['user_id'] = $this->user_info->id;
        $res=$category_model->save($data);
        if (!$res) {
            throw new BaseException();
        }
        throw new SuccessMessage(
            ['msg'=>'分类创建成功']
        );

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
        $res= CategoryModel::destroy($id);
        if (!$res) {
            throw new BaseException();
        }
        throw new SuccessMessage(
            ['code'=>202,'msg'=>'删除成功']
        );
    }
    public function updateCategory($id){
        $validate = new CategoryUpdate();
        $validate->goCheck();
        $params = Request::instance()->param();
        $data = [
           'name'=>$params['name'],
            'description'=>$params['description']
        ];
        $where=['user_id' => $this->user_info->id,'id'=>$id];
        $res = CategoryModel::update($data, $where);

        if (!$res){
            throw new BaseException();
        }
        throw new SuccessMessage(
            ['code'=>202,'msg'=>'更新成功']
        );

    }
}