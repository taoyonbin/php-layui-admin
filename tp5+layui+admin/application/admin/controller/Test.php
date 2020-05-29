<?php
namespace app\admin\controller;
/**
 * 继承common控制器
 * XXXX管控制器
 * 功能【1.XXXX查询输出(index)。2.增加XXXX（add）。3.修改XXXX(edit)。4.删除XXXX(del)】
 * Class Menu
 * @package app\admin\controller
 */
class Test extends Common
{
    /**调用XXXX模型model
     * @var string
     */
    private $model = 'XXXX';
    /**查询所有数据
     * @return string
     */
    public function index()
    {
//        if(!input('get.id')){
//            $this->success('请求失败','test/errs',null,0);
//        }else{
//            return view();
//        }
        return view();
    }
    public function add(){
        if(input('get.id')){
            $this->success('404');
        }
    }

    public function edit(){
        return view('edit');
    }

    public function errs(){
        return view('404');
    }



}
