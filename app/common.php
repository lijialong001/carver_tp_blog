<?php

use app\admin\model\CarverOperateLog;
use app\admin\model\CarverSystemLog;

// 应用公共文件

//p方法
function p($data)
{
// 定义样式
    $str = '<pre style="display: block;padding: 9.5px;margin: 44px 0 0 0;font-size: 13px;line-height: 1.42857;color: #333;word-break: break-all;word-wrap: break-word;background-color: #F5F5F5;border: 1px solid #CCC;border-radius: 4px;">';
// 如果是boolean或者null直接显示文字；否则print
    if (is_bool($data)) {
        $show_data = $data ? 'true' : 'false';
    } elseif (is_null($data)) {
        $show_data = 'null';
    } else {
        $show_data = print_r($data, true);
    }
    $str .= $show_data;
    $str .= '</pre>';
    echo $str;
}

/**
 * @param $action
 * @desc 操作和系统日志
 */
function logMsg($action)
{

    $isSystem = strpos($action, "system");

    if ($isSystem !== false) {
        $systemLog['action_name'] = lang($action);
        $systemLog['action_ip'] = get_client_ip();
        $systemLog['action_user_id'] = session("admin_id");
        $systemLog['action_user'] = session("admin_name");
        $systemLog['create_time'] = time();
        CarverSystemLog::insert($systemLog);
    } else {
        $adminLog['log_name'] = lang($action);
        $adminLog['log_user_id'] = session("admin_id");
        $adminLog['log_user'] = session("admin_name");
        $adminLog['create_time'] = time();
        CarverOperateLog::insert($adminLog);
    }


}

/*
 * @desc 获取客户端ip
 */
function get_client_ip($type = 0)
{
    $type = $type ? 1 : 0;
    static $ip = NULL;
    if ($ip !== NULL) return $ip[$type];
    if (isset($_SERVER['HTTP_X_REAL_IP'])) { //nginx 代理模式下，获取客户端真实IP
        $ip = $_SERVER['HTTP_X_REAL_IP'];
    } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) { //客户端的ip
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) { //浏览当前页面的用户计算机的网关
        $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        $pos = array_search('unknown', $arr);
        if (false !== $pos) unset($arr[$pos]);
        $ip = trim($arr[0]);
    } elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $ip = $_SERVER['REMOTE_ADDR']; //浏览当前页面的用户计算机的ip地址
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    // IP地址合法验证
    $long = sprintf("%u", ip2long($ip));
    $ip = $long ? array($ip, $long) : array('0.0.0.0', 0);
    return $ip[$type];
}

/**
 * @param $str
 * @return string|string[]|null
 * @desc 重新计算字符串的长度
 */
function mb_unserialize($str)
{
    return preg_replace_callback('#s:(\d+):"(.*?)";#s', function ($match) {
        return 's:' . strlen($match[2]) . ':"' . $match[2] . '";';
    }, $str);
}


/**
 * @param $file_url
 * @return string
 * @desc 下载远程图片到指定目录
 * @author  Carver
 * @date  2020-11-13
 */

if (!function_exists('downImage')) {
    function downImage($file_url, $save_url)
    {
        if (!is_dir($save_url)) {
            mkdir($save_url, 0777, true);
        }

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $file_url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);

        $file = curl_exec($ch);

        curl_close($ch);

        $filename = "favicon.ico";

        if(file_exists($save_url . $filename)){
            unlink($save_url . $filename);
        }

        $resource = fopen($save_url . $filename, 'a');

        fwrite($resource, $file);

        fclose($resource);

        return $save_url . '/' . $filename;
    }
}



function setUserClickInfo($userJsonInfo){
    session_start();
    $log = 'click.txt'; //记录文件，根目录下
    $handle = fopen($log,"a+");
    if(!$handle){
        exit('数据打开失败');
    }
    $country='暂无设置';
    $regionName='暂无设置';
    $city='暂无设置';
    $ip='暂无设置';
    $userInfo=json_decode($userJsonInfo,true);
    if(isset($userInfo['status']) && $userInfo['status']=='success'){
        $country=$userInfo['country'];
        $regionName=$userInfo['regionName'];
        $city=$userInfo['city'];
        $ip=$userInfo['query'];
        
    }
    
    $time=date("Y-m-d H:i:s",time());
    
    $urlParams="-".$country."【".$regionName."-".$city."】-".$time."-".$ip;
    
    $res = fwrite($handle,session_id().$urlParams.chr(13));
    if(!$res){
        exit('数据写入失败');
    }
    fclose($handle);
    $file = file_get_contents($log);
    $content = explode(chr(13),$file);
    $num = count($content)-1;
    return $num;

}


function getUserIpInfo($url='',$params=false,$ispost=0){
    $ch = curl_init();
        curl_setopt( $ch, CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_1 );
        curl_setopt( $ch, CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_1 );
        curl_setopt( $ch, CURLOPT_USERAGENT , 'free-api' );
        curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT , 60 );
        curl_setopt( $ch, CURLOPT_TIMEOUT , 60);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER , true );
        if( $ispost )
        {
            curl_setopt( $ch , CURLOPT_POST , true );
            curl_setopt( $ch , CURLOPT_POSTFIELDS , $params );
            curl_setopt( $ch , CURLOPT_URL , $url );
        }
        else
        {
            if($params){
                curl_setopt( $ch , CURLOPT_URL , $url.'?'.$params );
            }else{
                curl_setopt( $ch , CURLOPT_URL , $url);
            }
        }
        $response = curl_exec( $ch );
    
        if ($response === FALSE) {
            return false;
        }
        curl_close( $ch );
        return $response;
}


function getStrBetData($str,$first_str=0,$end_str=0){
    $result='';
    $st =mb_strpos($str,$first_str);
    $ed =mb_strpos($str,$end_str);
    if(($st!==false && $ed!==false) && $st<$ed){
        $result=mb_substr($str,($st+1),($ed-$st-1));
    };
    return $result;
}

function merge_arr_column($arr){
    $temp=[];
    foreach ($arr as $key => $value){
        if($value){
            $temp[$value][]=$value;
        }
        
    }
    return $temp;
}







