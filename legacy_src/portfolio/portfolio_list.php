<?
include('../inc/head.inc.php');
include('../inc/header.inc.php');
?>
<? //include('./popup.php');?> 
<style>
    body{
        background-color: #fff;
        
    }
    #container{
        min-height: calc(100vh - 330px)
    }
</style>
	<section class="visual" style="background:url('../img/main/visual_bg0<?=$pwd?>.jpg') no-repeat center top;">
		<h2 class="visual-txt"><img src="../img/main/visual_txt.png" alt="Your trust partner j&k media works We’re realizing creative designs base on the teamwork among experienced designers. We are certain that the recent projects below will porve it. "></h2>
	</section>
	<?
		$r_type = $_GET['r_type'];

		if($r_type == 'S'){
			$rTypeSql = " AND r_type IN ('S') ";
		}else{
			//$rTypeSql = " AND r_type in ('G','H','I','J','Z','Y','X','T','U') ";
			$rTypeSql = " AND r_type in ('G','H','I','J','Z','Y','T','U') ";
		}

	$total_sql = "
			select
				count(*) cnt,
				sum(if(r_type='G', 1, 0)) as cnt_G,
				sum(if(r_type='H', 1, 0)) as cnt_H,
				sum(if(r_type='I', 1, 0)) as cnt_I,
				sum(if(r_type='J', 1, 0)) as cnt_J,
				sum(if(r_type='Z', 1, 0)) as cnt_Z,
				sum(if(r_type='Y', 1, 0)) as cnt_Y,
				sum(if(r_type='X', 1, 0)) as cnt_X,
				sum(if(r_type='T', 1, 0)) as cnt_T,
				sum(if(r_type='U', 1, 0)) as cnt_U,
				sum(if(r_type='S', 1, 0)) as cnt_S,
				max(r_order) last_order
			from jk_goods
			where r_used = 'Y'
				and shopcode = ''
				$rTypeSql
		";

		$result = mysqli_query($connect, $total_sql) or die (mysqli_error($connect));
		$row=mysqli_fetch_array($result);

		$total_cnt = $row['cnt'];
		$total_cnt_G = $row['cnt_G'];
		$total_cnt_H = $row['cnt_H'];
		$total_cnt_I = $row['cnt_I'];
		$total_cnt_J = $row['cnt_J'];
		$total_cnt_Z = $row['cnt_Z'];
		$total_cnt_Y = $row['cnt_Y'];
		$total_cnt_X = $row['cnt_X'];
		$total_cnt_T = $row['cnt_T'];
		$total_cnt_U = $row['cnt_U'];
		$total_cnt_S = $row['cnt_S'];
		$last_order = $row['last_order'];

		
	?>
	<section id="container">
		<div class="wrap_1780">
			<div class="potfolio_box">
				<h2 class="page-tit" style="display:none">포트폴리오</h2>
				<div class="potfolio_top">
					
					<h3 class="title type_2 top"><span class="sub_loc_active active"></span> <!--/ <span class="tit">유월 Portfolio</span>--></h3>


					
					<nav id="potfolio_gnb">
						<b class="sub_gnb_tit"><span class="stm_tit"></span></b>
						<ul>
							<li <?if($r_type =="" || $r_type == "ALL")echo "class='active'";?>><a href="?r_type=ALL" sch_type="ALL">전체</a></li>
							<li <?if($r_type =="H")echo "class='active'";?>><a href="?r_type=H" sch_type="H">랜딩페이지<!--<span class="num">Y(<?=$total_cnt_G?>)</span></span>--></a></li>
							<li <?if($r_type =="Z")echo "class='active'";?>><a href="?r_type=Z" sch_type="Z">여행예약사이트<!--<span class="num">Y(<?=$total_cnt_G?>)</span></span>--></a></li>
							<li <?if($r_type =="G")echo "class='active'";?>><a href="?r_type=G" sch_type="G">기업소개<!--<span class="num">Y(<?=$total_cnt_G?>)</span></span>--></a></li>
							<li <?if($r_type =="I")echo "class='active'";?>><a href="?r_type=I" sch_type="I">쇼핑몰<!--<span class="num">Y(<?=$total_cnt_G?>)</span></span>--></a></li>
						<?/*?>
							<li <?if($r_type =="X")echo "class='active'";?>><a href="?r_type=X" sch_type="X">프랜차이즈<!--<span class="num">Y(<?=$total_cnt_G?>)</span></span>--></a></li>
						<?*/?>
							<li <?if($r_type =="T")echo "class='active'";?>><a href="?r_type=T" sch_type="T">상세페이지<!--<span class="num">Y(<?=$total_cnt_G?>)</span></span>--></a></li>
							<!--<li <?if($r_type =="Y")echo "class='active'";?>><a href="#!" sch_type="Y">성형&뷰티<span class="num">Y(<?=$total_cnt_G?>)</span></span></a></li>-->
							<li <?if($r_type =="J")echo "class='active'";?>><a href="?r_type=J" sch_type="J">앱개발<!--<span class="num">Y(<?=$total_cnt_G?>)</span></span>--></a></li>
							<li <?if($r_type =="S")echo "class='active'";?>><a href="?r_type=S" sch_type="S">사진촬영<!--<span class="num">Y(<?=$total_cnt_G?>)</span></span>--></a></li>
							<!-- <li <?if($r_type =="U")echo "class='active'";?>><a href="#!" sch_type="U">BI&CI<!--<span class="num">Y(<?=$total_cnt_G?>)</span></span></a></li>-->
							<!-- <li <?if($r_type =="H")echo "class='active'";?>><a href="#!" sch_type="H">포트폴리오<span class="num">(<?=$total_cnt_H?>)</span></a></li> -->
							<!-- <li <?if($r_type =="G")echo "class='active'";?>><a href="#!" sch_type="G">시안디자인<span class="num">Y(<?=$total_cnt_G?>)</span></span></a></li> -->
							<!-- <li <?if($r_type =="I")echo "class='active'";?>><a href="#!" sch_type="I">MARKETING<span class="num">(<?=$total_cnt_I?>)</span></a></li> -->
							
						</ul>
					</nav>
				</div>
				
				<div class="potfolio_list" id="masonry">
					<ul class="potfolio">
						
					</ul>
				</div>
			</div>
			<h2 class="tit">ALL</h2>
		</div>
	</section><!-- //container End -->
<? include('../inc/footer.inc.php');?>

<div id="potfolio_pop">

	<div class="potfolio_wrap">
		<b class="close"><img src="../img/btn/close_btn.png" alt="닫기버튼"></b>
		<h4 class="title">PORTFOLIO</h4>
		<b class="sub_title">총 <span>0</span>개의 포트폴리오를 선택하셨습니다.</b>
		<ul class="potfolio_pop_list">
			
		</ul>
		<div class="input_form">
			<form method="post" name="frm" id="frm" action="mail_submit.php">
				<input type="text" placeholder="받으실 이메일을 적어주세요" name="user_email" id="user_email" />
				<button type="button" class="mail_btn">보내기</button>
			</form>
		</div>
	</div>
</div>
<div class="layer_bg"></div>
<input type="hidden" name="check_face" id="check_face" value="N">
<script type="text/javascript">

/* 포트폴리오 gnb */
$(document).ready(function(){
	$('.stm_tit').text('전체');
	$("#potfolio_gnb > ul > li").click(function(){ //탭 클릭시
		//현재 윈도우 사이즈 가져오기
		var win_width =$( window ).width();
			$("#potfolio_gnb > ul > li").removeClass("active");
			$(this).addClass("active");
			var tab_text =$(this).find("a").text();
			$("h2.tit").text(tab_text);
			$(".stm_tit").text(tab_text);
			//사이즈가 769보다 작을때 클릭시 토글 이벤트 발생
			if(win_width <769){
				$("#potfolio_gnb > ul ").toggle();
			}
	});

	$( window ).resize(function() {
		var win_width =$( window ).width();
		if(win_width >768){
			$("#potfolio_gnb > ul ").show();
		}
	});

/* 포트폴리오 하트 */
	$(".favorite_add").on("click",function(){ //탭 클릭시
		//$(this).toggleClass("active");

	});

/* 팝업창 */
	$("ul.potfolio_favorite > li > p.add_num").click(function(){ //탭 클릭시
		$(".potfolio_pop_list li").remove();
		favorite_list();
		$("#potfolio_pop").addClass("block");
		$(".layer_bg").show();
	});
	$("#potfolio_pop b.close , .layer_bg").click(function(){ //탭 클릭시
		$("#potfolio_pop").removeClass("block");
		$(".layer_bg").hide();
	});
});
</script>

<script type="text/javascript">
	var last_order = '<?=$last_order;?>'; // 마지막 번호
	var user_ip ='<?=$_SERVER['REMOTE_ADDR'];?>';
	var total_cnt_arr = {
		 G:<?=$total_cnt_G * 1;?>,
		 H:<?=$total_cnt_H * 1;?>,
		 I:<?=$total_cnt_I * 1;?>,
		 J:<?=$total_cnt_J * 1;?>,
		 Z:<?=$total_cnt_Z * 1;?>,
		 Y:<?=$total_cnt_Y * 1;?>,
		 X:<?=$total_cnt_X * 1;?>,
		 T:<?=$total_cnt_T * 1;?>,
		 U:<?=$total_cnt_U * 1;?>,
		 S:<?=$total_cnt_S * 1;?>
		//C:'<?=$total_cnt_G * 1;?>',
		//B:'<?=$total_cnt_H * 1;?>',
		//M:'<?=$total_cnt_I * 1;?>'
	};

	//var sch_type = $("#potfolio_gnb  .active a").attr("sch_type"); // 현재 표시 필터
	<?if($r_type == ''){?>
		var sch_type = 'ALL'; // 현재 표시 필터
	<?}else{?>
		var sch_type = '<?=$r_type?>'; // 현재 표시 필터
	<?}?>
	var cur_cnt = 0; // 가져온 갯수 (초기 설정)
	var total_cnt = cur_cnt + total_cnt_arr[sch_type]; // 전체 갯수
	if(sch_type =="ALL")
		total_cnt = cur_cnt + parseInt('<?=$total_cnt?>'); // 전체 갯수
	// 자료 더 가져오기
	var backup_last_order = "";
	var backup_first_order = "";
	var switch_tab = "Y";
	function add_items(){
		last_order =$(".list-content").last().attr("r_order");
		if(!last_order)
			last_order ='<?=$last_order?>';
		else last_order =(last_order -1)*1;

		cur_cnt = $(".list-content").length;
		if(!cur_cnt)
			cur_cnt =0;
		console.log("sch_type : "+sch_type+", last_order : "+last_order+", cur_cnt:"+cur_cnt+", total_cnt:"+total_cnt);
		// 더 가져올 자료가 있으면...

		if(switch_tab == "Y"){
			if(cur_cnt < total_cnt){
				if(backup_first_order==""){
					backup_first_order = last_order;
				}

				if(backup_last_order==last_order && backup_last_order != backup_first_order ){
					return false;
				}
				backup_last_order = last_order;

				switch_tab = "N";

				$.ajax({
					type:"POST",
					url     : "/ajax/list_add.php",
					data    : "r_order="+last_order+"&sch_type="+sch_type,
					cache   : false,
					success : function(data) {
						//console.log(data);
						var items = $(data);

						//$(".potfolio").append(items).isotope('appended', items);
						$(".potfolio").append(items.fadeIn());
						switch_tab = "Y";
					},
					error:function(request,status,error){
						alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
					 }
				});
			}
		}
	}

	$(function(){
		//리스트 삭제후 관심리스트 가져오기
		$(".potfolio_pop_list li").remove();
		favorite_list();
		// 위로가기 버튼 클릭
		$(".btn_more").on( 'click', function(e) {
			var ta = 0;
			$('html, body').stop().animate({
				'scrollTop':  ta
			}, 800, 'easeInOutQuint' , function () {
				//window.location.hash = target;
			});
			e.preventDefault();
		});

		// 필터 변경
		$("#potfolio_gnb li a").click(function(){
			//var new_sch_type = $(this).attr("sch_type");
			<?if($r_type == ''){?>
				var new_sch_type = 'ALL';
			<?}else{?>
				var new_sch_type = '<?=$r_type?>';
			<?}?>
			if(new_sch_type != sch_type){
				sch_type = new_sch_type;
				$(".potfolio li").remove(); // 기존 컨텐츠 삭제

				//cur_cnt = $(".list-content").length; // 가져온 갯수 (초기 설정)
				cur_cnt = 0;
				total_cnt = cur_cnt + total_cnt_arr[sch_type]; // 전체 갯수
				if(sch_type =="ALL")
					total_cnt = cur_cnt + parseInt('<?=$total_cnt?>'); // 전체 갯수
				add_items(); // 컨텐츠 가져오기
			}
		});

		// 스크롤하다가 지정된 위치까지 다다르면 계속해서 내용을 추가하기
		$(window).on("scroll", function(){

         



			if(cur_cnt < total_cnt){
				var h = $(window).height(); // 창의 높이
				//var sh = $(window).prop('scrollHeight'); // 내용물의 높이
				var sh = document.body.scrollHeight; // 내용물의 높이
				var st = $(window).scrollTop(); // 현재 스크롤 위치 : 0 ~ (내용물의 높이 - 창의 높이)
				var gap = 600; // 추가 액션을 실행할 위치 (남은 스크롤 높이)

				// 바닥까지 스크롤 되었으면...
				//console.log("st : " + st + ", sh:" + sh+ ", h:" + h+", gap:"+gap);
				if(st >= sh - h - gap){
					add_items();
				}
			}
		});
		//sns 퍼가기 facebook twitter
		$(document).on('click',".share-facebook",function() {

			var r_idx =$(this).attr("r_idx");

			var url = "http://uwal.co.kr//portfolio/portfolio_sns.php?idx="+r_idx;

			url ="https:\//www.facebook.com/sharer/sharer.php?u="+encodeURIComponent(url);



			//if($("#check_face").val() =="Y"){
				//$("#check_face").val("N");
				window.open(url, "win_facebook", "menubar=1,resizable=1,width=600,height=400");
			//}


			/*

			var url =$(this).attr("link_url");
			//var url ="http://"+"uwal2017.jnkmw.com/portfolio/portfolio_list.php";
			surl =url;
			//console.log("url:"+surl);
			var title,img,scontent;
			img =$(this).attr('img_url');
			title = scontent =$(this).attr('list_title');
			var face_check =$("#check_face").val();
			//url ="https:\//www.facebook.com/sharer/sharer.php?s=100&u="+encodeURIComponent(url)+'&t='+encodeURIComponent(title)+'&p[images][0]='+encodeURI(img,'UTF-8');
			url ="https:\//www.facebook.com/sharer/sharer.php?u="+encodeURIComponent(url)+"&p[images][0]="+img;


			if(face_check =="N")
				cmaMetaTagsChange(surl,title,scontent,img,"fa");

			if($("#check_face").val() =="Y"){
				$("#check_face").val("N");
				window.open(url, "win_facebook", "menubar=1,resizable=1,width=600,height=400");
			}
			//console.log(url);return;
			/*
			if(face_check =="Y")
					window.open(url, "win_facebook", "menubar=1,resizable=1,width=600,height=400");
				return false;
				*/


		 });

		$(document).on('click',".share-twitter",function() {
			var url =$(this).attr("link_url");
				url ="https:\//twitter.com/intent/tweet?text=[%EA%B3%B5%EC%9C%A0]%20="+encodeURIComponent(url)+'%20-%20'+encodeURIComponent(document.title);
				window.open(url, "win_twitter", "menubar=1,resizable=1,width=600,height=400");
				 return false;
		 });
	});
	/*
	$(window).load(function(){
		// 처음에 기본 컨텐츠 가져오기
		//$(window).trigger("scroll");
		
	});
	기다리지 않고 바로 뜨게 해주세요...
	*/
	add_items();

function cmaMetaTagsChange(url,stitle,scontent,simg,type){
		$("#check_face").val("Y");
    $("#meta_image_src").attr("href", simg); // 트위터 카드를 사용하는 URL이다.
    // 트위터 관련 메타태그
    $("#meta_twitter_url").attr("content", url); // 트위터 카드를 사용하는 URL이다.
    $("#meta_twitter_title").attr("content", stitle+" [chongmoa.com]"); // 트위터 카드에 나타날 제목
    $("#meta_twitter_description").attr("content", scontent); // 트위터 카드에 나타날 요약 설명
    $("#meta_twitter_image").attr("content", simg); // 트위터 카드에 보여줄 이미지

    // 페이스북 관련 메타태그
    $("#meta_og_title").attr("content", stitle); //    제목표시
    $("#meta_og_image").attr("content", simg); //    이미지경로 w:90px , h:60px(이미지를 여러 개 지정할 수 있음)
    $("#meta_og_site_name").attr("content", stitle+" [chongmoa.com]"); //    사이트 이름
    $("#meta_og_url").attr("content", url); //    표시하고싶은URL
    $("#meta_og_description").attr("content", scontent); //    본문내용
		$("#imge_src").attr("href",simg);
		//facebook 일때 세션저장하기
		if(type="fa"){
			fa_session(url,stitle,simg,scontent);
		}
}
//meta 태그값 세션에 저장하기
function fa_session(surl,stitle,simg,scontent){
	$.ajax({
		type:"POST",
		url     : "/ajax/session_set.php",
		data    : "surl="+surl+"&stitle="+stitle+"&simg="+simg+"&scontent="+scontent,
		cache   : false,
		success : function(data) {
			if(!data)
				return;
		},
		error:function(request,status,error){
			alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
		 }
	});
}

//관심프로젝트 등록및 삭제
function favorite_set(mode,idx){
	$.ajax({
		type:"POST",
		url     : "/ajax/favorite_set.php",
		data    : "mode="+mode+"&idx="+idx+"&user_ip="+user_ip,
		cache   : false,
		success : function(data) {
			if(data){
				$(".add_num span").text(data);
				//마지막 1개 삭제일때 관심리스트 초기화 하기
				if(data =="0"){
					$(".potfolio_pop_list li").remove();
					$(".sub_title span").text(0);
					$(".potfolio_favorite .add_num img").attr("src","/img/ico/non_heart.png");

				}
			}
			if(!data)
				return;
		},
		error:function(request,status,error){
			alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
		 }
	});
}
//관심프로젝트 클릭시
//$(".social_box .favorite_add")
$(document).on("click",".social_box b",function(){
	var mode;
	var idx =$(this).attr("fa_idx");
	if($(this).hasClass('active') ==true){
		mode ="del";
		favorite_set(mode,idx);
		$(this).removeClass("active");
		favorite_list()
		//alert("true");
	}else{
		mode ="add";
		//현재관심등록된 수량 가져오기
		favorite_sum =$(".add_num span").text();
		if(favorite_sum ==12){
			alert("12개 까지 등록가능합니다.");
			return;
		}
		//alert("false"+idx);
		favorite_set(mode,idx);
		$(this).addClass("active");
		favorite_list()
	}
});

//관심포트폴리오 리스트 가져오기
function favorite_list(){
	$.ajax({
		type:"POST",
		url     : "/ajax/favorite_list.php",
		data    : "mode=list",
		cache   : false,
		success : function(data) {
			if(data){
				$(".potfolio_pop_list li").remove();
				$(".potfolio_pop_list").append(data);
				pop_count =$(".potfolio_pop_list li").length;
				$(".add_num span").text(pop_count);
				$(".sub_title span").text(pop_count);
				$(".potfolio_favorite .add_num img").attr("src","/img/ico/favorite_heart.png");
				//$(".add_num span").text(data);
			}
			if(!data)
				return;
		},
		error:function(request,status,error){
			alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
		 }
	});
}
//관심포트폴리오 삭제하기
$(document).on("click",".delete img",function(){
	var idx =$(this).attr("fa_idx");
	favorite_set("del",idx);
	favorite_list();
	$(".list-content").each(function(){
		var fa_layer =$(this).find(".favorite_add");
		if(fa_layer.attr("fa_idx") ==idx)
			fa_layer.removeClass("active");
	});
});
$(function(){
	$(".mail_btn").click(function(){
		var list_row = $(".potfolio_pop_list li").length;
		if(list_row <1){
			alert("포트폴리오를 선택해 주세요");
			$(".close").trigger("click");
			return;
		}
		if($("#user_email").val() ==""){
			alert("E-mail을 입력해주세요.");
			$("#user_email").focus();
			return;
		}
		$("#frm").submit();
	});
});


$(function() {

	$('#gnb > ul > li:nth-child(1)').addClass('active');
})


</script>
