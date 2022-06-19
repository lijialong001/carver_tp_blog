<?php

use app\admin\model\CarverOperateLog;
use app\admin\model\CarverSystemLog;
use \Firebase\JWT\JWT;

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


/**
 * @desc 生成自定义的密钥和共钥
 */
function getKeys() {
    
    $resource = openssl_pkey_new();
    openssl_pkey_export($resource, $privateKey);
    $detail = openssl_pkey_get_details($resource);
    $publicKey= $detail['key'];
    
    $data['private_key']=$privateKey;
    $data['public_key']=$publicKey;
    
    return $data;
}



/**
 * @param array $data 需要加密的数据
 * @param array $keys 密钥
 * @desc 加密
 */
function encryptCarver(array $data,array $keys=[]) {
        $data = json_encode($data);
        if(!isset($keys['private_key'])){
            $keys['private_key']='-----BEGIN PRIVATE KEY-----
MIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQDzlbkfgU88gra9
+YBOKmSChiuevu7xBscm5iS0twjjLSduaFiRrJ0IZV4RB4PonZr0ITeh/7UOA99b
H+Nglo9eAI8XwAUYqsTWfT3p3sOLJfYNW9QVHcXhrdJrss3QxY6i1G3NicSa7zzq
8dxJamXkjzkL+HkCh7iUcc8QrLWT3NlCnyRLDlbZMmeN9vxuYdr0zRW0uTaX6w4U
g8PY0HIBEFfGIhuo/6g7krJm9e0zb6bljQ3ZdivVALPppthyTDOiFvJEK34f232x
IMkluqZBLWcc4kvT8Tv2URrzS+1xClMd73Td6tqXJ909ynAZOvMdabXRGN9V7a4m
vzM3ZjzFAgMBAAECggEAQYEJ/4bun/8m1X+7GUodLVyXbmE6MGb6N2O8izyNj0od
SHuXFdWthQx9d2bl+jAn827bXx08u0AfWIoCw365nzXXRTPGKxQBSwzzEWlufIUA
3ibLqcIP7NiptXyoDHSUHwWxYYyi6mdbonLYIoYSUJyTYry3Dg8hfAn+/ST0z4YW
OCn8ez9CUAlHhWxOumKe1G2mYjy3oLIaO6at55S42DdLY1JImpefSmGxJGcm1tDJ
QW9FUex7m8dDgaBUDIOXMLjiIUr9J2wjBtaL9Sk1sQYRf1opJYz6I/GbpXnWZWj/
zEXyUsWW8k0UCWjOFF6pZ+Y9tSS4OlddtOdePF4sIQKBgQD6RgP8BYFa0LZHEQTY
9W4B0HLgSpYMq3/qNUwQBX8S9k8Q3aiK89tOVELWDODzIorfQcDlLWbWp+qVUuBe
R3sYJOCb3LNEZkB4n/mOBHQ1PnHAn6QTZlU5WHjPC3/tRcrP//PTqHn9LGmuP7+d
r+eWTA5gYAfOd+7IPTU3ukjBDwKBgQD5KIdVv4MGu/g9jubsLYQKiwM/D69Htakm
sYkjwZ3T/Sgusw3m+ioiVBDTjEc/HxN+SDhdLfN6tON25Fg7dlr9No717BoBclpf
x7BP/jjrkx8V2evwnhgfMI6+nP9OnkzM1LCyoQxSjamF75AAHwBspIG3WnzThkRF
mnIdXcq86wKBgQD46/CElnks+U+CaYP3wkvS1B+dw7FwEpdcO/xWJxFXq9HCBaTf
52EljBsZyJ9oU9/p4/1WNA0HzOU99bshKlldDziy7RUEH+tZzksonHd0iZIcMuu/
O9Xh/oPR8i8fsH3i2UELMJN8YtMNs2wDC3T8gNL/uiOpkJHXaUFoFwjLswKBgEDx
OWU2R7ano+qXpsUEkBgXZ782HV+5j99QAwjY3IR2xdR2QzdjGTxdYQ1i0Oc4+GG/
/UD8Syw+ndNNbVoCXXEGmXisE5Mw9TFl4STYhImSjVWquX68Fll61JoGXd1mEWqK
PYwxwf56gicw6/28FuY6cr0Rzttrcbwap4fT/JYFAoGBANRH9DMxxrorFnG/pAUN
31fgFzvaBLfVTZRK9ZwCZMUfG+oiOKOUH5KRqUZLN9buUHtycvpQI1f7WtAGT+yV
BBaiJzPOnYggR+a775mp71AQalrN7O5J8YlaRzNKNJgNacX+w6LBiq5tb0AxBYSG
llSnwERjO8naJ/+23H4ZRWnZ
-----END PRIVATE KEY-----';
        }
        
        $result = openssl_private_encrypt($data, $encrypted, $keys['private_key']);
        
        if($result === false) {
            return NULL;
        } else {
            
            return base64_encode($encrypted);
        }      
}    


/**
 * @param string $data 加密后的数据
 * @param array $keys 共钥
 * @desc 解密
 */

function decryptCarver(string $data ,array $keys=[]) {
        if(!isset($keys['public_key'])){
            $keys['public_key']='-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA85W5H4FPPIK2vfmATipk
goYrnr7u8QbHJuYktLcI4y0nbmhYkaydCGVeEQeD6J2a9CE3of+1DgPfWx/jYJaP
XgCPF8AFGKrE1n096d7DiyX2DVvUFR3F4a3Sa7LN0MWOotRtzYnEmu886vHcSWpl
5I85C/h5Aoe4lHHPEKy1k9zZQp8kSw5W2TJnjfb8bmHa9M0VtLk2l+sOFIPD2NBy
ARBXxiIbqP+oO5KyZvXtM2+m5Y0N2XYr1QCz6abYckwzohbyRCt+H9t9sSDJJbqm
QS1nHOJL0/E79lEa80vtcQpTHe903eralyfdPcpwGTrzHWm10RjfVe2uJr8zN2Y8
xQIDAQAB
-----END PUBLIC KEY-----';
        }
        $result = openssl_public_decrypt($data, $decrypted, $keys['public_key']);
        if($result === false) {
            return NULL;
        } else {
            return json_decode($decrypted, true);
        }
}   



function sendCarverEmail($userEmail='',$userName=''){
        //Create the Transport
        $transport = (new \Swift_SmtpTransport('smtp.qq.com', 465, 'ssl'))
            ->setUsername(env('carver.email_name'))
          ->setPassword(env("carver.email_password"));
        
        // Create the Mailer using your created Transport
        $mailer = new \Swift_Mailer($transport);
        
        $user_code=mt_rand(1000,9999);
        // Create a message
        $message = (new \Swift_Message('Carver 博客官网'))
            ->setFrom([env("carver.email_name") => 'Carver'])
            ->setTo([$userEmail => $userName])
            ->setBody('该验证码有效期为一分钟：'.$user_code)
        ;
        
        // Send the message
        $result = $mailer->send($message);
        $msg='服务器异常';
        $code=500;
        if($result){
            $code=200;
            $msg='发送成功';
        }
        return ['code'=>$code,'msg'=>$msg,'data'=>$user_code]; 
}

//生成验签
function signToken($uid){
    $key='Carver$#@!';//这里是自定义的一个随机字串，应该写在config文件中的，解密时也会用，相当    于加密中常用的 盐  salt
    $token=array(
        "iss"=>$key,         //签发者 可以为空
        "aud"=>'',           //面象的用户，可以为空
        "iat"=>time(),       //签发时间
        "nbf"=>time()+10,    //在什么时候jwt开始生效  （这里表示生成10秒后才生效）
        "exp"=> time()+3600, //token 过期时间 这里只是演示 设置的分钟
        "data"=>[            //记录的userid的信息，这里是自已添加上去的，如果有其它信息，可以再添加数组的键值对
            'uid'=>$uid,
        ]
    );

    $jwt = JWT::encode($token, $key, "HS256");  //根据参数生成了 token
    return $jwt;
}



//验证token
function checkToken($token){
    $key='Carver$#@!';
    $status=array("code"=>2);
    try {
        JWT::$leeway = 60;//当前时间减去60，把时间留点余地
        $decoded = JWT::decode($token, $key, array('HS256')); //HS256方式，这里要和签发的时候对
        $arr = (array)$decoded;
        $res['code']=1;
        $res['data']=$arr['data'];
        return $res;

    } catch(\Firebase\JWT\SignatureInvalidException $e) { //签名不正确
        $status['msg']="签名不正确";
        return $status;
    }catch(\Firebase\JWT\BeforeValidException $e) { // 签名在某个时间点之后才能用
        $status['msg']="token失效";
        return $status;
    }catch(\Firebase\JWT\ExpiredException $e) { // token过期
        $status['msg']="token失效";
        return $status;
    }catch(Exception $e) { //其他错误
        $status['msg']="未知错误";
        return $status;
    }
}





