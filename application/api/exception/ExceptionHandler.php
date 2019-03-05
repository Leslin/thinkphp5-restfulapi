<?php

namespace app\api\exception;

use think\exception\Handle;
use think\Log;
use Exception;

/**
 * 重写Handle的render方法，实现自定义异常消息
 * Class ExceptionHandler
 * @package app\api\library\exception
 */
class ExceptionHandler extends Handle
{
    private $code;
    private $message;
    private $statuscode;

    /**
     * 输出异常信息
     * @param Exception $e
     * @return \think\Response|\think\response\Json
     */
    public function render(Exception $e)
    {   
        $this->statuscode = $this->code = 500;

        if ($e instanceof BaseException) {  //是否异常实例
            $this->code = $e->code;
            $this->message = $e->message;
        } else {
            if (config('app_debug')) {   //是否开启debug模式，异常交给父类异常处理，否则输出json格式错误
                return parent::render($e);
            }
            $this->code = 500;
            $this->message = $e->getMessage() ?: '很抱歉，服务器内部错误';
            //$this->recordErrorLog($e);
        }
        // Http异常
        if ($e instanceof \think\exception\HttpException)
        {       
            $this->statuscode = $this->code = $e->getStatusCode();
        }
        return json(['msg' => $this->message, 'code' => $this->code,'data' => null],$this->statuscode);
    }

    /**
     * 将异常写入日志
     * @param Exception $e
     */
    private function recordErrorLog(Exception $e)
    {
        Log::record($e->getMessage(), 'error');
        Log::record($e->getTraceAsString(), 'error');
    }
}
