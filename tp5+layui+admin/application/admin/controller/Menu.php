<?php
namespace app\admin\controller;
/**
 * 继承common控制器
 * Menu管控制器
 * 功能【1.Menu查询输出(index)。2.增加Menu（add）。3.修改Menu(edit)。4.删除Menu(del)】
 * Class Menu
 * @package app\admin\controller
 */
class Menu extends Common
{

    /**调用Menu模型model
     * @var string
     */
    private $model = 'Menu';

    /**查询所有数据
     * @return string
     */
    public function index()
    {
        $list = new \app\admin\model\Menu();
        return view('index',['role'=>$list]);
    }

    public function getlist(){
        $list = new \app\admin\model\Menu();
        $data = input('get.');
        $page = $data['page'];
        $limit = $data['limit'];
        $lst =  $list->getList($page,$limit);
        return $lst;
    }

    /**添加
     * @return string
     */
    public function add()
    {
        $table_model =  new \app\admin\model\Menu();//调用模型
        $data = input('post.');//获取post数据
        $listV = $table_model->addValidate($data);//验证不能为空的数据

        return  $listV ? $listV :  $table_model->add($data);
    }

//    查询一条消息
    public function getinfo(){
        $table_model = new \app\admin\model\Menu();
        $list =  $table_model->where('id',input('get.id'))->find();
        $list['type'] = $list['type'] == 1 ? true : false;
        return success_actionlist('获取成功',$list);
    }
    /**修改
     * @return string
     */
    public function edit()
    {
        $table_model =  new \app\admin\model\Menu();
        $data = input('post.');
        $list = $table_model->editValidate($data);
        return  $list ?  $list :  $table_model->edit($data,$data['id']);
    }

    /**
     * 删除
     * @return string
     */
    public function dele()
    {
        $table_model =  new \app\admin\model\Menu();
        $data = input('post.');
        $list = $table_model->delValidate($data);
        return  $list ?  $list :  $table_model->dele($data['id']);
    }

    public function getAllmenu(){
        $model = new \app\admin\model\Menu();
        $list = $model->where('type',1)->field('title,id,type')->select();
        array_unshift($list,['id'=>0,'title'=>"一级菜单",'type'=>1]);
        return success_actionlist('获取成功',$list);
    }
    public function getMenu(){
        $model = new \app\admin\model\Menu();
        $list = $model->order('sort asc,id desc')->select();
        return success_actionlist('获取成功',$model->roleList($list,0));
    }

}
