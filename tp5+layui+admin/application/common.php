<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

function isfind($find){
    return  ['code'=>20000,'type'=>'success','find'=>$find] ;
}

/**
 * 所有请求未POSI
 */
function isPost(){
    $rep = request();
    $ispost = $rep->isPost();
    if($ispost == false){
        echo json_encode(['code'=>50001,'type'=>'error','msg'=>'请求方式错误','error'=>'请求方式必须为指定类型']);
        exit();
    }
}

/**
 * 验证数据库中非空字段除了id
 * @param $table
 * @param $data
 * @return array
 */
function addFindisOk($table,$data){
    if($data){//添加的内容不为空
        foreach ( $table as $k => $v ){//循环
            if($v['Null'] == 'NO'){//不为空的字段
                if($v['Field'] !== 'id'){//段除了id
                    if(isset($data[$v['Field']]) != true){//一条存在空不继续执行
                        return ['code'=>50000,'type'=>'error','msg'=>$v['Comment'].'不能为空','error'=>$v['Field']];
                    }
                }
            }
        }
    }else{//内容为空
        return ['code'=>50000,'type'=>'error','msg'=>'内容不能为空','error'=>'没有添加任何内容'];
    }
}

/**
 * 修改验证数据库中非空字段包括id
 * @param $table
 * @param $data
 * @return array
 */
function editFindisOk($table,$data){
    if($data){//添加的内容不为空
        foreach ( $table as $k => $v ){//循环
            if($v['Null'] == 'NO'){//不为空的字段
                if(isset($data[$v['Field']]) != true){//一条存在空不继续执行
                    return ['code'=>50000,'type'=>'error','msg'=>$v['Comment'].'不能为空','error'=>$v['Field']];
                }
            }
        }
    }else{//内容为空
        return ['code'=>50002,'type'=>'error','msg'=>'修改内容不能为空','error'=>'没有修改任何内容'];
    }
}
/**
 * 添加成功返回
 * @param $json
 * @param $msg
 * @return string
 */
function success_action($msg,$id,$data){
    return  ['code'=>20000,'type'=>'success','msg'=>$msg,'id'=>$id,'data'=>$data] ;
}


//base转图片
function baseToimg($image){
    $imageName = "userlogo_".date("His",time())."_".rand(1111,9999).'.png';
    if (strstr($image,",")){
        $image = explode(',',$image);
        $image = $image[1];
    }
    $path = "./uploads".date("Ymd",time());
    if (!is_dir($path)){ //判断目录是否存在 不存在就创建
        mkdir($path,0777,true);
    }

    $imageSrc= $path."/uploads/". $imageName; //图片名字
    $r = file_put_contents($imageSrc, base64_decode($image));//返回的是字节数
    if (!$r) {
        $tmparr1=array('data'=>null,"code"=>1,"msg"=>"图片生成失败");
        return $tmparr1;
    }else{
        $tmparr2=array('data'=>$r,"code"=>0,"msg"=>"图片生成成功");
        return $imageSrc;
    }
}

/**
 * 列表成功返回
 * @param $json
 * @param $msg
 * @return string
 */
function success_actionlist($msg,$data){
    return  ['code'=>20000,'type'=>'success','msg'=>$msg,'data'=>$data] ;
}
//表编号生成
function recordCode($uid){
    $var=sprintf("%04d", $uid);//不足4补0
    $ymd = config('record_code').date("YmdHi").$var;
    return $ymd;
}
//图片号生成
function imgCode($rid,$i,$uid){
    $uid_=sprintf("%04d", $uid);//不足4补0
    $i_ = sprintf("%02d", $i);//不足2补0
    $ymd = config('record_code').date("YmdHi").$uid_.'0'.$i_.$rid;
    return $ymd;
}
/**
 * 添加成功返回
 * @param $json
 * @param $msg
 * @return string
 */
function success_add($msg,$id){
    return  ['code'=>20000,'type'=>'success','msg'=>$msg,'id'=>$id] ;
}
/**添加失败
 * @param $json
 * @param $msg
 * @return string
 */
function error_action($msg){
    return ['code'=>50000,'type'=>'error','msg'=>$msg];
}

function getThisTitle($arr,$find){

    foreach ($arr as $k=>$v){
        if($v['code'] == $find){
            return $v['title'];
        }
    }
}

function getThis($arr,$find){

    foreach ($arr as $k=>$v){
        if($v['code'] == $find){
            return $v['code'];
        }
    }
}

function getThisTrue($arr,$find){

    foreach ($arr as $k=>$v){
        if($v['code'] == $find){
            return true;
        }
    }
}
/**
获取 IP  地理位置
 * 淘宝IP接口
 * @Return: array
 */
function getCity($ip = '')
{
    $url="http://ip.taobao.com/service/getIpInfo.php?ip=".$ip;
    $ip=json_decode(file_get_contents($url));
    if((string)$ip->code=='1'){
        return false;
    }
    $data = (array)$ip->data;
    return $data;
}
//获取ip
function getIp()
{
    if ($_SERVER["HTTP_CLIENT_IP"] && strcasecmp($_SERVER["HTTP_CLIENT_IP"], "unknown")) {
        $ip = $_SERVER["HTTP_CLIENT_IP"];
    } else {
        if ($_SERVER["HTTP_X_FORWARDED_FOR"] && strcasecmp($_SERVER["HTTP_X_FORWARDED_FOR"], "unknown")) {
            $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } else {
            if ($_SERVER["REMOTE_ADDR"] && strcasecmp($_SERVER["REMOTE_ADDR"], "unknown")) {
                $ip = $_SERVER["REMOTE_ADDR"];
            } else {
                if (isset ($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'],
                        "unknown")
                ) {
                    $ip = $_SERVER['REMOTE_ADDR'];
                } else {
                    $ip = "unknown";
                }
            }
        }
    }
    return ($ip);
}
/**
 * @return \think\response\View
 * 七陌云客服系统嵌入后台
 */
function qimo_view(){
    $accountid	=	"T00000006413";//云呼账号
    $secret		=	"90676be0-c560-11e9-a24f-7bce468a48c8";//云呼密码
    $time		=	date("YmdHis");

//echo $time;exit;
    $authorization	=	base64_encode($accountid.":".$time);
    $sig			=	strtoupper(md5($accountid.$secret.$time));

//echo $authorization;
//echo "<br>";
    $url	=	'https://openapis.7moor.com/v20160818/sso/getToken/'.$accountid."?sig=".$sig;
    $data	=	array(
        "account"=>$accountid,
        "exten"=>'8001',
        "password"=>md5('7moor'.$accountid.'8001'.'3_q7irObPin8001'.$time),
        "extentype"=>'sip',
        "timeStamp"=>$time,
        "module"=>'webchat'
    );

//print_r(  http_build_query($data) );exit;
//echo $url;
//exit;
//        echo strlen( http_build_query($data) );exit;
    $header[] = 'Connection: Keep-Alive';
    $header[] = "Accept: application/json";
    $header[] = "Content-type: application/json;charset='utf-8'";
    $header[] = "Content-Length: ".strlen( json_encode($data) );
    $header[] = "Authorization: ".$authorization;



    //print_r($header);

    $ch = curl_init ();
    curl_setopt($ch, CURLOPT_URL, ($url) );//地址
    curl_setopt($ch, CURLOPT_POST, 1);   //请求方式为post
    curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data)); //post传输的数据。
    curl_setopt($ch, CURLINFO_HEADER_OUT, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);

    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSLVERSION, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);


    $return = curl_exec ( $ch );

    if($return === FALSE ){
        echo "CURL Error:".curl_error($ch);exit;
    }

    curl_close ( $ch );

    return $return;
}


/**
 * 随机字符
 * @param number $length 长度
 * @param string $type 类型
 * @param number $convert 转换大小写
 * @return string
 */
function random($length=5, $type='string', $convert=0){
    $config = array(
        'number'=>'1234567890',
        'letter'=>'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
        'string'=>'abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ23456789',
        'all'=>'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'
    );

    if(!isset($config[$type])) $type = 'string';
    $string = $config[$type];

    $code = '';
    $strlen = strlen($string) -1;
    for($i = 0; $i < $length; $i++){
        $code .= $string{mt_rand(0, $strlen)};
    }
    if(!empty($convert)){
        $code = ($convert > 0)? strtoupper($code) : strtolower($code);
    }
    return $code;
}


/**
 * 根据 Ip 获取地址位置
 */
function getIpInfo($internetIp = '')
{

    try
    {
        //内网IP
        //  A类10.0.0.0～10.255.255.255
        //  B类172.16.0.0～172.31.255.255
        //  C类192.168.0.0～192.168.255.255
        //  ......
        $bLocalIp = !filter_var($internetIp, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE);
        if($bLocalIp)
            $internetIp = 'myip';//局域网IP
            $requestAPi = "http://ip.taobao.com/service/getIpInfo.php?ip=" . $internetIp;
            $opts       = array(
                'http' => array(
                    'method'  => 'GET',
                    'timeout' => 5, // 单位秒
                )
            );
            $jsonArr = json_decode( file_get_contents($requestAPi, false, stream_context_create($opts)),
                JSON_HEX_TAG | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_HEX_APOS );

            // 说明断网
            if (!isset($jsonArr) || !isset($jsonArr['code']))
            {
                return false;
            }

            // 0 表示成功
            if ($jsonArr['code'] !== 0)
            {

                return $requestAPi;
            }

        // 返回的数据结果：
        //  "ip": "223.98.166.115",
        //  "country": "中国",
        //  "area": "",
        //  "region": "山东",
        //  "city": "济南",
        //  "county": "XX",
        //  "isp": "移动",
        //  "country_id": "CN",
        //  "area_id": "",
        //  "region_id": "370000",
        //  "city_id": "370100",
        //  "county_id": "xx",
        //  "isp_id": "100025"

        $data = (array)$jsonArr['data'];

        return $data;
    }
    catch (\Exception $e)
    {

    }

    return false;
}



/**
 * 获取客户端IP地址
 * @param int $type [IP地址类型]
 * @param bool $strict [是否以严格模式获取]
 * @return mixed [客户端IP地址]
 */
function client_ip($type = 0, $strict = false)
{
    $ip = null;
    // 0 返回字段型地址(127.0.0.1)
    // 1 返回长整形地址(2130706433)
    $type = $type ? 1 : 0;
    if ($strict) {
        /* 防止IP地址伪装的严格模式 */
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $pos = array_search('unknown', $arr);
            if (false !== $pos) {
                unset($arr[$pos]);
            }
            $ip = trim(current($arr));
        } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
    } else if (isset($_SERVER['REMOTE_ADDR'])) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    /* IP地址合法性验证 */
    $long = sprintf("%u", ip2long($ip));
    $ip = $long ? [$ip, $long] : ['0.0.0.0', 0];
    return $ip[$type];
}



/**
 * 获取客户端操作系统信息包括win10
 * @param  null
 * @author  Jea杨
 * @return string
 */
function get_os(){
    $agent = $_SERVER['HTTP_USER_AGENT'];
    $os = false;

    if (preg_match('/win/i', $agent) && strpos($agent, '95'))
    {
        $os = 'Windows 95';
    }
    else if (preg_match('/win 9x/i', $agent) && strpos($agent, '4.90'))
    {
        $os = 'Windows ME';
    }
    else if (preg_match('/win/i', $agent) && preg_match('/98/i', $agent))
    {
        $os = 'Windows 98';
    }
    else if (preg_match('/win/i', $agent) && preg_match('/nt 6.0/i', $agent))
    {
        $os = 'Windows Vista';
    }
    else if (preg_match('/win/i', $agent) && preg_match('/nt 6.1/i', $agent))
    {
        $os = 'Windows 7';
    }
    else if (preg_match('/win/i', $agent) && preg_match('/nt 6.2/i', $agent))
    {
        $os = 'Windows 8';
    }else if(preg_match('/win/i', $agent) && preg_match('/nt 10.0/i', $agent))
    {
        $os = 'Windows 10';#添加win10判断
    }else if (preg_match('/win/i', $agent) && preg_match('/nt 5.1/i', $agent))
    {
        $os = 'Windows XP';
    }
    else if (preg_match('/win/i', $agent) && preg_match('/nt 5/i', $agent))
    {
        $os = 'Windows 2000';
    }
    else if (preg_match('/win/i', $agent) && preg_match('/nt/i', $agent))
    {
        $os = 'Windows NT';
    }
    else if (preg_match('/win/i', $agent) && preg_match('/32/i', $agent))
    {
        $os = 'Windows 32';
    }
    else if (preg_match('/linux/i', $agent))
    {
        $os = 'Linux';
    }
    else if (preg_match('/unix/i', $agent))
    {
        $os = 'Unix';
    }
    else if (preg_match('/sun/i', $agent) && preg_match('/os/i', $agent))
    {
        $os = 'SunOS';
    }
    else if (preg_match('/ibm/i', $agent) && preg_match('/os/i', $agent))
    {
        $os = 'IBM OS/2';
    }
    else if (preg_match('/Mac/i', $agent) && preg_match('/PC/i', $agent))
    {
        $os = 'Macintosh';
    }
    else if (preg_match('/PowerPC/i', $agent))
    {
        $os = 'PowerPC';
    }
    else if (preg_match('/AIX/i', $agent))
    {
        $os = 'AIX';
    }
    else if (preg_match('/HPUX/i', $agent))
    {
        $os = 'HPUX';
    }
    else if (preg_match('/NetBSD/i', $agent))
    {
        $os = 'NetBSD';
    }
    else if (preg_match('/BSD/i', $agent))
    {
        $os = 'BSD';
    }
    else if (preg_match('/OSF1/i', $agent))
    {
        $os = 'OSF1';
    }
    else if (preg_match('/IRIX/i', $agent))
    {
        $os = 'IRIX';
    }
    else if (preg_match('/FreeBSD/i', $agent))
    {
        $os = 'FreeBSD';
    }
    else if (preg_match('/teleport/i', $agent))
    {
        $os = 'teleport';
    }
    else if (preg_match('/flashget/i', $agent))
    {
        $os = 'flashget';
    }
    else if (preg_match('/webzip/i', $agent))
    {
        $os = 'webzip';
    }
    else if (preg_match('/offline/i', $agent))
    {
        $os = 'offline';
    }
    else
    {
        $os = '未知操作系统';
    }
    return $os;
}

/**
 * 获取客户端浏览器信息 添加win10 edge浏览器判断
 * @param  null
 * @author  Jea杨
 * @return string
 */
function get_broswer(){
    $sys = $_SERVER['HTTP_USER_AGENT'];  //获取用户代理字符串
    if (stripos($sys, "Firefox/") > 0) {
        preg_match("/Firefox\/([^;)]+)+/i", $sys, $b);
        $exp[0] = "Firefox";
        $exp[1] = $b[1];  //获取火狐浏览器的版本号
    } elseif (stripos($sys, "Maxthon") > 0) {
        preg_match("/Maxthon\/([\d\.]+)/", $sys, $aoyou);
        $exp[0] = "傲游";
        $exp[1] = $aoyou[1];
    } elseif (stripos($sys, "MSIE") > 0) {
        preg_match("/MSIE\s+([^;)]+)+/i", $sys, $ie);
        $exp[0] = "IE";
        $exp[1] = $ie[1];  //获取IE的版本号
    } elseif (stripos($sys, "OPR") > 0) {
        preg_match("/OPR\/([\d\.]+)/", $sys, $opera);
        $exp[0] = "Opera";
        $exp[1] = $opera[1];
    } elseif(stripos($sys, "Edge") > 0) {
        //win10 Edge浏览器 添加了chrome内核标记 在判断Chrome之前匹配
        preg_match("/Edge\/([\d\.]+)/", $sys, $Edge);
        $exp[0] = "Edge";
        $exp[1] = $Edge[1];
    } elseif (stripos($sys, "Chrome") > 0) {
        preg_match("/Chrome\/([\d\.]+)/", $sys, $google);
        $exp[0] = "Chrome";
        $exp[1] = $google[1];  //获取google chrome的版本号
    } elseif(stripos($sys,'rv:')>0 && stripos($sys,'Gecko')>0){
        preg_match("/rv:([\d\.]+)/", $sys, $IE);
        $exp[0] = "IE";
        $exp[1] = $IE[1];
    }else {
        $exp[0] = "未知浏览器";
        $exp[1] = "";
    }
    return $exp[0].'('.$exp[1].')';
}

function get_position($ip){
    if(empty($ip)){
        return  '缺少用户ip';
    }
    $url = 'http://ip.taobao.com/service/getIpInfo.php?ip='.$ip;
    $ipContent = file_get_contents($url);
    $ipContent = json_decode($ipContent,true);
    $list = $ipContent['data']['country'].$ipContent['data']['region'].$ipContent['data']['city'].$ipContent['data']['isp'];
    return $list;
}





function getHtml($url){
    // 1. 初始化
    $ch = curl_init();
    // 2. 设置选项，包括URL
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch,CURLOPT_HEADER,0);
    // 3. 执行并获取HTML文档内容
    $output = curl_exec($ch);
    if($output === FALSE ){
        $output = '';
    }
    // 4. 释放curl句柄
    curl_close($ch);
    return $output;
}

function getPageData($url){
    // 获取整个网页内容
    $html = getHtml($url);
    // 初步获取主块内容
    preg_match("/教程列表.*教程列表/s",$html,$body_html);

    // 返回数据
    $data = array();

    //判断是否存在要获取的内容
    if(count($body_html)){
        // 获取页面指定信息
        preg_match_all('/<a class="avatar".*user_id="(\S*)" href="(\S*)"/',$body_html[0],$info_1);
        preg_match_all('/<a href="(.*)".*title="(.*)"/',$body_html[0],$info_2);
        $info = array_merge($info_1,$info_2);

        //组合的信息
        for($index=0; $index<count($info[0]); $index++){
            //以文章信息作为key存数组，以及覆盖旧数据
            $data[$info[4][$index]] = array(
                'user_id'   =>  $info[1][$index],
                'user_home' =>  $info[2][$index],
                'a_url'     =>  $info[4][$index],
                'a_title'   =>  $info[5][$index],
            );
        }
    }

    return $data;
}
//判断字符串是否是base64编码
 function isbase64($str)
{
    if ($str == base64_encode(base64_decode($str))) {
        return true;
    }else{
        return false;
    }
}
/*  base64格式编码转换为图片并保存对应文件夹 */
function base64_image_content($base64_image_content,$path){
    //匹配出图片的格式
    if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)){
        $type = $result[2];
        $new_file = $path."/".date('Ymd',time())."/";
        if(!file_exists($new_file)){
            //检查是否有该文件夹，如果没有就创建，并给予最高权限
            mkdir($new_file, 0700);
        }
        $new_file = $new_file.time().".{$type}";
        if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_image_content)))){
            return '/'.$new_file;
        }else{
            return false;
        }
    }else{
        return false;
    }
}

function base64EncodeImage ($image_file)
{
    $base64_image = '';
    $image_info = getimagesize($image_file);
    $image_data = fread(fopen($image_file, 'r'), filesize($image_file));
    $base64_image = 'data:' . $image_info['mime'] . ';base64,' . chunk_split(base64_encode($image_data));
    return $base64_image;
}


/**
 * 验证手机号码格式
 * @param string $phone 手机号
 * @return boolean
 */
function is_phone($phone) {
    $chars = "/^13[0-9]{1}[0-9]{8}$|15[0-9]{1}[0-9]{8}$|18[0-9]{1}[0-9]{8}$|17[0-9]{1}[0-9]{8}$/";
    if (preg_match($chars, $phone)) {
        return true;
    } else {
        return false;
    }
}

function getUserToken(){
    $key = 'TaoYonBin-*-tybaoonin';
    $list['admin_id'] = $_SERVER['HTTP_USERID'];
    $list['company_id'] = $_SERVER['HTTP_COMPANYID'];
    $list['token'] = $_SERVER['HTTP_TOKEN'];
    $list['time'] = $_SERVER['HTTP_TIME'];

    $mkey = md5($key.$list['time']);

    $isok = md5($mkey.$list['admin_id'].$list['company_id']);

    if($list['token'] !== $isok){
        return json_encode(error_action('非法操作','验证失败'));
    }else{
        return $list;
    }
}

/**
 * 验证固定电话格式
 * @param string $tel 固定电话
 * @return boolean
 */
function is_tel($tel) {
    $chars = "/^([0-9]{3,4}-)?[0-9]{7,8}$/";
    if (preg_match($chars, $tel)) {
        return true;
    } else {
        return false;
    }
}

/**
 * 获取两个时间相差的天，小时，分钟，秒
 * @param $in_time
 * @param $out_time
 * @return array
 */
function getInOutTime($first,$second){
    $_start = $first;
    $_end = $second;
    $_start_time = strtotime($_start);
    $_end_time = strtotime($_end);
    $_timestamp = $_end_time-$_start_time;
    $_days = floor($_timestamp / 86400);
    $_hous = floor($_timestamp % 86400 / 3600);
    $_mintues = floor($_timestamp % 86400 % 3600 / 60);
    $_secode = floor($_timestamp % 86400 % 3600 % 60);
    $l = ['d'=>$_days,'h'=>$_hous,'i'=>$_mintues,'s'=>$_secode];
    return $l;
}

/**发送短信
 * @param $msg_content
 * @param $phone_number
 * @return mixed
 */
function sendMsg($msg_content,$phone_number){
    $statusStr = array(
        "0" => "短信发送成功",
        "-1" => "参数不全",
        "-2" => "服务器空间不支持,请确认支持curl或者fsocket，联系您的空间商解决或者更换空间！",
        "30" => "密码错误",
        "40" => "账号不存在",
        "41" => "余额不足",
        "42" => "帐户已过期",
        "43" => "IP地址限制",
        "50" => "内容含有敏感词"
    );
    $smsapi = "http://www.smsbao.com/"; //短信网关
    $user = config('SENDMSG_CONFIG')['user']; //短信平台帐号
    $pass = md5(config('SENDMSG_CONFIG')['pwd']); //短信平台密码
    $m = config('SENDMSG_CONFIG')['m'];
    $content = $m.$msg_content;//要发送的短信内容
    $phone = $phone_number; //要发送到哪里的手机号码
    $sendurl = $smsapi."sms?u=".$user."&p=".$pass."&m=".$phone."&c=".urlencode($content);
    $result =file_get_contents($sendurl) ;
    return $statusStr[$result];
}

function base64_to_img($image){
    $imageName = date("YmdHis",time())."_".rand(1111,9999).'.png';
    if (strstr($image,",")){
        $image = explode(',',$image);
        $image = $image[1];
    }
    $path = date("Ymd",time());
    if (!is_dir($path)){ //判断目录是否存在 不存在就创建
        mkdir($path,0777,true);
    }
    $imageSrc= $path."/". $imageName; //图片名字
    $r = file_put_contents($imageSrc, base64_decode($image));//返回的是字节数
    if (!$r) {
        return ['status'=>2,'date'=>null,'msg'=>'图片生成失败'];
    }else{

        return ['status'=>1,'date'=>$imageSrc,'msg'=>'图片生成成功'];
    }
}


/**
 * 发送短信
 * @param $shortMsgHead 信息头部信息
 * @param $msg_content 发送内容
 * @param $phone_number 发送手机号，用逗号隔开多个手机号码
 * @return mixed
 */
function send_msg($shortMsgHead,$msg_content, $phone_number)
{
    $statusStr = array(
        "0" => "短信发送成功",
        "-1" => "参数不全",
        "-2" => "服务器空间不支持,请确认支持curl或者fsocket，联系您的空间商解决或者更换空间！",
        "30" => "密码错误",
        "40" => "账号不存在",
        "41" => "余额不足",
        "42" => "帐户已过期",
        "43" => "IP地址限制",
        "50" => "内容含有敏感词"
    );
    $smsapi = "http://www.smsbao.com/"; //短信网关
    $user = "liyijiu"; //短信平台帐号
    $pass = md5("liyijiu547548847"); //短信平台密码
    $content = $msg_content;//要发送的短信内容
    $phone = $phone_number; //要发送到哪里的手机号码
    $sendurl = $smsapi . "sms?u=" . $user . "&p=" . $pass . "&m=" . $phone . "&c=" . urlencode($content);
    $result = file_get_contents($sendurl);
    return $statusStr[$result];
}

function check_phone($phone){
    if (!is_numeric($phone)) {
        return false;
    }
    return preg_match('#^1[3,4,5,7,8,9]{1}[\d]{9}$#', $phone) ? true : false;
}

/**
 * 验证手机号是否正确
 * @author 范鸿飞
 * @param INT $mobile
 */
 function isPhone($mobile) {
    if (!is_numeric($mobile)) {
        return false;
    }
    return preg_match('#^13[\d]{9}$|^14[5,7]{1}\d{8}$|^15[^4]{1}\d{8}$|^17[0,6,7,8]{1}\d{8}$|^18[\d]{9}$#', $mobile) ? true : false;
}
/**
 * 验证手机号是否正确
 * @author 范鸿飞
 * @param INT $mobile
 */
function isEmail($mobile) {

    $email = filter_var($mobile,FILTER_VALIDATE_EMAIL);

    return $email == true ? true : false;
}

function NoRand($length){
    $key = '';
    $pattern = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLOMNOPQRSTUVWXYZ';
    for($i=0;$i<$length;$i++)
    {
        $key .= $pattern{mt_rand(0,35)}; //生成php随机数
    }
    return $key;
}
//用法
//$str = '这里是数据';
//$key = '222';
//$authcode =  authcode($str,'ENCODE',$key,0); //加密
//echo $authcode;
//echo authcode($authcode,'DECODE',$key,0); //解密
//authcode加密函数
function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
    // 动态密匙长度，相同的明文会生成不同密文就是依靠动态密匙
    $ckey_length = 4;

    // 密匙
    $key = md5($key ? $key : $GLOBALS['discuz_auth_key']);

    // 密匙a会参与加解密
    $keya = md5(substr($key, 0, 16));
    // 密匙b会用来做数据完整性验证
    $keyb = md5(substr($key, 16, 16));
    // 密匙c用于变化生成的密文
    $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length):
        substr(md5(microtime()), -$ckey_length)) : '';
    // 参与运算的密匙
    $cryptkey = $keya.md5($keya.$keyc);
    $key_length = strlen($cryptkey);
    // 明文，前10位用来保存时间戳，解密时验证数据有效性，10到26位用来保存$keyb(密匙b)，
//解密时会通过这个密匙验证数据完整性
    // 如果是解码的话，会从第$ckey_length位开始，因为密文前$ckey_length位保存 动态密匙，以保证解密正确
    $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) :
        sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
    $string_length = strlen($string);
    $result = '';
    $box = range(0, 255);
    $rndkey = array();
    // 产生密匙簿
    for($i = 0; $i <= 255; $i++) {
        $rndkey[$i] = ord($cryptkey[$i % $key_length]);
    }
    // 用固定的算法，打乱密匙簿，增加随机性，好像很复杂，实际上对并不会增加密文的强度
    for($j = $i = 0; $i < 256; $i++) {
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }
    // 核心加解密部分
    for($a = $j = $i = 0; $i < $string_length; $i++) {
        $a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;
        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
        // 从密匙簿得出密匙进行异或，再转成字符
        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
    }
    if($operation == 'DECODE') {
        // 验证数据有效性，请看未加密明文的格式
        if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) &&
            substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
            return substr($result, 26);
        } else {
            return '';
        }
    } else {
        // 把动态密匙保存在密文里，这也是为什么同样的明文，生产不同密文后能解密的原因
        // 因为加密后的密文可能是一些特殊字符，复制过程可能会丢失，所以用base64编码
        return $keyc.str_replace('=', '', base64_encode($result));
    }
}
//加解密函数encrypt()：
function encrypt($string,$operation,$key=''){
    $key=md5($key);
    $key_length=strlen($key);
    $string=$operation=='D'?base64_decode($string):substr(md5($string.$key),0,8).$string;
    $string_length=strlen($string);
    $rndkey=$box=array();
    $result='';
    for($i=0;$i<=255;$i++){
        $rndkey[$i]=ord($key[$i%$key_length]);
        $box[$i]=$i;
    }
    for($j=$i=0;$i<256;$i++){
        $j=($j+$box[$i]+$rndkey[$i])%256;
        $tmp=$box[$i];
        $box[$i]=$box[$j];
        $box[$j]=$tmp;
    }
    for($a=$j=$i=0;$i<$string_length;$i++){
        $a=($a+1)%256;
        $j=($j+$box[$a])%256;
        $tmp=$box[$a];
        $box[$a]=$box[$j];
        $box[$j]=$tmp;
        $result.=chr(ord($string[$i])^($box[($box[$a]+$box[$j])%256]));
    }
    if($operation=='D'){
        if(substr($result,0,8)==substr(md5(substr($result,8).$key),0,8)){
            return substr($result,8);
        }else{
            return'';
        }
    }else{
        return str_replace('=','',base64_encode($result));
    }
}
/**
 * 获取两个时间之间的日期
 * @param $startDate
 * @param $endDate
 * @return array
 */
function getDatesBetweenTwoDays($startDate, $endDate)
{
    $dates = [];
    if (strtotime($startDate) > strtotime($endDate)) {
        // 如果开始日期大于结束日期，直接return 防止下面的循环出现死循环
        return $dates;
    } elseif ($startDate == $endDate) {
        // 开始日期与结束日期是同一天时
        array_push($dates, $startDate);
        return $dates;
    } else {
        array_push($dates, $startDate);
        $currentDate = $startDate;
        do {
            $nextDate = date('Y-m-d', strtotime($currentDate . ' +1 days'));
            array_push($dates, $nextDate);
            $currentDate = $nextDate;
        } while ($endDate != $currentDate);

        return $dates;
    }
}
/**
 * 获取本周所有日期
 */
function get_week($time = '', $format='Y-m-d'){
    $time = $time != '' ? $time : time();
    //获取当前周几
    $week = date('w', $time);
    $date = [];
    for ($i=1; $i<=7; $i++){
        $date[$i] = date($format ,strtotime( '+' . $i-$week .' days', $time));
    }
    return $date;
//    print_r(get_week());
//
//    Array
//    (
//        [1] => 2018-06-18
//    [2] => 2018-06-19
//    [3] => 2018-06-20
//    [4] => 2018-06-21
//    [5] => 2018-06-22
//    [6] => 2018-06-23
//    [7] => 2018-06-24
//)
}
/**
 * 获取最近七天所有日期
 */
function get_weeks($time = '', $format='Y-m-d'){
    $time = $time != '' ? $time : time();
    //组合数据
    $date = [];
    for ($i=1; $i<=7; $i++){
        $date[$i] = date($format ,strtotime( '+' . $i-7 .' days', $time));
    }
    return $date;

//    print_r(get_weeks());
//
//        Array
//        (
//            [1] => 2018-06-13
//        [2] => 2018-06-14
//        [3] => 2018-06-15
//        [4] => 2018-06-16
//        [5] => 2018-06-17
//        [6] => 2018-06-18
//        [7] => 2018-06-19
//    )
}

/**
 * 直接导出需要生产的内容
 * @param $field
 * @param $list
 * @param string $title
 * @throws \PHPExcel_Exception
 * @throws \PHPExcel_Writer_Exception
 */
function phpExcelList($field, $list, $title='文件')
{
    import('PHPExcel.PHPExcel');
    $objPHPExcel = new \PHPExcel();
    $objWriter = new \PHPExcel_Writer_Excel5($objPHPExcel); //设置保存版本格式
    foreach ($list as $key => $value) {
        foreach ($field as $k => $v) {
            if ($key == 0) {
                $objPHPExcel->getActiveSheet()->setCellValue($k . '1', $v[1]);
            }
            $i = $key + 2; //表格是从2开始的
            $objPHPExcel->getActiveSheet()->setCellValue($k . $i, $value[$v[0]]);
        }
    }
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
    header("Content-Type:application/force-download");
    header("Content-Type:application/vnd.ms-execl");
    header("Content-Type:application/octet-stream");
    header("Content-Type:application/download");;
    header('Content-Disposition:attachment;filename='.$title.'.xls');
    header("Content-Transfer-Encoding:binary");
    $objWriter->save('php://output');
}