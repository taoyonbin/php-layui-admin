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
 * Class AdminLog
 * @package app\admin\model
 */
class AdminLog extends Model
{
    /**获取数据
     * @param $where//条件
     * @param $page--第几页
     * @param $limit--每一页显示的数量
     * @param $field--查询的字段
     * @return array--返回数组
     */
    public function getList($where,$page,$limit){
        $count = $this->where($where)->count('id');//读取长度给定id可以提高加载速度
        $list =  $this->where($where)->page($page,$limit)->order('id', 'desc')->select();//条件查询
        $c = $count/$limit;//页数
        return ['data'=>$list,'count'=>$count,'page'=>$page,'limit'=>$limit,'nun'=>ceil($c)];
    }
    /**添加操作日志数据
     * @param $data
     * @return string
     */
    public function add($data,$adminId){

        $logdata['admin_id']        =  $adminId;
        $logdata['m']        =  request()->module();
        $logdata['c']        =  request()->controller();
        $logdata['a']        =  request()->action();
        $city                = getIpInfo(client_ip());
        $logdata['country'] =  $city['country'];
        $logdata['region']  =  $city['region'];
        $logdata['county']  =  $city['county'];
        $logdata['city']    =  $city['city'];
        $logdata['isp']     =  $city['isp'];
        $logdata['ip']      =  client_ip();
        $logdata['time']        =  date('Y-m-d H:i:s');
        $rep = request();
        $ispost = $rep->isPost();
        $logdata['data']        = json_encode(['request'=>$ispost == false ? 'get' : 'post','data'=>$data]) ;
        dump($logdata);
        $this->data($logdata);
        $this->sav();
    }
}