<?php

namespace app\api\controller\v1;

use think\Controller;
use think\Request;
use app\api\controller\Api;
use app\api\common\Page;
use app\api\validate\ValidataCommon;

class User extends Api
{   
    /**
     * 不需要鉴权方法
     * index、save不需要鉴权
     * ['index','save']
     * 所有方法都不需要鉴权
     * [*]
     */
    protected $noAuth = ['create'];
    
    /** 
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {  
       //通用参数验证
        ValidataCommon::validateCheck(['lng' => 'require', 'lat' => 'require'], $this->request->param('')); //参数验证
        //通用分页
        list($page, $size) = Page::getPage($this->request->param(''));
        echo($this->uid);
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        echo "create";
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        dump($this->uid);
        echo "save";
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        echo "read";
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        echo "edit";
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        echo "update";
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        echo "delete";
    }
}
