<?php
declare (strict_types=1);

namespace app;

use think\App;
use think\exception\ValidateException;
use think\facade\Db;
use think\Validate;
use think\facade\Lang;
use app\admin\model\CarverAdmin;
use app\admin\model\CarverRole;
use app\admin\model\CarverAdminRole;
use app\admin\model\CarverAuth;
use app\admin\model\CarverRoleAuth;
use think\facade\Cache;

/**
 * 控制器基础类
 */
abstract class BaseController
{
    /**
     * Request实例
     * @var \think\Request
     */
    protected $request;

    /**
     * 应用实例
     * @var \think\App
     */
    protected $app;

    /**
     * 是否批量验证
     * @var bool
     */
    protected $batchValidate = false;

    /**
     * 控制器中间件
     * @var array
     */
    protected $middleware = [];
    
    
    protected $is_temp_auth = null;

    /**
     * 构造方法
     * @access public
     * @param App $app 应用对象
     */
    public function __construct(App $app)
    {
        Lang::load(base_path() . 'admin/lang/' . config('lang.default_lang') . '/login.lang.php');
        $this->app = $app;
        $this->request = $this->app->request;
        $this->is_temp_auth= Cache::store('redis')->exists('carver_temp_user_'.get_client_ip());
        // 登录验证
        $this->initialize();
        
        /**
         * @desc 登录后的用户是否有相应的权限
         * @author  Carver
         * @date 2020-07-19
         */
         if(session("admin_role")){//判断当前的登录方式
             $role_id = session("admin_role");
         }else if($this->is_temp_auth){//临时授权
             $json_data = $this->checkUserInfo(true);
             $role_id = $json_data['role_id']??0;
         }else{
             return ['auth_code' => 0];
         }
         
         
        //用户的权限信息
        $auth_info = CarverAdminRole::where("carver_admin_role.role_id", $role_id)
            ->field("carver_admin_role.admin_id,b.role_name,a.auth_id,c.auth_name,c.p_id")
            ->join("carver_role_auth a", "carver_admin_role.role_id=a.role_id", "left")
            ->join("carver_role b", "carver_admin_role.role_id=b.role_id", "left")
            ->join("carver_auth_new c", "a.auth_id=c.auth_id", "left")
            ->group("a.auth_id,carver_admin_role.role_id")
            ->select()
            ->toArray();
            

        //获取当前访问的控制器和方法
        $current_controller = $this->request->controller();
        $current_action = $this->request->action();

        $reg = $this->judgeAuth($current_controller, $current_action, $auth_info);
        switch ($reg['code']) {
            case 0:
                return ['auth_code' => 0];
                break;
            case 1:
                return ['auth_code' => 1];
                break;
        }

    }

    //判断访问的权限数据
    public function judgeAuth($controller, $action, $data)
    {
        $auth_list = array_column($data, "auth_name");

        if (in_array($controller, $auth_list) && in_array($action, $auth_list)) {
            return ['code' => 1, 'msg' => '您有访问的权限!'];
        } else {
            return ['code' => 0, 'msg' => '您没有访问的权限!'];
        }

    }

    /**
     * @desc 初始化 验证用户是否已经登录
     * @author  Carver
     * @date 2020-07-18
     */
    protected function initialize()
    {

        $admin_id = session("admin_id");
        $admin_role = session("admin_role");

        if (is_null($admin_role) && !$this->is_temp_auth) {//正常登录或临时授权
            $this->clearUserInfo();
            $this->error(lang("admin_login_warning"), "Login/login");
        } else if(!is_null($admin_role)){
            $current_time = session("token_time");
            $current_token = md5($admin_id . $current_time);
            $lastToken = CarverAdmin::where('admin_id', $admin_id)->value("token");
    
            if ($current_token != $lastToken) {
    
                session("admin_id", null);
                $this->error("已在其他地方登录，请重新登录...", "Login/login");
            }
            
        }else if($this->is_temp_auth){//临时授权
            $this->checkUserInfo();
        }else{
            $this->clearUserInfo();
            $this->error(lang("admin_login_warning"), "Login/login");
            
        }

    }
    
    
    protected function checkUserInfo($is_return = false){
        $is_exists = Cache::store('redis')->get('temp_user_'.get_client_ip());
        if($is_exists){//是否已经过期
            $json_data = json_decode($is_exists,true);
            if(time() - $json_data['current_time'] > $json_data['expire_time'] ){//过期
                Cache::store('redis')->delete('temp_user_'.get_client_ip());
                Db::name('carver_temp_auth')
                ->where(['ip'=>get_client_ip(),'is_overduce'=>0])
                ->update(['is_overduce'=>1]);
                $this->clearUserInfo();
                $this->error(lang("admin_login_warning"), "Login/login");
            }else if($is_return){
                return [ 'json_data'=> $json_data];
            }
        }
    }
    
    
    protected function clearUserInfo(){
        session("admin_id", null);
        session("admin_role", null);
    }


    /**
     * 验证数据
     * @access protected
     * @param array $data 数据
     * @param string|array $validate 验证器名或者验证规则数组
     * @param array $message 提示信息
     * @param bool $batch 是否批量验证
     * @return array|string|true
     * @throws ValidateException
     */
    protected function validate(array $data, $validate, array $message = [])
    {
        if (is_array($validate)) {
            $v = new Validate();
            $v->rule($validate);
        } else {
            if (strpos($validate, '.')) {
                // 支持场景
                [$validate, $scene] = explode('.', $validate);
            }
            $class = false !== strpos($validate, '\\') ? $validate : $this->app->parseClass('validate', $validate);
            $v = new $class();
            if (!empty($scene)) {
                $v->scene($scene);
            }
        }

        $v->message($message);

        // 是否批量验证
        if ($batch || $this->batchValidate) {
            $v->batch(true);
        }

        return $v->failException(true)->check($data);
    }

    use \liliuwei\think\Jump;
}
