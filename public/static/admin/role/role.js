var role = function () {
    role.prototype.init();
};
//初始化数据
role.prototype.init = function () {
    // 将所有.ui-choose实例化
    $('.ui-choose').ui_choose();
    var auth_info_obj = JSON.parse($("#auth_info").val());

    var tempArr = new Array();
    $.each(auth_info_obj, function (k, v) {
        tempArr.push(v);
    });


    $(".choose-type-right").children("li").each(function (i, item) {
        var isCheck = item.getAttribute("class");
        var isValue = item.getAttribute("data-value");

        if ($.inArray(parseInt(isValue), tempArr) >= 0) {

            item.classList.add("selected");
        } else {
            item.classList.remove("selected");
        }
    })


    layui.use(['tree', 'util'], function () {
        var tree = layui.tree, layer = layui.layer
        var all_auth = JSON.parse($("#all_auth").val());
        var selected_auth = JSON.parse($("#selected_auth").val());

        var current_id = [];

        //开启复选框
        tree.render({
            elem: '#select_auth'
            , data: all_auth
            , showCheckbox: true
            , id: 'demoId'
            , oncheck: function (obj) {
                if (obj.checked == true) {
                    current_id.push(obj.data.id);
                    $("#admin_auth").val(current_id);
                } else {
                    for (var i = 0; i < current_id.length; i++) {
                        if (current_id[i] == obj.data.id) {
                            current_id.splice(i, 1);
                            $("#admin_auth").val(current_id);
                        }
                    }
                }

            }
        });
        tree.setChecked('demoId', selected_auth); //勾选指定节点
    });

};

//添加角色
role.prototype.addRole = function (that) {
    layui.use(['layer'], function () {
        var layer = layui.layer;
        var url = that.getAttribute("data-url");
        layer.open({
            title: '添加权限',
            type: 2,
            area: ['40%', '36%'],
            maxmin: true,
            content: url,
            success: function () {

            }
        });
    })
}

//提交添加角色的表单
role.prototype.subRole = function (that) {
    var auth_info = $("#sub_auth").serialize();
    var url = that.getAttribute("data-url");
    $.post(url, auth_info, function (data) {
        if (data.code == 1) {
            layer.msg(data.msg, {icon: 1, time: 2000}, function () {
                var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                parent.layer.close(index); //再执行关闭
                window.parent.location.reload();
            })
        } else {
            layer.msg(data.msg, {icon: 2, time: 2000}, function () {
                var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                parent.layer.close(index); //再执行关闭
                window.parent.location.reload();
            })
        }
    }, 'json')
}

role.prototype.delUpRoleAuth = function (that) {
    var delUrl = that.getAttribute("data-url");
    var role_id = that.getAttribute("role-id");
    $.get(delUrl, {role_id: role_id}, function (data) {
        if (data.code == 1) {
            layer.msg(data.msg, {icon: 1, time: 2000}, function () {
                window.parent.location.reload();
            })
        } else {
            layer.msg(data.msg, {icon: 2, time: 2000}, function () {
                window.parent.location.reload();
            })
        }
    }, 'json')
}


//清除角色权限
role.prototype.removeRoleAuth = function (that) {
    var removeUrl = that.getAttribute("data-url");
    var role_id = that.getAttribute("role-id");
    $.get(removeUrl, {role_id: role_id}, function (data) {
        if (data.code == 1) {
            layer.msg(data.msg, {icon: 1, time: 2000}, function () {
                var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                parent.layer.close(index); //再执行关闭
                window.parent.location.reload();
            })
        } else {
            layer.msg(data.msg, {icon: 2, time: 2000}, function () {
                var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                parent.layer.close(index); //再执行关闭
                window.parent.location.reload();
            })
        }
    }, 'json')
}

//修改用户权限
role.prototype.upRoleAuth = function (that) {
    var form_info = $("#upRoleAuth").serialize();
    var temp = [];
    var auth_park = [];
    $(".choose-type-right").children("li").each(function (i, item) {
        var isCheck = item.getAttribute("class");
        if (isCheck == 'selected') {
            temp.push(item.getAttribute("data-value"));
            var isPark = $(item.parentNode.parentNode.parentNode).children("b").children("span").attr("data-auth");
            auth_park.push(isPark);

        }
    })
    //子集分类
    var jsonData = JSON.stringify(temp);
    //权限分类
    var park_info = Array.from(new Set(auth_park));
    console.log(park_info)

    form_info = form_info + "&auth=" + jsonData + "&auth_title=" + park_info;


    var upUrl = that.getAttribute("data-url");


    $.post(upUrl, form_info, function (data) {
        if (data.code == 1) {
            layer.msg(data.msg, {icon: 1, time: 2000}, function () {
                window.location.href = "roleList";
            })
        } else {
            layer.msg(data.msg, {icon: 2, time: 2000}, function () {
                window.location.href = "roleList";
            })
        }
    }, 'json')
}









