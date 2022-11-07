<?php
declare (strict_types=1);

namespace app\admin\model;

use think\Model;
use think\model\concern\SoftDelete;

/**
 * @mixin \think\Model
 */
class CarverArticle extends Model
{
    protected $table = "carver_article";
    
    
    private static $instance = null;


    public static function getInstance() {
 
        if (!self::$instance instanceof self) {
     
           self::$instance = new self;
        }
     
        return self::$instance;
     
    }


    public function getArticleCount(){
        return $this->where("delete_time",0)->count();
    }

}
