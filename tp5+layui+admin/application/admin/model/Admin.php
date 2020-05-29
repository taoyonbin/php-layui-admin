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
use think\Cache;
use think\Cookie;
use think\Model;
use think\Validate;

/**管理员管理
 * Class Admin
 * @package app\admin\model
 */
class Admin extends Model
{

    /**登录验证
     * @var array
     * unique:Admin----查询的表
     */
    protected $login_rule = [
        'username'    => 'require|min:3|max:15' ,
        'password'    => 'require',
        'code'    => 'require|captcha'

    ];
    /**登录错误内容
     * @var array
     */
    protected $login_message = [
        'username.require'      => '用户名不能为空' ,
        'username.min'      => '用户名最低3位' ,
        'username.max'      => '用户名最多15位' ,
        'password.require'      => '密码不能为空' ,
        'code.require' => '验证码不能为空' ,
        'code.captcha' => '验证码不正确' ,
    ];
    /**添加验证
     * @var array
     * unique:Admin----查询的表
     */
    protected $add_rule = [
        'title'         => 'require|min:2|max:20' ,
        'phone'         => 'require' ,
        'username'    => 'require|unique:admin|min:3|max:15' ,
        'password'    => 'require|min:32|max:32' ,
        'password2'    => 'require|min:32|max:32' ,
        'role_id'=>'require'
    ];
    /**添加提示错误内容
     * @var array
     */
    protected $add_message = [

        'title.require'      => '姓名不得为空' ,
        'title.min'          => '姓名最少2位字符' ,
        'title.max'          => '姓名最多20位字符' ,

        'username.unique'  => '用户名已经存在' ,
        'username.require' => '用户名不得为空' ,
        'username.min'      => '用户名最少3位字符' ,
        'username.max'      => '用户名最多15位字符' ,

        'password.require' => '密码不得为空' ,
        'password.min'      => '密码长度为32位字符' ,
        'password.max'      => '密码长度为32位字符' ,

        'phone.require' => '电话不能为空' ,
        'role_id.require'              => '角色所属不能为空',

        
    ];

    /**修改验证
     * @var array
     * unique:Admin----查询的表
     */
    protected $edit_rule = [
        'id'            => 'require',
        'title'         => 'require|min:2|max:20' ,
        'phone'        =>'require',
        'username'     =>'require|min:3|max:15',
        'role_id'=>'require'
    ];
    /**修改提示错误内容
     * @var array
     */
    protected $edit_message = [
        'id.require'         => '标识不存在' ,
        'title.require'      => '姓名不得为空' ,
        'title.min'          => '姓名最少2位字符' ,
        'title.max'          => '姓名最多20位字符' ,
        'username.require'          => '用户名不能为空' ,
        'username.min'          => '姓名最少3位字符' ,
        'username.max'          => '姓名最多15位字符' ,
        'phone.require'              => '手机号码不能为空',
        'role_id.require'              => '角色所属不能为空',
    ];
    /**修改验证
     * @var array
     * unique:Admin----查询的表
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

    /**获取数据
     * @param $where//条件
     * @param $page--第几页
     * @param $limit--每一页显示的数量
     * @param $field--查询的字段
     * @return array--返回数组
     */
    public function getList($where,$page,$limit,$field){

        $count = $this->where($where)->count('id');//读取长度给定id可以提高加载速度

        $list =  $this->where($where)->field($field)->page($page,$limit)->order('id', 'desc')->select();//条件查询
        $c = $count/$limit;//页数

        $role_model = new Role();
        $role_list = $role_model->field('id,title')->select();
        foreach ($list as $k=>$v){
            foreach ($role_list as $kv=>$vv){
                if($v['role_id'] == $vv['id']){
                    $list[$k]['role_title'] = $vv['title'];
                }
            }
        }
//        return ['data'=>$list,'count'=>$count,'page'=>$page,'limit'=>$limit,'nun'=>ceil($c)];
        return ['code'=>0,"msg"=>'请求成功','count'=>$count,'data'=>$list];
    }



    public function role_find($data){
        $menu_role = new AdminRole();
        $menuIds =  $menu_role->getAdminRole(['admin_id'=>$data['id']]);

        return success_action('添加成功',null,array_unique($menuIds));
    }

    /**查询名称是否已经存在
     * @param $get
     * @return bool
     */
    public function getName($get){
        $list = $this->get($get);
        return !$list ? true : error_action(''.$get['name'].'：已经存在',$get['name']);
    }

    public function addValidate($data){

        $validate = new Validate($this->add_rule,$this->add_message);
        $result   = $validate->check($data);

        if(!$result){
            return error_action($validate->getError());
        }

        if($data['phone']){
            if(is_phone($data['phone']) || is_tel($data['phone'])){
            }else{
                return error_action('号码格式不正确',null);
            }
        }
    }

    public function editValidate($data){
        $validate = new Validate($this->edit_rule,$this->edit_message);
        $result   = $validate->check($data);
        if(!$result){
            return error_action($validate->getError());
        }
        if($data['phone']){
            if(is_phone($data['phone']) || is_tel($data['phone']) ){

            }else{
                return error_action('手机号或固定电话格式错误');
            }
        }
        if($data['password'] && $data['password2'] && $data['password'] !== $data['password2']){
            return error_action('两次密码不一致');
        }

        $list = $this->get($data['id']);
        if( $list['id'] == 1){
            return error_action('该用户不可被修改');
        }

        if(!$list ){
            return error_action('修改失败1');
        }
        if($data['username'] !== $list['username']){
            return error_action('修改失败2');
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
    public function add($data){
        $data['password'] = md5($data['password']);
        $this->data($data);
        if($this->save()){
            $data['id'] = $this->id;
            unset($data['password']);
            return success_action('添加成功',$this->id,$data);
        }else{
            return error_action('添加失败',null);
        }
    }

    public function role_admin($data,$id){

    }
    /**
     * 修改数据
     * @param $data
     * @param $findId
     * @return string
     */
    public function edit($data,$findId){
        $list = new Admin();
        if($data['password']){
            $data['password'] = md5($data['password']);
        }else{
            unset($data['password']);
        }

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
        if( $delId == 1){
            return error_action('该用户不可被删除');
        }else{
            if($this->destroy($delId)){
                return success_actionlist('删除成功',null);
            }else{
                return error_action('删除失败',null);
            }
        }

    }

    public function loginValidate($data){
        $validate = new Validate($this->login_rule,$this->login_message);
        $result   = $validate->check($data);
        if(!$result){
            return error_action($validate->getError());
        }



    }
    /**登录
     * @param $data
     * @return string
     */
    public function login($data){

        $list = $this->get(['username' => $data['username']]);
        if(!$list){
            return error_action('登陆失败:用户不存在');
        }

        if($list['password'] !== md5($data['password'])){
            return error_action('登陆失败:请输入正确的密码');
        }
        $random = random(5);
        $edit_list = new Admin();

        if($edit_list->update(['id'=>$list['id'],'code'=>$random])){
            Cookie::set('roleid',$list['role_id'],3600);
            Cache::set('code'.$list['id'],$random,3600);
            Cookie::set(config('cookie_name').$list['id'],md5(md5(config("Token_Admin").$random).$list['id']),3600);
            Cookie::set('adminid',$list['id'],3600);
            return success_action('登录成功',$list['id'],null) ;
        }else{
            return error_action('登录异常！重新登录');
        }
    }


    public function role_edit($data){
        $model = new AdminRole();
        return $model->admin_role_edit($data['menu'],$data['id']);
    }

    public function logout($data){
        $model = new Admin();
        if($model->update(['id'=>$data['id'],'code'=>''])){
            Cookie::delete('roleid');
            Cookie::delete(config('cookie_name').$data['id']);
            Cookie::delete('adminid'.$data['id']);
            Cache::rm('code'.$data['id']);
            return success_actionlist('退出成功',null);

        }

    }

    /**
     * 获取一条数据
     * @param $article_id
     * @return string
     */
    public function profile($id){
        $content = $this->where(['id'=>$id])->field('password,type',true)->find();
        return success_action('获取成功',$id,$content);
    }
}