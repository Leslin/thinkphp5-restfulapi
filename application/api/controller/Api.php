<?php
namespace app\api\controller;

use think\Controller;
use think\Request;
use app\api\controller\Send;
use app\api\controller\Oauth;

/**
 * api 入口文件基类，需要控制权限的控制器都应该继承该类
 */
class Api
{	
	use Send;
	/**
     * @var \think\Request Request实例
     */
    protected $request;

    protected $clientInfo;

    /**
     * 不需要鉴权方法
     */
    protected $noAuth = [];

	/**
	 * 构造方法
	 * @param Request $request Request对象
	 */
	public function __construct(Request $request)
	{
		$this->request = $request;
		$this->init();
		$this->uid = $this->clientInfo['uid'];

	}

	/**
	 * 初始化
	 * 检查请求类型，数据格式等
	 */
	public function init()
	{	
		//所有ajax请求的options预请求都会直接返回200，如果需要单独针对某个类中的方法，可以在路由规则中进行配置
		if($this->request->isOptions()){

			return self::returnMsg(200,'success');
		}
		if(!Oauth::match($this->noAuth)){
			$oauth = app('app\api\controller\Oauth');   //tp5.1容器，直接绑定类到容器进行实例化
    		return $this->clientInfo = $oauth->authenticate();;
		}

	}

	/**
	 * 空方法
	 */
	public function _empty()
    {
        return self::returnMsg(404, 'empty method!');
    }
}