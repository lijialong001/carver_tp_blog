<?php
declare (strict_types=1);

namespace app\admin\model;

use think\Model;
use think\model\concern\SoftDelete;

/**
 * @mixin \think\Model
 */
class CarverComment extends Model
{
    protected $table = "carver_comment";
    
    
    private static $instance = null;


    public static function getInstance() {
 
        if (!self::$instance instanceof self) {
     
           self::$instance = new self;
        }
     
        return self::$instance;
     
    }
    
    
    public function getCommentCount(){
        return $this
            ->alias("a")
            ->leftjoin("carver_comment_to_others r", "a.user_id=r.comment_user_id")
            ->where(['a.delete_time'=> null , 'r.delete_time' => null])
            ->count();
    }
    
}
