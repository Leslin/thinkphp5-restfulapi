<?php
namespace app\api\validate;

use think\Validate;
/**
 * 生成token参数验证器
 */
class Token extends Validate
{
	
	protected $rule = [
        'appid'       =>  'require',
        'mobile'      =>  'mobile|require',
        'nonce'       =>  'require',
        'timestamp'   =>  'number|require',
        'sign'        =>  'require'
    ];

    protected $message  =   [
        'appid.require'    => 'appid不能为空',
        'mobile.mobile'    => '手机格式错误',
        'nonce.require'    => '随机数不能为空',
        'timestamp.number' => '时间戳格式错误',
        'sign.require'     => '签名不能为空',    
    ];
}