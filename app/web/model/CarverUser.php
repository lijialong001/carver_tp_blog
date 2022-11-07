<?php
declare (strict_types = 1);

namespace app\web\model;

use think\Model;

/**
 * @mixin \think\Model
 */
class CarverUser extends Model
{
    protected $table="carver_user";
    
    private static $instance = null;


    public static function getInstance() {
 
        if (!self::$instance instanceof self) {
     
           self::$instance = new self;
        }
     
        return self::$instance;
     
    }
    
    
    
    public function getRegisterUserCount(){
        return $this->whereTime('add_time','today')->count();
    }
    
    
    
    public function getOnlineUserCount(){
        return $this->whereTime('last_login','today')->where(['is_lock' => 0 ,'online' => 1])->count();
    }
    
    
    public function getUserInfo(){
        return 1;
    }
    
    
}
