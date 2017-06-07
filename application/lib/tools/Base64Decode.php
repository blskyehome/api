<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2017/6/6
 * Time: 11:55
 * Description:
 */

namespace app\lib\tools;


use app\lib\exception\Base64DecodeException;
use app\lib\exception\FileUploadException;
use think\Exception;

class Base64Decode
{
    protected $base64;
    protected $file_name;
    protected $file_location;

    /**
     * Base64Decode constructor.
     * @param $base64
     * @param $file_name
     * @param $file_location
     */
    public function __construct($base64, $file_name, $file_location)
    {
        $this->base64 = $base64;
        $this->file_name = $file_name;
        $this->file_location = $file_location;
    }

    /**
     * @return string
     * @throws Exception
     */
    public function  tran(){
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $this->base64, $result)){
            $type = $result[2];
            $new_file = "{$this->file_location}/{$this->file_name}.{$type}";
            if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $this->base64)))){
                return $new_file;
            }
            else{
                throw new FileUploadException();
            }
        }else {
            throw new Base64DecodeException();
        }
    }

}