<?php
namespace app\index\controller;

use think\Request;

class Error
{
    public function index()
    {	

        return json(array('error'=>405,'message'=>'No routing path can be found for the request.'));
    }
}