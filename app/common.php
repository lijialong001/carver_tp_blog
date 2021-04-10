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




