<?php
namespace app\admin\controller;
/**
 * 继承common控制器
 * Admin管控制器
 * 功能【1.Admin查询输出(index)。2.增加Admin（add）。3.修改Admin(edit)。4.删除Admin(del)】
 * Class Menu
 * @package app\admin\controller
 */
class Admin extends Common
{

    /**调用Admin模型model
     * @var string
     */
    private $model = 'admin';

    /**查询所有数据
     * @return string
     */
    public function index()
    {
        return view();
    }
    public function getlist(){
        $list = new \app\admin\model\Admin();
        $data = input('get.');
        $where['title'] = ['like','%'.$data['title'].'%'];
        $where['username'] = ['like','%'.$data['username'].'%'];
        $where['phone'] = ['like','%'.$data['phone'].'%'];
        $page = $data['page'];
        $limit = $data['limit'];
        $lst =  $list->getList($where,$page,$limit,null);
        return $lst;
    }

    /**
     *
     */
    public function adminInfo(){

        $table_model = new \app\admin\model\Admin();
        $list =  $table_model->field('password', true)->where('id',2)->find();
        $list['status'] = $list['status'] == 1 ? true : false;
        return view('info',['data'=>$list]);
    }



//    查询一条消息
    public function getinfo(){
        $table_model = new \app\admin\model\Admin();
        $list =  $table_model->field('password', true)->where('id',input('get.id'))->find();
        $list['status'] = $list['status'] == 1 ? true : false;
        return success_actionlist('获取成功',$list);
    }

    /**登录
     * @return string
     */
    public function login()
    {

        $table_model = new \app\admin\model\Admin() ;
        $data = input('post.');
        $listV = $table_model->loginValidate($data);//验证不能为空的数据

        return  $listV ? $listV : success_actionlist('获取成功', $table_model->login($data));
    }
    /**登录
     * @return string
     */
    public function logout()
    {

        $table_model = new \app\admin\model\Admin() ;
        $data = input('post.');
        return  $table_model->logout($data);
    }

    /**添加
     * @return string
     */
    public function add()
    {
        $table_model =  new \app\admin\model\Admin();//调用模型
        $data = input('post.');//获取post数据
        $listV = $table_model->addValidate($data);//验证不能为空的数据
        return  $listV ? $listV :  $table_model->add($data);
    }

    public function getRole(){
        $table_model = new \app\admin\model\Role();
         $list = $table_model->where('status',1)->select();
        array_unshift($list,['id'=>'','title'=>"请选择所属角色"]);
        return success_action('获取成功',null,$list);
    }
    /**修改
     * @return string
     */
    public function edit()
    {
        $table_model =  new \app\admin\model\Admin();
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
        $table_model =  new \app\admin\model\Admin();
        $data = input('post.');
        $list = $table_model->delValidate($data);
        return  $list ?  $list :  $table_model->dele($data['id']);
    }

    /**查询一条数据
     * @return string
     */
    public function getfind()
    {
        $model = model($this->model);
        $list = $model->get(input('get.id'));
        return json_encode(success_action('获取成功',null,$list));
    }
    /**查询一条数据
     * @return string
     */
    public function getAdmin()
    {
        $model = model($this->model);
        $date = input('server.');
        $data['admin_id'] = $date['HTTP_ADMIN_USERID'];
        $list = $model->where(['id'=>$data['admin_id']])->field('password',true)->find();
        return json_encode(success_action('获取成功',null,$list));
    }

    /**
     * 上传照片
     */
    public function uploadImg(){
        $file = request()->file('file');
        if($file){
            $info = $file->move(config('upload_admin_path'));
            $list = $file->getInfo();
            if($info){
                $fl['url'] = 'uploads/admin/'.$info->getSaveName();
                $fl['size'] = $list['size'];
                $fl['name'] = $list['name'];
                $fl['type'] = $list['type'];
                return success_action('上传成功',null,$fl);
            }else{
                return error_action($file->getError());
            }
        }
    }
}
