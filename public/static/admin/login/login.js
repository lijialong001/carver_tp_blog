$(function () {
    var num=  $("#login_num").val();
      if(num>=3){
            $(".form").css("height","520px");
      }
});
//ajax请求点击按钮
layui.use('layer', function(){
    var layer = layui.layer;
    $("#btn").click(function () {
        var login_num=  $("#login_num").val();
        var admin_name=$("#user_name").val();
        var admin_pwd=$("#admin_pwd").val();
        var captcha=$("#captcha").val();
        if(admin_name==''){
            layer.msg("用户名不能为空~");
            return false;
        }
        if(admin_pwd==''){
            layer.msg("密码不能为空~");
            return false;
        }
        if(login_num>=3){
            if(captcha==''){
                layer.msg("验证码不能为空~");
                return false;
            }
        }
        $.ajax({
            url:"http://www.me.com/admin/doLogin",
            type:"get",
            data:{admin_name:admin_name,admin_pwd:admin_pwd,captcha:captcha},
            dataType:"json",
            beforeSend:function(){
                layer.msg("登录中...",{icon:16,time:6000});
            },
            success:function (data) {
                if(data.code==1){
                    layer.msg("登录成功",{icon:1,time:1500},function () {
                        window.location.href="http://www.me.com/admin/adminIndex";
                    });
                }else{
                    layer.msg(data.msg);
                    window.location.href="http://www.me.com/admin/login";
                }
            }
        })
    });
});
//点击回车事件请求ajax
layui.use('layer', function(){
    var layer = layui.layer;
    $(document).keyup(function(event){
        if(event.keyCode==13){
            var login_num=  $("#login_num").val();
            var admin_name=$("#user_name").val();
            var admin_pwd=$("#admin_pwd").val();
            var captcha=$("#captcha").val();
            if(admin_name==''){
                layer.msg("用户名不能为空~");
                return false;
            }
            if(admin_pwd==''){
                layer.msg("密码不能为空~");
                return false;
            }
            if(login_num>=3){
                if(captcha==''){
                    layer.msg("验证码不能为空~");
                    return false;
                }
            }
            var index=layer.load(2, {time: 10*1000});
            $.ajax({
                url:"http://www.me.com/admin/doLogin",
                type:"get",
                data:{admin_name:admin_name,admin_pwd:admin_pwd,captcha:captcha},
                dataType:"json",
                success:function (data) {
                    layer.close(index);
                    if(data.code==1){
                        layer.msg("登录成功",{icon:1,time:1500},function () {
                            window.location.href="http://www.me.com/admin/adminIndex";
                        });

                    }else{
                        layer.msg(data.msg);
                        window.location.href="http://www.me.com/admin/login";
                    }
                }
            })
        }
    });
});
