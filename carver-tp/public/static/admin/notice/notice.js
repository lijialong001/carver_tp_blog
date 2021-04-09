var notice=function () {

};
//初始化数据
notice.prototype.init=function(){

};
//添加公告
notice.prototype.addNotice=function (that) {
    layui.use(['layer'],function () {
        var layer=layui.layer;
        var url=that.getAttribute("data-url");
        layer.open({
            title:'添加公告',
            type:2,
            area:['40%','36%'],
            maxmin:true,
            content:url,
            success:function () {

            }
        });
    })
};

//提交公告数据
notice.prototype.subNotice=function (that) {
    layui.use(['layer'],function () {
        var layer=layui.layer;
        var content=$.trim($("[name='content']").val());
        if(content==''){
            layer.alert("公告内容不能为空!",{icon:2,title:'添加公告'}); return false;
        }
        var url=that.getAttribute("data-url");
        var index=layer.load(1);
        $.post(url,{content:content},function (data) {
             if(data.code==1){
                 layer.close(index);
                layer.msg(data.msg,{icon:1,time:1500},function () {
                    var audioEle=document.getElementById("me");
                    audioEle.play();//播放mp3
                    audioEle.loop = false;
                    audioEle.addEventListener('ended', function () {
                        notice.prototype.windPub();
                        window.parent.location.reload();
                    }, false);

                });
             }
        },'json')
    })
};

//关闭窗口的公共方法
notice.prototype.windPub=function () {
    var index=parent.layer.getFrameIndex(window.name); //获取当前窗口的name
    parent.layer.close(index);
};

//删除公告（只有管理员有相应的权限）
notice.prototype.delNotice=function (that) {
    layui.use(['layer'],function () {
        var layer=layui.layer;
        var manager_auth=that.getAttribute("data-auth");
        var notice_id=that.getAttribute("data-id");
        var url=that.getAttribute("data-url");
        if(manager_auth=='超级管理员'){
            var index=layer.load(1);
            $.post(url,{notice_id:notice_id},function (data) {
                    layer.close(index);
                    layer.msg(data.msg,{icon:1,time:1500},function () {
                        notice.prototype.windPub();
                        window.parent.location.reload();
                    });
            },'json')
        }else{
            layer.msg("爱卿，你没有删除的权限！",{icon:2,time:1500},function () {
                notice.prototype.windPub();
            });
        }
    })
};

//发送成功的提示声音
notice.prototype.fun=function(){
    var audioEle=document.getElementById("me");
    audioEle.play();
};
