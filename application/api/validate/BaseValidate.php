<?php
/**
 * Created by 七月
 * User: 七月
 * Date: 2017/2/14
 * Time: 12:16
 */

namespace app\api\validate;

use app\api\service\Token;
use app\lib\exception\BaseException;
use app\lib\exception\ForbiddenException;
use app\lib\exception\ParameterException;
use app\lib\exception\TokenException;
use app\model\UserToken;
use think\Cache;
use think\Exception;
use think\Request;
use think\Validate;

/**
 * Class BaseValidate
 * 验证类的基类
 */
class BaseValidate extends Validate
{
    /**
     * 检测所有客户端发来的参数是否符合验证类规则
     * 基类定义了很多自定义验证方法
     * 这些自定义验证方法其实，也可以直接调用
     * @throws ParameterException
     * @return true
     */
    public function goCheck()
    {
        //必须设置contetn-type:application/json
        $request = Request::instance();
        $params = $request->param();
//        $params['token'] = $request->header('token');

        if (!$this->check($params)) {
//            最终版
            $exception = new ParameterException(
                [
                    // $this->error有一个问题，并不是一定返回数组，需要判断
                    'msg' => is_array($this->error) ? implode(
                        ';', $this->error) : $this->error,
                ]);
            throw $exception;
//            throw new BaseException($this->error);
        }
        return true;
    }

    /**
     * @param array $arrays 通常传入request.post变量数组
     * @return array 按照规则key过滤后的变量数组
     * @throws ParameterException
     */
    public function getDataByRule($arrays)
    {
        if (array_key_exists('user_id', $arrays) | array_key_exists('uid', $arrays)) {
            // 不允许包含user_id或者uid，防止恶意覆盖user_id外键
            throw new ParameterException([
                'msg' => '参数中包含有非法的参数名user_id或者uid'
            ]);
        }
        $newArray = [];
//        var_dump($arrays);
        foreach ($this->rule as $key => $value) {
            $newArray[$key] = $arrays[$key];
            if (array_key_exists('password', $arrays)){
                $newArray['password']=salt_md5($arrays['password'],config('config.user_salt'));
            }
        }
        return $newArray;
    }

    /**
     * 是否是正整数
     * @param $value
     * @param string $rule
     * @param string $data
     * @param string $field
     * @return bool|string
     */
    protected function isPositiveInteger($value, $rule='', $data='', $field='')
    {
        if (is_numeric($value) && is_int($value + 0) && ($value + 0) > 0) {
            return true;
        }
        return $field . '必须是正整数';
    }

    /**
     * 是否为空
     * @param $value
     * @param string $rule
     * @param string $data
     * @param string $field
     * @return bool|string
     */
    protected function isNotEmpty($value, $rule='', $data='', $field='')
    {
        if (empty($value)) {
            return $field . '不允许为空';
        } else {
            return true;
        }
    }

    //没有使用TP的正则验证，集中在一处方便以后修改
    //不推荐使用正则，因为复用性太差
    //手机号的验证规则
    protected function isMobile($value)
    {
        $rule = '^1(3|4|5|7|8)[0-9]\d{8}$^';
        $result = preg_match($rule, $value);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 判断user token 是否存在
     * @param $value
     * @param string $rule
     * @param string $data
     * @param string $field
     * @return bool
     */
    protected function isUserToken($value, $rule='', $data='', $field=''){
        $result=UserToken::get(['token'=>$value]);
        if ($result) {
            return true;
        } else {
            return $field . ' 不正确';
        }
    }
    protected function isUrl($value, $rule='', $data='', $field=''){
        $result=filter_var($value, FILTER_VALIDATE_URL);
        if ($result) {
            return true;
        } else {
            return $field . '不是正确的url';
        }
    }

    /**
     * 验证分类id是否属于当前的token的用户
     * @param $value
     * @param string $rule
     * @param string $data
     * @param string $field
     * @return bool|string
     */
    protected function isCategoryBelongToUser($value, $rule='', $data='', $field=''){

        $request = Request::instance();
        $params = $request->param();
//        var_dump($params);
        //验证分类id是否存在 是否属于当前用户
        $token=UserToken::with(['categories'])->where(['token'=>$params['token']])->find();
        $result=$token->categories()->find($params['category_id']);
        if ($result) {
            return true;
        } else {
            return $field . '不正确';
        }
    }

    protected function isCaptchaBelongToMail($value, $rule='', $data='', $field=''){

        $request = Request::instance();
        $params = $request->param();

        $result=Cache::get($params['email']);

        if ($result==strtoupper($value)) {
            return true;
        } else {
            return  '验证码不正确';
        }
    }
    

}