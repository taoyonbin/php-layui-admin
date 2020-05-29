<?php
namespace app\admin\controller;
use think\Config;
use think\View;

/**
 * 继承common控制器
 * XXXX管控制器
 * 功能【1.XXXX查询输出(index)。2.增加XXXX（add）。3.修改XXXX(edit)。4.删除XXXX(del)】
 * Class Menu
 * @package app\admin\controller
 */
class System extends Common
{

    public function index()
    {
        $data = Config::get();
        $php['THINK_VERSION'] =phpversion() ;
        $php['MYSQL_VERSION'] =$this->MYSQL_VERSION() ;
        $php['APACHE_VERSION'] =apache_get_version();
        $php['APACHE_SERVER_PORT'] =$_SERVER["SERVER_PORT"];
//        echo json_encode($data['img_ip']);
        return view('index',['data'=>$data,'thinkphp'=>$php]);
    }
    public function MYSQL_VERSION(){

        $mysql= Db()->query("select VERSION() as version");
        $mysql=$mysql[0]['version'];
        $mysql=empty($mysql)?L('UNKNOWN'):$mysql;
        return $mysql;
    }


}
