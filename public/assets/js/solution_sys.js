new WOW().init();

$(function () {
    $(window).on('scroll', function () {
        var scrollTop = $(window).scrollTop();
        var heightHalf = $(window).height() / 3;
        var scrollHeight = scrollTop + heightHalf;
        var sysTab = $('.solution_list_wrap').offset().top;
        var solutionList01 = $('.solution_list01').offset().top;
        var solutionList02 = $('.solution_list02').offset().top;
        var solutionList03 = $('.solution_list03').offset().top;
        var solutionList04 = $('.solution_list04').offset().top;
        var solutionList05 = $('.solution_list05').offset().top;
        var portfolioBox = solutionList05 + $('.solution_list05').height();


        // solution_sys_tab fixed;
        if (scrollTop >= sysTab) {
            $('.solution_sys_tab').addClass('fixed');
        } else {
            $('.solution_sys_tab').removeClass('fixed');
        }

        // solution_list

        if (scrollHeight >= solutionList01 && scrollHeight <= solutionList02) {
            $('.solution_list01').addClass('on');
            $('.solution_sys_tab li:nth-child(1)').addClass('on').siblings().removeClass('on');
        } else if (scrollHeight >= solutionList02 && scrollHeight <= solutionList03) {
            $('.solution_list02').addClass('on');
            $('.solution_sys_tab li:nth-child(2)').addClass('on').siblings().removeClass('on');
        } else if (scrollHeight >= solutionList03 && scrollHeight <= solutionList04) {
            $('.solution_list03').addClass('on');
            $('.solution_sys_tab li:nth-child(3)').addClass('on').siblings().removeClass('on');
        } else if (scrollHeight >= solutionList04 && scrollHeight <= solutionList05) {
            $('.solution_list04').addClass('on');
            $('.solution_sys_tab li:nth-child(4)').addClass('on').siblings().removeClass('on');
        } else if (scrollHeight >= solutionList05 && scrollHeight <= portfolioBox) {
            $('.solution_list05').addClass('on');
            $('.solution_sys_tab li:nth-child(5)').addClass('on').siblings().removeClass('on');
        } else {
            $('.solution_sys_tab li').removeClass('on');
        }

        if (scrollTop >= portfolioBox) {
            $('.solution_sys_tab').hide();
        } else {
            $('.solution_sys_tab').show();
        }

    })

    //solution_list_tab button 클릭
    // .solution_list_tab_cont  .on 추가는 show/hide
    // .solution_list_tab_cont  .active 추가는 animation
    $('.solution_list_tab button').on('click', function () {
        var idx = $(this).index();
        $(this).addClass('on').siblings().removeClass('on');
        $('.solution_list_tab_cont').eq(idx).addClass('on').siblings().removeClass('on');
        setTimeout(function () {
            $('.solution_list_tab_cont').eq(idx).addClass('active').siblings().removeClass('active');
        }, 10);
    })


    // 제일 하단 solution_btn 클릭
    $(".solution_btn").on('click', function () {
        $('.inquiry_box').css({
            'display': 'block',
            'position': 'absolute;'
        });
        if ($(window).width() < 720) {
            $('html').css({ 'overflow': 'auto', 'height': '100%' });
            $('#element').off('scroll touchmove mousewheel');
        } else {
            $('html').css({ 'overflow': 'hidden', 'height': '100%' });
            $('#element').on('scroll touchmove mousewheel', function (event) { event.preventDefault(); event.stopPropagation(); return false; });
        }
    });


})