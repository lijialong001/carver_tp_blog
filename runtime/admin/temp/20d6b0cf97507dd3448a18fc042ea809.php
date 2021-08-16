<?php /*a:1:{s:80:"/www/wwwroot/101.200.121.249/carver_tp_blog/app/admin/view/notice/addNotice.html";i:1618120768;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>添加公告</title>
    <link rel="stylesheet" href="/static/web/bootstrap/css/bootstrap.css" media="all">
    <link rel="stylesheet" href="/static/admin/layui/css/layui.css">
    <script src="/static/admin/layui/layui.js"></script>
    <script type="text/javascript" src="/static/admin/people/js/jquery.min.js"></script>
    <script type="text/javascript" src="/static/web/bootstrap/js/bootstrap.js"></script>
</head>
<body>
<form role="form">
    <div class="form-group  form-inline">
        <div class="panel panel-default ">
            <div class="panel-body text-center" style="font-size: 23px;background: lightgreen">
                公告内容 ( <span class="glyphicon glyphicon-warning-sign" style="color: red">不可以随意修改公告 </span> )
            </div>
        </div>
        <textarea class="form-control" name="content" placeholder="请输入公告内容"
                  style="resize: none;width: 80%;margin-left: 10%"
        ></textarea>
    </div>
    <div class="panel-body text-center">
         <button type="button" class="btn btn-primary" id="subNotice" onclick="notice.prototype.subNotice(this)"
                 data-url="<?php echo url('notice/doNotice'); ?>">提交
         </button>
    </div>
</form>
</body>
</html>
<audio  src="/static/admin/mp3/success.mp3" id="me"></audio>
<script src="/static/admin/notice/notice.js"></script>
<script>
    notice.prototype.init();
</script>
