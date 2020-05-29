<?php
namespace app\index\controller;

class Index
{
    public function index()
    {

        $where = input('get.');

        $li = ["type"=>"类型","url"=>"www.baidu.com","img"=>"../images/图层1拷贝3.png"];
        $json = [];
        for ($i=0;$i<20;$i++){
            $li['name'] = $i.'列表名称';
            $li['value'] = (($i+1)*2+23).".00";
            $li['id'] = $i+1;
            $li['time'] = date('Y-m-d');
            array_push($json,$li);
        }
        $wheredata = [];
        if($where['name']){
            foreach ($json as $v){
                if(strpos($v['name'],$where['name']) !== false){
                    array_push($wheredata,$v);
                }
            }
            $wheredata = $wheredata;
        }else{
            $wheredata = $json;
        }

        $newdata = [];
        foreach ($wheredata as $k=>$v){
            if( ( $where['page'] - 1 ) * $where['limit'] <= $k ){
                if( $k <= $where['page'] * ( $where['limit'] - 1 ) ){
                    array_push($newdata,$v);
                }
            }
        }
        return json_encode(['data'=>["data"=>$newdata,"total"=>count($wheredata),"page"=>$where['page']],'code'=>200]);
    }
}
