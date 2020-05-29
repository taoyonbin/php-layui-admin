<?php
namespace app\admin\controller;

use app\admin\model\AdminRole;
use think\Cache;
use think\captcha\Captcha;
use think\Cookie;
use think\Request;

class Index extends Common
{

    public function index()
    {
        $table_model = new \app\admin\model\Admin();
        $list =  $table_model->field('password', true)->where('id',cookie('adminid'))->find();
        return view('index',['data'=>$list]);

    }

    public function getRoleMenu(){
        $role_model = new AdminRole();

        $admin_model = new \app\admin\model\Admin();
        $admin = $admin_model->get(cookie('adminid'));
        $menu_model = new \app\admin\model\Menu();
        if($admin['type'] !== 1){
            $admin_role= $role_model->where('role_id',$admin['role_id'])->select();
            $str = [];
            foreach ($admin_role as $k=>$v){
                $str[] = $v['menu_id'];

            }
            $str = implode(',',$str);
            $men_list = $menu_model->where('type',1)->select($str);
            $role_list = $menu_model->select($str);
        }else{
            $men_list = $menu_model->where('type',1)->select();
            $role_list = $menu_model->select();
        }

        Cache::set('roleMenu',$role_list,3600);
        $menulist = $menu_model->roleList($men_list,0);

        return $menulist;

    }

    public function loginView(){

        return view('login');
    }

    public function errers(){
        return view('404');
    }

    /**登录
     * @return string
     */
    public function logout()
    {

        $table_model = new \app\admin\model\Admin() ;
        $data_id = cookie('adminid');
        if($table_model->update(['id'=>$data_id,'code'=>''])){
            Cookie::delete(config('cookie_name').$data_id);
            Cookie::delete('adminid'.$data_id);
            Cache::rm('code'.$data_id);
            return success_actionlist("请求成功",null);
        }

    }


}
