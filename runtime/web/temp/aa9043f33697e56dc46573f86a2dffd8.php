<?php /*a:1:{s:85:"/www/wwwroot/101.200.121.249/carver_tp_blog/app/web/view/loginUser/loginRegister.html";i:1618130635;}*/ ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Carver-登录</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--图标库-->
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css'>

    <!--响应式框架-->
    <link rel='stylesheet' href='https://ajax.aspnetcdn.com/ajax/bootstrap/4.2.1/css/bootstrap.min.css'>

    <!--主要样式-->
    <link rel="stylesheet" href="/static/web/login/css/style.css">
    <link rel="stylesheet" href="/static/web/layui/css/layui.css">


</head>

<body>

<div class="container">

    <div class="card-wrap">

        <div class="card border-0 shadow card--welcome is-show" id="welcome">
            <div class="card-body">
                <h2 class="card-title" style="font-family: 华文行楷">Carver博客</h2>
                <p>欢迎进入Carver博客！</p><br>
                <div class="btn-wrap">
                    <a class="btn btn-lg btn-register js-btn" data-target="register">注册</a>
                    <a class="btn btn-lg btn-login js-btn" data-target="login">登录</a><br>
                    <a class="btn btn-sm btn-register  js-btn" style="margin-left: 14%" href="/">返回首页</a></div>
            </div>
        </div>

        <div class="card border-0 shadow card--register" id="register">
            <div class="card-body">
                <h2 class="card-title" style="font-family: 华文行楷">欢迎注册Carver博客！</h2>
                <!--<p class="card-text" style="margin-bottom: 12px">第三方注册</p>-->
                <!--<p class="badge-wrap">-->
                <!--<a class="badge" href="javascript:void (0)">-->
                <!--<i class="fab fa-qq"></i>-->
                <!--</a>-->
                <!--<a class="badge">-->
                <!--<i-->
                <!--class="fab fa-android"></i>-->
                <!--</a>-->
                <!--<a class="badge">-->
                <!--<i class="fab fa-apple">-->
                <!---->
                <!--</i>-->
                <!--</a>-->
                <!--</p>-->
                <!--<p style="margin-top: 12px;margin-bottom: 12px">或者使用您的电子邮箱进行注册</p>-->
                <form>
                    <div class="form-group">
                        <input class="form-control" type="text" placeholder="您的账号" required="required" id="user_name"/>
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="email" placeholder="您的邮箱" required="required"
                               id="user_email"/>
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="password" placeholder="您的密码" required="required"
                               id="user_pwd"/>
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="password" placeholder="您的确认密码" required="required"
                               id="user_repwd"/>
                    </div>
                    <input type="button" class="btn btn-lg" value="注册" id="windRegister">
                </form>
            </div>
            <button class="btn btn-back js-btn" data-target="welcome"><i class="fas fa-angle-left"></i></button>
        </div>

        <div class="card border-0 shadow card--login loginFirst" id="login">
            <div class="card-body">
                <h2 class="card-title" style="font-family: 华文行楷">欢迎登录Carver博客！</h2>
                <!--<p style="margin-bottom: 12px">第三方登录</p>-->
                <!--<p class="badge-wrap"><a class="badge" href="qqIndex"><i class="fab fa-qq"></i></a><a class="badge"><i-->
                <!--class="fab fa-android"></i></a><a class="badge"><i class="fab fa-apple"></i></a></p>-->
                <!--<p style="margin-top: 12px;margin-bottom: 12px">或者使用您的电子邮箱进行登录</p>-->
                <form>
                    <div class="form-group">
                        <input class="form-control" type="email" placeholder="账号" value="" required="required"
                               id="usernameinfo"/>
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="password" placeholder="密码" required="required"
                               id="userpwdinfo"/>
                    </div>
                    <p><a class="btn btn-sm btn-register js-btn" data-target="forgetPwdInfo">忘记密码？</a><br></p><br>
                    <input type="button" class="btn btn-lg" value="登录" id="windLogin">
                </form>
            </div>
            <button class="btn btn-back js-btn" data-target="welcome"><i class="fas fa-angle-left"></i></button>
        </div>

        <div class="card border-0 shadow card--login" id="forgetPwdInfo">
            <div class="card-body">
                <h2 class="card-title" style="font-family: 华文行楷">忘记密码</h2>
                <form>
                    <div class="form-group">
                        <input class="form-control" type="email" placeholder="请输入您账号绑定的邮箱" value="" required="required"
                               id="userId"/>
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="password" placeholder="请输入您的新密码" required="required"
                               id="userPassword"/>
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="password" placeholder="请再次输入您的新密码" required="required"
                               id="userPasswordConfirm"/>
                    </div>
                    <input type="button" class="btn btn-lg" value="确认提交" id="forgetInfo">
                </form>
            </div>
            <button class="btn btn-back js-btn" data-target="welcome"><i class="fas fa-angle-left"></i></button>
        </div>

    </div>

</div>
<script src="/static/web/login/js/index.js"></script>
<script src="/static/web/login/js/jquery.min.js"></script>
<script src="/static/web/layui/layui.js"></script>
</body>
</html>
<script>
    /**
     * @desc 监听注册，登录按钮事件
     * @author lijialong
     * @2020-07-22
     */
    layui.use('layer', function () {
        var layer = layui.layer;
        $(".btn-wrap *").click(function (e) {
            if (e.target == $(".btn-register")[0]) {
                $("#windRegister").click(function () {
                    var user_name = $("#register form #user_name").val();
                    var user_email = $("#register form #user_email").val();
                    var user_pwd = $("#register form #user_pwd").val();
                    var user_repwd = $("#register form #user_repwd").val();
                    //对电子邮件的验证
                    var email_reg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;

                    if (user_name == "") {
                        layer.alert("名称不能为空 ~", {title: "注册", icon: 5});
                        return false;
                    }
                    if (user_email == "") {
                        layer.alert("邮箱不能为空 ~", {title: "注册", icon: 5});
                        return false;
                    }

                    if (!email_reg.test(user_email)) {
                        layer.msg('邮箱格式不正确 ~', {title: "注册", icon: 5});
                        myreg.focus();
                        return false;
                    }

                    if (user_pwd == "") {
                        layer.alert("密码不能为空 ~", {title: "注册", icon: 5});
                        return false;
                    }
                    if (user_repwd == "") {
                        layer.alert("确认密码不能为空 ~", {title: "注册", icon: 5});
                        return false;
                    }
                    if (user_pwd != user_repwd) {
                        layer.alert("两次密码不一致，请重新输入 ~", {title: "注册", icon: 5});
                        return false;
                    }


                    layer.load(4, {
                        shade: false,
                        time: 1000,
                        success: function (data) {
                            $.ajax({
                                url: "/web/LoginUser/doRegister",
                                type: "post",
                                dataType: "json",
                                data: {user_name: user_name, user_email: user_email, user_pwd: user_pwd},
                                success: function (data) {
                                    layer.msg(data.msg);
                                    $("body").removeClass("is-register");
                                    $(".card--welcome").removeClass("is-show");
                                    $(".card--register").removeClass("is-show");
                                    $("body").addClass("is-login");
                                    $(".loginFirst").addClass("is-show");

                                },
                                error: function (data) {
                                    layer.alert("服务器繁忙~", {title: "注册", icon: 5});
                                }
                            })
                        }
                    });

                })

            }
            if (e.target == $(".btn-login")[0]) {
                $("#windLogin").click(function () {
                    var usernameinfo = $("#usernameinfo").val();
                    var userpwdinfo = $("#userpwdinfo").val();
                    if (usernameinfo == "") {
                        layer.alert("名称或邮箱不能为空 ~", {title: "登录", icon: 5});
                        return false;
                    }
                    if (userpwdinfo == "") {
                        layer.alert("密码不能为空 ~", {title: "登录", icon: 5});
                        return false;
                    }
                    layer.load(4, {
                        shade: false,
                        time: 3 * 1000,
                        success: function (data) {
                            $.ajax({
                                url: "/web/LoginUser/doLogin",
                                type: "post",
                                dataType: "json",
                                data: {user_name: usernameinfo, user_pwd: userpwdinfo},
                                success: function (data) {
                                    layer.msg(data.msg, {icon: -1, time: 3000}, function () {
                                        window.location.href = "/web/LoginUser/userIndex"
                                    });
                                },
                                error: function (data) {
                                    layer.alert("服务器繁忙~", {title: "登录", icon: 5});
                                }
                            })
                        }
                    });

                })
            }
        })
    });


    /**
     * @desc 注册之后跳转进行登录
     * @author lijialong
     * @2020-07-22
     */
    $("#windLogin").click(function () {
        var usernameinfo = $("#login form #usernameinfo").val();
        var userpwdinfo = $("#login form #userpwdinfo").val();
        if (usernameinfo == "") {
            layer.alert("名称或邮箱不能为空 ~", {title: "登录", icon: 5});
            return false;
        }
        if (userpwdinfo == "") {
            layer.alert("密码不能为空 ~", {title: "登录", icon: 5});
            return false;
        }
        layer.load(4, {
            shade: false,
            time: 3 * 1000,
            success: function (data) {
                $.ajax({
                    url: "/web/LoginUser/doLogin",
                    type: "post",
                    dataType: "json",
                    data: {user_name: usernameinfo, user_pwd: userpwdinfo},
                    success: function (data) {
                        $("body").removeClass("is-register");
                        $(".card--welcome").removeClass("is-show");
                        $(".card--register").removeClass("is-show");
                        $("body").addClass("is-login");
                        $(".loginFirst").addClass("is-show");
                        layer.msg(data.msg, {icon: -1, time: 3000}, function () {
                            window.location.href = "/web/LoginUser/userIndex"
                        });
                    },
                    error: function (data) {
                        layer.alert("服务器繁忙~", {title: "登录", icon: 5});
                    }
                })
            }
        });

    })

    /**
     * @desc 忘记密码
     * @author Carver
     */
    $("#forgetInfo").click(function () {
        var user_email = $("#userId").val();
        var userPassword = $("#userPassword").val();
        var userPasswordConfirm = $("#userPasswordConfirm").val();

        //对电子邮件的验证
        var email_reg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;

        if (user_email == "") {
            layer.alert("邮箱不能为空 ~", {title: "忘记密码", icon: 5});
            return false;
        }

        if (!email_reg.test(user_email)) {
            layer.alert("邮箱格式不正确 ~", {title: "忘记密码", icon: 5});
            return false;
        }

        if (userPassword == "") {
            layer.alert("新密码不能为空 ~", {title: "忘记密码", icon: 5});
            return false;
        }

        if (userPasswordConfirm == "") {
            layer.alert("确认的新密码不能为空 ~", {title: "忘记密码", icon: 5});
            return false;
        }

        if (userPassword != userPasswordConfirm) {
            layer.alert("两次输入的密码不一致 ~", {title: "忘记密码", icon: 5});
            return false;
        }


        layer.load(4, {
            shade: false,
            time: 3 * 1000,
            success: function (data) {
                $.ajax({
                    url: "/web/LoginUser/forgetPwd",
                    type: "post",
                    dataType: "json",
                    data: {user_email: user_email, user_pwd: userPassword},
                    success: function (data) {
                        layer.msg(data.msg, {icon: -1, time: 3000}, function () {
                            window.location.href = "/web/LoginUser/userIndex"
                        });
                    },
                    error: function (data) {
                        layer.alert("服务器繁忙~", {title: "登录", icon: 5});
                    }
                })
            }
        });
    })

</script>
