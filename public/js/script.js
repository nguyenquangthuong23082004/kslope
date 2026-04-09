$(function(){
    // common
    $(window).on('scroll', function(){
        if($(window).scrollTop() > 0){
          $('#header').addClass('fix');
        }else{
          $('#header').removeClass('fix');
        }
      });


      $('.gnb .depth01 button').on('mouseenter',function(){
        $(this).parent('li').siblings().removeClass('on');
        $(this).parent('li').toggleClass('on');

        $('.gnb .depth02').hide();
        $(this).next().toggle();
      })

      $('.gnb').on('mouseleave',function(){
        $('.gnb .depth02').hide();
      })

    // 전체메뉴 열기
    $('#header .ham_btn').on('click', function(){
        $('.all_menu_wrap').addClass('open');
        $('html').addClass('overflow');
    })

    // 전체메뉴 닫기
    $('.all_menu_wrap .all_menu_close').on('click', function(){
        $('.all_menu_wrap').removeClass('open');
        $('html').removeClass('overflow');
    })

    // 전체메뉴 2차메뉴 열기
    $('.all_menu_wrap button.all_menu01').on('click', function(){
        if($(this).hasClass('on')) {
            $(this).removeClass('on');
            $(this).next('.all_menu02').slideUp();
        } else {
            $('button.all_menu01').removeClass('on');
            $('.all_menu_wrap .all_menu02').slideUp();
            $(this).addClass('on');
            $(this).next('.all_menu02').slideDown();
        }
    })

    $('.quick_btn').click(function(){
        $('.quick_box .quick_list').toggle();
        $(this).toggleClass('on');
    })

    // top btn
    $('.top_btn').on('click', function(){
        $('html, body').animate({
            scrollTop: 0
        }, 1000);
    })

    // sub_nav 관련 스크립트
    var folder = $('#container').attr('data-folder');
    var page = $('#container').attr('data-page');
    if(folder != undefined && folder != '') {
        if(!(folder == 'mypage')) {
            //모바일에서 필요한 클래스입니다
            $('#header').addClass('sub_v');
        }
        $('#header .gnb ul li[data-depth="' + folder + '"]').addClass('on');
        $('.sub_nav ul[data-depth01="' + folder + '"]').addClass('on');
    }
    if(page != undefined && page != '') {
        $('.sub_nav li a[data-depth02="' + page + '"]').addClass('on');
        
        // mobile sub_nav scroll
        if($(window).width() <= 768) {
            $('.sub_nav').scrollLeft($('.sub_nav li a.on').offset().left - 15);
        }
    }

    // footer
    $('.family_site button').click(function () {
        $('.family_site').toggleClass('active');
        $('.family_site ul').slideToggle();
    });

    $('.popup_wrap .close').click(function(){
        $('.popup_wrap').hide();
    });

    $('.popup .close').click(function(){
        $('.popup').hide();
    })

})

// 파일 업로드 
$(document).ready(function () {



    var fileTarget = $('#ufile1');
    fileTarget.on('change', function () { // 값이 변경되면
        //var cur = $(fileTarget).val();
        let fileName = "";
        if(window.FileReader) {  // modern browser
            if($(this)[0].files[0]){
                fileName = $(this)[0].files[0].name;
            }
        }else{  // old IE
            fileName = $(this).val().split('/').pop().split('\\').pop();  // 파일명만 추출
        }
        $("#upload1").val(fileName);
    });

    var fileTarget2 = $('#ufile2');
    fileTarget2.on('change', function () { // 값이 변경되면
        //var cur2 = $(fileTarget2).val();
        let fileName = "";
        if(window.FileReader) {  // modern browser
            if($(this)[0].files[0]){
                fileName = $(this)[0].files[0].name;
            }
        }else{  // old IE
            fileName = $(this).val().split('/').pop().split('\\').pop();  // 파일명만 추출
        }
        $("#upload2").val(fileName);
    });
    var fileTarget3 = $('#ufile3');
    fileTarget3.on('change', function () { // 값이 변경되면
        //var cur3 = $(fileTarget3).val();
        let fileName = "";
        if(window.FileReader) {  // modern browser
            if($(this)[0].files[0]){
                fileName = $(this)[0].files[0].name;
            }
        }else{  // old IE
            fileName = $(this).val().split('/').pop().split('\\').pop();  // 파일명만 추출
        }
        $("#upload3").val(fileName);
    });
});
