<?php /*a:3:{s:73:"/www/wwwroot/101.200.121.249/carver_tp_blog/app/admin/view/site/site.html";i:1629026141;s:75:"/www/wwwroot/101.200.121.249/carver_tp_blog/app/admin/view/index/index.html";i:1629028550;s:70:"/www/wwwroot/101.200.121.249/carver_tp_blog/app/admin/view/header.html";i:1618120768;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="/static/admin/pace/themes/green/pace-theme-flash.css" type="text/css">
    <link rel="stylesheet" href="/static/admin/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="/static/admin/tag/modules/tag.css" media="all">
    <link rel="stylesheet" href="/static/web/bootstrap/css/bootstrap.css" media="all">
    <link href="/static/admin/people/css/public.css" rel="stylesheet" type="text/css">
    <link href="/static/admin/layui/input/inputTags.css" rel="stylesheet" type="text/css">
    <link href="/static/admin/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="/static/admin/css/bootstrap-select.css">
    <link rel="stylesheet" href="/static/admin/select_switch/css/bootstrap3/bootstrap-switch.min.css">
    <link rel="stylesheet" href="/static/admin/bootstrap_label/dist/jquery-tagsinput.min.css">
    <link rel="stylesheet" href="/static/admin/summernote/dist/summernote.css">
    <script type="text/javascript" src="/static/admin/layui/layui.js"></script>
    <script type="text/javascript" src="/static/admin/layui/input/inputTags.js"></script>
    <script type="text/javascript" src="/static/admin/dist/xm-select.js"></script>
    <script type="text/javascript" src="/static/admin/dist/InsertSelect.js"></script>
    <script type="text/javascript" src="/static/admin/people/js/jquery.min.js"></script>
    <script type="text/javascript" src="/static/admin/people/js/global.js"></script>
    <script type="text/javascript" src="/static/admin/dist/xm-select.js"></script>
    <script type="text/javascript" src="/static/admin/bootstrap-select/dist/js/bootstrap-select.js"></script>
    <script type="text/javascript" src="/static/web/bootstrap/js/bootstrap.js"></script>
    <script type="text/javascript" src="/static/admin/pace/pace.js"></script>
    <script type="text/javascript" src="/static/admin/js/echarts.min.js"></script>
    <script type="text/javascript" src="/static/admin/tag/modules/tag.js"></script>
    <script type="text/javascript" src="/static/admin/js/tabControl.js"></script>
    <script type="text/javascript" src="/static/admin/treeview/js/bootstrap-treeview.js"></script>
    <script type="text/javascript" src="/static/admin/js/bootstrap-select.js"></script>
    <script type="text/javascript" src="/static/admin/select_switch/js/bootstrap-switch.js"></script>
    <script type="text/javascript" src="/static/admin/bootstrap_label/dist/jquery-tagsinput.min.js"></script>
    <script type="text/javascript" src="/static/admin/pub/user.js"></script>
    <script type="text/javascript" src="/static/admin/summernote/dist/summernote.js"></script>
    <script type="text/javascript" src="/static/admin/summernote/dist/lang/summernote-zh-CN.js"></script>
                     
    <style>
        @font-face {
            font-family: 'iconfont';  /* project id 1984462 */
            src: url('//at.alicdn.com/t/font_1984462_cwry9xt7ef4.eot');
            src: url('//at.alicdn.com/t/font_1984462_cwry9xt7ef4.eot?#iefix') format('embedded-opentype'),
            url('//at.alicdn.com/t/font_1984462_cwry9xt7ef4.woff2') format('woff2'),
            url('//at.alicdn.com/t/font_1984462_cwry9xt7ef4.woff') format('woff'),
            url('//at.alicdn.com/t/font_1984462_cwry9xt7ef4.ttf') format('truetype'),
            url('//at.alicdn.com/t/font_1984462_cwry9xt7ef4.svg#iconfont') format('svg');
        }

        .iconfont {
            font-family: "iconfont" !important;
            font-size: 16px;
            font-style: normal;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        #main_body table {
            width: 430px;
            height: 200px;
        }

        #main_body {
            padding-left: 30px;
            padding-top: 40px;
            border: 0px;
        }

        #main_body table tr td {
            width: 80px;
            height: 30px;
            font-family: 华文楷体;
            font-size: 16px;
            font-weight: bolder;
        }

        #right_version table {
            width: 200px;
            height: 200px;
        }
        .bootstrap-switch-normal{
            margin-left: 12px;
        }

    </style>
</head>


<body class="layui-layout-body" style="font-family:华文中宋;margin-top: -15px">




<div class="layui-layout layui-layout-admin">
    <!--头部导航-->
    <div class="layui-header">
        <div class="layui-logo" style="color: white">Carver后台管理系统</div>
        <!-- 头部区域（可配合layui已有的水平导航） -->
        <ul class="layui-nav layui-layout-left">

            <li class="layui-nav-item"><a href="<?php echo url('index/adminIndex'); ?>"><i class="iconfont">&#xe61b;</i>首页</a>
            </li>

            <li class="layui-nav-item">
                <a href="javascript:void (0);"><i class="layui-icon layui-icon-group"></i>人员管理</a>
                <dl class="layui-nav-child"> <!-- 二级菜单 -->
                    <dd><a href="<?php echo url('admin/adminList'); ?>" style="text-decoration: none">用户列表</a></dd>
                    <dd><a href="<?php echo url('admin/roleList'); ?>" style="text-decoration: none">角色列表</a></dd>
                </dl>
            </li>

            <li class="layui-nav-item">
                <a href="javascript:void (0);"><i class="iconfont">&#xe707;</i>内容管理</a>
                <dl class="layui-nav-child"> <!-- 二级菜单 -->
                    <dd><a href="<?php echo url('article/articleList'); ?>" style="text-decoration: none">文章管理</a></dd>
                </dl>
            </li>

            <li class="layui-nav-item">
                <a href="javascript:void (0);"><i class="iconfont">&#xe618;</i>导航管理</a>
                <dl class="layui-nav-child"> <!-- 二级菜单 -->
                    <dd><a href="<?php echo url('navigate/carouseList'); ?>" style="text-decoration: none">前台轮播图管理</a></dd>
                    <dd><a href="<?php echo url('navigate/navigateList'); ?>" style="text-decoration: none">前台导航管理</a></dd>
                </dl>
            </li>


            <li class="layui-nav-item ">
                <a href="javascript:;" style="text-decoration: none"><i class="iconfont">&#xe6d7;</i>公告管理</a>
                <dl class="layui-nav-child">
                    <dd><a href="<?php echo url('Notice/noticeList'); ?>" style="text-decoration: none">公告列表</a></dd>
                </dl>
            </li>

            <li class="layui-nav-item">
                <a href="javascript:;" style="text-decoration: none"><i class="iconfont">&#xe693;</i>友情管理</a>
                <dl class="layui-nav-child">
                    <dd><a href="<?php echo url('link/linkList'); ?>" style="text-decoration: none">
                        友情列表</a></dd>
                </dl>
            </li>

            <li class="layui-nav-item">
                <a href="javascript:;" style="text-decoration: none"><i class="iconfont">&#xe6c6;</i>网站管理</a>
                <dl class="layui-nav-child">
                    <dd><a href="<?php echo url('Site/index'); ?>" style="text-decoration: none">网站配置</a>
                    </dd>
                </dl>
            </li>

            <li class="layui-nav-item">
                <a href="javascript:;" style="text-decoration: none"><i class="iconfont">&#xe640;</i>日志管理</a>
                <dl class="layui-nav-child">
                    <dd><a href="<?php echo url('log/logActIndex'); ?>" style="text-decoration: none">行为日志</a>
                    </dd>
                    <dd><a href="<?php echo url('log/logSysIndex'); ?>" style="text-decoration: none">系统日志</a>
                    </dd>
                </dl>
            </li>

        </ul>
        <ul class="layui-nav layui-layout-right">
            <li class="layui-nav-item"><a href="/web/LoginUser/userIndex">前台首页</a></li>
            <li class="layui-nav-item">
                <a href="javascript:void (0);">
                    <img src="<?php echo htmlentities(app('request')->session('admin_image')); ?>" class="layui-nav-img">
                    <?php echo htmlentities(app('request')->session('admin_name')); ?>
                </a>
                <dl class="layui-nav-child">
                    <dd><a href="<?php echo url('admin/updateAdmin',['admin_id'=>app('request')->session('admin_id')]); ?>"
                           up-id="<?php echo htmlentities(app('request')->session('admin_id')); ?>"><i class="iconfont"
                                                                  style="width: 30px">&#xe887;</i>&nbsp;&nbsp;编辑资料</a>
                    </dd>
                </dl>
            </li>
            <input type="hidden" value="<?php echo htmlentities(app('request')->session('login_num')); ?>" id="login_status">
            <li class="layui-nav-item" id="out_login"><a href="<?php echo url('index/outLogin'); ?>">退出登录</a></li>
        </ul>
    </div>


    <script>
        //导航必须引入的哟！！！
        layui.use('element', function () {
            var element = layui.element;
        });


        function setCookie(cname, cvalue, exdays) {
            var d = new Date();
            d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
            var expires = "expires=" + d.toGMTString();
            document.cookie = cname + "=" + cvalue + "; " + expires;
        }

        function getCookie(cname) {
            var name = cname + "=";
            var ca = document.cookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i].trim();
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        }

        function clearCookie(name) {
            setCookie(name, "", -1);
        }

    </script>

    <!--中间身体部分内容-->
    <div class="layui-body"
         style="background-image: url('/static/admin/img/index.jpg');background-repeat: no-repeat;background-position:
          center center; background-size: cover;height: 100%;width: 100%;margin-left: -199px">

        
<form class="form-horizontal" style="float: left;margin-left: 20%;margin-top:40px;width:400px;background: lightskyblue" id="site_info" data-id="<?php echo isset($siteInfo['site_id']) ? htmlentities($siteInfo['site_id']) : ''; ?>">
    <h3 style="margin-top: 40px;font-size: 18px;text-align: center">网站配置信息</h3>
    <div class="form-group" style="margin-top: 30px;margin-left: -258px">
        <label for="inputEmail3" class="col-sm-6 control-label">网站标题</label>
        <div class="col-sm-5">
            <input type="text" class="form-control" id="site_title" name="site_title" placeholder="请输入站点名"
                   value="<?php echo isset($siteInfo['site_title']) ? htmlentities($siteInfo['site_title']) : ''; ?>">
        </div>
    </div>
    <div class="form-group" style="margin-left: -258px">
        <label for="inputPassword3" class="col-sm-6 control-label">网站描述</label>
        <div class="col-sm-5">
            <input type="text" class="form-control" id="site_description" name="site_description" placeholder="请输入站点描述"
                   value="<?php echo isset($siteInfo['site_description']) ? htmlentities($siteInfo['site_description']) : ''; ?>">
        </div>
    </div>
    <div class="form-group" style="margin-left: -258px">
        <label for="inputPassword3" class="col-sm-6 control-label">网站图标</label>
        <div class="col-sm-5">
            <?php if(empty($siteInfo['site_image']) || (($siteInfo['site_image'] instanceof \think\Collection || $siteInfo['site_image'] instanceof \think\Paginator ) && $siteInfo['site_image']->isEmpty())): ?> <span id="fail_msg" style="color: red">暂时没有设置</span> <?php else: ?><img
                src="<?php echo isset($siteInfo['site_image']) ? htmlentities($siteInfo['site_image']) : ''; ?>" alt=""
                style="width: 50px;height: 40px" id="preview_img"><?php endif; ?>
            <br><br>
            <button type="button" class="layui-btn" id="upload_img">
                <i class="layui-icon">&#xe67c;</i><span>上传图片</span>
            </button>
            <input type="hidden" name="site_image" value="<?php echo isset($siteInfo['site_image']) ? htmlentities($siteInfo['site_image']) : ''; ?>" id="site_image">
        </div>
    </div>
    <div class="form-group" style="margin-left: -258px">
        <div class="col-sm-offset-7 col-sm-10">
            <button type="button" class="btn btn-default site_info">确认配置</button>
        </div>
    </div>
</form>

<form class="form-horizontal" style="float: left;margin-left: 200px;margin-top:40px;width:400px;background:lightgreen" id="blog_info" data-id="<?php echo isset($siteInfo['site_id']) ? htmlentities($siteInfo['site_id']) : ''; ?>">
    <h3 style="margin-top: 40px;font-size: 18px;text-align: center">博主个人资料</h3>
    <div class="form-group" style="margin-top: 30px;margin-left: -258px">
        <label for="inputEmail3" class="col-sm-6 control-label">博客名</label>
        <div class="col-sm-5">
            <input type="text" class="form-control" id="blog_name" name="blog_name" placeholder="请输入博客名"
                   value="<?php echo isset($siteInfo['blog_name']) ? htmlentities($siteInfo['blog_name']) : ''; ?>">
        </div>
    </div>
    <div class="form-group" style="margin-left: -258px">
        <label for="inputPassword3" class="col-sm-6 control-label">职业</label>
        <div class="col-sm-5">
            <input type="text" class="form-control" id="blog_work" name="blog_work" placeholder="请输入职业"
                   value="<?php echo isset($siteInfo['blog_work']) ? htmlentities($siteInfo['blog_work']) : ''; ?>">
        </div>
    </div>
    <div class="form-group" style="margin-left: -258px">
        <label for="inputPassword3" class="col-sm-6 control-label">现居</label>
        <div class="col-sm-5">
            <input type="text" class="form-control" id="blog_home" name="blog_home" placeholder="请输入现居地址"
                   value="<?php echo isset($siteInfo['blog_home']) ? htmlentities($siteInfo['blog_home']) : ''; ?>">
        </div>
    </div>
    <div class="form-group" style="margin-left: -258px">
        <label for="inputPassword3" class="col-sm-6 control-label">博客网址</label>
        <div class="col-sm-5">
            <input type="text" class="form-control" id="blog_site" name="blog_site" placeholder="请输入博客网址"
                   value="<?php echo isset($siteInfo['blog_site']) ? htmlentities($siteInfo['blog_site']) : ''; ?>">
        </div>
    </div>
    <div class="form-group" style="margin-left: -258px">
        <div class="col-sm-offset-7 col-sm-10">
            <button type="button" class="btn btn-default blog_info">确认提交</button>
        </div>
    </div>
</form>
<script src="/static/admin/site/site.js"></script>
<script>
    site.prototype.init();
</script>


    </div>
</div>
</body>
</html>
<script type="text/javascript">
    // 基于准备好的dom，初始化echarts实例
    var myChart = echarts.init(document.getElementById('main'));
    console.log(myChart)

    myChart.setOption({
        title: {
            text: '用户分布',
            x: 'center',
            subtext: '用户量',
            borderColor: '#ccc',
        },
        tooltip: {},
        series: [
            {
                name: '访问来源',
                type: 'pie',    // 设置图表类型为饼图
                radius: '55%',  // 饼图的半径，外半径为可视区尺寸（容器高宽中较小一项）的 55% 长度。
                data: [          // 数据数组，name 为数据项名称，value 为数据项值
                    {value: 235, name: '视频广告'},
                    {value: 274, name: '联盟广告'},
                    {value: 310, name: '好友推介'},
                    {value: 335, name: '直接访问'},
                    {value: 400, name: '搜索引擎'}
                ]
            }
        ],
        legend: {
            data: ['销量']
        },
        textStyle: { //主标题文本样式{"fontSize": 18,"fontWeight": "bolder","color": "#333"}
            fontFamily: '楷体',
            fontSize: 18,
            fontStyle: 'normal',
            fontWeight: 'normal',
        },
    })


    // 基于准备好的dom，初始化echarts实例
    var me = echarts.init(document.getElementById('years'));

    option = {
        tooltip: {
            trigger: 'axis',
            axisPointer: {
                type: 'cross',
                crossStyle: {
                    color: '#999'
                }
            }
        },
        toolbox: {
            feature: {
                dataView: {show: true, readOnly: false},
                magicType: {show: true, type: ['line', 'bar']},
                restore: {show: true},
                saveAsImage: {show: true}
            }
        },
        legend: {
            data: ['白天', '晚上']
        },
        xAxis: [
            {
                type: 'category',
                data: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'],
                axisPointer: {
                    type: 'shadow'
                }
            }
        ],
        yAxis: [
            {
                type: 'value',
                name: '访问量',
                min: 0,
                max: 90,
                interval: 50,
                axisLabel: {
                    formatter: '{value} 次'
                }
            },
            {
                type: 'value',
                name: '点击量',
                min: 0,
                max: 25,
                interval: 5,
                axisLabel: {
                    formatter: '{value} 次'
                }
            }
        ],
        series: [
            {
                name: '白天',
                type: 'bar',
                data: [2.0, 4.9, 7.0, 23.2, 25.6, 76.7, 135.6, 162.2, 32.6, 20.0, 6.4, 3.3]
            },
            {
                name: '晚上',
                type: 'bar',
                data: [2.6, 5.9, 9.0, 26.4, 28.7, 70.7, 175.6, 182.2, 48.7, 18.8, 6.0, 2.3]
            },
        ]
    };

    // 使用刚指定的配置项和数据显示图表。
    me.setOption(option);
    /**
     * @desc 修改用户
     * @author Carver
     * @date 2020-07-28
     */
    $(document).on("click", "#ups_data", function () {
        console.log(1111111111)
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
</script>
