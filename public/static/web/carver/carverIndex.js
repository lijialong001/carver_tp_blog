/*
    @desc 加载图片
    */
    window.onload = setLoadImg;
    document.onscroll = setLoadImg;
    window.onresize = setLoadImg;
    var doc = document,
        doc_type = doc.compatMode == "BackCompat" ? doc.body : doc.documentElement;
    var client_height = doc_type.clientHeight;//显示区域高度
    var scroll_top = doc_type.scrollTop;//滚动条的top

    
    $(function(){
        
        //初始化当前图片加载
        var banner_img = $("#slider1 img");
        for(var i = 0; i <banner_img.length;i++){
            //图片可视到顶部的距离
            var banner_img_top = banner_img[i].getBoundingClientRect().top;
            if(banner_img_top < client_height + scroll_top){
                var src = banner_img[i].getAttribute('data-src');
                banner_img[i].setAttribute('src',src);
            }
        }
        
        
        
        //初始化当前天气信息
        $.ajax({
            url:
              "/web/Music/getWetherInfo",
            dataType: "json",
            type: "GET",
        
            success: function (data) {
              $("#city-weather-temperature").html(data.data.data.result.realtime.temperature + "° C");
              $("#city-weather-description").html(data.data.data.result.realtime.info);
              if(data.data.data.result.realtime.info.indexOf('雨') != -1){
                  $('.city-weather-icon').attr('src','/static/web/image/rain.gif');
              }else if(data.data.data.result.realtime.info.indexOf('雪') != -1){
                  $('.city-weather-icon').attr('src','/static/web/image/snow.gif');
              }else{
                  $('.city-weather-icon').attr('src','/static/web/image/clound.gif');
              }
              
              $(".city-title").html(data.data.data.result.city);
              
            },
            error: function (xhr, status, errorThrown) {
              
            }
          });
    
          //右侧导航栏
          $(".content nav ul li a").on("click", function () {
            var $this = $(this);
            var target = $this.attr("self-id");
            $this.parent().addClass("selected").siblings().removeClass("selected");
            $("#" + target).fadeIn("slow").removeClass("hide").siblings().not("nav").not(".nav-info-behind").hide();
            return false;
          });
          
          
          
          //超过文字省略
          $(window).scroll(function(){
    
                var scrollTop = $(this).scrollTop();
    
                 //            alert(ks_area);
                 if (scrollTop >= 315) {
                     $(".top").show("slow");
                     $(".navbox").css("background","#373D41");
                 }else{
                     $(".top").hide(1000);
                     $(".navbox").css("background","#333");
                 }
                 
            });
           
           
           
           
            //切换浏览器标签 切换标题
            sessionStorage.setItem("title",document.title);
            var hiddenProperty = 'hidden' in document ? 'hidden' :
                    'webkitHidden' in document ? 'webkitHidden' :
    				'mozHidden' in document ? 'mozHidden' :
    				null;
            var visibilityChangeEvent = hiddenProperty.replace(/hidden/i, 'visibilitychange');
            var Tiao;
            var onVisibilityChange = function(){
                if (!document[hiddenProperty]) {
    					clearInterval(Tiao);
                        document.title = sessionStorage['title']
    
                }else{
                    var a = false;
                    Tiao = setInterval(function(){
                        document.title = a ? "千万别走,主人来电话了" : "➟千万别走,主人来电话了~";
    						a = !a;
                    },50);
                }
            }
            
            document.addEventListener(visibilityChangeEvent, onVisibilityChange);
            
            
            //设置右上角登录和注册
            var changeHtml='<a href="/web/LoginUser/index.html" style="color: white;font-family:Lucida Calligraphy, cursive, serif, sans-serif">登录</a>';
            var changeHtmlTop='<button class="btn btn-primary btn-lg" id="please_register"><a href="/web/LoginUser/index.html" style="color: white;font-family:Lucida Calligraphy, cursive, serif, sans-serif">注册</a></button>';
            var userData=localStorage.getItem("userInfo");
    
            if(userData){
                let userJson=JSON.parse(userData);
    
                if(userJson['token']){
                    changeHtml=userJson['userInfo']['user_name'];
                    changeHtmlTop='<a href="/web/LoginUser/outLogin.html?user_id='+userJson['userInfo']['user_id']+'" class="btn btn-primary btn-lg" id="out_login"><span class="glyphicon glyphicon-log-out"></span>&nbsp;退出</a>';
                }
            }
    
            $(".userSelfInfo").html(changeHtml);
            $(".userSelfInfoTop").html(changeHtmlTop);
            $("#out_login").click(function(){
                localStorage.removeItem("userInfo");
            })
            
            
            
            
            //在线音乐申请
            layui.use('layer', function () {
                var layer = layui.layer;
                $('.apply_btn').click(function(){
                    let apply_music = $.trim($('input[name=apply_music]').val());
    
                    if(apply_music==''){
                        layer.msg('输入内容不能为空');
                        return false;
                    }
                    
                    
                    $.ajax({
                        url:
                          "/web/Music/applyMusic",
                        dataType: "json",
                        type: "POST",
                    
                        success: function (data) {
                            layer.msg(data.msg);
                        },
                        error: function (xhr, status, errorThrown) {
                          
                        }
                  });
                    
                    
                })
            });
            
            
                
           
           
           
          
          
          
    })

    //图片懒加载
    function setLoadImg(){
    	var  img = $('.bloglist .imgscale img');
        for(var i = 0; i <img.length;i++){
            //图片可视到顶部的距离
            var img_top = img[i].getBoundingClientRect().top;
            if(img_top < client_height + scroll_top){
                var src = img[i].getAttribute('data-src');
                img[i].setAttribute('src',src);
            }
        }
    		        
    }



    //申请友情链接
    function applicateLink(that) {
        layui.use('layer', function () {
            var layer = layui.layer;
            var url = that.getAttribute("data-url");
            layer.open({
                type: 2,
                title: '申请友情',
                shade: 0.2,
                area: ['386px', '300px'],
                content: url,
            })
        });
    }
    
    

            
    //右侧电子表 获取显示小时的区域框对象
    var hour=document.getElementById('h');
    //获取显示分钟的区域框对象
    var minute=document.getElementById('m');
    //获取显示秒的区域框对象
    var second=document.getElementById('s');
             
    //获取当前时间
    function getCurrentTime(){
        var date=new Date();
        var h=date.getHours();
        var m=date.getMinutes();
        var s=date.getSeconds();
                 
        if(h<10) h='0'+h;//确保0-9时也显示成两位数
        if(m<10) m='0'+m;//确保0-9分钟也显示成两位数
        if(s<10) s='0'+s;//确保0-9秒也显示成两位数
                 
        hour.innerHTML=h;
        minute.innerHTML=m;
        second.innerHTML=s;
    }
    //每秒更新一次时间
    setInterval('getCurrentTime()',1000);
    
    
    
    
    //设置雪花背景 获取画布内容
    var canvas = document.querySelector('canvas');
    var ctx = canvas.getContext('2d');
    
    //将画布调暗设置为窗口高度和宽度
    var W = window.innerWidth;
    var H = window.innerHeight;
    canvas.width = W;
    canvas.height = H;
    
    //生成雪花并应用属性
    var flakesCount = 100;
    var flakes = []; //雪花实例
    
    // 循环遍历空雪花
    for (var i = 0; i < flakesCount; i++) {
        flakes.push({
          x: Math.random() * W,
          y: Math.random() * H,
          r: Math.random() * 5 + 2, // 2px - 7px
          d: Math.random() + 1
        });
    }
    
    //绘制雪花到画布上
    function drawFlakes() {
        ctx.clearRect(0, 0, W, H);
        ctx.fillStyle = '#fff';
        ctx.beginPath();
        for (var i = 0; i < flakesCount; i++) {
          var flake = flakes[i];
          ctx.moveTo(flake.x, flake.y);
          ctx.arc(flake.x, flake.y, flake.r, 0, Math.PI * 2, true);
        }
        ctx.fill();
        moveFlakes();
    }
    
    var angle = 0;
    
    function moveFlakes() {
        angle += 0.01;
        for (var i = 0; i < flakesCount; i++) {
          var flake = flakes[i];
          flake.y += Math.pow(flake.d, 2) + 1;
          flake.x += Math.sin(angle) * 2;
    
          if (flake.y > H) {
            flakes[i] = { x: Math.random() * W, y: 0, r: flake.r, d: flake.d };
          }
        }
    }
    
    setInterval(drawFlakes, 25);
    
    
    
    
    
    
    //初始化代码高亮
    hljs.initHighlightingOnLoad();
    //初始化底部音乐部分
    var musicSelf = {
		        element: document.getElementById("player3"),
		        autoPlay: 0,/*是否开启自动播放,默认false*/
		        lrcStart: 1,/*是否开启歌词功能 ，默认false（为true时musics集合中需要传入lrc字段。）*/
		        showLrc: 1,/*开启歌词功能后是否展示歌词内容 ，默认false*/
		        fixed:1, /*是否固定在底部，默认false*/
		        listFolded:1, /*列表是否折叠，默认false*/
		        listMaxHeight:300, /*列表最大高度，默认240*/
		        musics: []
		    }
		    
		    setTimeout(function(){
		        
                $.ajax({
                    type: "get",
                    url: "/web/music/getSongList",
                    data: {},
                    dataType: "json",
                    success: function (data) {
                        
                        for(var i in data.data.data){
                            let allMusic = {
                                'title':'',
                                'author':'',
                                'url':'',
                                'pic':'',
                                'lrc':''
                            };
                            
                             allMusic.title=  data.data.data[i]['title'];
                             allMusic.author=  data.data.data[i]['author'];
                             allMusic.url=  data.data.data[i]['url'];
                             allMusic.pic=  data.data.data[i]['pic'];
                             allMusic.lrc=  data.data.data[i]['lyric'];
                            musicSelf.musics.push(allMusic);
                        }
                        
                        var zp3 = new zplayer(musicSelf);
                    }
                    
                })
    },1000)
        
    // 初始化行数显示
    //hljs.initLineNumbersOnLoad()
    
    
    // $('.self_article').on('click',function(){
    //     var hash_url = $(this).data("id"); //获取data-id的值
    //     window.location.hash = hash_id; //设置锚点
    //     // //重载
    //     articleLoad(hash_url);
    // })
    
    
    
    // function articleLoad(hash_url){

    //     var hash_url = window.location.hash;
    //     var hash_id = hash_url.split('/');
    //     var path;
    //     var self_hash_id = hash_id[0]??'#';
    //     var nav_id = hash_id[1]??'';
    
    //     switch(self_hash_id){
    //       case "#article": path = "/web/ArticleUser/searchLabel?nav_id="+nav_id;break;
    //       default:path = '' ;break;
    //     }
        
    //     $("#all_part").load(path); //加载相对应的内容
    // }
    
    
    // var self_hash = window.location.hash;
    // articleLoad(self_hash);
    

    
    
    
    
    
    
    