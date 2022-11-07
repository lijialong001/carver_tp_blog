$(document).ready(function() {
    
    
    //限制字符个数
        $(".desc_info").each(function () {
            let maxwidth = 100;
            if ($(this).text().length > maxwidth) {
                $(this).text($(this).text().substring(0, maxwidth));
                $(this).html($(this).html() + '…');
            }
        });
        
        
        $(".article_title").each(function(){
            let maxwidth = 22;
            if ($(this).text().length > maxwidth) {
                $(this).text($(this).text().substring(0, maxwidth));
                $(this).html($(this).html() + '…');
            }
        })
    
    
    
    //nav     
    var obj = null;
    var As = document.getElementById('starlist').getElementsByTagName('a');
    obj = As[0];
    for (i = 1; i < As.length; i++) {
        if (window.location.href.indexOf(As[i].href) >= 0) obj = As[i];
    }
    obj.id = 'selected';
    //nav
    $("#mnavh").click(function() {
        $("#starlist").toggle();
        $("#mnavh").toggleClass("open");
    });
    //search  
    $(".searchico").click(function() {
        $(".search").toggleClass("open");
    });
    //searchclose 
    $(".searchclose").click(function() {
        $(".search").removeClass("open");
    });
    //banner
    $('#banner').easyFader();
    //nav menu   
    $(".menu").click(function(event) {
        $(this).children('.sub').slideToggle();
    });
    //tab
    $('.tab_buttons li').click(function() {
        $(this).addClass('newscurrent').siblings().removeClass('newscurrent');
        $('.newstab>div:eq(' + $(this).index() + ')').show().siblings().hide();
    });
    
    
    /**
     * @desc 修改用户
     * @author Carver
     * @date 2020-07-28
     */
    $(document).on("click", "#ups_data", function () {
        var up_id = $(this).attr("up_id");
        layui.use(['layer', 'form', 'upload'], function () {
            var layer = layui.layer;
            var form = layui.form;
            var upload = layui.upload, $ = layui.jquery;
            layer.open({
                type: 1,
                skin: 'layui-layer-demo',
                title: "修改用户",
                closeBtn: 2,
                shift: 6,
                area: ['500px', '500px'],
                shadeClose: true,
                shade: 0.5,
                content: $("#up_form"),
                success: function () {
                    $("#up_form").show();
                    $.ajax({
                        url: "/admin/updateAdmin",
                        type: "post",
                        data: {id: up_id},
                        dataType: "json",
                        success: function (data) {
                            if (data.code == 1) {
                                $('[name=user_name]').val(data.data.admin_name)
                                $('[name=user_email]').val(data.data.admin_email)
                                $('[name=user_pwd]').val(data.data.admin_pwd)
                                $('[name=user_repwd]').val(data.data.admin_pwd)
                                $('[name=user_auth]').val(data.data.role_id).addClass("layui-this").attr("selected", true);
                                $('[name=user_id]').val(up_id);
                            }
                        }
                    })
                }

            });

            //表单提交
            form.on('submit(carvers)', function (data) {
                var user_pwd = data.field['user_pwd'];
                var user_repwd = data.field['user_repwd'];
                if (user_pwd != user_repwd) {
                    layer.msg("两次密码不一致~");
                    return false;
                }
                $.ajax({
                    type: "POST",
                    url: "/admin/doUpdateAdmin",
                    data: data.field,
                    dataType: "json",
                    success: function (data) {
                        layer.msg(data.msg);
                        window.location.href = "/admin/adminList";
                    }
                });
                return false;
            });


            //文件上传
            upload.render({
                elem: '#up_img_upload' //绑定元素
                , url: "/admin/admin/uploadInfo"
                , accept: 'images'
                , done: function (res) {
                    console.log(res)
                    layer.close(index);
                    //上传完毕回调
                    if (res.code == 1) {
                        $('input[name="user_image"]').val(res.data);
                        $('#up_img_upload i').html("&#xe605;<span style='font-family: 华文楷体'>上传成功</span>");
                    }
                }
                , error: function () {
                    //请求异常回调
                    layer.msg("您上传的接口出错啦~");
                }
                , before: function () {
                    index = layer.load(1);
                }
            });
        })
    })
    
    
});