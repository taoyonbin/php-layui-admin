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

/**模型名称对应数据库名字
 * Class XXXX
 * @package app\admin\model
 */
class XXXX extends Model
{
    /**查询表字段内容
     * @var string
     */
    protected $query_tab  = 'SHOW FULL FIELDS FROM tb_menu';
    /*
     * 过滤数据库不存在的字段
     */
    protected $field = true;

    /**
     * 获取菜单数据
     * @return array
     */
    public function getList(){
        $list = Menu::all(function($query){
            $query->order('sort', 'desc');
        });
        return $this->menuList($list,0);
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
                $v['children'] = $this->menuList($arr,$v['id']);
                $list[] = $v;
            }
        }
        return $list;
    }

    /**获取一条数据
     * @param $find
     * @return bool
     */
    public function getName($find){
        $list = $this->get($find);
        return !$list ? true : false;
    }

    /**
     * 添加数据验证
     * @param $data
     */
    public function addVeri($data){
        $table = $this->query($this->query_tab);
        $list = addFindisOk($table,$data);
        return $list;
    }


    /**修改数据验证
     * @param $data
     * @return array
     */
    public function editVeri($data){
        $table = $this->query($this->query_tab);
        $list = editFindisOk($table,$data);
        return $list;
    }

    /**删除数据验证
     * @param $delId//删除的条件id是否存在
     * @return array
     */
    public function delVeri($delId){
        if(!$delId){
            return ['code'=>500,'type'=>'error','msg'=>'删除参数错误','error'=>'您删除的参数不存在'];
        }
    }

    /**添加数据
     * @param $data
     * @return string
     */
    public function add($data){
        $this->data($data);
        if($this->save()){
            $data['id'] = $this->id;
            return success_action('添加成功',$this->id,$data);
        }else{
            return error_action('添加失败',null);
        }
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
    public function del($delId){
        if($this->destroy($delId)){
            return success_action('删除成功',$delId,null);
        }else{
            return error_action('删除失败',null);
        }
    }
}