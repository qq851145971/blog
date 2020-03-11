$(document).ready(function () {
    $("#nav .sub-menu a").click(function(){
        var url = $(this).attr("url");
        window.location.href=url;
    });
});
layui.use(['layer','element','jquery'],function() {
    layer = layui.layer;
    element = layui.element;
    $ = layui.jquery;
    if($('.left-nav').css('width')=='60px'){
        // $('.left-nav').animate({width: '220px'}, 100);
        // $('.page-content').animate({left: '220px'}, 100);
        // $('.left-nav i').css('font-size','14px');
        // $('.left-nav cite,.left-nav .nav_right').show();
        alert(2);
    }

    if($(window).width()<768){
        // $('.page-content-bg').show();
        alert(1);
    }
    $('.left-nav #nav').on('click', 'li', function(event) {
        $('.left-nav').find('a').removeClass('active');
        $(this).children('a').addClass('active');
        if($(this).children('.sub-menu').length){
            if($(this).hasClass('open')){
                $(this).removeClass('open');
                $(this).find('.nav_right').html('&#xe697;');
                $(this).children('.sub-menu').stop(true,true).slideUp();
                $(this).siblings().children('.sub-menu').slideUp();
            }else{
                $(this).addClass('open');
                $(this).children('a').find('.nav_right').html('&#xe6a6;');
                $(this).children('.sub-menu').stop(true,true).slideDown();
                $(this).siblings().children('.sub-menu').stop(true,true).slideUp();
                $(this).siblings().find('.nav_right').html('&#xe697;');
                $(this).siblings().removeClass('open');
            }
        }
        event.stopPropagation();
    });
    // 隐藏左侧
    $('.layui-easy .left_open i').click(function(event) {
        if($('.left-nav').css('width')=='220px'){
            $('.left-nav .open').click();
            $('.left-nav i').css('font-size','18px');
            $('.left-nav').animate({width: '60px'}, 100);
            $('.left-nav cite,.left-nav .nav_right').hide();
            $('.page-content').animate({left: '60px'}, 100);
            $('.page-content-bg').hide();
        }else{
            $('.left-nav').animate({width: '220px'}, 100);
            $('.page-content').animate({left: '220px'}, 100);
            $('.left-nav i').css('font-size','14px');
            $('.left-nav cite,.left-nav .nav_right').show();
            if($(window).width()<768){
                $('.page-content-bg').show();
            }
        }

    });
});

