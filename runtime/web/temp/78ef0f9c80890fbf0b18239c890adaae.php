<?php /*a:2:{s:89:"/www/wwwroot/101.200.121.249/tp-project/carver-tp/app/web/view/article/searchArticle.html";i:1616980464;s:88:"/www/wwwroot/101.200.121.249/tp-project/carver-tp/app/web/view/article/articleIndex.html";i:1617090890;}*/ ?>
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
        <div class="logo"><a href="javascript:void(0)" style="font-family: 华文宋体;text-decoration: none">Carver 博客</a></div>
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
    
<div class="lbox">
    <!--banbox begin-->
    <div class="banbox">
        <div class="banner">
            <div id="banner" class="fader">
                <?php foreach($carouse as $key => $value): ?>
                <li class="slide"><a href="javascript:void (0)"><img src="<?php echo htmlentities($value['carouse_img']); ?>"><span><?php echo htmlentities($value['carouse_desc']); ?></span></a>
                </li>
                <?php endforeach; ?>
                <div class="fader_controls">
                    <div class="page prev" data-target="prev"></div>
                    <div class="page next" data-target="next"></div>
                    <ul class="pager_list">
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--banbox end-->
    <!--headline begin-->
    <!--    <div class="headline">-->
    <!--        <ul>-->
    <!--            <li><a href="javascript:void (0)" title="为什么说10月24日是程序员的节日？"><img src="/static/admin/headdata/images/h1.jpg"-->
    <!--                                                                              alt="为什么说10月24日是程序员的节日？"><span>为什么说10月24-->
    <!--          日是程序员的节日？</span></a></li>-->
    <!--            <li><a href="javascript:void (0)" title="个人网站做好了，百度不收录怎么办？来，看看他们怎么做的"><img-->
    <!--                    src="/static/admin/headdata/images/h2.jpg" alt="个人网站做好了，百度不收录怎么办？来，看看他们怎么做的。"><span>个人网站做好了，百度不收录怎么办？来，看看他们怎么做的。</span></a>-->
    <!--            </li>-->
    <!--        </ul>-->
    <!--    </div>-->
    <!--headline end-->
    <div class="clearblank"></div>
    <!--tab_box end-->
    <div class="whitebg bloglist">
        <h2 class="htitle">最新文章</h2>
        <ul>
            <!--多图模式 置顶设计-->
            <!--<li>-->
            <!--<h3 class="blogtitle"><a href="/" target="_blank"><b>【顶】</b>别让这些闹心的套路，毁了你的网页设计!</a></h3>-->
            <!--<span class="bplist"><a href="info.html"> <img src="/static/admin/headdata/images/b02.jpg" alt=""></a> <a href="info.html"><img src="/static/admin/headdata/images/b03.jpg" alt=""></a> <a href="info.html"><img src="/static/admin/headdata/images/b04.jpg" alt=""> </a><a href="info.html"><img src="images/b05.jpg" alt=""> </a></span>-->
            <!--<p class="blogtext">如图，要实现上图效果，我采用如下方法：1、首先在数据库模型，增加字段，分别是图片2，图片3。2、增加标签模板，用if，else if 来判断，输出。思路已打开，样式调用就可以多样化啦！... </p>-->
            <!--<p class="bloginfo"><i class="avatar"><img src="/static/admin/headdata/images/avatar.jpg"></i><span>XX</span><span>2018-10-28</span><span>【<a href="info.html">原创模板</a>】</span></p>-->
            <!--</li>-->
            <!--文章列表-->
            <?php foreach($articles['data'] as $key => $value): ?>
            <li>
                <h3 class="blogtitle"><a
                        href="<?php echo url('ArticleUser/articleDetail'); ?>?article_id=<?php echo htmlentities($value['article_id']); ?>"><?php echo htmlentities($value['article_title']); ?></a>
                </h3>
                <span class="blogpic imgscale">
            <?php if($value['is_top_show']==1): ?>
                            <i style="border-radius: 20px">
                              <a href="javascript:void (0)" style="text-decoration: none;font-size: 20px;color: red">【 置顶 】</a>
                            </i>
                        <?php else: ?><?php endif; ?>
            <a href="javascript:void (0)"
               title=""><img src="<?php echo htmlentities($value['article_img']); ?>" alt="www.lijialong.site" style="border-radius: 10px"></a>
          </span>
                <p class="blogtext desc_info" nowrap="nowrap"><?php echo htmlentities($value['article_desc']); ?></p>
                <p class="bloginfo" style="font-size: 16px"> 作者:&nbsp;<span><b><?php echo htmlentities($value['article_author']); ?></b>
          </span><span style="margin-left: 30px"><i class="layui-icon layui-icon-time
" style="font-size: 16px; color: #1E9FFF;"></i> <?php echo htmlentities(date('Y-m-d',!is_numeric($value['add_time'])? strtotime($value['add_time']) : $value['add_time'])); ?><span style="margin-left: 30px">  <i
                        class="layui-icon layui-icon-unlink
" style="font-size: 16px; color: #1E9FFF;"></i>&nbsp;<?php echo htmlentities($value['article_label']); ?></span></span></p>
                <a href="<?php echo url('ArticleUser/articleDetail'); ?>?article_id=<?php echo htmlentities($value['article_id']); ?>"
                   class="viewmore">阅读更多</a>
                <?php endforeach; ?>
            </li>
        </ul>
        <div class="pagelist">
            <?php echo $page; ?>
        </div>
    </div>
    <!--bloglist end-->
</div>

    <div class="rbox" style="font-family: 华文新魏">
        
        <div class="card" style="background: white;color: black;">
            <p style="padding-top: 7px">网名：<?php echo !empty($self[0]['blog_name']) ? htmlentities($self[0]['blog_name']) : '暂无设置'; ?></p>
            <p>职业：<?php echo !empty($self[0]['blog_work']) ? htmlentities($self[0]['blog_work']) : '暂无设置'; ?></p>
            <p>现居：<?php echo !empty($self[0]['blog_home']) ? htmlentities($self[0]['blog_home']) : '暂无设置'; ?></p>
            <p>网址：<?php echo !empty($self[0]['blog_site']) ? htmlentities($self[0]['blog_site']) : '暂无设置'; ?></p>
<!--            <ul class="linkmore" style="text-align: center">-->
<!--                <li><a href="" target="_blank" class="iconfont icon-&#45;&#45;" title="QQ联系我"></a>-->
<!--                </li>-->
<!--                <li id="weixin"><a href="" target="_blank" class="iconfont icon-weixin"-->
<!--                                   title="关注我的微信"></a><i><img src="/static/admin/headdata/images/wx.png"></i></li>-->
<!--            </ul>-->
        </div>
        <div class="whitebg notice">
            <h2 class="htitle"><i class="layui-icon layui-icon-speaker" style="font-size: 18px;"></i>&nbsp;网站公告</h2>
            <ul>
                <?php foreach($notice as $k => $v): ?>
                <li><a href="javascript:void(0)"><?php echo htmlentities($v['notice_content']); ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
        
        
        <div class="whitebg paihang">
            <h2 class="htitle"><i class="layui-icon layui-icon-fire" style="font-size: 18px;"></i>&nbsp;点击排行</h2>
            <ul>
                <?php foreach($click_articles as $k => $v): ?>
                <li><i></i><a href="<?php echo url('ArticleUser/articleDetail'); ?>?article_id=<?php echo htmlentities($v['article_id']); ?>"><?php echo htmlentities($v['article_title']); ?></a>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
        
        
        <div class="whitebg cloud">
            <h2 class="htitle"><i class="layui-icon layui-icon-note" style="font-size: 18px;color: black"></i>&nbsp;标签云</h2>
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
                <a href="javascript:void (0)" onclick="applicateLink(this)" data-url="<?php echo url('admin/Link/addLink'); ?>" style="text-decoration: none">申请链接
                </a>
        </span><i class="layui-icon layui-icon-link" style="font-size: 18px;"></i>&nbsp;友情链接
            </h2>
            <ul>
                <?php foreach($links as $k => $v): ?>
                <li>
                    <a href="<?php echo htmlentities($v['link_site']); ?>" target="_blank" style="text-decoration: none"><i class="layui-icon layui-icon-link" style="font-size: 12px; color: #1E9FFF;"></i>&nbsp;<?php echo htmlentities($v['link_name']); ?></a>
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

    function watermarkWord(id,watermarkImg, watermarkText) {
        var screenHeight = window.screen.height
        var watermarkImg = watermarkImg ;
        var watermarkText =  watermarkText;

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
