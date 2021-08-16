<?php /*a:2:{s:83:"/www/wwwroot/101.200.121.249/carver_tp_blog/app/web/view/article/articleDetail.html";i:1618120768;s:82:"/www/wwwroot/101.200.121.249/carver_tp_blog/app/web/view/article/articleIndex.html";i:1628956606;}*/ ?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Carver</title>
    <link rel="stylesheet" href="/static/admin/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="/static/web/bootstrap/css/bootstrap.css" media="all">
    <link href="/static/admin/headdata/css/base.css" rel="stylesheet">
    <link href="/static/admin/headdata/css/m.css" rel="stylesheet">
    <script src="/static/admin/headdata/js/jquery-1.8.3.min.js"></script>
    <script src="/static/admin/headdata/js/comm.js"></script>
    <script type="text/javascript" src="/static/admin/layui/layui.js"></script>
    <script type="text/javascript" src="/static/web/bootstrap/js/bootstrap.js"></script>
    <!--[if lt IE 9]>
    <script src="/static/admin/headdata/js/modernizr.js"></script>
    <![endif]-->
</head>
<body>

<!--top begin-->

<header id="header">
    <div class="navbox">
        <h2 id="mnavh"><span class="navicon"></span></h2>
        <div class="logo"><a href="javascript:void(0)" style="font-family: 华文宋体;text-decoration: none">Carver 博客</a>
        </div>
        <nav>
            <ul id="starlist">
                <li><a href="<?php echo url('LoginUser/userIndex'); ?>">首页</a></li>
                <?php if(empty($navigate) || (($navigate instanceof \think\Collection || $navigate instanceof \think\Paginator ) && $navigate->isEmpty())): else: foreach($navigate as $key => $value): if(empty($value['son']) || (($value['son'] instanceof \think\Collection || $value['son'] instanceof \think\Paginator ) && $value['son']->isEmpty())): ?>
                <li><a href="<?php echo url('LoginUser/userIndex'); ?>"><?php echo htmlentities($value['nav_name']); ?></a></li>
                <?php else: ?>
                <li class="menu"><a href="javascript:void (0)"><?php echo htmlentities($value['nav_name']); ?></a>
                    <ul class="sub">
                        <?php foreach($value['son'] as $k => $v): ?>
                        <li>
                            <?php if(count($value['son']) > 1): ?>
                            <a href="<?php echo url('ArticleUser/searchLabel'); ?>?nav_id=<?php echo htmlentities($v['nav_id']); ?>">&nbsp;&nbsp;&nbsp;<?php echo htmlentities($v['nav_name']); ?></a>
                            <?php else: ?>
                            <a href="<?php echo url('ArticleUser/searchLabel'); ?>?nav_id=<?php echo htmlentities($v['nav_id']); ?>"><?php echo htmlentities($v['nav_name']); ?></a>
                            <?php endif; ?>

                        </li>
                        <?php endforeach; ?>
                    </ul>
                </li>
                <?php endif; ?>
                <?php endforeach; ?>
                <?php endif; ?>

            </ul>
        </nav>
        <div class="searchico"></div>
        <div style="float: right;padding-top: 6px;margin-right: 107px">
            <button class="btn btn-primary btn-sm" id="please_login">
                <?php if(empty(app('request')->session('user_name')) || ((app('request')->session('user_name') instanceof \think\Collection || app('request')->session('user_name') instanceof \think\Paginator ) && app('request')->session('user_name')->isEmpty())): ?>
                <a href="<?php echo url('LoginUser/index'); ?>" style="color: white">登录</a>
                <?php else: ?>
                <?php echo htmlentities(app('request')->session('user_name')); ?>
                <?php endif; ?>
            </button>
            <?php if(empty(app('request')->session('user_name')) || ((app('request')->session('user_name') instanceof \think\Collection || app('request')->session('user_name') instanceof \think\Paginator ) && app('request')->session('user_name')->isEmpty())): ?>
            <button class="btn btn-primary btn-sm" id="please_register">
                <a href="<?php echo url('LoginUser/index'); ?>" style="color: white">注册</a>
            </button>
            <?php else: ?>
            <a href="<?php echo url('LoginUser/outLogin'); ?>" class="btn btn-primary btn-sm" id="out_login">
                <span class="glyphicon glyphicon-log-out"></span>&nbsp;退出
            </a>
            <?php endif; ?>
        </div>

    </div>

</header>


<div class="searchbox">
    <div class="search">
        <form action="<?php echo url('ArticleUser/searchArticle'); ?>" method="get" name="searchform" id="searchform">
            <input name="article_title" id="keyboard" class="input_text" value="请输入关键字词"
                   style="color: rgb(153, 153, 153);"
                   onFocus="if(value=='请输入关键字词'){this.style.color='#000';value=''}"
                   onBlur="if(value==''){this.style.color='#999';value='请输入关键字词'}" type="text">
            <input name="Submit" class="input_submit" value="搜索" type="submit">
        </form>
    </div>
    <div class="searchclose"></div>
</div>

<!--top end-->
<article>
    <!--lbox begin-->
    
    <!--lbox begin-->
    <div class="lbox">
        <div class="content_box whitebg">
            <h1 class="con_tilte"><?php echo htmlentities($article_info['article_title']); ?></h1>
            <p class="con_info"><b><span style="font-size: 20px">简介:</span> <span><?php echo htmlentities($article_info['article_desc']); ?></span></b></p>
            <div class="con_text">
                <?php echo $article_info['article_content']; ?>
                <p class="share"><b>转载：</b>感谢您对Carver个人博客网站平台的认可，但转载请说明文章出处“来源Carver个人博客”
                </p>
                <p><span class="diggit"><a href="javascript:void(0)" class="click_prize"
                                           click-text="<?php echo htmlentities($article_info['article_id']); ?>"><span
                        class="glyphicon glyphicon-thumbs-up"></span></a>&nbsp;&nbsp;( <span class="click_num"><?php echo htmlentities($article_info['click_num']); ?></span> )</span>
                </p>
                <div class="nextinfo">
                    <p>上一篇：<a href="javascript:void (0)"><?php echo htmlentities($pre_article); ?></a></p>
                    <p>下一篇：<a href="javascript:void (0)"><?php echo htmlentities($next_article); ?></a></p>
                </div>
            </div>
        </div>
        <div class="whitebg gbook" art_id="<?php echo htmlentities($article_info['article_id']); ?>" id="article_info">
            <textarea name="publish_content" required lay-verify="required" placeholder="请先登录后发布评论..."
                      class="layui-textarea"></textarea>
            <button class="layui-btn layui-btn-radius layui-btn-normal" style="float: right;margin-top: 5px"
                    id="publish_btn">发布
            </button>
            <h2 class="htitle" style="margin-top: 30px">文章评论</h2>
            <input type="hidden" value="<?php echo htmlentities(app('request')->session('user_name')); ?>" class="is_login">
            <ul class="comment_list">
                <?php if(empty($comments) || (($comments instanceof \think\Collection || $comments instanceof \think\Paginator ) && $comments->isEmpty())): ?>
                暂时没有更多评论...
                <?php else: foreach($comments as $key => $value): ?>
                <li>
                <li class="layui-timeline-item per_comment">
                    <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
                    <div class="layui-timeline-content layui-text">
                        <h3 class="layui-timeline-title"><b><?php echo htmlentities($value['user_name']); ?></b>&nbsp;<a href="javascript:void(0)"
                                                                                           class="tip_people"
                                                                                           user-info="<?php echo htmlentities($value['user_id']); ?>"
                                                                                           style="color: steelblue"
                                                                                           comment-id="<?php echo htmlentities($value['comment_id']); ?>">回复</a>
                        </h3>
                        <p>
                            <?php echo htmlentities($value['comment_content']); ?> <span style="float: right"><b><?php echo htmlentities(date("Y-m-d H:i",!is_numeric($value['create_time'])? strtotime($value['create_time']) : $value['create_time'])); ?></b></span>
                        </p>
                        <textarea placeholder="请先登录后回复评论..." rows="3" cols="30" class="comment_click"
                                  style="display: none"></textarea>
                        <button class="layui-btn layui-btn-radius layui-btn-primary" id="publish" style="display: none">
                            点击回复
                        </button>
                    </div>
                </li>

                <br>
                <?php if(empty($value['son']) || (($value['son'] instanceof \think\Collection || $value['son'] instanceof \think\Paginator ) && $value['son']->isEmpty())): ?>
                <!--一级评论-->
                <?php foreach($value['son'] as $ks => $vs): ?>

                <li class="per_comment">
                    <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
                    <div class="layui-timeline-content layui-text">
                        <h3 class="layui-timeline-title"><b><?php echo htmlentities($value['user_name']); ?></b>&nbsp;<a href="javascript:void(0)"
                                                                                           class="tip_people"
                                                                                           user-info="<?php echo htmlentities($value['user_id']); ?>"
                                                                                           style="color: steelblue"
                                                                                           comment-id="<?php echo htmlentities($value['comment_id']); ?>">回复</a>
                        </h3>
                        <p>
                            <?php echo htmlentities($vs['comment_to_content']); ?><span
                                style="float: right"><b><?php echo htmlentities(date("Y-m-d H:i",!is_numeric($vs['create_time'])? strtotime($vs['create_time']) : $vs['create_time'])); ?></b></span>
                        </p>
                        <textarea placeholder="请先登录后回复评论..." rows="3" cols="30" class="comment_click"
                                  style="display: none"></textarea>
                        <button class="layui-btn layui-btn-radius layui-btn-primary" id="publish" style="display: none">
                            点击回复
                        </button>
                    </div>
                </li>

                <?php endforeach; else: ?>
                <!--存在多级评论-->
                <?php foreach($value['son'] as $k => $v): ?>
                <li class="per_comment">
                    <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
                    <div class="layui-timeline-content layui-text">
                        <h3 class="layui-timeline-title"><b>
                            <?php echo htmlentities($v['user_name']); ?> @
                            <?php echo htmlentities($user_all[$v['comment_to_user_id']]); ?></b>&nbsp;&nbsp;<a href="javascript:void(0)"
                                                                                 class="tip_people"
                                                                                 user-info="<?php echo htmlentities($v['comment_user_id']); ?>"
                                                                                 style="color: steelblue"
                                                                                 comment-id="<?php echo htmlentities($value['comment_id']); ?>">回复</a>
                        </h3>
                        <p>
                            <br>
                            <?php echo htmlentities($v['comment_to_content']); ?> <span
                                style="float: right"><b><?php echo htmlentities(date("Y-m-d H:i",!is_numeric($v['create_time'])? strtotime($v['create_time']) : $v['create_time'])); ?></b></span>
                            <br>
                        </p>
                        <textarea placeholder="请先登录后回复评论..." rows="3" cols="30" class="comment_click"
                                  style="display: none"></textarea>
                        <button class="layui-btn layui-btn-radius layui-btn-primary" id="publish" style="display: none">
                            点击回复
                        </button>
                    </div>
                </li>

                <?php endforeach; ?>

                <?php endif; ?>
                </li>
                <?php endforeach; ?>
                <?php endif; ?>

            </ul>
        </div>
    </div>
    <script src="/static/admin/headdata/js/jquery-1.8.3.min.js"></script>
    <script>
        layui.use('layer', function () {
            //发布评论
            $(document).on("click", "#publish_btn", function () {
                var isLogin = $(".is_login").val();
                if (isLogin) {
                    var publish_content = $("[name='publish_content']").val();
                    if (publish_content == '') {
                        layer.msg("品论不能为空~", {icon: -5, time: 1500});
                        return false;
                    }
                    var article_id = $("#article_info").attr("art_id");
                    $.ajax({
                        url: '/web/ArticleUser/addComment',
                        data: {article_id: article_id, comment_content: publish_content},
                        type: "post",
                        dataType: "json",
                        success: function (req) {
                            layer.msg(req['msg'], {icon: -1, time: 1500}, function () {
                                window.location.reload();
                            });
                        }
                    })
                } else {
                    layer.msg("请先登录!", {icon: 5, time: 1500});
                }
            });

            //回复评论
            $(document).on("click", ".per_comment div h3 .tip_people", function () {
                $(this).parent("h3").siblings(".comment_click").toggle();//发布的评论内容
                $(this).parent("h3").siblings("#publish").toggle();//发布评论的按钮

                var user_id = $(this).attr("user-info");//用户id
                var article_id = $("#article_info").attr("art_id");//文章id
                var comment_id = $(this).attr("comment-id");//评论id

                $(this).parent("h3").siblings("#publish").click(function () {
                    var comment_contents = $(this).siblings(".comment_click").val();//被回复的内容
                    if (comment_contents == '') {
                        layer.msg("回复的内容不能为空~", {icon: -5, time: 1500});
                        return false;
                    }
                    $.ajax({
                        url: '/web/ArticleUser/searchRepeatUser',
                        data: {
                            article_id: article_id,
                            user_id: user_id,
                            comment_content: comment_contents,
                            comment_id: comment_id
                        },
                        type: "post",
                        dataType: "json",
                        success: function (req) {
                            if (req['code'] == 1) {
                                layer.msg(req['msg'], {icon: -1, time: 1500}, function () {
                                    window.location.reload();
                                });
                            } else {
                                layer.msg(req['msg'], {icon: 5, time: 1500}, function () {
                                    window.location.reload();
                                });
                            }

                        }
                    })
                })

            })


            //点赞
            $(document).on("click", ".click_prize", function () {
                var article_id = $(this).attr("click-text");
                var keyClick=Date.parse(new Date())/1000;//当前时间戳

                $.ajax({
                    url: '/web/ArticleUser/clickPrize',
                    data: {
                        article_id: article_id,
                        key_time:keyClick
                    },
                    type: "get",
                    dataType: "json",
                    success: function (req) {
                        if (req['code'] == 1) {
                            var oldClick = $(".click_prize").siblings(".click_num").html();//旧的点击量
                            var newClick = parseInt(oldClick) + 1;
                            $(".click_prize").siblings(".click_num").html(newClick);//新的点击量
                            layer.msg(req['msg'], {icon: -1, time: 1500});
                        } else {
                            layer.msg(req['msg'], {icon: 5, time: 1500});
                        }

                    }
                })
            })
        });


    </script>
    
    <div class="rbox" style="font-family: 华文新魏">
        

    
        
    <div class="whitebg paihang">
        <h2 class="htitle">点击排行</h2>
        <section class="topnews imgscale"><a href="info.html"><img
                src="/static/admin/headdata/images/h1.jpg"><span>php手把手教你，点击试试看
      </span></a></section>
        <ul>
            <?php foreach($click_articles as $k => $v): ?>
            <li><i></i><a
                    href="<?php echo url('ArticleUser/articleDetail'); ?>?article_id=<?php echo htmlentities($v['article_id']); ?>"><?php echo htmlentities($v['article_title']); ?></a>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
    
        
    <div class="whitebg cloud">
        <h2 class="htitle">标签云</h2>
        <ul>
            <?php foreach($label as $k => $v): ?>
            <a href="<?php echo url('ArticleUser/searchArticleLabel'); ?>?label=<?php echo htmlentities($v); ?>"><?php echo htmlentities($v); ?></a>
            <?php endforeach; ?>

        </ul>
    </div>
    
        <div class="links whitebg">
            <h2 class="htitle">
        <span
                class="sqlink">
                <a href="javascript:void (0)" onclick="applicateLink(this)" data-url="<?php echo url('ArticleUser/addLink'); ?>"
                   style="text-decoration: none">申请链接
                </a>
        </span><i class="layui-icon layui-icon-link" style="font-size: 18px;"></i>&nbsp;友情链接
            </h2>
            <ul>
                <?php foreach($links as $k => $v): ?>
                <li>
                    <a href="<?php echo htmlentities($v['link_site']); ?>" target="_blank" style="text-decoration: none"><i
                            class="layui-icon layui-icon-link" style="font-size: 12px; color: #1E9FFF;"></i>&nbsp;<?php echo htmlentities($v['link_name']); ?></a>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</article>
<footer>
    <div class="box">
        <div class="endnav">
            <p><b>关于我们</b></p>
            <p>个人开发博客</p>
            <p>ICP备256987445号&nbsp;&nbsp;
                技术支持：<a href="http://www.php.cn/" title="carver" target="_blank">http://www.lijialong.store</a></p>
        </div>
    </div>
    <a href="#">
        <div class="top"></div>
    </a></footer>
</body>
</html>
<script>

    //超过文字省略
    $(function () {
        //限制字符个数
        $(".desc_info").each(function () {
            console.log($(this).text())
            var maxwidth = 100;
            if ($(this).text().length > maxwidth) {
                $(this).text($(this).text().substring(0, maxwidth));
                $(this).html($(this).html() + '…');
            }
        });
        console.log($(".albtn").text());
    });


    //申请友情链接
    function applicateLink(that) {
        layui.use('layer', function () {
            var layer = layui.layer;
            var url = that.getAttribute("data-url");
            layer.open({
                type: 2,
                title: '申请友情',
                shade: 0.2,
                area: ['300px', '240px'],
                content: url,
            })
        });
    }

    /**
     * 文字加图片水印效果
     * id 要加水印的区域
     * watermarkImg 水印为图片的图片url
     * watermarkText 水印文字
     */

    function watermarkWord(id, watermarkImg, watermarkText) {
        var screenHeight = window.screen.height
        var watermarkImg = watermarkImg;
        var watermarkText = watermarkText;

        if (navigator.appName == "Microsoft Internet Explorer" && navigator.appVersion.match(/9./i) == "9.") {
            var step = 180 / 480 * screenHeight;
            for (var i = 0; i <= parseInt($("body").height() / step); i++) {
                $('body').append('<div style="z-index:-999;width:100%;text-align:center;opacity:0.2;color:#000;position:absolute;top:' + step * (i) + 'px;font-size:2em;transform:rotate(-30deg); -ms-transform:rotate(-30deg); -o-tranform:rotate(-30deg); -webkit-transform:rotate(-30deg); -moz-transform:rotate(-30deg);filter:progid:DXImageTransform.Microsoft.Alpha(opacity=10));">' + watermarkText + '<br /><img style="width:8em;" src="' + watermarkImg + '" /></div>');
            }
        } else {
            var step = 180 / 480 * screenHeight;
            for (var i = 0; i <= parseInt($("body").height() / step); i++) {
                $('body').append('<div style="z-index:-999;width:100%;text-align:center;opacity:0.5;color:#000;position:absolute;top:' + step * (i) + 'px;font-size:2em;transform:rotate(-30deg); -ms-transform:rotate(-30deg); -o-tranform:rotate(-30deg); -webkit-transform:rotate(-30deg); -moz-transform:rotate(-30deg);filter:progid:DXImageTransform.Microsoft.Alpha(opacity=10) progid:DXImageTransform.Microsoft.Matrix(sizingMethod=\'auto expand\', M11=0.866025404, M12=0.5, M21=-0.5, M22=0.866025404);">' + watermarkText + '<br /><img  style="width:8em;" src="' + watermarkImg + '" /></div>');
            }
        }
    }
</script>
