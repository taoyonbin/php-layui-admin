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

/**管理员管理
 * Class Admin
 * @package app\admin\model
 */
class AdminRole extends Model
{


    /**获取所有id
     * @param $where
     * @return array
     */
    public function getAdminRole($where){
        $list = $this->all($where);
        $menu_ids = [];
        foreach ($list as $k=>$v){
            $menu_ids[] = $v['menu_id'];
        }
        return $menu_ids;
    }

    /**数据修改或添加
     * @param $menu
     * @param $roleId
     * @param $adminId
     */
    public function edit($menu,$adminId){
        $data  = [];
        foreach ($menu as $k=>$v){
            $data[] = ['menu_id'=>$v,'admin_id'=>$adminId,];
        }
        $this->where('admin_id',$adminId)->delete();
        $this->saveAll($data);
    }

    /**数据修改或添加
     * @param $menu
     * @param $roleId
     * @param $adminId
     */
    public function admin_role_edit($menu,$adminId){
        $data  = [];
        foreach ($menu as $k=>$v){
            $data[] = ['menu_id'=>$v,'admin_id'=>$adminId,];
        }
        $this->where('admin_id',$adminId)->delete();
        $this->saveAll($data);
        return success_actionlist('权限设置成功',null,null);

    }
}