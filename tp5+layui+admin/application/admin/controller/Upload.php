<?php
namespace app\admin\controller;

class Upload extends Common
{
    public function index(){}
    public function uploadLogo()
    {
        // 获取表单上传的文件，例如上传了一张图片
        $file = request()->file('file');
        if($file){
            //将传入的图片移动到框架应用根目录/public/uploads/ 目录下，ROOT_PATH是根目录下，DS是代表斜杠 /
            $info = $file->move(ROOT_PATH . 'public' . DS . 'static'. DS .'uploads');

            if($info){
                return $info->getSaveName();
            }else{
                // 上传失败获取错误信息
                echo $file->getError();die;
            }
        }
    }

    public function uploadImgs()
    {
        // 获取表单上传的文件，例如上传了一张图片
        $file = request()->file('file');
        $infos = $file->getInfo();
        if($file){
            //将传入的图片移动到框架应用根目录/public/uploads/ 目录下，ROOT_PATH是根目录下，DS是代表斜杠 /
            $info = $file->validate(['size'=>400000,'ext'=>'jpg,png,jpeg,gif'])->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($info){
                $lis['name'] = $infos['name'];
                $lis['url'] = config('IMG_IP').'uploads/'.$info->getSaveName();
                $lis['size'] = $infos['size'];
                return json_encode(success_actionlist('上传成功',$lis));

            }else{
                if(150000 < $infos ){
                    return  json_encode(error_action('上传失败,文件必须小于150kb'.$infos['size'],null));
                }else{
                    return  json_encode(error_action('上传失败,文件只能上传png,jpg,gif,jpeg文件',null));
                }
                die;
            }
        }
    }

    public function uploadFiles()
    {
        // 获取表单上传的文件，例如上传了一张图片
        $file = request()->file('file');
        $infos = $file->getInfo();
        if($file){
            //将传入的图片移动到框架应用根目录/public/uploads/ 目录下，ROOT_PATH是根目录下，DS是代表斜杠 /
            $info = $file->validate(['size'=>400000,'ext'=>'doc,docx,ppt,pptx,xls,xlsx,pdf,zip'])->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($info){
                $lis['name'] = $infos['name'];
                $lis['url'] = config('IMG_IP').'uploads/'.$info->getSaveName();
                $lis['size'] = $infos['size'];
                return json_encode(success_actionlist('上传成功',$lis));

            }else{
                if(150000 < $infos ){
                    return  json_encode(error_action('上传失败,文件必须小于150kb'.$infos['size'],null));
                }else{
                    return  json_encode(error_action('上传失败,文件只能上传png,jpg,gif,jpeg文件',null));
                }
                die;
            }
        }
    }

    public function deleteImgs()
    {
        $path = 'uploads/20200320\a90fdf1e1c097efa607ffe61d82f8992.png';
        return is_file($path) && unlink($path);
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
                $fl['url'] = 'uploads/admin'.$info->getSaveName();
                $fl['size'] = $list['size'];
                $fl['name'] = $list['name'];
                $fl['type'] = $list['type'];
                return json_encode($fl);
            }else{
                return json_encode(error_action($file->getError()));
            }
        }
    }

}
