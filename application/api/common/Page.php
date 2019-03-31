<?php
namespace app\api\common;

use think\Controller;

class Page extends Controller
{
    /**
     * 设置分页数据
     * 如果客户端没传，默认取第一页，每页10条
     * 客户端传参数，以为客户端为准
     * @param array $data
     * @param int $page
     * @param int $size
     * @return array
     */
    static function getPage($data = [],$page = 1,$size = 10){
        if(isset($data['page']) && isset($data['size'])){
            $where_page = $data['page'];
            $where_size = $data['size'];
        }else{
            $where_page = $page;
            $where_size = $size;
        }
        return [$where_page,$where_size];
    }
}