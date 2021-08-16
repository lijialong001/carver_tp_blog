<?php /*a:1:{s:74:"/www/wwwroot/101.200.121.249/carver_tp_blog/app/web/view/link/addLink.html";i:1618120768;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>申请友情</title>
    <link rel="stylesheet" href="/static/admin/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="/static/web/bootstrap/css/bootstrap.css" media="all">
    <script type="text/javascript" src="/static/web/bootstrap/js/bootstrap.js"></script>
    <script src="/static/admin/headdata/js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="/static/admin/layui/layui.js"></script>
</head>
<body>
<form role="form" id="linkForm">
    <div class="form-group form-inline">
        <label for="link_name" class="col-sm-2 control-label">友情名称</label>
        <div class="col-sm-1">
            <input type="text" class="form-control" name="link_name" placeholder="请输入友情名称">
        </div>
    </div>
    <div class="form-group form-inline">
        <label for="link_site" class="col-sm-2 control-label">友情网站地址</label>
        <div class="col-sm-1">
            <input type="text" class="form-control" name="link_site" placeholder="请输入友情网站地址(http或https)">
        </div>
    </div>
    <div style="width: 100%">
        <button type="button" class="btn btn-default col-sm-2 m-auto " onclick="addLink(this)"
                style="margin-left: 119px" data-url="<?php echo url('ArticleUser/applyLink'); ?>">提交
        </button>
    </div>
</form>
</body>
</html>
<script>
    //点击提交申请友情
    function addLink(that) {
        layui.use('layer', function () {
            var layer = layui.layer;
            var link_name = $.trim($("[name='link_name']").val());
            var link_site = $.trim($("[name='link_site']").val());
            if (link_name == '') {
                layer.msg("友情名称不能为空~", {icon: 2});
                return false;
            }
            if (link_site == '') {
                layer.msg("友情网站地址不能为空~", {icon: 2});
                return false;
            }
            //url地址验证
            var regExp = /http[s]{0,1}:\/\/([\w.]+\/?)\S*/;
            if (!regExp.test(link_site)) {
                layer.msg("友情链接格式不正确~", {icon: 5});
                return false;
            }
            var url = that.getAttribute("data-url");
            var index = layer.load(1);
            $.post(url, {link_name: link_name, link_site: link_site}, function (data) {
                layer.close(index);
                if (data.code == 1) {
                    layer.msg(data.msg, {icon: 6, time: 1500}, function () {
                        var indexs = parent.layer.getFrameIndex(window.name);//关闭当前窗口
                        parent.layer.close(indexs);
                        window.location.reload();
                    });
                } else {
                    layer.msg(data.msg, {icon: 5, time: 1500}, function () {
                        var indexs = parent.layer.getFrameIndex(window.name);//关闭当前窗口
                        parent.layer.close(indexs);
                        window.location.reload();
                    });
                }

            }, "json")
        });
    }
</script>
