<?php
/**
 * Created by 七月
 * User: 七月
 * Date: 2017/2/18
 * Time: 12:35
 */
namespace app\api\validate;

class TokenGet extends BaseValidate
{
    protected $rule = [
        'user_name' => 'require|isNotEmpty',
        'password'=> 'require|isNotEmpty'
    ];

  /*  protected $message=[
        'user_name' =>'11'
    ];*/

    /**
     * 判断用户名的类型 是手机号还是邮箱 还是真是用户名
     * @param array $arrays
     * @return array
     */
    public function getDataByRule($arrays){
        //判断user_name的类型
        $newArray = [];
        $newArray['flag']=0;
        foreach ($this->rule as $key => $value) {
            $newArray[$key] = $arrays[$key];
        }
        if (array_key_exists('user_name', $arrays)){
            if ($this->isMobile($arrays['user_name'])){
                $newArray['flag']=1;
            }
            if ($this->is($arrays['user_name'],'email')){
                $newArray['flag']=2;
            }
        }
        return $newArray;
    }
}
