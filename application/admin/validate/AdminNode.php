<?php
// +----------------------------------------------------------------------
// | tpadmin [a web admin based ThinkPHP5]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 tianpian All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: tianpian <tianpian0805@gmail.com>
// +----------------------------------------------------------------------

//------------------------
// 节点验证器
//-------------------------

namespace app\admin\validate;

use think\Validate;
use think\Db;

class AdminNode extends Validate
{
    protected $rule = [
        "title|标题"  => "require",
        "name|名称"   => "require|checkNode:1",
        "sort|排序"   => "require",
        "status|状态" => "require",
    ];

    //验证节点是否唯一
    protected function checkNode($value, $rule, $data)
    {
        if (isset($data['id']) && $data['id']) $where['id'] = ["neq", $data['id']];
        $where['pid'] = $data['pid'];
        $where['name'] = $data['name'];
        $where['isdelete'] = 0;

        return Db::name("AdminNode")->where($where)->find() ? "节点已经存在" : true;
    }
}