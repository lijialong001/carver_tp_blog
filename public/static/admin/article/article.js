var articles = function () {
    articles.prototype.init();
};
//初始化数据
articles.prototype.init = function () {
    window.addEventListener("load", function () {
        $(".albtn").remove()
    })
    layui.use('form', function () {
    })

    $("#article_guide").selectpicker({
        width: 160,
        liveSearch: true,
        liveSearchPlaceholder: "请输入导航名",
        noneResultsText: "匹配不到导航",
    });

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

    $("[name='is_top_show']").bootstrapSwitch({
        onText: "置顶",      // 设置ON文本
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
                $("#upload_img").siblings("#article_img").val("/uploads/" + res.data);

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


    //点击量的相加
    $("#click_num").click(function () {
        var click_num = $("[name='click_num']").val();
        if (parseInt(click_num) >= 999999) {
            layer.msg("不能大于六位位数字哦~");
            return false;
        }
        var nums = parseInt(click_num) + 1;
        $("[name='click_num']").val(nums);

    })

    $('.summernote').summernote({
        height: 200,
        tabsize: 2,
        lang: 'zh-CN'
    });
}

//添加文章(提交表单数据)
$(document).on("click", "#sub_article", function () {
    layui.use(['layedit', 'layer', 'jquery'], function () {
        var content = $('.summernote').summernote('code');
        var article_guide = $("[name='article_guide']").val();//文章导航
        var article_title = $("[name='article_title']").val();//文章标题
        var article_label = $("[name='article_label']").val();//文章标签
        var article_desc = $("[name='article_desc']").val();//文章简介
        var is_show_up = $("[name='is_show']").val();//是否显示
        var is_top_show = $("[name='is_top_show']").val();//是否置顶显示
        var article_img = $("[name='article_img']").val();//文章封面
        var up_click_need = $("[name='click_num']").val();//点击量

        if (article_title == '') {
            layer.alert("文章标题不能为空~", {title: '文章出错啦~', icon: 5});
            return false;
        }
        if (article_label == '') {
            layer.alert("文章标签不能为空~", {title: '文章出错啦~', icon: 5});
            return false;
        }
        if (article_desc == '') {
            layer.alert("文章简介不能为空~", {title: '文章出错啦~', icon: 5});
            return false;
        }
        if (article_img == '') {
            let arr_img=[];
            let reg = new RegExp('<img.*?src=[\'"](.+?)["\'].*?>', 'g')
            while (reg.exec(content)) {
                arr_img.push(RegExp.$1);
            }  
            article_img=arr_img[0]?arr_img[0]:"http://www.lijialong.site/uploads/20220610/2016684db04899b71b7cc7ee1a753f40.jpeg";
            
        }
        
        if (content == '') {
            layer.alert("文章内容不能为空~", {title: '文章出错啦~', icon: 5});
            return false;
        }
        
    
        $.ajax({
            type: "POST",
            url: "/admin/article/doAddArticle",
            data: {
                article_content: content,
                article_guide: article_guide,
                article_title: article_title,
                article_label: article_label,
                article_desc: article_desc,
                is_show: is_show_up,
                is_top_show: is_top_show,
                article_img: article_img,
                click_num: up_click_need,
            },
            dataType: "json",
            success: function (data) {
                layer.msg(data.msg, {time: 1500}, function () {
                    var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                    parent.layer.close(index); //再执行关闭
                    window.parent.location.reload();
                });

            }
        });

    })
})


//添加文章
articles.prototype.addArticle = function (that) {
    layui.use(['form', 'layer', 'element', 'jquery', 'layedit', 'inputTags', 'upload'], function () {
        var layer = layui.layer;
        var $ = layui.jquery;
        var layedit = layui.layedit;
        var form = layui.form;
        var inputTags = layui.inputTags;
        var upload = layui.upload;
        var add_url = that.getAttribute("data-url");

        layer.open({
            type: 2,
            skin: 'layui-layer-demo',
            title: "添加文章",
            closeBtn: 2,
            shift: 5,
            area: ['1000px', '600px'],
            shadeClose: true,
            shade: 0.5,
            content: add_url,
            success: function () {
                console.log("正在弹窗...")
            }
        });

    })
}




//修改文章(表单信息)
$(document).on("click", "#sub_up_article", function () {
    var article_id = $("[name='article_id']").val();//文章id
    var article_guide = $("[name='article_guide']").val();//文章导航
    var article_title = $("[name='article_title']").val();//文章标题
    var article_label = $("[name='article_label']").val();//文章标签
    var article_desc = $("[name='article_desc']").val();//文章简介
    var is_show_up = $("[name='is_show']").val();//是否显示
    var is_top_show = $("[name='is_top_show']").val();//是否置顶显示
    var article_img = $("[name='article_img']").val();//文章封面
    var up_click_need = $("[name='click_num']").val();//点击量
    var article_content = $('.summernote').summernote('code');//文章内容
    var article_pre_img = $("#upload_img").siblings("#preview_img").attr("src");//原图


    if (article_title == '') {
        layer.alert("文章标题不能为空~", {title: '文章出错啦~', icon: 5});
        return false;
    }
    if (article_label == '') {
        layer.alert("文章标签不能为空~", {title: '文章出错啦~', icon: 5});
        return false;
    }
    if (article_desc == '') {
        layer.alert("文章简介不能为空~", {title: '文章出错啦~', icon: 5});
        return false;
    }
    if (article_pre_img == '') {
        layer.alert("文章封面不能为空~", {title: '文章出错啦~', icon: 5});
        return false;
    }
    if (article_content == '') {
        layer.alert("文章内容不能为空~", {title: '文章出错啦~', icon: 5});
        return false;
    }

    $.ajax({
        type: "POST",
        url: "/admin/article/doEditArticle",
        data: {
            article_id: article_id,
            article_content: article_content,
            article_guide: article_guide,
            article_title: article_title,
            article_label: article_label,
            article_desc: article_desc,
            is_show: is_show_up,
            is_top_show: is_top_show,
            article_img: article_pre_img,
            click_num: up_click_need,
        },
        dataType: "json",
        success: function (data) {
            layer.msg(data.msg, {icon: 1, time: 2000}, function () {
                window.location.href = 'articleList';
            })

        }
    });
})

//删除文章
articles.prototype.delArticle = function (that) {
    var article_id = that.getAttribute("article-id");

    layer.confirm('确认删除吗？', {
        title: '删除',
        btn: ['确认', '取消', '再想一想'], //可以无限个按钮
        btn3: function (index, layero) {
            layer.close(index)
        }
    }, function (index, layero) {
        //确认按钮
        $.ajax({
            type: "get",
            url: "/admin/article/delArticle",
            data: {
                article_id: article_id
            },
            dataType: "json",
            success: function (data) {
                if (data.code == 1) {
                    layer.msg(data.msg, {icon: 1, time: 2000}, function () {
                        window.location.reload();
                    })
                } else {
                    layer.msg(data.msg, {icon: 0, time: 2000}, function () {
                        window.location.reload();
                    })
                }


            }
        });
    }, function (index) {//取消按钮
        layer.close(index)
    });

}








