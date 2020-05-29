<?php
namespace app\admin\controller;

use app\admin\model\AdminLog;
use app\admin\model\AdminRole;
use function PHPSTORM_META\type;
use think\Cache;
use think\Cookie;
use think\Log;
use think\Model;
use think\Controller;
class Common extends Controller
{
    /**请求拦截
     * Common constructor.
     */
    private  $postdate = '123';
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
    function _empty(){
        $this->success('登录过期','Login/index',null,1);

    }
    function isApi(){
        $module = request()->module();
        $controller = request()->controller();
        $action = request()->action();
        $wh['m'] = $module;
        $wh['c'] = $controller;
        $wh['a'] = $action;
        $adminid = cookie('adminid');
        $token = cookie(config('cookie_name'). $adminid);
        $code  = Cache::get('code'.$adminid);

        if($controller === 'Login'  || $controller === 'errers' ){

        }else{
            if($token !== md5(md5(config("Token_Admin").$code).$adminid)){
                $this->redirect('Login/index');
            }
            if(Cookie::get('roleid') !== 1){
                $rolemenu = Cache::get('roleMenu');
                $istrue_ = false;
                foreach ($rolemenu as $k=>$v){
//                    dump($v['m'].'-----'.$v['c'].'-----'.$v['f']);
                    if( $v['m'] ==  $module && $v['c'] ==  $controller && $v['f'] ==  $action){
                        $istrue_ = true;
                    }

                }
//                dump($istrue_);
//                dump($wh);
                if($istrue_ !== true){
                    $this->redirect('Index/errers');
                }
            }

        }


    }


}
