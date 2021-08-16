var user = function () {

};
//初始化数据
user.prototype.init = function () {
    layui.use('form', function () {
    })

    $("#getAuth").selectpicker({
        width: 160,
        liveSearch: true,
        liveSearchPlaceholder: "请输入特权",
        noneResultsText: "匹配不到特权",
    });

    layui.use(['layedit', 'layer', 'upload'], function () {
        var layedit = layui.layedit;
        var upload = layui.upload;
        //文件上传
        upload.render({
            elem: '#upload_img' //绑定元素
            , url: "/admin/admin/uploadInfo"
            , accept: 'file'
            , done: function (res) {
                layer.close(index);
                $("#upload_img").find("i").html("&#xe605;");
                $("#upload_img").find("span").html(res.msg);
                $("#upload_img").siblings("#admin_img").val(res.data);
                $("#upload_img").siblings("#preview_img").attr("src","/uploads/"+res.data);
            }
            , error: function (req) {
                layer.msg("上传接口出错啦~");
            }
            , before: function () {
                index = layer.load(1);
            }
        });
    })
};

/**
 * @desc 添加用户
 * @author Carver
 * @date 2020-07-28
 */
user.prototype.addAdmin = function (that) {
    layui.use(['layer', 'form', 'upload', 'element'], function () {
        var layer = layui.layer;
        var form = layui.form;
        var upload = layui.upload, $ = layui.jquery;
        var add_url = that.getAttribute("data-url");

        //页面层
        layer.open({
            type: 2,
            skin: 'layui-layer-demo',
            title: "添加用户",
            closeBtn: 2,
            shift: 8,
            area: ['500px', '520px'],
            shadeClose: true,
            shade: 0.5,
            content: add_url, //调到新增页面
            success: function () {
                console.log("add User ~")
            }
        });

    })
}

//添加用户
$(document).on("click", "#sub_admin", function () {
    var admin_name = $("[name='admin_name']").val();//用户名
    var admin_img = $("[name='admin_img']").val();//用户头像
    var auth = $("[name='auth']").val();//用户身份
    var password = $("[name='password']").val();//用户密码
    var password_confirm = $("[name='password_confirm']").val();//用户确认密码
    var email = $("[name='email']").val();//用户邮箱

    if (admin_name == '') {
        layer.alert("用户名不能为空~", {title: '添加用户出错啦~', icon: 5});
        return false;
    }
    if (admin_img == '') {
        layer.alert("用户头像不能为空~", {title: '添加用户出错啦~', icon: 5});
        return false;
    }
    if (password == '') {
        layer.alert("用户密码不能为空~", {title: '添加用户出错啦~', icon: 5});
        return false;
    }
    if (password_confirm == '') {
        layer.alert("用户确认密码不能为空~", {title: '添加用户出错啦~', icon: 5});
        return false;
    }
    if (password != password_confirm) {
        layer.alert("两次密码不一致，请重新输入~", {title: '添加用户出错啦~', icon: 5});
        return false;
    }
    if (email == '') {
        layer.alert("用户邮箱不能为空~", {title: '添加用户出错啦~', icon: 5});
        return false;
    }
    var reg = new RegExp("^[a-z0-9]+([._\\-]*[a-z0-9])*@([a-z0-9]+[-a-z0-9]*[a-z0-9]+.){1,63}[a-z0-9]+$"); //邮箱正则
    if (!reg.test(email)) {
        layer.alert("用户邮箱格式不正确~", {title: '添加用户出错啦~', icon: 5});
        return false;
    }
    $.ajax({
        type: "POST",
        url: "/admin/admin/doAddAdmin",
        data: {admin_name: admin_name, admin_pwd: password, admin_img: admin_img, admin_email: email, auth: auth},
        dataType: "json",
        success: function (data) {
            layer.msg(data.msg, {icon: 1, time: 1500}, function () {
                var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                parent.layer.close(index); //再执行关闭
                window.parent.location.reload();
            });

        }
    });
})


/**
 * @desc 修改用户
 * @author Carver
 * @date 2020-07-28
 */
$(document).on("click", "#up_admin", function () {
    var admin_id = $(this).attr("data-id");
    var admin_info=$("#form_admin_up").serialize();

    layui.use(['layer', 'form', 'upload'], function () {
        var layer = layui.layer;
        var form = layui.form;
        $.ajax({
            url: "doUpdateAdmin",
            type: "post",
            data: {admin_info: admin_info},
            dataType: "json",
            success: function (data) {
                if (data.code == 1) {
                    layer.msg(data.msg, {icon: 1, time: 1500}, function () {
                        window.location.href='adminList';
                    });
                } else if(data.code == 2){
                    layer.msg(data.msg, {icon: 2, time: 1500}, function () {
                        window.location.href='login';
                    });
                }else{
                    layer.msg(data.msg, {icon: 2, time: 1500}, function () {
                        window.location.reload();
                    });
                }
            }
        })

    })
})


//删除用户
user.prototype.delAdmin = function (that) {

    var del_url = that.getAttribute("data-url");
    var del_id = that.getAttribute("data-id");
    $.ajax({
        type: "get",
        url: del_url,
        data: {admin_id: del_id},
        dataType: "json",
        success: function (data) {
            if (data.code == 1) {
                layer.msg(data.msg, {icon: 1, time: 1500}, function () {
                    window.location.reload();
                });
            } else {
                layer.msg(data.msg, {icon: 2, time: 1500}, function () {
                    window.location.reload();
                });
            }

        }
    });
}







