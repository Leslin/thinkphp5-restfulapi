<?php
/**
 * 授权失败
 */
namespace app\api\controller;

use think\Exception;

class UnauthorizedException extends Exception
{

    public $authenticate;


    public function __construct($challenge = 'Basic', $message = 'authentication Failed')
    {
        $this->authenticate = $challenge;
        $this->message = $message;
    }

    /**
     * 获取验证错误信息
     * @access public
     * @return array|string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * WWW-Authenticate challenge string
     * @return array
     */
    public function getHeaders()
    {
        return array('WWW-Authenticate' => $this->authenticate);
    }

}