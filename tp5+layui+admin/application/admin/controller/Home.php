<?php
namespace app\admin\controller;
/**
 * 继承common控制器
 * @package app\admin\controller
 */
class Home extends Common
{

    /**查询所有数据
     * @return string
     */
    public function index()
    {
        return view();
    }

    public function getNumber(){
        return success_action('获取成功',null,[]);

    }



}
