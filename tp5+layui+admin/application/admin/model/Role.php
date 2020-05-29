<?php
/**
 * Created by PhpStorm.
 * User: YOULIN
 * Date: 2019-08-22
 * Time: 14:40
 */
namespace app\admin\model;

/**
 * 继承model
 */
use think\Model;
use think\Validate;

/**角色管理
 * Class Role
 * @package app\admin\model
 */
class Role extends Model
{
    /**添加验证
     * @var array
     * unique:User----查询的表
     */
    protected $add_rule = [
        'title'         => 'require|unique:Role|max:20' ,
    ];
    /**添加提示错误内容
     * @var array
     */
    protected $add_message = [


        'title.unique'  => '角色已经存在' ,
        'title.require' => '角色名称不得为空' ,
        'title.max' => '角色名称不得超过20字符' ,

    ];

    /**修改验证
     * @var array
     * unique:User----查询的表
     */
    protected $edit_rule = [
        'id'            => 'require',
        'title'         => 'require|max:20'
    ];
    /**修改提示错误内容
     * @var array
     */
    protected $edit_message = [
        'id.require'         => '标识不存在' ,
        'title.require' => '角色名称不得为空' ,
        'title.max' => '角色名称不得超过20字符' ,
    ];
    /**修改验证
     * @var array
     * unique:User----查询的表
     */
    protected $del_rule = [
        'id'      => 'require|number',
    ];
    /**修改提示错误内容
     * @var array
     */
    protected $del_message = [
        'id.require'   => '标识不存在' ,
        'id.number'    => '必须为number' ,
    ];
    /*
     * 过滤数据库不存在的字段
     */
    protected $field = true;
    /**
     * 获取角色数据
     * @return array
     */
    public function getList($page,$limit){

        $count = $this->count('id');//读取长度给定id可以提高加载速度
//        page($page,$limit)->
        $list =  $this-> page($page,$limit)->order('id desc')->select();//条件查询
        $c = $count/$limit;//页数

//        return ['data'=>$list,'count'=>$count,'page'=>$page,'limit'=>$limit,'nun'=>ceil($c)];
        return ['code'=>0,"msg"=>'请求成功','count'=>$count,'data'=>$list];
    }
//    查询一条消息
    public function getinfo(){
        $table_model = new \app\admin\model\Role();
        $list =  $table_model->where('id',input('get.id'))->find();
        $list['status'] = $list['status'] == 1 ? true : false;
        return success_actionlist('获取成功',$list);
    }

    public function addValidate($data){
        $validate = new Validate($this->add_rule,$this->add_message);
        $result   = $validate->check($data);
        if(!$result){
            return error_action($validate->getError());
        }

    }

    public function editValidate($data){
        $validate = new Validate($this->edit_rule,$this->edit_message);
        $result   = $validate->check($data);
        if(!$result){
            return error_action($validate->getError());
        }
        $list = $this->where('title',$data['title'])->select();

        foreach ($list as $k=>$v){

            if($v['id'] == $data['id']){

            }else{
                return error_action('已存在该角色');
            }
        }
    }


    /**删除数据验证
     * @param $delId//删除的条件id是否存在
     * @return array
     */
    public function delValidate($data){
        $validate = new Validate($this->del_rule,$this->del_message);
        $result   = $validate->check($data);

        if(!$result){
            return error_action($validate->getError());
        }
        if($data['id'] == 1){
            return error_action('该角色不可删除');
        }
    }

    /**添加数据
     * @param $data
     * @return string
     */
    public function add($data)
    {
        $this->startTrans();  // 开启添加事务
        $this->data($data);
        if (!$this->save()) {
            $this->rollBack();//添加事务回滚
            return error_action('添加失败');
        }

        $id = $this->id;
        $role_model = new AdminRole();
        $role_model->startTrans();
        $roledate = $data['role'];
        if($roledate){
            $list_ = [];
            foreach ($roledate as $k=>$v){
                $list_[] = ["role_id"=>$id,"menu_id"=>$v];
            }
            $result = $role_model->saveAll($list_);
            if($result === false){
                $role_model->rollBack();// 添加回滚
                $this->rollBack();// 图片事务回滚
                return error_action('添加失败');
            }
        }
        $role_model->commit();
        $this->commit();
        return success_add('添加成功',$id);
    }
    /**
     * 修改数据
     * @param $data
     * @param $findId
     * @return string
     */
    public function edit($data,$findId){

        $list = new Role();
        $list->startTrans();  // 开启添加事务
        if (!$list->update($data)) {
            $list->rollBack();//添加事务回滚
            return error_action('添加失败');
        }

        $id = $data['id'];
        $role_model = new AdminRole();
        $role_model->startTrans();
        $roledate = $data['role'];
        if($roledate){
            $list_ = [];
            foreach ($roledate as $k=>$v){
                $list_[] = ["role_id"=>$id,"menu_id"=>$v];
            }
            $role_model->where('role_id',$id)->delete();
            $result = $role_model->saveAll($list_);
            if($result === false){
                $role_model->rollBack();// 添加回滚
                $this->rollBack();// 图片事务回滚
                return error_action('修改失败');
            }
        }
        $role_model->commit();
        $this->commit();
        return success_add('修改成功',$id);
    }

    /**删除数据
     * @param $delId
     * @return string
     */
    public function dele($delId){
        if($this->destroy($delId)){
            return success_actionlist('删除成功',null);
        }else{
            return error_action('删除失败',null);
        }
    }
}