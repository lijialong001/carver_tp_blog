<?php /*a:1:{s:83:"/www/wwwroot/101.200.121.249/carver_tp_blog/app/admin/view/navigate/addCarouse.html";i:1618120768;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>添加轮播图</title>
    <link rel="stylesheet" href="/static/web/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="/static/admin/layui/css/layui.css">
    <link rel="stylesheet" href="/static/admin/css/bootstrap-select.css">
    <link rel="stylesheet" href="/static/admin/select_switch/css/bootstrap3/bootstrap-switch.min.css">
    <script src="/static/admin/layui/layui.js"></script>
    <script type="text/javascript" src="/static/admin/people/js/jquery.min.js"></script>
    <script type="text/javascript" src="/static/web/bootstrap/js/bootstrap.js"></script>
    <script type="text/javascript" src="/static/admin/js/bootstrap-select.js"></script>
    <script type="text/javascript" src="/static/admin/select_switch/js/bootstrap-switch.js"></script>
</head>
<body>
<form style="margin-top: 30px;font-size: 17px;margin-left: 60px" id="addCarouseForm">
    <div class="layui-form-item">
        <tr>
            <label class="layui-form-label  bg-warning" style="width: 150px;text-align: center">轮播图</label>
            <td>
                <div style="margin-left: 163px">
                    <button type="button" class="layui-btn" id="upload_img">
                        <i class="layui-icon">&#xe67c;</i><span>上传图片</span>
                    </button>
                    <input type="hidden" name="carouse_img" value="" id="carouse_img">
                </div>
            </td>
        </tr>
    </div>

    <div class="layui-form-item">
        <tr>
            <label class="layui-form-label  bg-warning" style="width: 150px;text-align: center">轮播图描述</label>
            <div class="layui-input-inline">
                <input type="text" name="carouse_desc" class="layui-input" value="" id="carouse_desc" style="width: 230px;margin-left: 10px;height: 38px">
            </div>
        </tr>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label  bg-warning" style="width: 150px;text-align: center">排序</label>
        <div class="layui-input-inline">
            <input type="text" name="carouse_sort" required lay-verify="required" autocomplete="off"
                   class="layui-input" style="width: 230px;margin-left: 10px;height: 38px" value="100"
                   onkeyup="this.value=this.value.replace(/[^\d]/g,'')">
        </div>
        <div class="layui-form-mid layui-word-aux" style="margin-left: 50px"><span style="color: red">默认排序为100</span>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label  bg-warning" style="width: 150px;text-align: center">是否显示</label>
        <div style="margin-left: 160px">
            <input type="checkbox" name="is_show"  value="0" id="is_show" >
        </div>
    </div>
    <div class="layui-form-item">
        <tr>
            <label class="layui-form-label"></label>
            <td>
                <button type="button" class="btn-primary btn-lg" onclick="navigates.prototype.subCarouse(this)"
                        data-url="<?php echo url('admin/Navigate/doAddCarouse'); ?>" style="margin-top: 16px;margin-left: 74px;font-size: 16px">立即添加
                </button>
            </td>
        </tr>
    </div>
</form>
</body>
</html>
<script src="/static/admin/navigate/navigate.js"></script>
<script>
    navigates.prototype.init();
</script>
