<?php /*a:1:{s:80:"/www/wwwroot/101.200.121.249/carver-tp/app/web/view/loginUser/loginRegister.html";i:1617024272;}*/ ?>
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
                <div class="btn-wrap"><a class="btn btn-lg btn-register js-btn" data-target="register">注册</a><a
                        class="btn btn-lg btn-login js-btn" data-target="login">登录</a></div>
            </div>
        </div>

        <div class="card border-0 shadow card--register" id="register">
            <div class="card-body">
                <h2 class="card-title" style="font-family: 华文行楷">欢迎注册Carver博客！</h2>
                <p class="card-text" style="margin-bottom: 12px">第三方注册</p>
                <p class="badge-wrap"><a class="badge" href="qqIndex"><i class="fab fa-qq"></i></a><a class="badge"><i
                        class="fab fa-android"></i></a><a class="badge"><i class="fab fa-apple"></i></a></p>
                <p style="margin-top: 12px;margin-bottom: 12px">或者使用您的电子邮箱进行注册</p>
                <form>
                    <div class="form-group">
                        <input class="form-control" type="text" placeholder="您的名称" required="required" id="user_name"/>
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

        <div class="card border-0 shadow card--login" id="login">
            <div class="card-body">
                <h2 class="card-title" style="font-family: 华文行楷">欢迎登录Carver博客！</h2>
                <p style="margin-bottom: 12px">第三方登录</p>
                <p class="badge-wrap"><a class="badge" href="qqIndex"><i class="fab fa-qq"></i></a><a class="badge"><i
                        class="fab fa-android"></i></a><a class="badge"><i class="fab fa-apple"></i></a></p>
                <p style="margin-top: 12px;margin-bottom: 12px">或者使用您的电子邮箱进行登录</p>
                <form>
                    <div class="form-group">
                        <input class="form-control" type="email" placeholder="账号/邮箱/第三方登录" value="" required="required"
                               id="username"/>
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="password" placeholder="密码" required="required" id="userpwd"/>
                    </div>
                    <p><a href="#">忘记密码?</a></p>
                    <input type="button" class="btn btn-lg" value="登录" id="windLogin">
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
                    if (user_name == "") {
                        layer.alert("名称不能为空~", {title: "注册", icon: 5});
                        return false;
                    }
                    if (user_email == "") {
                        layer.alert("邮箱不能为空~", {title: "注册", icon: 5});
                        return false;
                    }
                    if (user_pwd == "") {
                        layer.alert("密码不能为空~", {title: "注册", icon: 5});
                        return false;
                    }
                    if (user_repwd == "") {
                        layer.alert("确认密码不能为空~", {title: "注册", icon: 5});
                        return false;
                    }
                    if (user_pwd != user_repwd) {
                        layer.alert("两次密码不一致，请重新输入~", {title: "注册", icon: 5});
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
                                    $(".card--login").addClass("is-show");

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
                    var user_name = $("#login form #username").val();
                    var user_pwd = $("#login form #userpwd").val();
                    if (user_name == "") {
                        layer.alert("名称或邮箱不能为空~", {title: "登录", icon: 5, type: 5});
                        return false;
                    }
                    if (user_pwd == "") {
                        layer.alert("密码不能为空~", {title: "登录", icon: 5});
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
                                data: {user_name: user_name, user_pwd: user_pwd},
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
        var user_name = $("#login form #username").val();
        var user_pwd = $("#login form #userpwd").val();
        if (user_name == "") {
            layer.alert("名称或邮箱不能为空~", {title: "登录", icon: 5, type: 5});
            return false;
        }
        if (user_pwd == "") {
            layer.alert("密码不能为空~", {title: "登录", icon: 5});
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
                    data: {user_name: user_name, user_pwd: user_pwd},
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
