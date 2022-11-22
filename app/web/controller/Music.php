<?php
declare (strict_types=1);

namespace app\web\controller;

use think\facade\Db;
use think\facade\Session;
use think\facade\View;
use think\Request;
use app\admin\model\CarverArticle;
use app\web\model\CarverUser;
use app\web\model\CarverNavigation;
use app\admin\model\CarverLink;
use app\admin\model\CarverNotice;
use page\page;
use think\facade\Lang;
use think\facade\Cache;



class Music
{
    protected $user;
    protected $defaultConfig=[];
    protected $apiUrl;

    public function __construct()
    {
        Lang::load(base_path() . 'web/lang/'.'/zh-cn.php');
    }


    /**
     * @desc 获取歌曲
     * @author Carver
     */
    public function getSongList()
    {
        $is_cache = Cache::store('redis')->exists("carver_song_list");
        if($is_cache){
            $songs = Cache::store('redis')->get("song_list");
            $data['data'] = json_decode($songs,true);
            $data['is_cache'] = true;
            
        }else{
            $data['data'] = Db::name('carver_music')->where('delete_time',0)->select()->toArray();
            Cache::store('redis')->set("song_list",json_encode($data['data']));
            $data['is_cache'] = false;
        }
        
    
        foreach ($data['data'] as $item){
            $item['lyric'] = json_decode($item['lyric'],true);
        }
        
        return json(['code' => 200, 'msg' => \lang('get_success'), 'data' => $data]);
        
        
    }
    
    
    
    /**
     * @desc 获取天气信息
     * @author Carver
     */
    public function getWetherInfo()
    {
        //获取当前用户当地的天气
        $user_info = ip_details(get_client_ip());
        $user_address = json_decode(json_encode($user_info),true)['city']??'';
        if(empty($user_address)){
            throw new \Exception(\lang('wether_request_count'));
        }
        $userWetherCacheKey = sprintf('wether_user_%s',$user_address);
    
        //查找当天的用户是否是同一个地区
        $is_cache = Cache::store('redis')->exists("carver_".$userWetherCacheKey);
        if($is_cache){
            $wether = Cache::store('redis')->get($userWetherCacheKey);
            $params['city'] = json_decode($wether,true);
                
        }else{
        
            //获取当前地区的请求次数
            $count = Cache::store('redis')->get('carver_'.$userWetherCacheKey.'_count');
            if($count > 3) throw new \Exception(\lang('wether_request_count'));
            $translate_result = translate($user_address);
            $cacheData = $translate_result['trans_result'][0]['dst']??'';
            Cache::store('redis')->set($userWetherCacheKey,json_encode($cacheData),strtotime(date('Y-m-d 23:59:59',time()))-time());
            Cache::store('redis')->incr('carver_'.$userWetherCacheKey.'_count',1);
            $params['city'] = $cacheData;
        }
        
    
        try {
            
            $userAddressCacheKey = sprintf('wether_info_%s',$user_address);
            $is_cache = Cache::store('redis')->exists("carver_".$userAddressCacheKey);
            if($is_cache){
                $wether = Cache::store('redis')->get($userAddressCacheKey);
                $data['data'] = json_decode($wether,true);
                $data['is_cache'] = true;
                
            }else{
                $params['city'] = $params['city'];
                $params['key'] = env("carver.wether_key");
                $result = curlGet('http://apis.juhe.cn/simpleWeather/query',$params);
                $res = json_decode($result,true);
                $data['data'] = $res;
                $data['is_cache'] = false;  
                
                if(isset($res['error_code']) && $res['error_code'] == 0){
                    Cache::store('redis')->set($userAddressCacheKey,$result,strtotime(date('Y-m-d 23:59:59',time()))-time());
                    
                }else{
                    throw new \Exception(\lang('wether_request_count'));
                }
                
            }
            
            return json(['code' => 200, 'msg' => \lang('get_success'), 'data' => $data]);
            
        } catch (\Exception $e) {
            
            return json(['code' => 5012, 'msg' => $e->getMessage(), 'data' => '']);
            
        }
        
    }
    
    
    /**
     * @desc 申请歌曲
     * @author Carver
     */
    public function applyMusic(){
        
        return json(['code' => 200, 'msg' => \lang('get_no'), 'data' => '']);
    }
    
    
    
    
    
    
    


}
