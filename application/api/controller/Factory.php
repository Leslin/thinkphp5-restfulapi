<?php
/**
 * 
 */
namespace app\api\controller;


class Factory
{

    private static $Factory;

    private function __construct()
    {

    }

    public static function getInstance($className, $options = null)
    {
        if (!isset(self::$Factory[$className]) || !self::$Factory[$className]) {
            self::$Factory[$className] = new $className($options);
        }
        return self::$Factory[$className];
    }
}