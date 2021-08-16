<?php /*a:2:{s:82:"/www/wwwroot/101.200.121.249/carver_tp_blog/app/admin/view/article/addArticle.html";i:1618120768;s:70:"/www/wwwroot/101.200.121.249/carver_tp_blog/app/admin/view/header.html";i:1618120768;}*/ ?>
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

<form action="" style="margin-left: 20px">
    <div class="layui-form-item" style="padding-top: 30px">
        <label class="layui-form-label bg-success  text-center" style="width: 100px">所属导航</label>
        <div class="layui-input-block" style="width: 160px;text-align: center">
            <select name="article_guide" lay-verify="required" id="article_guide">
                <option value="0">请选择导航</option>
                <?php foreach($navigations as $k => $v): ?>
                <option value="<?php echo htmlentities($v['nav_id']); ?>"><?php echo htmlentities($v['nav_name']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label bg-success  text-center" style="width: 100px">文章标题</label>
        <div class="layui-input-block">
            <input type="text" name="article_title" lay-verify="title" autocomplete="off" placeholder="请输入标题"
                   class="form-control" style="width: 500px">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label bg-success  text-center" style="width: 100px">文章标签</label>
        <div style="margin-left: 111px"><input data-role='tags-input' value="php" style="color: red;"
                                               name="article_label"></div>

    </div>
    <div class="layui-form-item">
        <label class="layui-form-label bg-success  text-center" style="width: 100px">文章简介</label>
        <div class="layui-input-block" style="width: 500px;height: 200px">
            <textarea name="article_desc" id="" cols="30" rows="10"
                      style="border: 1px darkgrey solid;width: 500px;height: 200px;resize: none">请输入文章简介...</textarea>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label bg-success  text-center" style="width: 100px">是否显示</label>
        <input type="checkbox" name="is_show" value="0" style="margin-left: 12px">
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label bg-success  text-center" style="width: 100px">点击量</label>
        <div class="layui-input-block">
            <input type="text" name="click_num" lay-verify="title" autocomplete="off" placeholder="" class="layui-input"
                   style="width: 60px;display: inline" value="1" maxlength="6">
            <button type="button" class="layui-btn layui-btn-xs"
                    style="display: inline;height: 36px;width: 30px;font-size: 20px" id="click_num">+
            </button>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label bg-success  text-center" style="width: 100px">是否置顶</label>
        <input type="checkbox" name="is_top_show" value="0">
    </div>
    <div class="layui-form-item click_img_btn">
        <label class="layui-form-label bg-success  text-center" style="width: 100px">文章封面</label>
        <div class="layui-input-block">
            <button type="button" class="layui-btn" id="upload_img">
                <i class="layui-icon">&#xe67c;</i><span>上传图片</span>
            </button>
            <input type="hidden" name="article_img" value="" id="article_img">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label bg-success text-center" style="width: 100px">文章内容</label>
        <div class="layui-input-block">
            <div class="m">
                <div class="summernote" id="content">请输入文章内容...</div>
            </div>
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <button type="button" class="btn-primary btn-sm" id="sub_article">立即添加</button>
        </div>
    </div>
</form>

<script src="/static/admin/article/article.js"></script>

<script>
    $(document).ready(function () {
        $('[data-role="tags-input"]').tagsInput();
    });
    articles.prototype.init();
</script>




