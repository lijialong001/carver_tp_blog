<?php /*a:1:{s:84:"/www/wwwroot/101.200.121.249/carver_tp_blog/app/admin/view/navigate/addNavigate.html";i:1618120768;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>添加导航</title>
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


<form  style="margin-top: 30px;font-size: 17px;margin-left: 60px"
      >
    <div class="layui-form-item layui-inline">
        <label class="layui-form-label  bg-success" style="width: 150px;text-align: center">父级导航</label>
        <div class="layui-input-block" id="navigate_name_parent" style="width: 120px;margin-left: 160px">
            <select name="navigate_name_parent" id="searchSelect">
                <option value="0">一级导航</option>
                <?php foreach($data as $k => $v): ?>
                <option value="<?php echo htmlentities($v['nav_id']); ?>"><?php echo htmlentities($v['nav_name']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

    </div>

    <div class="layui-form-item">
        <tr>
            <label class="layui-form-label  bg-warning" style="width: 150px;text-align: center">导航名称</label>
            <td>
                <input type="text" name="navigate_name" lay-verify="required" placeholder="请输入导航名称" autocomplete="off"
                       class="form-control"
                       style="width: 230px;margin-left: 160px;height: 38px" value="">
            </td>
        </tr>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label  bg-warning" style="width: 150px;text-align: center">排序</label>
        <div class="layui-input-inline">
            <input type="text" name="sort_info" required lay-verify="required" autocomplete="off"
                   class="layui-input" style="width: 230px;margin-left: 10px;height: 38px" value="1"
                   onkeyup="this.value=this.value.replace(/[^\d]/g,'')">
        </div>
        <div class="layui-form-mid layui-word-aux" style="margin-left: 50px"><span style="color: red">默认排序为1</span>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label  bg-warning" style="width: 150px;text-align: center">是否显示</label>
        <input type="checkbox" name="is_show" checked value="1">
    </div>
    <div class="layui-form-item">
        <tr>
            <label class="layui-form-label"></label>
            <td>
                <button type="button" class="btn-primary btn-lg"  onclick="navigates.prototype.subNavigate(this)"
                       data-url="<?php echo url('admin/Navigate/doAddNavigate'); ?>" style="margin-top: 16px;margin-left: 74px">立即添加
                </button>
            </td>
        </tr>
    </div>
</form>
</body>
</html>
<script src="/static/admin/navigate/navigate.js"></script>
<script>

    $(function () {
        $("#searchSelect").selectpicker({
            width: 160,
            liveSearch: true,
            liveSearchPlaceholder: "请输入父级导航名"
            ,noneResultsText:"匹配失败",
            tickIcon:"glyphicon-ok"
        });

        $("[name='is_show']").bootstrapSwitch({
            onText : "显示",      // 设置ON文本
            offText : "禁止",    // 设置OFF文本
            onColor : "success",// 设置ON文本颜色(info/success/warning/danger/primary)
            offColor : "danger",  // 设置OFF文本颜色 (info/success/warning/danger/primary)
            size : "normal",    // 设置控件大小,从小到大  (mini/small/normal/large)
            handleWidth:"20,30",
            // 当开关状态改变时触发
            onSwitchChange : function(event, state) {
                if(state==true){
                    $(this).val(1);
                }else{
                    $(this).val(0);
                }
            }
        });

    })

    navigates.prototype.init();
</script>
