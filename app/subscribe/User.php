<?php
declare (strict_types = 1);

namespace app\subscribe;

use think\facade\Db;


class User
{
		public function onCar(){
					Db::name("user")->where("user_Id",1)->update(['user_name'=>1111]);
		}
}
