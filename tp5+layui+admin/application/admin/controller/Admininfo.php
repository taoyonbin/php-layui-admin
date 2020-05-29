<?php
namespace app\admin\controller;
/**
 * 继承common控制器
 * Admin管控制器
 * 功能【1.Admin查询输出(index)。2.增加Admin（add）。3.修改Admin(edit)。4.删除Admin(del)】
 * Class Menu
 * @package app\admin\controller
 */
class Admininfo extends Common
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
        $table_model = new \app\admin\model\Admin();
        $list =  $table_model->field('password', true)->where('id',cookie('adminid'))->find();

        return view('index',['data'=>$list]);
    }


    /**登录
     * @return string
     */
    public function logout()
    {

        $table_model = new \app\admin\model\Admin() ;
        $data = input('post.');
        $listV = $table_model->logoutValidate($data);//验证不能为空的数据

        return  $listV ? json_encode($listV) :  json_encode($table_model->logout($data));
    }

    /**修改
     * @return string
     */
    public function edit()
    {
        $table_model =  new \app\admin\model\Admin();
        $data = input('post.');
        $list = $table_model->editValidate($data);
        return  $list ?  $list :  $table_model->edit($data,cookie('adminid'));
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
                $fl['url'] ='uploads/admin/'.$info->getSaveName();
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
