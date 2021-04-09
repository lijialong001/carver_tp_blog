<?php
declare (strict_types = 1);

namespace app\admin\validate;

use think\Validate;

class AdminValidate extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */
	protected $rule = [
        'admin_name | 用户名'  => 'require | max:9 | chsAlpha',
        'auth | 用户类型'   => 'number | between:1,3',
        'password | 用户密码' => 'require |  max:10',
        'password_confirm | 用户确认密码' => 'require |  max:10 | confirm:password',
        'email | 用户邮箱' => 'require |  email'
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */
    protected $message = [
        'admin_name.require' => '用户名不能为空',
        'admin_name.max'     => '最多只能九个字符',
        'admin_name.chsAlpha'     => '用户名只能是汉字和字母',
        'auth.number'   => '选择正确的用户类型',
        'auth.between'  => '不在用户类型范围',
        'password.require'        => '用户密码不能为空',
        'password.max'        => '用户密码最多10个字符',
        'password_confirm.require'        => '用户确认密码不能为空',
        'password_confirm.max'        => '用户确认密码最多10个字符',
        'password_confirm.confirm'        => '两次密码不一致',
        'email.require'        => '邮箱不能为空',
        'email.email'        => '邮箱格式不正确'
    ];
}
