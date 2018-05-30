<?php
/**
 * 授权基类，所有获取access_token以及验证access_token 异常都在此类中完成
 */
namespace app\api\controller;

use think\Controller;
use think\Request;
use think\Config;
use think\Exception;
use app\api\controller\Factory;
use app\api\controller\Send;
use think\response\Redirect;
use app\api\controller\UnauthorizedException;

class Api extends Controller
{	
	use Send;

	/**
     * 对应操作
     * @var array
     */
    public $methodToAction = [
        'get' => 'read',
        'post' => 'save',
        'put' => 'update',
        'delete' => 'delete',
        'patch' => 'patch',
        'head' => 'head',
        'options' => 'options',
    ];
    /**
     *  允许访问的请求类型
     * @var string
     */
    public $restMethodList = 'get|post|put|delete|patch|head|options';
    /** 
     * 默认不验证 
     * @var bool 
     */
    public $apiAuth = false;

	protected $request;
	/**
     * 当前请求类型
     * @var string
     */
    protected $method;
    /**
     * 当前资源类型
     * @var string
     */
    protected $type;

    public static $app;
    /**
     * 返回的资源类的
     * @var string
     */
    protected $restTypeList = 'json';
    /**
     * REST允许输出的资源类型列表
     * @var array
     */
    protected $restOutputType = [ 
        'json' => 'application/json',
    ];

    /**
     * 客户端信息
     */
    protected $clientInfo;
	/**
	 * 控制器初始化操作
	 */
	public function _initialize()
    {	
    	$request = Request::instance();
    	$this->request = $request;
        $this->init();    //请求方法检查 
        $this->clientInfo = $this->checkAuth();  //接口权限检查  
    } 

    /**
     * 初始化方法 
     * 检测请求类型，数据格式等操作
     */
    public function init()
    { 
    	// 资源类型检测
        $request = Request::instance();
        $ext = $request->ext();
        if ('' == $ext) {
            // 自动检测资源类型
            $this->type = $request->type();
        } elseif (!preg_match('/\(' . $this->restTypeList . '\)$/i', $ext)) {
            // 资源类型非法 则用默认资源类型访问 
            $this->type = $this->restDefaultType;
        } else {
            $this->type = $ext;
        }
        $this->setType();
        // 请求方式检测
        $method = strtolower($request->method());
        $this->method = $method;
        //这里可以加入header，防止前端ajax跨域
        if (false === stripos($this->restMethodList, $method)) {

          return self::returnmsg(405,'Method Not Allowed',[],["access-control-request-method" => $this->restMethodList]);
        }
    }

    /**
     * 检测客户端是否有权限调用接口 
     */
    public function checkAuth()
    {	
    	$baseAuth = Factory::getInstance(\app\api\controller\Oauth::class);
    	$clientInfo = $baseAuth->authenticate();
    	return $clientInfo;
    }
    /**
     * 空操作
     * 404 
     * @return \think\Response|\think\response\Json|\think\response\Jsonp|\think\response\Xml
     */
    public function _empty()
    {
        return $this->sendSuccess([], 'empty method!', 200);
    }
}