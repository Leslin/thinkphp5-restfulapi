<?php
namespace app\api\controller;

use app\api\controller\Send;
/**
 * 异常提示
 */
class Exception
{
	use Send;

	/**
	 * 路由不存在情况
	 */
	public static function miss()
	{
		return self::returnMsg(404,'route not found');
	}
}