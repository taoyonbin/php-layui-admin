<?php
namespace app\admin\controller;
/**
 * 继承common控制器
 * XXXX管控制器
 * 功能【1.XXXX查询输出(index)。2.增加XXXX（add）。3.修改XXXX(edit)。4.删除XXXX(del)】
 * Class Menu
 * @package app\admin\controller
 */
class XXXX extends Common
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
        $list = model($this->model);
        return json_encode($list->getlist());
    }

    /**添加
     * @return string
     */
    public function add()
    {
        $table_model =  model($this->model);
        $data = input('post.');
        $list = $table_model->addVeri($data);
        return  $list ?  json_encode($list) :  json_encode($table_model->add($data));
    }

    /**修改
     * @return string
     */
    public function edit()
    {
        $table_model =  model($this->model);
        $data = input('post.');
        $list = $table_model->editVeri($data);
        return  $list ?  json_encode($list) :  json_encode($table_model->edit($data,$data['id']));
    }

    /**
     * 删除
     * @return string
     */
    public function del()
    {
        $table_model =  model($this->model);
        $data = input('post.');
        $list = $table_model->delVeri($data['id']);
        return  $list ?  json_encode($list) :  json_encode($table_model->del($data['id']));
    }
}
