function responsive(){

   var $wh = $(window).width();


   if ($wh <= 736)
   {
	  $("body").removeClass("web");
      $("body").addClass("mobile");
		$('#gnb_web .gnb_list > li').removeClass('active');
		
		//$('.ico_mypage img').attr('src','/img/ico/mypage02.png');
		//$('.ico_cart img').attr('src','/img/ico/cart02.png');
		//$('h1.logo img').attr('src','/img/main/logo_w.png');
		$(".recommend .img_box img").height($(".itme_type01 .thum_img").width());
   }else{
      $("body").removeClass("mobile");
	  $("body").addClass("web");
	    $('#gnb_web .gnb_list > li').removeClass('active');
		
		//$('.ico_mypage img').attr('src','/img/ico/mypage01.png');
		//$('.ico_cart img').attr('src','/img/ico/cart01.png');
		//$('h1.logo img').attr('src','/img/main/logo.png');
		$(".recommend .img_box img").height($(".recommend .img_box img").width());
   }
}
$(function(){
	if($(window).width() > 1959){
		$(".main .aside_right").css({"right":"14%"});
		//$(".main .aside_left").css({"left":"15%"});
	}
	
});
function CategoryList(e){
		var $Loac = window.location.href;
		var e = $Loac 
		/*if( e == 'http://comedak.com/main/main.php' || e == 'http://www.comedak.com/main/main.php'){
			return false;
			
		}*/
		$('.btn_category').removeClass('on');
			$('#category .cg_list').css({'display':'none'});
			$(".btn_category").mouseenter(function(){
				$(this).addClass("on");
				$(this).next(".cg_list").show();
			});
			$("#category").mouseleave(function(){
				$(this).children(".btn_category").removeClass("on");
				$(this).children(".cg_list").hide();
			});

			/*$('.cg_list > li > a').css({
					'background':'#585858',
					
			});
		

			$('.cg_list > li > a').hover(function(){
				$(this).css({
					'color':'#333',
					'background':'#fff',
					
					/*'border-top':'1px solid #fff',
					'border-bottom':'1px solid #fff',*/
				/*});
			},function(){
				$(this).css({
					'color':'#fff',
					'background':'#585858',
				});
			});*/

		


	}

$(function(){
   $( window ).load(function() {
      responsive();
	   
   });
   $( window ).resize(function() {
      responsive();
   });

   $(document).ready(function(){
		CategoryList();
   });
});


//gnb
$(document).ready(function(){
	$("#gnb_web > ul > li").mouseover(function(){
		if($("body").hasClass("web")){
			$("#gnb_web > ul > li > .depth_list").stop().slideUp("");
			$(this).find(".depth_list").stop().slideDown("");
			$("#gnb_web > ul > li").removeClass("active");
			$(this).addClass("active");
		}
	});
	$("#gnb_web > ul > li").bind('touchstart',function(){
		$("#gnb_web > ul > li").removeClass('active');
		$(this).addClass('active');
	});
	$("#gnb_web > ul > li").mouseout(function(){
		if($("body").hasClass("web")){
			$("#gnb_web > ul > li > .depth_list").stop().slideUp("");
			$("#gnb_web > ul > li").removeClass("active");
		}
	});
	
	
	//if( )

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
$(document).ready(function(){
	$('.date_form').on('click',function(){
		$('.ui-datepicker.ui-widget.ui-widget-content.ui-helper-clearfix.ui-corner-all:before').css({'display':'block'});

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

$(document).bind( "ajaxComplete ready", function(){
	
	$(".btn_zzim,.btn_vs").unbind('click');
	$(".btn_zzim,.btn_vs").click(function(e){
		$(this).toggleClass("active");
		$(".btn_zzim,.btn_vs").bind('click');
		return false;
		//,.btn_share
	});

});

// 비교하기 버튼 보기
/*
$(document).ready(function(){
	$(".btn_vs").mouseover(function(){
		console.log("up");
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


*/

$(document).bind( "ajaxComplete ready", function(){
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
			//$("html").removeClass("snb_detail_open");
			$("html").removeClass("snb_search_open");
			$("html").removeClass('detail_tab_open');
		}
	});

	//모바일 제품 검색
	$(".snb_search01_in .set").on("click",function(){
		if($("body").hasClass("mobile")){
			$(".btn_detil_fi").removeClass("active");
			$("html").toggleClass("snb_search_open");
			//$("html").removeClass("snb_detail_open");
			$("html").removeClass("gnbOpen");
			$("html").removeClass('detail_tab_open');
		}
	});
	

	$(document).on("click",".btn_detil_fi,.snb_detail_open .layer_bg,.close_btn,.item_detail_tab button",function(){
		if($("body").hasClass("mobile")){
			//$("html").toggleClass("snb_detail_open");
			$("html").removeClass("gnbOpen");
			$("html").removeClass("snb_search_open");
			$(".btn_detil_fi").toggleClass("active");
			$("html").toggleClass('detail_tab_open');
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

		// 서브 모바일 상단 메뉴
		$('.moblie_sub_menu li a').bind('touchstart',function(){
			//alert('33')
			$('.moblie_sub_menu li a').removeClass('active');
			$(this).addClass('active');
				
		
		});
		$('.moblie_sub_menu li a').each(function(){
			if($(this).hasClass('active')){
				$(this).bind('touchend',function(e){
					var event = e.originalEvent;
					var $link = $(this).attr('href');
					window.location.href = $(this).attr('href');
					 e.preventDefault();
				});
			}
		
		})
		
		

		//$('.moblie_sub_menu li a').on('click',function(){
			
		//	var $link = $(this).attr('href');

		//	window.loaction = $link
			//alert($link)
		//});

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

$(document).bind( "ajaxComplete ready", function(){
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

$(document).ready(function(){
	$('.more_box > button').on('click',function(){
	
		//$(this).siblings('.more_item').css({'display':'none'});
		if(!$('.more_item').hasClass('active')){
			$('.more_item').addClass('active');
			//$('.more_item').css({'display':'block'});
		}else{
			$('.more_item').removeClass('active');
			//$('.more_item').css({'display':'none'});
		}
	});
});


 // 걷go,먹go,쉬go
$(document).ready(function(){

	$('.main_tabmenu .tabmenu > li').mouseenter(function(){
		//alert('33')
		//$('.main_tabmenu .tabmenu > li').find('.depth02').css({'display':'none'});
		//$(this).find('.depth02').css({'display':'block'});
		$(this).addClass('active');
		if($('body').width()<=736){
			$(this).find('.depth02').css({'display':'none'});		
		}
	});

	$('.main_tabmenu .tabmenu > li').mouseleave(function(){
		$(this).removeClass('active');
		//$(this).find('.depth02').css({'display':'none'});
	});


	/*$('.main_tabmenu .tabmenu > li > a').on('click',function(){
		if($('body').width()<=736){
			$('.main_tabmenu .tabmenu > li > a').css({'cursor':'pointer'});
			var $link = $(this).attr('data-link');
			//alert($link)
			window.location.href = $(this).attr('data-link');
			
		}	
		
	});*/
	$('.main_tabmenu .tabmenu > li > a').bind('touchend click',function(){
				$('.main_tabmenu .tabmenu > li > a').css({'cursor':'pointer'});
				var $link = $(this).attr('data-link');
				if(!$(this).attr('target','blank')){
					
				}
				setTimeout( function() {
					
					window.location.href = $link;
				  }, 500);
			});
	$('.main_tabmenu .tabmenu > li .depth02 h2').on('touchstart click',function(){
		window.location.href = $(this).attr('data-link');	
	});
});


function CreateBookmarkLink(){
	var _title = document.title;
	var _url = document.location.href;

	if (window.sidebar && window.sidebar.addPanel){ // Firefox
		window.sidebar.addPanel(_title, _url,"");
	}else if(navigator.userAgent.indexOf("Chrome") > 0 || navigator.userAgent.indexOf("Safari") > 0 ){
		alert("북마크를 하시려면 Ctrl+D를 눌러주세요.");
	}else if (window.external) { // IE
		window.external.AddFavorite(_url, _title);
	}else if (window.opera && window.print) {
		window.external.AddFavorite(_url, _title);
	}else{
		alert("브라우저에서 북마크를 추가해주십시오");
	}

	/* user function
		<a href="javascript:CreateBookmarkLink();">Add to Favorites/Bookmark</a>
	*/
}

//오늘하구 열지 않기
// Get cookie function
function getCookie(name) { 
   var cookieName = name + "=";
   var x = 0;
   while ( x <= document.cookie.length ) { 
      var y = (x+cookieName.length); 
      if ( document.cookie.substring( x, y ) == cookieName) { 
         if ((lastChrCookie=document.cookie.indexOf(";", y)) == -1) 
            lastChrCookie = document.cookie.length;
         return decodeURI(document.cookie.substring(y, lastChrCookie));
      }
      x = document.cookie.indexOf(" ", x ) + 1; 
      if ( x == 0 )
         break; 
      } 
   return "";
}


$(window).load(function(){
	var $Brand_Length = $('.brand_filter li').length;
	$('.brand_filter02 li').each(function(i){
		i = i % 6;
		$(this).find('.brand_info').css({

			'left': i*-163 + 'px'
		});

		$(this).find('.brand_info .triangle01').css({
								
			'left':i*162 + 73 + 'px'
		});

									 
	});

});
$(document).ready(function(){
			function Mdpick() {
				setInterval(function(){ 
					$('.md_pick').toggleClass('on');
				 }, 300);
			}
			Mdpick();
});

function LayerBg(){	
	var $Height = $('#wrap').height();
	$('.layer_bg').height($Height - 276);
}

$(window).load(function(){	
	LayerBg();	
});
$(window).resize(function(){	
	LayerBg();	
});



	function Above(){
		$('span.above').each(function(){
			var $Length = $(this).siblings('strong').html().length;
			var $Width1 = $(this).width();
			var $Width2 = $(this).siblings('strong').width();
			
			
			
			
			$Length = $Length -1 ;
			console.log($Width3)
			 var $wh = $(window).width();
			
			/*$(this).attr('style','right:'+$Windth2+'px')
			$(this).css({'display':$Windth3+'px'});*/


			if ($wh <= 850) {
				var $Width3 = $Width2 - $Width1;
				$(this).attr('style','right:'+ $Width3 + 'px');

			} else {
				var $Width3 = $Width2 - $Width1 + 26;
				$(this).attr('style','right:'+ $Width3 + 'px');
				
			}	
		});


	}

	
	$(window).load(function(){
		Above();
	
	});
	$(window).resize(function(){
		Above();
		
	});
