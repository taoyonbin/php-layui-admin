<?php
namespace app\app\controller;
use think\Controller;
// use 引入的类文件需要首字母大写

/**
* 基础类
* @author aierui github  https://github.com/Aierui
* @version 1.0 
*/
class Common extends Controller
{
//	protected $request;
//	private $module_name;
	function __construct()
	{
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Origin,User-id,User-Token,User-Time,X-Requested-With,Content-Type,token, Accept, Authorization");
        header('Access-Control-Allow-Methods: GET, POST, PUT,DELETE,OPTIONS,PATCH');

        if($_SERVER['REQUEST_METHOD'] == 'OPTIONS'){
            exit;
        }
        $this->isApi();
	}
    function isApi(){
        $action = request()->action();

        if($action !== 'login'){
            $date = input('server.');
            $id = $date['HTTP_USER_ID'];
            $time = $date['HTTP_USER_TIME'];
            $token = $date['HTTP_USER_TOKEN'];
            if(isset($id) == false || isset($time) == false || isset($token) == false){
                exit(json_encode(error_action('网络错误:user_id,user_time,user_tiken')));
            }else{
                if($token !== md5(md5(config('Token_API').$time).$id)){
                    $arr = 'token = md5(md5(Token_API+time)+id)';
                    exit(json_encode(error_action('网络错误:请求验证错误'.$arr)));
                }
            }
        }

    }
}

