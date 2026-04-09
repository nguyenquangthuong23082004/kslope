<?
include_once('../common.php');

$idx = $_GET['idx'];
$sql = " select * from jk_goods where r_idx = '" . $idx . "' ";
$result = mysqli_query($connect, $sql) or die (mysqli_error($connect));
$row = mysqli_fetch_array($result);

$r =mysqli_query($connect, "DESC jk_goods");
while($d=mysqli_fetch_array($r)){
	${$d[0]} =$row[$d[0]];
	//echo $d[0]." = ".${$d[0]}."<br/>";
}

$_SESSION['meta_url'] 		= $r_url;
$_SESSION['meta_title'] 	= $r_title; 
$_SESSION['meta_img'] 		= $r_file;
$_SESSION['meta_content'] 	= $r_description;
$_SESSION['meta_keywords'] 	= $r_keywords;

include_once('../inc/head.inc.php');
include('../inc/header.inc.php');

$lType	= $_GET['lType'];
//카테고리별 카운트 구하기
$total_sql = "
	select
		count(*) cnt,
		sum(if(r_type='G', 1, 0)) as cnt_G,
		sum(if(r_type='H', 1, 0)) as cnt_H,
		sum(if(r_type='I', 1, 0)) as cnt_I,
		sum(if(r_type='J', 1, 0)) as cnt_J,
		sum(if(r_type='Z', 1, 0)) as cnt_Z,
		max(r_order) last_order
	from jk_goods
	where r_used = 'Y'
		and shopcode = ''
		and r_type in ('G','H','I','J','Z')
";
$result = mysqli_query($connect, $total_sql) or die (mysqli_error($connect));
$row=mysqli_fetch_array($result);

$total_cnt = $row['cnt'];
$total_cnt_G = $row['cnt_G'];
$total_cnt_H = $row['cnt_H'];
$total_cnt_I = $row['cnt_I'];
$total_cnt_J = $row['cnt_J'];
$total_cnt_Z = $row['cnt_Z'];
$last_order = $row['last_order'];

//현제페이지 url
$http_host = $_SERVER['HTTP_HOST'];
$request_uri = $_SERVER['REQUEST_URI'];
$url = 'http://' . $http_host . $request_uri;

// 이전글을 얻음
$sql = " select r_idx from jk_goods where r_used ='Y' and r_type ='".$r_type."' and r_idx < ".$idx."  order by  r_idx desc  limit 1 ";
$result =mysqli_query($connect, $sql);
$prev = mysqli_fetch_array($result);
$prev_idx =$prev['r_idx'];
if($prev_idx)
	$prev_url ="?idx=".$prev_idx."&lType=".$lType;
else $prev_url ="#!";

// 다음글을 얻음
$sql = " select r_idx from jk_goods where r_used ='Y' and r_type ='".$r_type."' and r_idx > ".$idx."  order by r_idx  limit 1 ";
$result =mysqli_query($connect, $sql);
$next = mysqli_fetch_array($result);
$next_idx =$next['r_idx'];
if($next_idx)
	$next_url ="?idx=".$next_idx."&lType=".$lType;
else $next_url="#!";

//GNB 메뉴명
if($r_type =="C")
	$sub_gnb ="SOLUTION";
elseif($r_type =="B")
	$sub_gnb ="Web AGENCY";
elseif($r_type =="M")
	$sub_gnb ="MARKETING";



$categ_code = $_GET['categ_code'];
if ($categ_code == "1") {
	$categ_txt = "포트폴리오";
}else{
	$categ_txt = "쇼핑몰제작";
}
?>
	<section class="visual " style="background:url('../img/main/visual_bg0<?=$pwd?>.jpg') no-repeat center top;">
		<h2 class="visual-txt"><img src="../img/main/visual_txt.png" alt="Your trust partner j&k media works We’re realizing creative designs base on the teamwork among experienced designers. We are certain that the recent projects below will porve it. "></h2>
	</section>
	<section id="container">
		<div class="wrap_1780">
			<div class="potfolio_box">
			   <h2 class="page-tit" style="display:none"><?=$categ_txt?></h2>
				<div class="potfolio_top">
					<ul class="potfolio_favorite">
                        <li><p class="title"><span class="sub_loc_active active"></span>  <!-- <span class="sta_tit"></span> / -->
                        <!--/ <span class="sto_tit"></span> -->
                        </p>  </li>
                       
                    </ul>
                    <!-- <div class="back"><a href="./portfolio_list.php?r_type=<?=$lType?>" sch_type="ALL" class="his_back">목록으로 <i></i></a></div> -->
					<nav id="potfolio_gnb">
                        <b class="sub_gnb_tit"><span class="stm_tit">전체</span></b>
						<ul>
						<?if( $r_type == "R" ){?>
							<li class=""><a href="../about/s_shoppingmall.php">쇼핑몰제작비용</a></li>
							<li class=""><a href="../about/s_shopm.php">쇼핑몰 운영대행</a></li>
							<li class="<?if($r_type == "R")echo"active";?>"><a href="../about/s_shop_po1.php">상세페이지</a></li>
							<!-- <li class="<?if($r_type == "S")echo"active";?>"><a href="../about/s_shop_po2.php">사진촬영</a></li> -->


						 <!-- ?}else{?>
							<li <?if($r_type =="")echo "class='active'";?>><a href="./portfolio_list.php?r_type=<?=$lType?>" sch_type="ALL" class="his_back">목록으로 <i></i></a></li -->
							
						<?}?> 
						</ul>
                    </nav>
                    
				</div>
				<div class="potfolio_list_view">
					<div class="link_list">
						<a href="<?=$prev_url?>" class="prev"><img src="../img/btn/news_list_prev.png" alt="이전페이지로"></a>
						<a href="<?=$next_url?>" class="next"><img src="../img/btn/news_list_next.png" alt="다음페이지로"></a>
					</div>
					<div class="inquiry_tit">
						<h4 class="tit"><?=$r_title?></h4>
						<h5 class="sub_tit" style="display:none;"><?=$sub_gnb?></h5>
						<ul class="potfolio_type">
                            <li>
                                <b class="c_tit">DESIGN</b>
                                <span class="tit"><?=$r_title?></span>
                                <span class="line">|</span>
                                <span class="date">
                                    <?
								if($r_regdate =="0000-00-00 00:00:00")
									$r_time ="";
								else $r_time =substr($r_regdate,0,10);
								echo $r_time;
                                ?>
                                </span>
                            </li>
							
							<!-- <?if($r_url !=""){?>
							<li><a href="<?=$r_url?>" target="blank_"><?=$r_url?></a></li>
							<?}?> -->
						</ul>
						<ul class="social_list">
                            <!-- <li>
                                <a href="#!" target="_blank"><img src="../img/ico/social_link_img03.png"></a>
                            </li>
                            <li>
                                <a href="#!"><img src="../img/ico/social_link_img04.png"></a>
                            </li> -->
							<!-- <li class="share-facebook" r_idx = <?=$idx?> style="cursor:pointer;" >
								<img src="../img/ico/social_link_img01.png">
							</li> -->


							<!-- <li> <a href="#" onclick="javascript:window.open('https://twitter.com/intent/tweet?text=[%EA%B3%B5%EC%9C%A0]%20' +encodeURIComponent(document.URL)+'%20-%20'+encodeURIComponent(document.title), 'twittersharedialog', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" target="_blank" alt="Share on Twitter" ><img src="../img/ico/social_link_img02.png"></a></li> -->
							<?if($r_url !=""){?>
								<li><a href="<?=$r_url?>" target="_blank" class="btn_new">바로보기</a></li>
                                <li <?if($r_type =="")echo "class='active'";?> ><a href="./portfolio_list.php?r_type=<?=$lType?>" sch_type="ALL" class="btn_new back_btn_line" >목록으로 <i></i></a></li>
                                
							<?}else{?>
							
							<?}?>
						</ul><!--
						<ul class="uwal_tel">
							<li><img src="../img/ico/uwal_tel_img01.png" alt="전화아이콘">02.3667.0774</li>
							<li><img src="../img/ico/uwal_tel_img02.png" alt="팩스아이콘">02.6094.1113</li>
							<li><img src="../img/ico/uwal_tel_img03.png" alt="이메일아이콘">uwal@uwal.co.kr</li>
						</ul> -->

						<?
						//  인쇄 쪽일 경우에는 글씨 안나오게 처리
						if($row['r_type'] == "D" || $row['r_type'] == "E" || $row['r_type'] == "F"){?>

						<?}else{?>
							<?if($r_url !=""){?>
								<p class="portfolio_cation">초록색 링크 버튼을 누르시면 웹사이트를 보실 수 있습니다.</p>
							<?}?>
						<?}?>
					</div>
					<div class="wrap_1158">
						<div class="potfolio_text">
							<p class="text"><?=$r_content ?></p>
						</div>
						<ul class="potfolio_info">
							<?
								for ($i=2; $i <7 ; $i++) {
									if(${'r_file'.$i} ==null)
										continue;
									 $img_url ="https://".$_SERVER['HTTP_HOST']."/upload/file/".${'r_file'.$i};

							?>
							<li class="potfolio_visual">
								<div class="img_box">
									<img src="<?=$img_url?>" alt="<?=${'r_file'.$i."ori"}?>">
								</div>
							</li>
							<?}?>

						</ul>
					</div>
					<div class="link_list">
						<a href="<?=$prev_url?>" class="prev"><img src="../img/btn/news_list_prev.png" alt="이전페이지로"></a>
						<a href="<?=$next_url?>" class="next"><img src="../img/btn/news_list_next.png" alt="다음페이지로"></a>
					</div>
				</div>
				<div class="potfolio_list related">
					<b class="tit">FAVORITE PORTFOLIO</b>
					<ul>
						<?
						$http_host = $_SERVER['HTTP_HOST'];
						$request_uri = $_SERVER['REQUEST_URI'];

						$sql ="select r_portfolio_idx from jk_favorite where r_ip='".$_SERVER['REMOTE_ADDR']."' order by r_portfolio_idx ";
						$result =mysqli_query($connect, $sql);

						while ($row=mysqli_fetch_array($result)) {
						  $total_sql ="select *  from jk_goods  where r_idx ='".$row['r_portfolio_idx']."'" ;
						  $result2 = mysqli_query($connect, $total_sql) or die (mysqli_error($connect));
						  $sub_row=mysqli_fetch_array($result2);

							$sns_url ='http://' . $http_host . "/portfolio/portfolio_list_view.php?idx=".$sub_row['r_idx'];
							$img_url ="http://".$_SERVER['HTTP_HOST']."/upload/file/".$sub_row['r_file'];
						?>
						<li>
							<a href="?idx=<?=$sub_row['r_idx']?>">
								<div class="img_box">
									<img src="http://<?=$_SERVER['HTTP_HOST']?>/upload/file/<?=$sub_row['r_file']?>" alt="" >
								</div>
								<div class="text">
									<div class="txt_box">
										<b class="title"><?=$sub_row['r_title']?></b>
										<p class="type"><?=$sub_row['r_output']?></b>
									</div>
									<div class="social_box">
										<ul class="social_link">
											<li>
												<a href="#!" class="share-facebook" link_url="<?=$sns_url?>" img_url="<?=$img_url?>" list_title="<?=$sub_row['r_title']?>"  r_idx="<?=$sub_row['r_idx']?>">
													<img src="../img/ico/social_link_img01.png" alt="페이스북 아이콘 이미지">
												</a>
											</li>
											<li class="share-twitter" link_url="<?=$sns_url?>"  list_tile="<?=$sub_row['r_file']?>">
												<a href="#!" ><img src="../img/ico/social_link_img02.png" alt="트위터 아이콘 이미지"></a>
											</li>
											<?if($sub_row['r_url']){?>
											<li><a href="<?=$sub_row['r_url']?>" target="_blank"><img src="../img/ico/social_link_img06.png" alt="link 아이콘 이미지"></a></li>
											<?}?>
										</ul>
										<b class="favorite_add active"></b>
									</div>
								</div>
							</a>
						</li>
						<?}?>
					</ul>
				</div>
			</div>
		</div>
		<input type="hidden" name="check_face" id="check_face" value="N">
	</section><!-- //container End -->
<? include('../inc/footer.inc.php');?>


<script type="text/javascript">
/* 포트폴리오 gnb */
$(document).ready(function(){
	

	$("#potfolio_gnb > ul > li").click(function(){ //탭 클릭시
			$("#potfolio_gnb > ul > li").removeClass("active");
			$(this).addClass("active");
	});
	//sns 퍼가기 facebook
	$(document).on('click',".share-facebook",function() {


		var r_idx =$(this).attr("r_idx");
			
		var url = "http://uwal.co.kr//portfolio/portfolio_sns.php?idx="+r_idx;

		url ="https:\//www.facebook.com/sharer/sharer.php?u="+encodeURIComponent(url);
			
			
		window.open(url, "win_facebook", "menubar=1,resizable=1,width=600,height=400");

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

$(document).ready(function(){
	$(".potfolio_text .text img").css("height","");
	$(".potfolio_text .text img").css("width","100%");

    var activeTxt = $('#potfolio_gnb ul li.active a').text();
    $('.potfolio_top #potfolio_gnb b.sub_gnb_tit .stm_tit').text(activeTxt);
});
</script>
<style>
.potfolio_box .potfolio_top .potfolio_favorite li::after{display:none;}
</style>
