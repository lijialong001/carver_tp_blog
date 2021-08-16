<?php /*a:1:{s:75:"/www/wwwroot/101.200.121.249/carver_tp_blog/app/admin/view/link/upLink.html";i:1618120768;}*/ ?>
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
    <input type="hidden" name="link_id" value="<?php echo htmlentities($data['link_id']); ?>">
    <div class="form-group form-inline">
        <label for="link_name" class="col-sm-2 control-label">友情名称</label>
        <div class="col-sm-1">
            <input type="text" class="form-control" name="link_name" readonly placeholder="请输入友情名称"
                   value="<?php echo htmlentities($data['link_name']); ?>">
        </div>
    </div>
    <div class="form-group form-inline">
        <label for="link_site" class="col-sm-2 control-label">友情网站地址</label>
        <div class="col-sm-1">
            <input type="text" class="form-control disabled" readonly name="link_site" placeholder="请输入友情网站地址"
                   value="<?php echo htmlentities($data['link_site']); ?>">
        </div>
    </div>
    <div class="form-group form-inline">
        <label for="is_confirm" class="col-sm-2 control-label">申请状态</label>
        <div class="col-sm-1">
            <select name="is_confirm" id="is_confirm" class="form-control">
                <option value="0">未审核</option>
                <option value="1">正在审核</option>
                <option value="2">审核通过</option>
                <option value="3">审核未通过</option>
            </select>
        </div>
    </div>
    <div style="width: 100%">
        <button type="button" class="btn btn-default col-sm-2 m-auto " onclick="upLink(this)"
                style="margin-left: 119px" data-url="<?php echo url('Link/doLink'); ?>">提交
        </button>
    </div>
</form>
</body>
</html>
<script>
    //点击提交申请友情
    function upLink(that) {
        layui.use('layer', function () {
            var layer = layui.layer;
            var link_id = $.trim($("[name='link_id']").val());
            var link_name = $.trim($("[name='link_name']").val());
            var link_site = $.trim($("[name='link_site']").val());
            var is_confirm = $.trim($("[name='is_confirm']").val());
            if (link_name == '') {
                layer.msg("友情名称不能为空~", {icon: 2});
                return false;
            }
            if (link_site == '') {
                layer.msg("友情网站地址不能为空~", {icon: 2});
                return false;
            }
            if (is_confirm == '') {
                layer.msg("状态不能为空~", {icon: 2});
                return false;
            }
            var url = that.getAttribute("data-url");
            var index = layer.load(1);
            $.post(url, {
                link_id: link_id,
                link_name: link_name,
                link_site: link_site,
                is_confirm: is_confirm
            }, function (data) {
                layer.close(index);
                if (data.code == 1) {
                    layer.msg(data.msg, {icon: 1, time: 1500}, function () {
                        var indexs = parent.layer.getFrameIndex(window.name);//关闭当前窗口
                        parent.layer.close(indexs);
                        window.parent.location.reload();
                    });
                } else {
                    layer.msg(data.msg, {icon: 5, time: 1500}, function () {
                        var indexs = parent.layer.getFrameIndex(window.name);//关闭当前窗口
                        parent.layer.close(indexs);
                        window.parent.location.reload();
                    });
                }

            }, "json")
        });
    }
</script>
