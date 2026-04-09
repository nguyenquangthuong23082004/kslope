<?
	include $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php";
	if ($_SESSION[member][id] != "admin") {
		header('Location:/AdmMaster/');
		exit();
	}
		// 등록된 아이피만 관리자에 접속 할 수 있습니다.
	adminBlock("AdmMaster");
?>

<!--[if lt IE 7]>      <html class="ie6"> <![endif]-->
<!--[if IE 7]>         <html class="ie7"> <![endif]-->
<!--[if IE 8]>         <html class="ie8"> <![endif]-->
<!--[if gt IE 8]><!--><!DOCTYPE HTML><!--<![endif]-->
<html lang="ko">
<head>
<title><?=_IT_BROWSER_TITLE?></title>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="apple-mobile-web-app-title" content="">
<!-- 파비콘 설정 -->
<link rel="shortcut icon" type="image/x-icon" href="/AdmMaster/_images/favicon.ico">
<link rel="apple-touch-icon" href="/AdmMaster/_images/apple-touch-icon.png" />
<meta name="Generator" content="">
<meta name="Author" content="">
<meta name="Keywords" content="<?=_IT_META_KEYWORD?>">
<meta name="Description" content="<?=_IT_META_TAG?>">

<script type="text/javascript" src="/AdmMaster/_common/js/jquery-1.8.3.min.js"></script>
<!--[if lte IE 9]>
<script src="/AdmMaster/_common/js/html5.js"></script>
<script src="/AdmMaster/_common/js/respond.min.js"></script>
<![endif]-->


<link rel="stylesheet" href="/js/jquery-ui-1.11.2.custom/jquery-ui.css">
<script type="text/javascript" src="/js/jquery.number.js"></script>
<!-- <script src="/js/jquery-ui-1.11.2.custom/jquery-ui.js"></script> -->
<script src="/js/jquery-ui.min.js" type="text/javascript"></script>
<script src="/js/notifIt.js" type="text/javascript"></script>
<link href="/js/notifIt.css" type="text/css" rel="stylesheet">


<link rel="stylesheet" href="/js/colorbox-master/example4/colorbox.css" />
<script src="/js/colorbox-master/jquery.colorbox.js"></script>
<link rel="stylesheet" href="/AdmMaster/_common/css/import.css" type="text/css" />


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

<!-- 다음 우편번호 -->
<?if($_ssl_use){?>
	<script src="https://ssl.daumcdn.net/dmaps/map_js_init/postcode.v2.js"></script>
<?}else{?>
	<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
<?}?>

</head>
<body>
<div id="ajax_loader" class="wrap-loading display-none">
	<div><img src="/js/ajax-loader.gif"/></div>
</div>

	<div id="wrap">


		<header id="header">

			<div class="headerSet">

				<p class="pic">
					<a href="/" target="_blank">
						<img src="<?=_IT_LOGOS?>" alt="<?=_IT_SITE_NAME?>" style="max-height:100px;max-width:100px;">
					</a>
				</p>
				<div class="settings">
					<p class="config"><b>관리자</b>님 접속중 <a href="/AdmMaster/_adminrator/adm_setting.php"><img src="/AdmMaster/_images/common/ico_setting.png" alt="설정" /></a> <!-- &nbsp;<a href="/AdmMaster/logout.php"><img src="/AdmMaster/_images/common/logout.png" alt="로그아웃" /></a>//--></p>
					<div class="config2">
					<h1><span class="col_yellow"> <?=_IT_SITE_NAME?> 관리자</span></h1>


					</div>
				</div>
			</div><!-- // headerSet -->


				<div id="gnb" class="gnb_update">
					<ul class="gnb_menu">
						
						<li class="menu1  <? if($code == "notice" || $code == "faq" || $code == "event" || $code == "as" )  { ?>on<? }?>"><a href="/AdmMaster/_bbs/board_list.php?code=notice"><img src="/AdmMaster/_images/common/ico_gnb_01.png" alt="" /> <span class="tit">고객센터</span></a>
							<ul class="smenu_1" style="width:580px;">
								<li class="fir"><a href="/AdmMaster/_bbs/board_list.php?code=notice">본토소식</a></li>
								<li class=""><a href="/AdmMaster/_bbs/board_list.php?code=faq">자주묻는질문</a></li>
								<li class=""><a href="/AdmMaster/_bbs/board_list.php?code=as">A/S</a></li>
								<li class="end"><a href="/AdmMaster/_bbs/board_list.php?code=event">이벤트</a></li>
							</ul>
						</li>


						<li class="menu11  <? if(strpos($_SERVER[PHP_SELF], "/AdmMaster/_member/") !== false)  { ?>on<? }?>"><a href="/AdmMaster/_member/list.php"><img src="/AdmMaster/_images/common/ico_gnb_06.png" alt="" /> <span class="tit">회원관리</span></a>
							<ul class="smenu_11">
								<li class="fir"><a href="/AdmMaster/_member/list.php">회원관리</a></li>
								<li class=""><a href="/AdmMaster/_member/member_point.php">회원 적립금 관리</a></li>
								<li class=""><a href="/AdmMaster/_member/email01.php">이메일 관리</a></li>
								<li class=""><a href="/AdmMaster/_member/sms01.php">SMS 관리</a></li>
							</ul>
						</li>



						<li class="menu3  <? if(strpos($_SERVER[PHP_SELF], "/AdmMaster/_counsel/") !== false ||$code == "qna"  || $code == "ContactUs")  { ?>on<? }?>"><a href="/AdmMaster/_counsel/deal_list.php"><img src="/AdmMaster/_images/common/ico_gnb_03.png" alt="" /> <span class="tit">문의</span></a>
							<ul class="smenu_3">
								<li class="fir"><a href="/AdmMaster/_counsel/deal_list.php">박리다매DEAL</a></li>
								<li class=""><a href="/AdmMaster/_counsel/booking_list.php">예약판매</a></li>
								<li class=""><a href="/AdmMaster/_bbs/board_list.php?code=qna">1:1문의하기</a></li>
								<li class=""><a href="/AdmMaster/_bbs/board_list.php?code=ContactUs">제휴상담/신청</a></li>
							</ul>
						</li>


						<li class="menu4  <? if(strpos($_SERVER[PHP_SELF], "/AdmMaster/_code/") !== false)  { ?>on<? }?>"><a href="/AdmMaster/_code/list.php"><img src="/AdmMaster/_images/common/ico_gnb_04.png" alt="" /> <span class="tit">코드관리</span></a>
							<ul class="smenu_4">
								<li class="fir"><a href="/AdmMaster/_code/list.php">카테고리</a></li>
								<li class=""><a href="/AdmMaster/_code/group_list.php">분류</a></li>
								<li class=""><a href="/AdmMaster/_code/brand_list.php">브랜드</a></li>
								<li class=""><a href="/AdmMaster/_code/country_list.php">국가</a></li>

								<li class=""><a href="/AdmMaster/_code/size_type_list.php">상품사이즈 그룹관리</a></li>
								<li class=""><a href="/AdmMaster/_code/size_list.php">상품사이즈</a></li>
								<li class=""><a href="/AdmMaster/_code/color_list.php">색상관리</a></li>
								<li class=""><a href="/AdmMaster/_code/icon_list.php">아이콘관리</a></li>
								<li class=""><a href="/AdmMaster/_code/dbcolor_list.php">대표색상코드관리</a></li>

							</ul>
						</li>

						<li class="menu6  <? if(strpos($_SERVER[PHP_SELF], "/AdmMaster/_goods/") !== false)  { ?>on<? }?>"><a href="/AdmMaster/_goods/list.php"><img src="/AdmMaster/_images/common/ico_gnb_06.png" alt="" /> <span class="tit">상품관리</span></a>
							<ul class="smenu_6">
								<li class="fir"><a href="/AdmMaster/_goods/list.php">상품관리</a></li>
								<li class=""><a href="/AdmMaster/_goods/review_list.php">상품후기</a></li>
							</ul>
						</li>

						<li class="menu13  <? if(strpos($_SERVER[PHP_SELF], "/AdmMaster/_order/") !== false)  { ?>on<? }?>"><a href="/AdmMaster/_order/list.php"><img src="/AdmMaster/_images/common/ico_gnb_06.png" alt="" /> <span class="tit">주문관리</span></a>
							<ul class="smenu_13">
							</ul>
						</li>

						<li class="menu5  <? if( $code == "banner" )  { ?>on<? }?>"><a href="/AdmMaster/_bbs/board_list.php?code=banner&scategory=16"><img src="/AdmMaster/_images/common/ico_gnb_05.png" alt="" /> <span class="tit">배너관리</span></a>
							<ul class="smenu_5">
							<?
							$fsql    = " select * from tbl_bbs_category where code='$code' order by onum desc";
							$fresult = mysqli_query($connect, $fsql) or die (mysqli_error($connect));
							while($frow=mysqli_fetch_array($fresult)){
							?>
								<li style="padding:0 3px 0 3px;"><a href='/AdmMaster/_bbs/board_list.php?code=banner&scategory=<?=$frow["tbc_idx"]?>'><?=$frow["subject"]?></a></li>
							<?
							}
							?>
							</ul>
						</li>

						<li class="menu7  <? if(strpos($_SERVER[PHP_SELF], "/AdmMaster/_adminrator/") !== false )  { ?>on<? }?>"><a href="/AdmMaster/_adminrator/setting.php"><img src="/AdmMaster/_images/common/ico_gnb_07.png" alt="" /> <span class="tit">기본설정</span></a>
							<ul class="smenu_7">
								<li class="fir"><a href='/AdmMaster/_adminrator/setting.php'>쇼핑몰 기본설정</a></li>
								<li><a href='/AdmMaster/_adminrator/store_config_admin.php'>운영자 계정관리</a></li>
								<li><a href='/AdmMaster/_adminrator/stock_list.php'>정책 설정</a></li>
								<li><a href='/AdmMaster/_adminrator/transcom_list.php'>배송사관리</a></li>

								<li class="end"><a href='/AdmMaster/_adminrator/policy.php'>약관 및 정책</a></li>
							</ul>
						</li>
						
						<!-- new -->
						
						<li class="menu16  <? if(strpos($_SERVER[PHP_SELF], "/AdmMaster/_statistics/") !== false )  { ?>on<? }?>"><a href="/AdmMaster/_statistics/statistics01_01.php"><img src="/AdmMaster/_images/common/ico_gnb_07.png" alt="" /><span class="tit">통계</span></a>
							<ul class="smenu_16">
								<li class="fir"><a href='/AdmMaster/_statistics/statistics01_01.php'>주문분석</a></li>
								<li><a href='/AdmMaster/_statistics/statistics02_01.php'>매출분석</a></li>
								<li><a href='/AdmMaster/_statistics/statistics02_01.php'>방문분석</a></li>
								<li><a href='/AdmMaster/_statistics/statistics02_01.php'>상품분석</a></li>
								<li><a href='/AdmMaster/_statistics/statistics02_01.php'>회원분석</a></li>
							</ul>
						</li>

						<li class="menu8  <? if(strpos($_SERVER[PHP_SELF], "/AdmMaster/_operator/") !== false || strpos($_SERVER[PHP_SELF], "/AdmMaster/_front/") !== false )  { ?>on<? }?>"><a href="/AdmMaster/_operator/coupon_list.php"><img src="/AdmMaster/_images/common/ico_gnb_08.png" alt="" /> <span class="tit">운영관리</span></a>
							<ul class="smenu_8">
								<li class="fir"><a href='/AdmMaster/_operator/coupon_list.php'>쿠폰관리</a></li>
								<li><a href='/AdmMaster/_operator/coupon_setting.php'>쿠폰설정</a></li>

								<li><a href='/AdmMaster/_operator/top5.php'>TOP5</a></li>
								<li><a href='/AdmMaster/_operator/popular.php'>인기상품</a></li>
								<!--
								<li><a href='/AdmMaster/_bbs/board_list.php?code=banner'>배너관리</a></li>
								-->
								<li><a href="/AdmMaster/_operator/deal_list.php?code=01">박리다매 DEAL</a></li>
								<li><a href="/AdmMaster/_operator/deal_list.php?code=02">본토회원DEAL</a></li>
								<li><a href="/AdmMaster/_operator/deal_list.php?code=03">본토장터</a></li>
								<li><a href="/AdmMaster/_operator/deal_list.php?code=04">9장 DEAL</a></li>
								<li><a href="/AdmMaster/_operator/booking_list.php">예약판매</a></li>
								<li><a href="/AdmMaster/_operator/market_list.php">매장관리</a></li>
								<li class="end"><a href='/AdmMaster/_front/popup_list.php'>팝업관리</a></li>
								<!--
								<li class="end"><a href='/AdmMaster/_operator/policy.php'>---</a></li>
								-->
							</ul>
						</li>


						<li class="menu12  <? if(strpos($_SERVER[PHP_SELF], "/AdmMaster/_stock/") !== false)  { ?>on<? }?>"><a href="/AdmMaster/_stock/list.php"><img src="/AdmMaster/_images/common/ico_gnb_06.png" alt="" /> <span class="tit">재고관리</span></a>
							<ul class="smenu_12">
								<li class="fir"><a href="/AdmMaster/_stock/list.php">재고관리</a></li>
								<li><a href="/AdmMaster/_stock/head_office.php">본사 재고추가</a></li>
								<li><a href="/AdmMaster/_stock/agency.php">대리점 재고관리</a></li>

								<li class="end"><a href='/AdmMaster/_stock/store_inventory.php'>매장재고현황</a></li>
							</ul>
						</li>



						<li class="menu10 last"><a href="/AdmMaster/logout.php"><img src="/AdmMaster/_images/common/ico_gnb_10.png" alt="" /> <span class="tit">로그아웃</span></a></li>
					</ul>
				</div><!-- // gnb -->



		</header><!-- // header -->
<script>
var menu_cnt = 0;
for (i=0; i <= 20; i++)
{
	if ($(".menu"+i).hasClass("on") == true)
	{
		menu_cnt = i;
	}
}


$( "#header" ).mouseleave(function(e) {
	setTimeout(function() {
		/*
		e.preventDefault();
		e.stopPropagation();
		*/
		$(".menu"+menu_cnt).addClass("on");
	}, 10);
});
</script>
<script>
$(function() {
	$.datepicker.regional['ko'] = {
	showButtonPanel: true,
	beforeShow: function( input ) {
		setTimeout(function() {
			var buttonPane = $( input )
			.datepicker( "widget" )
			.find( ".ui-datepicker-buttonpane" );
			var btn = $('<BUTTON class="ui-datepicker-current ui-state-default ui-priority-secondary ui-corner-all">Clear</BUTTON>');
			btn .unbind("click").bind("click", function () {
				$.datepicker._clearDate( input );
			});
			btn.appendTo( buttonPane );
		}, 1 );
	}   ,
	closeText: '닫기',
	prevText: '이전',
	nextText: '다음',
	monthNames: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
	monthNamesShort: ['1','2','3','4','5','6','7','8','9','10','11','12'],
	dayNames: ['일','월','화','수','목','금','토'],
	dayNamesShort: ['일','월','화','수','목','금','토'],
	dayNamesMin: ['일','월','화','수','목','금','토'],
	weekHeader: 'Wk',
	dateFormat: 'yy-mm-dd',
	firstDay: 0,
	isRTL: false,
	showMonthAfterYear: true,
	changeMonth: true,
	changeYear: true,
	showMonthAfterYear: true,
	closeText: '닫기',  // 닫기 버튼 패널
	yearSuffix: ''};
	$.datepicker.setDefaults($.datepicker.regional['ko']);

	setTimeout(function() {
		$( ".datepicker" ).datepicker({
			showButtonPanel: true
			,beforeShow: function( input ) {
				setTimeout(function() {
					var buttonPane = $( input )
					.datepicker( "widget" )
					.find( ".ui-datepicker-buttonpane" );
					var btn = $('<BUTTON class="ui-datepicker-current ui-state-default ui-priority-secondary ui-corner-all">Clear</BUTTON>');
					btn .unbind("click").bind("click", function () {
						$.datepicker._clearDate( input );
					});
					btn.appendTo( buttonPane );
				}, 1 );
			}
			,dateFormat: 'yy-mm-dd'
			,showOn: "both"
			,yearRange: "c-100:c+10"
			,buttonImage: "/AdmMaster/_images/common/date.png"
			,buttonImageOnly: true
			,closeText: '닫기'
			,prevText: '이전'
			,nextText: '다음'

		});
		$( ".datepicker2" ).datepicker({
			showButtonPanel: true
			,beforeShow: function( input ) {
				setTimeout(function() {
					var buttonPane = $( input )
					.datepicker( "widget" )
					.find( ".ui-datepicker-buttonpane" );
					var btn = $('<BUTTON class="ui-datepicker-current ui-state-default ui-priority-secondary ui-corner-all">Clear</BUTTON>');
					btn .unbind("click").bind("click", function () {
						$.datepicker._clearDate( input );
					});
					btn.appendTo( buttonPane );
				}, 1 );
			}
			,dateFormat: 'yy-mm-dd'
			,yearRange: "c-100:c+10"
			,closeText: '닫기'
			,prevText: '이전'
			,nextText: '다음'

		});
		$('img.ui-datepicker-trigger').css({'cursor':'pointer'});
		$('input.hasDatepicker').css({'cursor':'pointer'});
	}, 100);
});

</script>
