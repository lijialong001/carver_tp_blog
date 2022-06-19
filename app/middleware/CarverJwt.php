<?php


namespace app\middleware;
use \Firebase\JWT\JWT;
use think\facade\Request;
class CarverJwt
{

    public function handle($request, \Closure $next)
    {	
		$token = $request->param();
		if(!isset($token['token'])){
		    return json(['status'=>5001,'msg'=>'请求不合法~']);
		}


		$data = checkToken($token['token']);
		
		if ($data['code'] != 1){
			return json(['status'=>5002,'msg'=>'请先登录~']);
		}
		return $next($request);


    }
}
