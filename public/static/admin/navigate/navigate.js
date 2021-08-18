var navigates = function () {
    navigates.prototype.init();
};
//初始化数据
navigates.prototype.init = function () {
    layui.use('form', function () {
    })

    $("[name='is_show']").bootstrapSwitch({
        onText: "显示",      // 设置ON文本
        offText: "隐藏",    // 设置OFF文本
        onColor: "success",// 设置ON文本颜色(info/success/warning/danger/primary)
        offColor: "danger",  // 设置OFF文本颜色 (info/success/warning/danger/primary)
        size: "normal",    // 设置控件大小,从小到大  (mini/small/normal/large)
        handleWidth: "55",
        // 当开关状态改变时触发
        onSwitchChange: function (event, state) {
            if (state == true) {
                $(this).val(1);
            } else {
                $(this).val(0);
            }
        }
    });

    $(".is_show_list").bootstrapSwitch({
        onText: "显示",      // 设置ON文本
        offText: "隐藏",    // 设置OFF文本
        onColor: "success",// 设置ON文本颜色(info/success/warning/danger/primary)
        offColor: "danger",  // 设置OFF文本颜色 (info/success/warning/danger/primary)
        size: "normal",    // 设置控件大小,从小到大  (mini/small/normal/large)
        handleWidth: "55",
        // 当开关状态改变时触发
        onSwitchChange: function (event, state) {
            var id = $(this).attr("data-id");//修改的id
            var url = $(this).attr("data-url");//跳转地址
            var is_on = 1;
            if (state == true) {
                is_on = 1;
            } else {
                is_on = 0;
            }
            $.post(url, {id: id, is_on: is_on}, function (data) {
                if (is_on) {
                    var msg = '已显示';
                } else {
                    var msg = '已隐藏';
                }
                layer.msg(msg, {icon: -1, time: 1500}, function () {
                    var index = parent.layer.getFrameIndex(window.name); //获取当前窗口的name
                    parent.layer.close(index);
                    window.parent.location.reload();
                })
            }, 'json')

        }
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
                $("#upload_img").siblings("#carouse_img").val("/uploads/" + res.data);

                if ($("#upload_img").siblings("#preview_img").length) {//当前是否存在图片预览（添加页面）
                    $("#upload_img").siblings("#preview_img").attr("src", "/uploads/" + res.data);
                } else {//（修改页面）
                    var add_img = '<img src="/uploads/' + res.data + '" alt="" style="width: 50px;height: 40px;margin-right: 4px" id="preview_img">';
                    $("#upload_img").before(add_img);
                }

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


//添加导航
navigates.prototype.addNavigate = function (that) {
    layui.use(['layer', 'form'], function () {
        var layer = layui.layer;
        var form = layui.form;
        var url = that.getAttribute("data-url");
        layer.open({
            title: '添加导航',
            type: 2,
            area: ['35%', '45%'],
            content: url,
            success: function () {
                form.render("select");
            }
        });

    })
};


//点击切换隐藏显示
$(document).on("click", ".add_btn", function () {
    var btn_info = $(this).parent("td").parent("tr").attr("add-btn");
    var all_elemet = $(this).parent("td").parent("tr").siblings("tr");
    $(all_elemet).each(function (index, res) {
        if ($(res).attr("add-btn") == btn_info) {
            $($(res)).toggle();
        }
    })
    if ($(this).children("i").hasClass('layui-icon-right')) {
        $(this).children("i").removeClass("layui-icon-right")
        $(this).children("i").addClass("layui-icon-down")
    } else {
        $(this).children("i").removeClass("layui-icon-down")
        $(this).children("i").addClass("layui-icon-right")
    }


})

//处理添加导航（表单）
navigates.prototype.subNavigate = function (that) {
    layui.use('form', function () {
        var form = layui.form;
        //监听提交
        var navigate_name_parent = $("[name='navigate_name_parent']").val();//父级导航
        var navigate_name = $("[name='navigate_name']").val();//导航名
        var sort_info = $("[name='sort_info']").val();//排序
        var is_show = $("[name='is_show']").val();//是否显示

        $.ajax({
            type: "post",
            url: that.getAttribute("data-url"),
            data: {
                navigate_name_parent: navigate_name_parent,
                navigate_name: navigate_name,
                sort: sort_info,
                is_show: is_show
            },
            dataType: "json",
            success: function (data) {
                if (data.code == 1) {
                    layer.msg(data.msg, {icon: 1, time: 1500}, function () {
                        var index = parent.layer.getFrameIndex(window.name); //获取当前窗口的name
                        parent.layer.close(index);
                        window.parent.location.reload();
                    })
                } else {
                    layer.msg(data.msg, {icon: 2, time: 1500}, function () {
                        var index = parent.layer.getFrameIndex(window.name); //获取当前窗口的name
                        parent.layer.close(index);
                        window.parent.location.reload();
                    })
                }

            }
        })

        //监听指定开关
        form.on('switch(switchNavigate)', function (data) {
            var is_checked = this.checked;

            if (is_checked) {
                $("[name='is_show']").val(1);
                $(this).attr("checked", "checked")
            } else {
                $("[name='is_show']").val(0);
            }
        });
    });
}

//添加导航
navigates.prototype.addCarouse = function (that) {
    layui.use(['layer', 'form'], function () {
        var layer = layui.layer;
        var form = layui.form;
        var url = that.getAttribute("data-url");
        layer.open({
            title: '添加轮播图',
            type: 2,
            area: ['35%', '45%'],
            content: url,
            success: function () {
                form.render("select");
            }
        });

    })
};


//添加前台轮播图
navigates.prototype.subCarouse = function (that) {
    var add_url = that.getAttribute("data-url");
    var carouse_img = $("[name=carouse_img]").val();
    var carouse_desc = $("[name=carouse_desc]").val();
    var carouse_sort = $("[name=carouse_sort]").val();
    var addCarouseForm = $("#addCarouseForm").serialize();

    if (carouse_img == '') {
        layer.msg("请点击上传图片!");
        return false;
    }

    if (carouse_desc == '') {
        layer.msg("请输入图片描述!");
        return false;
    }

    if (carouse_sort == '') {
        layer.msg("请排序!");
        return false;
    }

    $.post(add_url, addCarouseForm, function (data) {
        if (data.code == 1) {
            layer.msg(data.msg, {time: 2000, icon: 1}, function () {
                var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                parent.layer.close(index); //再执行关闭
                window.parent.location.reload();
            })
        } else {
            layer.msg(data.msg, {time: 2000, icon: 2}, function () {
                var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                parent.layer.close(index); //再执行关闭
                window.parent.location.reload();
            })
        }

    }, 'json')
}


//编辑前台轮播图
navigates.prototype.deleteCarouse = function (that) {

    layui.use(['layedit', 'layer', 'upload'], function () {
        layer.confirm('亲，确定要删除么?', {icon: 3, title: '删除'}, function (index) {

            $.post(that.getAttribute("data-url"), {id: that.getAttribute("data-id")}, function (data) {
                if (data.code == 1) {
                    layer.msg(data.msg, {time: 2000, icon: 1}, function () {
                        var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                        parent.layer.close(index); //再执行关闭
                        window.parent.location.reload();
                    })
                } else {
                    layer.msg(data.msg, {time: 2000, icon: 2}, function () {
                        var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                        parent.layer.close(index); //再执行关闭
                        window.parent.location.reload();
                    })
                }

            }, 'json')

            layer.close(index);
        });

    })
};










