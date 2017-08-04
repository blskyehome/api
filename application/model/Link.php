<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2017/5/31
 * Time: 15:59
 * Description:
 */

namespace app\model;


class Link extends BaseModel
{
    public function category()
    {
        return $this->hasOne('Category','id','category_id');
    }
    public function getLinkList($condition,$paginate = true, $page = 0,$size=0,$order = array(),$field = '*', $limit = 0)
    {
        $query= self::field($field)->where($condition)->order($order)->limit($limit);
        if ($paginate){
            $res=$query->paginate($size, false, ['page' => $page]);
        }else{
            $res= $query->select();
        }
        foreach ($res as $re){
            $re['category']=$re->category;
            $domain=get_domain($re['url']);
            $re['icon']='http://'.$domain.'/favicon.ico';
            $re['domain']=$domain;
        }
//        favicon.ico
        return $res;
    }

    public static function getUserLinkByCategoryID(
        $categoryID, $paginate = true, $page = 1, $size = 30)
    {
        $query = self::
        where('category_id', '=', $categoryID);
        if (!$paginate)
        {
            return $query->select();
        }
        else
        {
            // paginate 第二参数true表示采用简洁模式，简洁模式不需要查询记录总数
            return $query->paginate(
                $size, true, [
                'page' => $page
            ]);
        }
    }

    /**
     * 获取近几个月的link数量
     * @param $month
     * @param $user_id
     * @return array
     */
    public static function getRecentMonthLinkSum($month,$user_id){
        $link_sum=get_recent_months($month);//近6个月的起始时间戳
        foreach ($link_sum as $key => $value){
            $link_sum[$key]['sum']=Link::where(
                array(
                    'user_id'=>$user_id,
                )
            )->whereTime('create_time', 'between', [$value[0], $value[1]])->count('id');
            $link_sum[$key]['month']=date('Y-m',$value[0]);
        }
        return $link_sum;
    }


}