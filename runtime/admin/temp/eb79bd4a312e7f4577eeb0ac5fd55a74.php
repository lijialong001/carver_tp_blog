<?php /*a:1:{s:75:"/www/wwwroot/101.200.121.249/carver_tp_blog/app/admin/view/login/login.html";i:1618120768;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Carver</title>
    <link rel="stylesheet" href="/static/admin/css/style.css">
    <script src="/static/admin/layui/layui.js"></script>
</head>

<body>
<main style="background:mediumpurple">
    <input type="hidden" value="{__CARVER__}">
    <form class="form">
        <div class="form__cover"></div>
        <div class="form__loader">
            <div class="spinner active">
                <svg class="spinner__circular" viewBox="25 25 50 50">
                    <circle class="spinner__path" cx="50" cy="50" r="20" fill="none" stroke-width="4"
                            stroke-miterlimit="10"></circle>
                </svg>
            </div>
        </div>
        <div class="form__content">
            <h1 style="font-family: 华文行楷;color: white">Carver</h1>
            <div class="styled-input">
                <input type="text" class="styled-input__input" id="user_name">
                <div class="styled-input__placeholder"><span class="styled-input__placeholder-text">请输入您的用户名</span>
                </div>
                <div class="styled-input__circle"></div>
            </div>
            <div class="styled-input">
                <input type="password" class="styled-input__input" id="admin_pwd">
                <div class="styled-input__placeholder"><span class="styled-input__placeholder-text">请输入您的密码</span></div>
                <div class="styled-input__circle"></div>
            </div>
            <?php if(app('request')->session('login_num')!=null && app('request')->session('login_num')>=3): ?>
            <div class="styled-input">
                <input type="text" class="styled-input__input" id="captcha">
                <div class="styled-input__placeholder"><span class="styled-input__placeholder-text">请输入您验证码</span></div>
                <div class="styled-input__circle"></div>
            </div>
            <div class="styled-input">
                <div style="width: 200px;height: 40px"><?php echo captcha_img(); ?></div>
            </div>
            <?php endif; ?>
            <button type="button" class="styled-button" style="font-size: 23px;height: 60px;line-height: 20px" id="btn">
                <span class="styled-button__real-text-holder"> <span class="styled-button__real-text">登&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;录</span> <span
                        class="styled-button__moving-block face"> <span class="styled-button__text-holder"> <span
                        class="styled-button__text">登&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;录</span> </span> </span><span
                        class="styled-button__moving-block back"> <span class="styled-button__text-holder"> <span
                        class="styled-button__text">登&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;录</span> </span> </span> </span>
            </button>
            <!--            <marquee behavior="" direction="" style="color: white;font-family: 华文行楷">欢迎登录龙为天下电商管理系统！</marquee>-->
        </div>
    </form>
</main>
<script src="/static/admin/js/index.js"></script>
<script src="/static/admin/js/jqueryNew/jquery-3.5.1.js"></script>
<script>
    layui.use('layer', function () {
        var layer = layui.layer;
        var click_num = 0;
        //ajax请求点击按钮
        $("#btn").click(function () {
            var admin_name = $("#user_name").val();
            var admin_pwd = $("#admin_pwd").val();
            var captcha = $("#captcha").val();
            click_num++;
            $.ajax({
                url: "/admin/doLogin",
                type: "get",
                data: {admin_name: admin_name, admin_pwd: admin_pwd, captcha: captcha, click_num: click_num},
                dataType: "json",
                success: function (data) {
                    if (data.code == 1) {
                        if (data[0]['num'] == 1) {
                            layer.msg(data.msg, {icon: 1});
                            setTimeout(function () {
                                window.location.href = "/admin/adminIndex";
                            }, 2000)
                        } else {
                            layer.msg("正在登录中...,请稍后!", {icon: 5});
                            return false;
                        }
                    } else {
                        layer.msg(data.msg, {icon: 2});
                        window.location.href = "/admin/login";
                    }
                }
            })
        });

        //点击回车事件请求ajax
        $(document).keyup(function (event) {
            var admin_name = $("#user_name").val();
            var admin_pwd = $("#admin_pwd").val();
            var captcha = $("#captcha").val();
            if (event.keyCode == 13) {
                click_num++;
                $.ajax({
                    url: "/admin/doLogin",
                    type: "get",
                    data: {admin_name: admin_name, admin_pwd: admin_pwd, captcha: captcha, click_num: click_num},
                    dataType: "json",
                    success: function (data) {
                        if (data.code == 1) {
                            if (data[0]['num'] == 1) {
                                layer.msg(data.msg, {icon: 1});
                                setTimeout(function () {
                                    window.location.href = "/admin/adminIndex";
                                }, 2000)
                            } else {
                                layer.msg("正在登录中...,请稍后!", {icon: 5});
                                return false;
                            }
                        } else {
                            layer.msg(data.msg, {icon: 2});
                            window.location.href = "/admin/login";
                        }
                    }
                })
            }
        });
    });
</script>
</body>
</html>
