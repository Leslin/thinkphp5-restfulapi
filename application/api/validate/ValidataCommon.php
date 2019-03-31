<?php
namespace app\api\validate;

use app\api\controller\Send;

/**
 * 公共验证码方法
 * Class Common
 * @package app\api\validate
 */
class ValidataCommon
{
    use Send;
    /**
     * 默认支持验证规则
     * 更多验证规则请使用原生验证器
     * @var array
     */
    public static $dataRule = ['require','int','mobile'];

    /**
     * 接口参数公共验证方法
     * @param array $rule
     * @param array $data
     */
    static function validateCheck($rule = [],$data = []){
        if(is_array($rule) && is_array($data)){
            foreach ($rule as $k => $v){
                if(!in_array($v,self::$dataRule)){
                    return self::returnMsg(401,'fail','验证规则只支持require，int');
                }
                if(!isset($data[$k]) || empty($data[$k])){
                    return self::returnMsg(401,'fail',$k.'不能为空');
                }else{
                    if($v == 'int'){
                        if(!is_numeric($data[$k])){
                            return self::returnMsg(401,'fail',$k.'类型必须为'.$v);
                        }
                    }elseif ($v == 'mobile'){
                        if(!preg_match('/^1[3-9][0-9]\d{8}$/',$data[$k])){
                            return self::returnMsg(401,'fail',$k.'手机号格式错误');
                        }
                    }
                }
            }
        }else{
            return self::returnMsg(401,'fail','验证数据格式为数组');
        }

    }
}