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
 * Class Menu
 * @package app\admin\model
 */
class Menu extends Model
{
    /**添加验证
     * @var array
     * unique:User----查询的表
     */
    protected $add_rule = [
        'title'         => 'require|unique:Menu|max:20' ,
        'pid'         => 'require' ,
        'm'         => 'require|max:20' ,
    ];
    /**添加提示错误内容
     * @var array
     */
    protected $add_message = [


        'title.unique'  => '菜单已经存在' ,
        'title.require' => '菜单名称不得为空' ,
        'title.max' => '菜单名称不得超过20字符' ,
        'pid.require' => '所属不得为空' ,
        'm.require' => '模块名不能为空' ,
        'm.max' => '模块名不得超过20字符' ,

    ];

    /**修改验证
     * @var array
     * unique:User----查询的表
     */
    protected $edit_rule = [
        'id'            => 'require',
        'title'         => 'require|max:20' ,
        'pid'         => 'require' ,
        'm'         => 'require|max:20'
    ];
    /**修改提示错误内容
     * @var array
     */
    protected $edit_message = [
        'id.require'         => '标识不存在' ,
        'title.require' => '菜单名称不得为空' ,
        'title.max' => '菜单名称不得超过20字符' ,
        'pid.require' => '所属不得为空' ,
        'm.require' => '模块名不能为空' ,
        'm.max' => '模块名不得超过20字符' ,
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
     * 获取菜单数据
     * @return array
     */
    public function getList($page,$limit){

        $count = $this->count('id');//读取长度给定id可以提高加载速度
//        page($page,$limit)->
        $list =  $this-> page($page,$limit)->order('pid asc,id asc')->select();//条件查询
        $c = $count/$limit;//页数
        foreach ($list as $k=>$v){
            $list[$k]['type'] = $v['type'] == 1 ?"菜单":"方法";
            $list[$k]['p_title'] =  $v["pid"] == 0 ? "一级菜单":$this->get($v['pid'])->title ;

        }
//        return ['data'=>$list,'count'=>$count,'page'=>$page,'limit'=>$limit,'nun'=>ceil($c)];
        return ['code'=>0,"msg"=>'请求成功','count'=>$count,'data'=>$list];
    }
//    查询一条消息
    public function getinfo(){
        $table_model = new \app\admin\model\Menu();
        $list =  $table_model->where('id',input('get.id'))->find();
        $list['status'] = $list['status'] == 1 ? true : false;
        return success_actionlist('获取成功',$list);
    }
    /**
     * 无限极菜单循环
     * @param $arr//菜单data
     * @param $id//一级
     * @return array
     */
    public function menuList($arr,$id ){
        $list = [];
        foreach ($arr as $k=>$v){

            if ($v['pid'] == $id){
                if($this->menuList($arr,$v['id'])){
                    $v['children'] = $this->menuList($arr,$v['id']) ;
                    $v['title']  = $v['title'];
                }
//                $v['title']  = $v['title'].'----'.$v['m'].'----'.$v['c'].'----'.$v['f'];
                $v['spread'] = true;
                $list[] = $v;
            }
        }
        return $list;
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
                return error_action('该菜单存在');
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
    }

    /**添加数据
     * @param $data
     * @return string
     */
    public function add($data)
    {

//        $this->startTrans();  // 开启添加事务
//        $this->data($data);
//        if ($this->save()) {
//            $data['id'] = $this->id;
//            if($data['pid'] == $data['id']){
//                return error_action('添加失败', null);
//            }
//            return success_action('添加成功', $this->id, $data);
//        } else {
//            return error_action('添加失败', null);
//        }
        $this->startTrans();  // 开启添加事务
        $this->data($data);
        if (!$this->save() ) {
            $this->rollBack();//添加事务回滚
            return error_action('添加失败');
        }

        $id = $this->id;
        if($id == $data['pid']){
            $this->rollBack();//添加事务回滚
            return error_action('添加失败所属不能为本身');
        }
        $this->commit();
        return success_add('添加成功',$id);
    }
    /**
     * 无限极菜单循环
     * @param $arr//菜单data
     * @param $id//一级
     * @return array
     */
    public function roleList($arr,$id ){
        $list = [];
        foreach ($arr as $k=>$v){
            if ($v['pid'] == $id){
                if($this->roleList($arr,$v['id'])){
                    $v['children'] = $this->roleList($arr,$v['id']) ;
                }
                $v['spread'] = true;
                $list[] = $v;
            }
        }
        return $list;
    }
    /**
     * 修改数据
     * @param $data
     * @param $findId
     * @return string
     */
    public function edit($data,$findId){
        $list = new Menu();
        if($list->update($data)){
            return success_action('修改成功',$findId,$data);
        }else{
            return error_action('修改失败',null);
        }
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