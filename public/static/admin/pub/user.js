var user = function () {

};
//初始化数据
user.prototype.init = function () {
    layui.use('form', function () {
    })
};


//编辑用户资料
user.prototype.editUser = function (that) {
    layui.use(['layer', 'form'], function () {
        var layer = layui.layer;
        var form = layui.form;
        var user_id = that.getAttribute("up-id");

        layer.open({
            title: '添加导航',
            type: 2,
            area: ['35%', '45%'],
            content: url,
            success: function () {
                form.render("select");
            }
        });

    })
};








