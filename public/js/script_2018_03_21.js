function responsive(){

   var $wh = $(window).width();


   if ($wh <= 736)
   {
	  $("body").removeClass("web");
      $("body").addClass("mobile");
   }else{
      $("body").removeClass("mobile");
	  $("body").addClass("web");
   }
}
$(function(){
   $( window ).load(function() {
      responsive();
   });
   $( window ).resize(function() {
      responsive();
   });
});


//gnb
$(document).ready(function(){
	$("#gnb > ul > li").mouseover(function(){
		if($("body").hasClass("web")){
			$("#gnb > ul > li > .depth_list").stop().slideUp("");
			$(this).find(".depth_list").stop().slideDown("");
			$("#gnb > ul > li").removeClass("active");
			$(this).addClass("active");
		}
	});
	$("#gnb > ul > li").mouseout(function(){
		if($("body").hasClass("web")){
			$("#gnb > ul > li > .depth_list").stop().slideUp("");
			$("#gnb > ul > li").removeClass("active");
		}
	});
});


//검색
$(document).ready(function(){
	$(".btn_search_mo").click(function(){
		if($("body").hasClass("mobile")){
			$(".header_middle .search_form").toggle();
			$(this).toggleClass("active");
		}
	});
});

//주 메뉴 스크립트
$(document).ready(function(){
	$("#gnb > .gnb_list > li > a").click(function(e){
		if($("body").hasClass("mobile")){
			var $con = $(this).next(".depth_list");
			if($con.is(":visible")) {
				$con.slideUp();
				$(".gnb_list > li > a").removeClass("active");
			} else {
				$(".gnb_list > li > .depth_list:visible").slideUp();
				$(".gnb_list > li > a").removeClass("active");
				$(this).addClass("active");
				$con.slideDown();
			}
				//e.preventDefault();
		}
	});
	var toggle=0;
	$(".gnb_menu").click(function(e){
		if($("body").hasClass("mobile")){
			if(toggle == 0){
				$("#gnb").stop().slideToggle("slow");
				$("#header").addClass("active");
				$(".gnb_bg").show();
				$(this).addClass("on");
				//e.preventDefault();
				return toggle=1;
			}else if(toggle == 1){
				$("#gnb").stop().slideToggle("slow");
				$(".gnb_menu").removeClass("on");
				$("#header").removeClass("active");
				$(".gnb_bg").hide();
				return toggle=0;
			}
		}
	});
	/*$(".gnb_bg").click(function(){
		if(toggle==1){
			$("#gnb").removeClass("on");
			$(".gnb_menu").removeClass("on");
			$(".gnb_bg").hide();
			return toggle=0;
		}
	});*/

})

//서브상단 메뉴 및 active효과
$(document).ready(function(){
	$(".loc_nav > li > .sub_loc_active , .sub_btn").click(function(e){
		$(".dep02").stop().slideToggle();
		$(this).toggleClass("on");
		e.preventDefault();
	});

	/*var slider = $('.main_visual_slide').bxSlider({
			mode:"fade",
			auto:true,
			pause: 5000,
			speed: 800,
			controls:false
		});*/
	//모바일 서브 탭메뉴 슬라이드
	$(".st_menu_mo .stm_tit").click(function(){
		$(this).toggleClass("active");
		$(this).next("ul").slideToggle(200);
	});
	//서브위치active스크립트
	var $smenu=$('.gnb_list li, .dep_03 li , .depth_01 li');
	var $stmenu=$('.bing li');
	var $locTxt=$('h2.sub_tit').text();
	var $slocTxt=$('.bing').text();
	for (var i=0; i<$smenu.length; i++){
		var menutxt=$.trim($smenu.eq(i).find('>a').text());
		var loctxt=$.trim($locTxt);
		if (menutxt == loctxt){
			$smenu.eq(i).addClass('active');
			$stmenu.eq(i).addClass('on');
		}
	}
	for (var i=0; i<$stmenu.length; i++){
		var menutxt=$.trim($stmenu.eq(i).find('>a').text());
		var loctxt=$.trim($slocTxt);
		if (menutxt == loctxt){
			$smenu.eq(i).addClass('active');
			$stmenu.eq(i).addClass('on');
		}
	}
	$(".sub_loc_active").text($locTxt);
	$(".stm_tit").text($locTxt);
});
//유튜브 영상 팝업
$(document).ready(function(){
	var $v_link = $('.youtube_layer iframe')
	var videoURL = $v_link.prop('src');
		videoURL += "&autoplay=1";
	$(".btn_video").click(function(e){
		$v_link.prop('src',videoURL);
		$(".layer_bg").stop().fadeIn("fast");
		$(".youtube_layer").stop().fadeIn("fast");
		e.preventDefault();
		$(".youtube_layer .btn_close,.layer_bg").click(function(e){
			videoURL = videoURL.replace("&autoplay=1", "");
			$v_link.prop('src','');
			$v_link.prop('src',videoURL);
			$(".layer_bg").stop().hide();
			$(".youtube_layer").stop().hide();
			e.preventDefault();
		});
	});

	$('a[href^="#wrap"],a[href^="#content01"],a[href^="#content02"],a[href^="#content03"]').on('click',function (e) {
		e.preventDefault();
		var target = this.hash,
		$target = $(target);
		var ta = $target.offset().top;
		$('html, body').stop().animate({
			'scrollTop': ta
		}, 500, function () {
			//window.location.hash = target;
		});
	});
});

//모바일 테이블 화살표
$(function(){
	$(".ta_overwrap").scroll(function(){
		var sl = $(this).scrollLeft();
		if(sl > 5){
			$(this).find(".more_arrow").fadeOut("fast");
		}else{
			$(this).find(".more_arrow").fadeIn("fast");
		}
	});
});



$(function(){
	$(".system_configuration > b").on("click",function(){
		$(this).toggleClass("active");
		$(this).next(".box_in").slideToggle(200);
	});
});

$(function(){
	$(".all_menu ").on("click",function(){
		$(this).toggleClass("on");
		$("#sub_gnb").toggleClass("on");
	});
});


$(function(){
	$(".system_configuration2 > b").on("click",function(){
		$(this).toggleClass("active");
		$(this).next(".box_in").slideToggle(200);
	});
});
//언어 선택
$(function(){
	$(".language_down > a").on("click",function(){
		$(this).next(".lang_depth").stop().slideToggle(200);
	});
});
$(document).ready(function(){
	$(".lang_depth li a").click(function(){ //탭 클릭시
			$(".lang_depth li a").removeClass("active");
			$(this).addClass("active");
	});
});
//헤더 검색창
$(function(){
	$(".find_box ").on("click",function(){
		$(".input_form").stop().slideToggle("fast");
	});
});

//전체 메뉴창
$(function(){
	$(".w_gnb_menu").on("click",function(){
		$(this).toggleClass("on");
		$(".all_gnb").stop().slideToggle("500");
	});
});

//모바일 언어 선택
$(document).ready(function(){
	$(".languge_select > a").on("click",function(){
		$(this).next(".footer_languge").stop().slideToggle(200);
	});
	$(".footer_languge li").click(function(){ //탭 클릭시
			$(".footer_languge li").removeClass("active");
			$(this).addClass("active");
	});
});

//가격 메뉴 스크립트
$(document).ready(function(){
	$(".table_gnb , .price_nav > li  , h3.price_tit").click(function(e){
		$(".price_nav").stop().slideToggle();
		$(this).toggleClass("on");
		e.preventDefault();
	});


});

$(document).ready(function(){
 $(".price_nav li").click(function(){
	$(".price_nav li").removeClass("active");
	$(this).addClass("active");
	var idx = $(this).attr('idx');
	$('.table_box').hide();
	$('.table_box').eq(idx).show();
 });
});

//상단 언어 카테고리
$(document).ready(function(){
	$(".lang_select > li  ").click(function(e){
		$(".lang_select > li").removeClass("active");
		$(this).addClass("active");
	});
});

//서브상단 메뉴 및 active효과
$(document).ready(function(){
	$(".sub_gnb > .wrap_1000 > ul > li > a ").click(function(e){
		$(this).next(".dep_05").stop().slideToggle("slow");
	});
});

//product 메뉴 active효과
$(document).ready(function(){
	$(".sub_product_gnb > li").click(function(e){
		$(".sub_product_gnb > li").removeClass("active");
		$(this).addClass("active");
	});
});
//product 상세보기 탭메뉴
$(document).ready(function(){
 $(".product_tab ul li").click(function(){
	$(".product_tab ul li").removeClass("active");
	$(this).addClass("active");
	var idx = $(this).attr('idx');
	$('.add_explanation_txt').hide();
	$('.add_explanation_txt').eq(idx).show();
 });
});

//product 상세보기 제품 메뉴
$(document).ready(function(){
	/*$('.product_big ul').bxSlider({
		mode:'horizontal', //default : 'horizontal', options: 'horizontal', 'vertical', 'fade'
		speed:1000, //default:500 이미지변환 속도
		auto: false, //default:false 자동 시작
		captions: false, // 이미지의 title 속성이 노출된다.
		autoControls: false,//default:false 정지,시작 콘트롤 노출, css 수정이 필요
		controls:true,
		pagerCustom: '.bx-pager',
		autoDelay: 4000
	});*/
});

//특허/인증서 gnb
$(document).ready(function(){
 $(".patent_gnb ul li").click(function(){
	$(".patent_gnb ul li").removeClass("active");
	$(this).addClass("active");
	var idx = $(this).attr('idx');
	$('.patent_list').hide();
	$('.patent_list').eq(idx).show();
 });
});

$(function(){
	$(".btn_zzim,.btn_vs,.btn_share").click(function(e){
		$(this).toggleClass("active");
		return false;
	});
});

// 비교하기 버튼 보기
$(document).ready(function(){
	$(".btn_vs").mouseover(function(){
			$(".btn_vsmore").hide();
			$(this).next(".btn_vsmore").show();
	}).mouseleave(function(){
		$(".btn_vsmore").hide();
	});

	$(".btn_vsmore").mouseover(function(){
		$(this).show();
	}).mouseleave(function(){
		$(this).hide();
	});
});



$(function(){
	$(".btn_gnb_mo,.gnb_bg").on("click",function(){
		if($("body").hasClass("mobile")){
			$("html").toggleClass("gnbOpen");
			$("html").removeClass("snb_detail_open");
			$("html").removeClass("snb_search_open");
		}
	});

	//모바일 제품 검색
	$(".snb_search01_in .set").on("click",function(){
		if($("body").hasClass("mobile")){
			$("html").toggleClass("snb_search_open");
			$("html").removeClass("snb_detail_open");
			$("html").removeClass("gnbOpen");
		}
	});

	$(document).on("click",".btn_detil_fi,.snb_detail_open .layer_bg",function(){
		if($("body").hasClass("mobile")){
			$("html").toggleClass("snb_detail_open");
			$("html").removeClass("gnbOpen");
			$("html").removeClass("snb_search_open");
			$(".btn_detil_fi").toggleClass("active");
		}
	});
	/*$(".gnb_list .btn_dep02 > a").on("click",function(e){
		$(this).parent(".btn_dep02").toggleClass("on");
		e.preventDefault();
	});
	$(".gnb_list .btn_dep03 > a").on("click",function(e){
		$(this).parent(".btn_dep03").toggleClass("on");
		e.preventDefault();
	});*/
});

$(document).ready(function(){
	if( $('body').hasClass('moblie')){
		$('body').css({'background-color':'red'})

	}



	//$('.snb_submenu li a').hover(function(){
		//alert('3')
	//});
});


/* 모바일 마이페이지 메뉴 */
function moblie_sub(){
	$('.moblie_sub_menu').css({'display':'none'});
	
	
};


function moblie_sub_slide(){
	var $wh = $(window).width();

   if ($wh <= 736)
   {
	  $('.moblie_menu').css({'display':'block'});
	  $('.web_menu').css({'display':'none'});
		if($('section').hasClass('my_shopping')){
			$('.moblie_sub1').addClass('active');
			sub_mune01();
		}
		if($('section').hasClass('my_coupon')){
			$('.moblie_sub2').addClass('active');
			sub_mune02();
		}
		if($('section').hasClass('my_active')){
			$('.moblie_sub3').addClass('active');
			sub_mune03();
		}
		if($('section').hasClass('my_info')){
			$('.moblie_sub4').addClass('active');
			sub_mune04();
		}
   }else{
	  $('.moblie_menu').css({'display':'none'});
	  $('.web_menu').css({'display':'block'});
	  $('.moblie_sub_menu').css({'display':'none'});
   }
	
};
$(function(){
	$(window).load(function(){
		 moblie_sub_slide();
	});
	$(window).resize(function(){
		 moblie_sub_slide();
	});
});


function sub_mune01(){
	$('.moblie_sub_menu').css({'display':'none'});
	$('.submenu_01').css({'display':'block'});
	$('#snb > .submenu_01').slick({
		  slidesToShow:3.5,
		  slidesToScroll: 1,
		  arrows: false,
		  autoplay: false,
		  infinite: false
	});
	
	$('.submenu_01').slick('setPosition');
};
function sub_mune02(){
	$('.moblie_sub_menu').css({'display':'none'});
	$('.submenu_02').css({'display':'block'});
	$('#snb > .submenu_02').slick({
		  slidesToShow:2,
		  slidesToScroll: 1,
		  arrows: false,
		  autoplay: false,
		  infinite: false
	});
	
	$('.submenu_02').slick('setPosition');
};
function sub_mune03(){	
	$('.moblie_sub_menu').css({'display':'none'});
	$('.submenu_03').css({'display':'block'});
	$('#snb > .submenu_03').slick({
		  slidesToShow:2,
		  slidesToScroll: 1,
		  arrows: false,
		  autoplay: false,
		  infinite: false
	});
	
	$('.submenu_03').slick('setPosition');
};
function sub_mune04(){	
	$('.moblie_sub_menu').css({'display':'none'});
	$('.submenu_04').css({'display':'block'});
	$('#snb > .submenu_04').slick({
		  slidesToShow:3,
		  slidesToScroll: 1,
		  arrows: false,
		  autoplay: false,
		  infinite: false
	});
	
	$('.submenu_04').slick('setPosition');
};

$(document).ready(function(){
		
		moblie_sub();
		$('.moblie_sub_menu li a').removeClass('active');
		$('.moblie_sub_menu li:first-child a').addClass('active');


		$('.moblie_menu li a').on('click',function(){
			$('.moblie_menu li a').removeClass('active');
			$(this).addClass('active');

			//$('.moblie_sub_menu').css({'display':'none'});
			$('.moblie_sub_menu li a').removeClass('active');
			$('.moblie_sub_menu li:first-child a').addClass('active');
				
		});
		$('.moblie_sub_menu li a').hover(function(){
			//alert('33')
			$('.moblie_sub_menu li a').removeClass('active');
			$(this).addClass('active');
		});

		$('.moblie_sub1').on('click',function(){
			sub_mune01();
		});
		$('.moblie_sub2').on('click',function(){
			sub_mune02();
			
		});
		$('.moblie_sub3').on('click',function(){
			sub_mune03();
		});
		$('.moblie_sub4').on('click',function(){
			sub_mune04();
			
		});				
});

$(document).ready(function(){
  //비교하기 세션가져오기
  var btn_vs_array = $.session.get('btn_vs');
  //비교하기 클래스 active 주기
  $(".btn_vs").each(function(){
    var code_no =$(this).attr("code_no");
    if(btn_vs_array){//세션목록이 있을때 실행
      btn_vs =btn_vs_array.split('|');
      for (var i = 0; i < btn_vs.length; i++) {
        if(btn_vs[i] == code_no){
            $(this).addClass("active");
        }
      }
    }
  });

  //vs비교하기 이동하기
  $(".btn_vsmore").click(function(e){
    e.preventDefault();
    location.href="/item/vs_list.php";
  });
});
