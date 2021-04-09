var site = function () {
    site.prototype.init();
};
//初始化数据
site.prototype.init = function () {
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
                $("#upload_img").siblings("#site_image").val("/uploads/" + res.data);

                if ($("#upload_img").siblings("#preview_img").length) {//当前是否存在图片预览（修改页面）
                    $("#upload_img").siblings("#preview_img").attr("src", "/uploads/" + res.data);
                } else {//（添加页面）
                    var add_img = '<img src="/uploads/' + res.data + '" alt="" style="width: 50px;height: 40px;margin-right: 4px" id="preview_img">';
                    $("#upload_img").before(add_img);
                    $("#upload_img").siblings("#fail_msg").remove();
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

$(document).on("click", ".site_info", function () {
    var site_info = $("#site_info").serialize();
    var site_id = $("#site_info").attr("data-id");

    $.post("setSiteInfo", {info: site_info, setType: 'site_info', site_id: site_id}, function (data) {
        if (data.code == 1) {
            layer.msg(data.msg, {icon: 1, time: 2000}, function () {
                window.location.reload();
            })

        } else {
            layer.msg(data.msg, {icon: 2, time: 2000}, function () {
                window.location.reload();
            })
        }
    }, 'json')
})

$(document).on("click", ".blog_info", function () {
    var site_info = $("#blog_info").serialize();
    var site_id = $("#blog_info").attr("data-id");

    $.post("setSiteInfo", {info: site_info, setType: 'blog_info', site_id: site_id}, function (data) {
        if (data.code == 1) {
            layer.msg(data.msg, {icon: 1, time: 2000}, function () {
                window.location.reload();
            })
        } else {
            layer.msg(data.msg, {icon: 2, time: 2000}, function () {
                window.location.reload();
            })
        }
    }, 'json')
})
