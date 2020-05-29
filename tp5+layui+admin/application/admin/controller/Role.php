<?php
namespace app\admin\controller;
/**
 * 继承common控制器
 * Role管控制器
 * 功能【1.Role查询输出(index)。2.增加Role（add）。3.修改Role(edit)。4.删除Role(del)】
 * Class Menu
 * @package app\admin\controller
 */
class Role extends Common
{

    /**调用Role模型model
     * @var string
     */
    private $model = 'role';

    /**查询所有数据
     * @return string
     */
    public function index()
    {
        $list = new \app\admin\model\Role();
        return view('index',['role'=>$list]);
    }

    public function getlist(){
        $list = new \app\admin\model\Role();
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
        $table_model =  new \app\admin\model\Role();//调用模型
        $data = input('post.');//获取post数据
        $listV = $table_model->addValidate($data);//验证不能为空的数据

        return  $listV ? $listV :  $table_model->add($data);
    }

//    查询一条消息
    public function getinfo(){
        $table_model = new \app\admin\model\Role();
        $list =  $table_model->where('id',input('get.id'))->find();
        $list['status'] = $list['status'] == 1 ? true : false;
        $role = new \app\admin\model\AdminRole();
        $roles_= $role->where(['role_id'=>input('get.id')])->select();
        $seL = [];
        foreach ($roles_ as $k=>$v){
            $seL[] = $v['menu_id'];
        }
        $menu = new \app\admin\model\Menu();
        $mlist = $menu->select(implode(",", $seL));
        $men_ = [];
        foreach ($mlist as $k=>$v){
            if($v['type'] == 0){
                $men_[] = $v['id'];
            }
        }
        $list['role'] = array_unique($men_);
        return success_actionlist('获取成功',$list);
    }
    /**修改
     * @return string
     */
    public function edit()
    {
        $table_model =  new \app\admin\model\Role();
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
        $table_model =  new \app\admin\model\Role();
        $data = input('post.');
        $list = $table_model->delValidate($data);
        return  $list ?  $list :  $table_model->dele($data['id']);
    }

    public function getAllrole(){
        $model = new \app\admin\model\Menu();
        $list = $model->field('id,title,pid,type')->select();
        return success_actionlist('获取成功',$model->roleList($list,0));
    }
}
