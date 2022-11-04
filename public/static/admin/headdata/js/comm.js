$(document).ready(function() {
    
    
    //限制字符个数
        $(".desc_info").each(function () {
            let maxwidth = 100;
            if ($(this).text().length > maxwidth) {
                $(this).text($(this).text().substring(0, maxwidth));
                $(this).html($(this).html() + '…');
            }
        });
        
        
        $(".article_title").each(function(){
            let maxwidth = 22;
            if ($(this).text().length > maxwidth) {
                $(this).text($(this).text().substring(0, maxwidth));
                $(this).html($(this).html() + '…');
            }
        })
    
    
    
    //nav     
    var obj = null;
    var As = document.getElementById('starlist').getElementsByTagName('a');
    obj = As[0];
    for (i = 1; i < As.length; i++) {
        if (window.location.href.indexOf(As[i].href) >= 0) obj = As[i];
    }
    obj.id = 'selected';
    //nav
    $("#mnavh").click(function() {
        $("#starlist").toggle();
        $("#mnavh").toggleClass("open");
    });
    //search  
    $(".searchico").click(function() {
        $(".search").toggleClass("open");
    });
    //searchclose 
    $(".searchclose").click(function() {
        $(".search").removeClass("open");
    });
    //banner
    $('#banner').easyFader();
    //nav menu   
    $(".menu").click(function(event) {
        $(this).children('.sub').slideToggle();
    });
    //tab
    $('.tab_buttons li').click(function() {
        $(this).addClass('newscurrent').siblings().removeClass('newscurrent');
        $('.newstab>div:eq(' + $(this).index() + ')').show().siblings().hide();
    });
    
    
    
    
    
});