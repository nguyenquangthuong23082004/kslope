<?
	include_once $_SERVER['DOCUMENT_ROOT']."/include/lib.inc.php"; 

	if ($_SESSION[member][id] != "admin") {
		header('Location:/AdmMaster/');
		exit();
	}
	
	// 권한 확인하여 링크 표시
	function check_perm($code, $url, $title){
		$link = "<a href='$url'>$title</a>";
		return $link;
	}


	// 탑 메뉴
	if($top_menu == ""){
		// 게시판
		if(strpos($_SERVER[PHP_SELF], "/AdmMaster/_bbs/") !== false){
			// 환경설정
			if($_SERVER[PHP_SELF] == "/AdmMaster/_bbs/fair_opt.php")
				$top_menu = "config";
			// 고객센터
			else if(in_array($code, array("notice1", "qna_group", "suggest", "faq", "contact", "notice")))
				$top_menu = "bbs_1";
			// 커뮤니티
			else if(in_array($code, array("review", "knowhow", "gallery")))
				$top_menu = "bbs_2";
			// 기타 게시판
			else if(in_array($code, array("free", "press", "fair")))
				$top_menu = "bbs_3";
			// 등록 관리
			else if(in_array($code, array("isec", "pickup")))
				$top_menu = "regi";
		}
		// CMS
		else if(strpos($_SERVER[PHP_SELF], "/AdmMaster/_cms/") !== false ){
			// 기타 게시판
			if(in_array($code, array("event", "exibition", "jarubook")))
				$top_menu = "bbs_3";
			else 
				$top_menu = "config";
		}
		else if(strpos($_SERVER[PHP_SELF], "/AdmMaster/_inquiry/") !== false ){
			$top_menu = "_inquiry";
		}
		// 등록관리
		else if(strpos($_SERVER[PHP_SELF], "/AdmMaster/_regi/") !== false ){
			$top_menu = "regi";
		}
		else if(strpos($_SERVER[PHP_SELF], "/AdmMaster/_code/") !== false || strpos($_SERVER[PHP_SELF], "/AdmMaster/_tourStay/") !== false  || strpos($_SERVER[PHP_SELF], "/AdmMaster/_tourSights/") !== false  || strpos($_SERVER[PHP_SELF], "/AdmMaster/_tourCountry/") !== false || strpos($_SERVER[PHP_SELF], "/AdmMaster/_tourGuide/") !== false ){
			$top_menu = "regi";
		}
		else if(strpos($_SERVER[PHP_SELF], "/AdmMaster/_tourRegist/") !== false ){
			$top_menu = "regi";
		}    
		// 여행예약관리
		else if(strpos($_SERVER[PHP_SELF], "/AdmMaster/_tour/") !== false || strpos($_SERVER[PHP_SELF], "/AdmMaster/_reservation/") !== false || strpos($_SERVER[PHP_SELF], "/AdmMaster/_guide/") !== false || strpos($_SERVER[PHP_SELF], "/AdmMaster/_coupon/") !== false || strpos($_SERVER[PHP_SELF], "/AdmMaster/_mileage/") !== false ||strpos($_SERVER[PHP_SELF], "/AdmMaster/_pass/") !== false ){
			$top_menu = "reserve";
		} 
		// 인트라넷
		else if(strpos($_SERVER[PHP_SELF], "/AdmMaster/_memberBoard") !== false || strpos($_SERVER[PHP_SELF], "/AdmMaster/_schedule/") !== false  || strpos($_SERVER[PHP_SELF], "/AdmMaster/_memberBreak/") !== false ){
			$top_menu = "intra";
		// 회원관리
		}
		else if(strpos($_SERVER[PHP_SELF], "/AdmMaster/_member") !== false){ 
			$top_menu = "member";
		}
		// 로그분석기
		else if(strpos($_SERVER[PHP_SELF], "/AdmMaster/_logAnalysis") !== false){
			$top_menu = "analysis";
		}
		// 기존웹사이트
		else if(strpos($_SERVER[PHP_SELF], "/AdmMaster/_admold") !== false){
			$top_menu = "admold";
		}
		// B2B등록
		else if(strpos($_SERVER[PHP_SELF], "/AdmMaster/_b2b") !== false ){
			$top_menu = "b2b";
		}
		// 상담관리
		else if(strpos($_SERVER[PHP_SELF], "/AdmMaster/_consult/") !== false ){
			$top_menu = "consult";
		}
		// 환경설정
		else if(strpos($_SERVER[PHP_SELF], "/AdmMaster/_adminrator/") !== false || strpos($_SERVER[PHP_SELF], "/AdmMaster/_codeBanner/") !== false ){
			$top_menu = "config";
		}
	}


	//echo "top_menu : " . $top_menu ."<br/>";

?>
<!--[if lt IE 7]>      <html class="ie6"> <![endif]-->
<!--[if IE 7]>         <html class="ie7"> <![endif]-->
<!--[if IE 8]>         <html class="ie8"> <![endif]-->
<!--[if gt IE 8]><!--><!DOCTYPE HTML><!--<![endif]-->
<html lang="ko">
<head>
<title><?=_IT_SITE_NAME?></title>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="apple-mobile-web-app-title" content="">
<!--
<link rel="shortcut icon" type="image/x-icon" href="/AdmMaster/_images/favicon.ico">
-->
<link rel="apple-touch-icon" href="/AdmMaster/_images/apple-touch-icon.png" />
<meta name="Generator" content="">
<meta name="Author" content="">
<meta name="Keywords" content="">
<meta name="Description" content="">
<link rel="stylesheet" href="/AdmMaster/_common/css/import.css" type="text/css" />
<script type="text/javascript" src="/AdmMaster/_common/js/jquery-1.8.3.min.js"></script>
<!--[if lte IE 9]>
<script src="/AdmMaster/_common/js/html5.js"></script>
<script src="/AdmMaster/_common/js/respond.min.js"></script>
<![endif]-->


<link rel="stylesheet" href="/js/jquery-ui-1.11.2.custom/jquery-ui.css">
<script type="text/javascript" src="/js/jquery.number.js"></script>
<script src="/js/jquery-ui-1.11.2.custom/jquery-ui.js"></script>
<script src="/js/notifIt.js" type="text/javascript"></script>
<script src="/js/jquery.number.js" type="text/javascript"></script>
<link href="/js/notifIt.css" type="text/css" rel="stylesheet">

<link rel="stylesheet" href="/js/colorbox-master/example4/colorbox.css" />
<script src="/js/colorbox-master/jquery.colorbox.js"></script>



<!--notice 스크립트끝-->
<script src="/js/common.js"></script>
<script src="/js/jquery.form.js"></script>
<style type="text/css" >
.wrap-loading { /*화면 전체를 어둡게 합니다.*/
	position: fixed;
	left:0;
	right:0;
	top:0;
	bottom:0;
	z-index:999;
	background: rgba(0, 0, 0, 0.2); /*not in ie */
 filter: progid:DXImageTransform.Microsoft.Gradient(startColorstr='#20000000', endColorstr='#20000000');    /* ie */
}
.wrap-loading div { /*로딩 이미지*/
	position: fixed;
	top:50%;
	left:50%;
	margin-left: -21px;
	margin-top: -21px;
}
.display-none { /*감추기*/
	display:none;
}
</style>

<link rel="stylesheet" href="/AdmMaster/_common/css/pop.css" type="text/css" />
<script>
//화면의 중앙으로 팝업창 띄우기
 function PopUp(url, wName, width, height) {//화면의 중앙
  var LeftPosition = (screen.width/2) - (width/2);
  var TopPosition = (screen.height/2) - (height/2);
  var win = window.open(url, wName, "left="+LeftPosition+",top="+TopPosition+",width="+width+",height="+height);
  if(win == null){
   alert("팝업차단을 해제해주세요!");
  } else{
   win.focus();
  }
 }

//화면의 중앙으로 팝업창 띄우기..(스크롤포함)
 function PopUpWithScroll(url, wName, width, height) {//화면의 중앙
  var LeftPosition = (screen.width/2) - (width/2);
  var TopPosition = (screen.height/2) - (height/2);
  var win = window.open(url, wName, "left="+LeftPosition+",top="+TopPosition+",width="+width+",height="+height+",scrollbars=yes");
  if(win == null){
   alert("팝업차단을 해제해주세요!");
  } else{
   win.focus();
  }
 }
</script>

<script language="JavaScript">
<!--
var printpp

function bp() {
  printpp = document.body.innerHTML;
  document.body.innerHTML = print_this.innerHTML;
}

function ap() {
  document.body.innerHTML = printpp;
}

function pp() {
  window.print();
}

window.onbeforeprint = bp;
window.onafterprint = ap;
//-->
</script>
</head>
<body>
<div id="ajax_loader" class="wrap-loading display-none">
	<div><img src="/js/ajax-loader.gif"/></div>
</div>

	<div id="wrap">
		<header id="header">
			<div class="headerSet">
				
				<p class="pic" style="vertical-align:middle;" >
					<a href="/" target="_blank">
						<img src="<?=_IT_LOGOS?>" alt="<?=_IT_SITE_NAME?>" style="max-height:100px;max-width:100px;">
					</a>
				</p>

				<div class="settings">
					<p class="config"><b><?=$_SESSION[member][name]?></b> 님 <a href="/AdmMaster/_adminrator/adm_setting.php"><img src="/AdmMaster/_images/common/ico_setting.png" alt="설정" /></a> <!-- &nbsp;<a href="/AdmMaster/logout.php"><img src="/AdmMaster/_images/common/logout.png" alt="로그아웃" /></a>//--></p>

					<div class="config2">
						<h1><span class="col_yellow"><?=_IT_SITE_NAME?> 관리자</span></h1>
					</div>
				</div>

			</div><!-- // headerSet -->
			
			<div id="gnb" class="gnb_update">
				<ul class="gnb_menu">
					<li class="menu <? if($top_menu == "bbs_1" || $top_menu == "_inquiry") echo "on";?>">
						<a href="#!"><img src="/AdmMaster/_images/common/ico_gnb_01_1.png" alt="" /> <span class="tit">고객센터</span></a>
						<ul class="smenu" style="width:760px;">
							<li class="fir"><a href="/AdmMaster/_bbs/board_list.php?code=notice1">공지사항(국문)</a></li>
							<li class="end"><a href="/AdmMaster/_bbs/board_list.php?code=notice_en">공지사항(영문)</a></li>
						</ul>
					</li>   

					<li class="menu <? if($top_menu == "bbs_2") echo "on";?>">
						<a href="#!"><img src="/AdmMaster/_images/common/ico_gnb_02_1.png" alt="" /> <span class="tit">커뮤니티</span></a>
						<ul class="smenu" style="width:500px;">
							<li class="fir"><a href='/AdmMaster/_bbs/index.php?code=review'>여행 후기</a></li>
							<li><a href='/AdmMaster/_bbs/index.php?code=knowhow'>여행 지식</a></li>
							<li class="end"><a href='/AdmMaster/_bbs/index.php?code=gallery'>여행 갤러리</a></li>
						</ul>
					</li>

					
					
					<li class="menu <? if($top_menu == "reserve") echo "on";?>">  
						<a href="#!"><img src="/AdmMaster/_images/common/ico_gnb_05_1.png" alt="" /> <span class="tit">주문관리</span></a>
						<ul class="smenu" style="width:760px;margin-left:-200px;">
							<li class="fir"><a href='/AdmMaster/_reservation/list.php'>투어예약</a></li>
							<li><a href='/AdmMaster/_guide/list.php'>현지투어예약</a></li> 
							<li><a href='/AdmMaster/_coupon/list.php'>쿠폰리스트</a></li>
							<li><a href='/AdmMaster/_coupon/history.php'>쿠폰사용리스트</a></li>
							<li><a href='/AdmMaster/_mileage/list.php'>마일리지리스트</a></li>
							<li class="end"><a href='/AdmMaster/_mileageTrans/list.php'>마일리지양도</a></li>
						</ul>  
					</li>

					<li class="menu <? if($top_menu == "member") echo "on";?>">
						<a href="#!"><img src="/AdmMaster/_images/common/ico_gnb_06_1.png" alt="" /> <span class="tit">회원관리</span></a>
						<ul class="smenu" style="width:600px;margin-left:-200px;">
							<li class="fir"><a href='/AdmMaster/_member/list.php?s_status=Y'>일반회원</a></li>
							<li class=""><a href='/AdmMaster/_member/list.php?s_status=N'>탈퇴회원</a></li>
							<li class=""><a href='/AdmMaster/_memberAdmin/list.php'>자사회원</a></li>
							<li class=""><a href='/AdmMaster/_memberAdmin/blist.php'>B2B회원</a></li>
							<li class="end"><a href='/AdmMaster/_member/email_list.php'>이메일</a></li>
						</ul>
					</li>
					
				
					
					<li class="menu <? if($top_menu == "intra") echo "on";?>">
						<a href="#!"><img src="/AdmMaster/_images/common/ico_gnb_10.png" alt="" /> <span class="tit">인트라넷</span></a>
						<ul class="smenu"  style="width:650px; margin-left:-200px;">
							<li class="fir"><a href="/AdmMaster/_memberBoard/board_list.php?code=mem_board">사내게시판</a></li>
							<li><a href="/AdmMaster/_memberBoard/board_list.php?code=mem_pds">자료실</a></li>
							<li><a href="/AdmMaster/_schedule/calendar.php">일정관리</a></li>
							<li class="end"><a href="/AdmMaster/_memberBreak/list.php">연차관리</a></li>  
						</ul>
					</li>
					
					

					<li class="menu <? if($top_menu == "config") echo "on";?>">
						<a href="#!"><img src="/AdmMaster/_images/common/ico_gnb_09_1.png" alt="" /> <span class="tit">환경설정</span></a>
						<ul class="smenu" style="width:800px; margin-left:-650px;">
							<li class="fir"><a href='/AdmMaster/_codeBanner/list.php'>서브배너관리</a></li>
							<li><a href='/AdmMaster/_adminrator/setting.php'>홈페이지 설정</a></li>
							<li class="end"><a href='/AdmMaster/_adminrator/adm_setting.php'>관리자설정</a></li>
						</ul>
					</li>

					<li class="last"><a href="/AdmMaster/logout.php"><img src="/AdmMaster/_images/common/ico_gnb_10.png" alt="" /> <span class="tit">로그아웃</span></a></li>
				</ul>
			</div><!-- // gnb -->

		</header><!-- // header -->


<script>

// 현재 on 된 메뉴

$(document).ready(function(){
	var cur_menu = $("#gnb .menu").index( $("#gnb .menu.on") );
	

	$("#gnb .menu").removeClass("on");
	$("#gnb .menu").eq(cur_menu).addClass("on");

	$( "#header" ).mouseleave(function(e) {
		setTimeout(function() {
			$("#gnb .menu").removeClass("on");
			$("#gnb .menu").eq(cur_menu).addClass("on");
		}, 10);
	});

	$( ".gnb_menu .menu" ).each(function(index){
		
		$(this).mouseenter(function(){
			$(this).addClass("on");
			
			if( index != cur_menu ){
				$("#gnb .menu").eq(cur_menu).removeClass("on");
			}else{
				
			}
		});

		$(this).mouseleave(function(){
			$(this).removeClass("on");
		});
	});
	  
	// 첫번째 서브메뉴 실행
	$("#gnb .menu > a").click(function(){
		document.location.href = $(this).parent().find(".smenu li a").eq(0).attr("href");
	});
});

</script>