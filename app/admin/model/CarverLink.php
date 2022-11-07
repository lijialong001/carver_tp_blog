<?php
declare (strict_types = 1);

namespace app\admin\model;

use think\Model;

/**
 * @mixin \think\Model
 */
class CarverLink extends Model
{
    protected $table="carver_link";
    
    
    private static $instance = null;


    public static function getInstance() {
 
        if (!self::$instance instanceof self) {
     
           self::$instance = new self;
        }
     
        return self::$instance;
     
    }
    
    
    public function getLinkCount(){
        return $this->where(["delete_time"=>null,'is_doc' => 1])
            ->count();
    }
    
    public function getNewLinkCount(){
        return $this->whereTime('create_time','today')->where('is_confirm',0)
            ->count();
    }
    
    
    
    
    

}
