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
use app\facade\Lang;
use think\facade\Cache;



class Music
{
    protected $user;
    protected $defaultConfig=[];
    protected $apiUrl;

    public function __construct()
    {
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
        
        return json(['code' => 200, 'msg' => "获取成功", 'data' => $data]);
        
        
    }
    
    
    
    /**
     * @desc 获取天气信息
     * @author Carver
     */
    public function getWetherInfo()
    {
        $params['city'] = input('city','深圳');
        try {
            
            $is_cache = Cache::store('redis')->exists("carver_wether_info");
            if($is_cache){
                $wether = Cache::store('redis')->get("wether_info");
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
                    Cache::store('redis')->set("wether_info",$result,strtotime(date('Y-m-d 23:59:59',time()))-time());
                    
                }else{
                    throw new \Exception('请求不合法~');
                }
                
            }
            
            return json(['code' => 200, 'msg' => "获取成功", 'data' => $data]);
            
        } catch (\Exception $e) {
            
            return json(['code' => 5012, 'msg' => $e->getMessage(), 'data' => '']);
            
        }
        
    }
    
    
    /**
     * @desc 申请歌曲
     * @author Carver
     */
    public function applyMusic(){
        return json(['code' => 200, 'msg' => '暂时未开放', 'data' => '']);
    }
    
    
    
    


}
