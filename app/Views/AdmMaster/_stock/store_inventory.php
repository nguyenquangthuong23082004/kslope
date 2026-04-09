<? include "../_include/_header.php"; ?>
	
		
<?

	$size_type = updateSQ($_GET["size_type"]);
	$search_type = updateSQ($_GET["search_type"]);
	$search_keyword = updateSQ($_GET["search_keyword"]);

	if($search_keyword !=""){
		if($search_type == "shop_name"){
			$sWhere = " and a.".$search_type." like '%".$search_keyword."%' ";
		}
		if($search_type == "goods_code"){
			$sWhere = " and g.".$search_type." like '%".$search_keyword."%' ";
		}
		if($search_type == "goods_name_front"){
			$sWhere = " and g.".$search_type." like '%".$search_keyword."%' ";
		}
		if($search_type == "goods_color"){
			$sWhere = " and c.goods_color = (select code_no from tbl_color where code_name like '%".$search_keyword."%' limit 0,1) ";
		}
	}
	

	if($size_type == ""){
		$size_type = "신발";
	}


	$sql = "select";
	$sql = $sql." m_idx, shop_name, goods_name_front, goods_code";
	$sql = $sql." , (select code_name from tbl_color as co where co.code_no = goods_color) as goods_color";
	
	$sql = $sql." , IFNULL(SUM(A),0) as A";
	$sql = $sql." , IFNULL(SUM(B),0) as B";
	$sql = $sql." , IFNULL(SUM(C),0) as C";
	$sql = $sql." , IFNULL(SUM(D),0) as D";
	$sql = $sql." , IFNULL(SUM(E),0) as E";
	$sql = $sql." , IFNULL(SUM(F),0) as F";
	$sql = $sql." , IFNULL(SUM(G),0) as G";
	$sql = $sql." , IFNULL(SUM(H),0) as H";
	$sql = $sql." , IFNULL(SUM(I),0) as I";
	$sql = $sql." , IFNULL(SUM(J),0) as J";
	$sql = $sql." , IFNULL(SUM(K),0) as K";
	$sql = $sql." , IFNULL(SUM(L),0) as L";
	$sql = $sql." , IFNULL(SUM(M),0) as M";
	$sql = $sql." , IFNULL(SUM(N),0) as N";
	$sql = $sql." , IFNULL(SUM(O),0) as O";

	//$sql = $sql." , sum(price_normal) as price_normal, sum(price_margin) as price_margin, sum(price_one) as price_one";
	$sql = $sql." , price_normal, price_margin, price_one";
	$sql = $sql."   from (";
	$sql = $sql." 	select a.m_idx, a.shop_name, g.goods_name_front, c.goods_code, c.goods_color, c.price_normal, c.price_margin, c.price_one";   
	
	if($size_type == "신발"){
		$sql = $sql." 		, CASE WHEN b.goods_size = '72' OR b.goods_size = '79' THEN c.goods_cnt END AS A";
		$sql = $sql." 		, CASE WHEN b.goods_size = '73' OR b.goods_size = '80' THEN c.goods_cnt END AS B";
		$sql = $sql." 		, CASE WHEN b.goods_size = '74' OR b.goods_size = '81' THEN c.goods_cnt END AS C";
		$sql = $sql." 		, CASE WHEN b.goods_size = '75' OR b.goods_size = '82' THEN c.goods_cnt END AS D";
		$sql = $sql." 		, CASE WHEN b.goods_size = '76' OR b.goods_size = '83' THEN c.goods_cnt END AS E";
		$sql = $sql." 		, CASE WHEN b.goods_size = '77' OR b.goods_size = '84' OR b.goods_size = '86' THEN c.goods_cnt END AS F";
		$sql = $sql." 		, CASE WHEN b.goods_size = '78' OR b.goods_size = '85' OR b.goods_size = '87' THEN c.goods_cnt END AS G";
		$sql = $sql." 		, CASE WHEN b.goods_size = '95' OR b.goods_size = '88' THEN c.goods_cnt END AS H";
		$sql = $sql." 		, CASE WHEN b.goods_size = '96' OR b.goods_size = '89' THEN c.goods_cnt END AS I";
		$sql = $sql." 		, CASE WHEN b.goods_size = '90' OR b.goods_size = '97' THEN c.goods_cnt END AS J";
		$sql = $sql." 		, CASE WHEN b.goods_size = '91' OR b.goods_size = '115' THEN c.goods_cnt END AS K";
		$sql = $sql." 		, CASE WHEN b.goods_size = '92' OR b.goods_size = '98' THEN c.goods_cnt END AS L";
		$sql = $sql." 		, CASE WHEN b.goods_size = '93' OR b.goods_size = '99' THEN c.goods_cnt END AS M";
		$sql = $sql." 		, CASE WHEN b.goods_size = '94' OR b.goods_size = '100' THEN c.goods_cnt END AS N";
		$sql = $sql." 		, CASE WHEN b.goods_size = '117' OR b.goods_size = '119' THEN c.goods_cnt END AS O";		
	}

	if($size_type == "상의"){
		$sql = $sql."		, CASE WHEN b.goods_size = '120' THEN c.goods_cnt END AS A 	";/*여성 85*/
		$sql = $sql."		, CASE WHEN b.goods_size = '112' THEN c.goods_cnt END AS B 	";/*여성 90*/
		$sql = $sql."		, CASE WHEN b.goods_size = '113' THEN c.goods_cnt END AS C 	";/*여성 95*/
		$sql = $sql."		, CASE WHEN b.goods_size = '114' THEN c.goods_cnt END AS D ";/*여성 100*/	
		$sql = $sql."		, CASE WHEN b.goods_size = '121' THEN c.goods_cnt END AS E 	";/*여성 105*/
		$sql = $sql."		, CASE WHEN b.goods_size = '122' THEN c.goods_cnt END AS F 	";/*여성 110*/
		$sql = $sql."		, CASE WHEN b.goods_size = '105' THEN c.goods_cnt END AS G ";  /* 남성 90*/  
		$sql = $sql."		, CASE WHEN b.goods_size = '101' THEN c.goods_cnt END AS H 	"; /*남성 95*/
		$sql = $sql."		, CASE WHEN b.goods_size = '102' THEN c.goods_cnt END AS I 	"; /*남성 100*/
		$sql = $sql."		, CASE WHEN b.goods_size = '103' THEN c.goods_cnt END AS J 	"; /*남성 105*/
		$sql = $sql."		, CASE WHEN b.goods_size = '104' THEN c.goods_cnt END AS K "; /*남성 110*/	
		$sql = $sql."		, CASE WHEN b.goods_size = '106' THEN c.goods_cnt END AS L 	";/*FREE*/
		$sql = $sql." 		, 0 AS M";
		$sql = $sql." 		, 0 AS N";
		$sql = $sql." 		, 0 AS O";
	}
	
	if($size_type == "남성하의"){
		$sql = $sql." 		, CASE WHEN b.goods_size = '136' THEN c.goods_cnt END AS A"; /*64*/
		$sql = $sql." 		, CASE WHEN b.goods_size = '137' THEN c.goods_cnt END AS B"; /*69*/
		$sql = $sql." 		, CASE WHEN b.goods_size = '138' THEN c.goods_cnt END AS C"; /*74*/
		$sql = $sql." 		, CASE WHEN b.goods_size = '107' THEN c.goods_cnt END AS D"; /*76*/
		$sql = $sql." 		, CASE WHEN b.goods_size = '139' THEN c.goods_cnt END AS E"; /*79*/
		$sql = $sql." 		, CASE WHEN b.goods_size = '108' THEN c.goods_cnt END AS F"; /*81*/
		$sql = $sql." 		, CASE WHEN b.goods_size = '140' THEN c.goods_cnt END AS G"; /*84*/
		$sql = $sql." 		, CASE WHEN b.goods_size = '109' THEN c.goods_cnt END AS H"; /*86*/
		$sql = $sql." 		, CASE WHEN b.goods_size = '110' THEN c.goods_cnt END AS I"; /*91*/
		$sql = $sql." 		, CASE WHEN b.goods_size = '111' THEN c.goods_cnt END AS J"; /*96*/
		$sql = $sql." 		, CASE WHEN b.goods_size = '141' THEN c.goods_cnt END AS K"; /*101*/
		$sql = $sql." 		, 0 AS L";
		$sql = $sql." 		, 0 AS M";
		$sql = $sql." 		, 0 AS N";
		$sql = $sql." 		, 0 AS O";		
	}

	if($size_type == "허리사이즈"){
		$sql = $sql." 		, CASE WHEN b.goods_size = '123' THEN c.goods_cnt END AS A"; /*26*/
		$sql = $sql." 		, CASE WHEN b.goods_size = '124' THEN c.goods_cnt END AS B"; /*28*/
		$sql = $sql." 		, CASE WHEN b.goods_size = '125' THEN c.goods_cnt END AS C"; /*30*/
		$sql = $sql." 		, CASE WHEN b.goods_size = '126' THEN c.goods_cnt END AS D"; /*32*/
		$sql = $sql." 		, CASE WHEN b.goods_size = '127' THEN c.goods_cnt END AS E"; /*34*/
		$sql = $sql." 		, CASE WHEN b.goods_size = '128' THEN c.goods_cnt END AS F"; /*36*/
		$sql = $sql." 		, CASE WHEN b.goods_size = '129' THEN c.goods_cnt END AS G"; /*38*/
		$sql = $sql." 		, CASE WHEN b.goods_size = '130' THEN c.goods_cnt END AS H"; /*65*/
		$sql = $sql." 		, CASE WHEN b.goods_size = '132' THEN c.goods_cnt END AS I"; /*75*/
		$sql = $sql." 		, CASE WHEN b.goods_size = '133' THEN c.goods_cnt END AS J"; /*80*/
		$sql = $sql." 		, CASE WHEN b.goods_size = '134' THEN c.goods_cnt END AS K"; /*85*/
		$sql = $sql." 		, CASE WHEN b.goods_size = '135' THEN c.goods_cnt END AS L"; /*90*/
		$sql = $sql." 		, 0 AS M";
		$sql = $sql." 		, 0 AS N";
		$sql = $sql." 		, 0 AS O";		
	}


	
	$sql = $sql." 	from tbl_market as a ";
	$sql = $sql." 	inner join tbl_goods_agency_option as b ";
	$sql = $sql." 		on a.m_idx = b.m_idx  ";

	$sql = $sql."	inner join tbl_goods as g "; 
	$sql = $sql." 		on b.goods_code = g.goods_code ";

	$sql = $sql." 	inner join tbl_goods_adm_option as c ";
	$sql = $sql." 		on a.m_idx = c.m_idx 
							and b.goods_code = b.goods_code 
							and b.goods_color = c.goods_color 
							and b.goods_size = c.goods_size";


	$sql = $sql."	left join tbl_size as size on c.goods_size = size.code_no ";
	if($size_type == "신발"){
		$sql = $sql." 		where size.type in(6,8,9) ";
	}
	if($size_type == "상의"){
		$sql = $sql." 		where size.type in(7,12,10) ";
	}
	if($size_type == "남성하의"){
		$sql = $sql." 		where size.type in(11) ";
	}
	if($size_type == "허리사이즈"){
		$sql = $sql." 		where size.type in(13) ";
	}
	
	$sql = $sql.$sWhere;


	$sql = $sql." ) AS T ";
	$sql = $sql." group by shop_name, goods_code, goods_color order by m_idx ASC, goods_code ASC";
		
	
	//echo $sql;
	$result = mysqli_query($connect, $sql) or die (mysql_error($connect));

?>
		<div id="container">
			<span id="print_this"><!-- 인쇄영역 시작 //-->

				<header id="headerContainer" >
					
					<div class="inner">
						<h2>매장재고현황</h2>
					</div><!-- // inner -->

				</header><!-- // headerContainer -->

				<div id="contents">
					<form name="frmSearch" id="frmSearch" method="get"  >		
						<header id="headerContents" class="edit1" style="height:40px;" >
							
							<select id="size_type" name="size_type" class="input_select" >								
								<option value="신발" <? if($size_type == "신발"){echo "selected";}?>>신발</option>
								<option value="상의" <? if($size_type == "상의"){echo "selected";}?>>상의 및 FREE</option>
								<option value="남성하의" <? if($size_type == "남성하의"){echo "selected";}?>>남성의류-하의</option>
								<option value="허리사이즈" <? if($size_type == "허리사이즈"){echo "selected";}?>>허리사이즈</option>
							</select>							
							
							<select id="search_type" name="search_type" class="input_select" >
								<option value="">검색</option>
								<option value="shop_name" <? if($search_type == "shop_name"){echo "selected";}?>>매장명</option>
								<option value="goods_code" <? if($search_type == "goods_code"){echo "selected";}?>>상품코드</option>
								<option value="goods_name_front" <? if($search_type == "goods_name_front"){echo "selected";}?>>상품명</option>
								<option value="goods_color" <? if($search_type == "goods_color"){echo "selected";}?>>색상</option>
							</select>

							<input type="text" id="search_keyword" name="search_keyword" value="<?=$search_keyword?>" class="input_txt placeHolder" placeholder="검색어 입력"/>

							<a href="javascript:fncSearchList()" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> <span class="txt" >검색하기</span></a>

						
						</header><!-- // headerContents -->
					</form>
					<form name="excelfrm" id="excelfrm" action="excelfileUpload.php" method="post"  enctype="multipart/form-data"  >
					<div style="height:30px; padding-bottom:10px;">
							<a href="javascript:fncExcelUpload();" class="btn btn-primary fr"><span class="txt">파일업로드</span></a>
							<a href="#n" class="fr" ><input type="file" name="ufile1" id="ufile1" style="width:190px;"  /></a> 
							
							<select id="size_type_" name="size_type_" class="input_select fr" style="margin-right:10px;" >								
								<option value="" >업로드 할 사이즈 정보 선택</option>
								<option value="신발">신발</option>
								<option value="상의">상의 및 FREE</option>
								<option value="남의하의">남성의류-하의</option>
								<option value="허리사이즈">허리사이즈</option>
							</select>
					</div>
					</form>


					<div class="listWrap edit2">
						<!-- 안내 문구 필요시 구성 //-->

						<div class="srock_list">
							<form name="" id="">				
								<div class="listBottom">
									<table cellpadding="0" cellspacing="0" summary="" class="listTable">
										<caption>매장 재고 현황</caption>
										<colgroup>
											<col width="" />
											<col width="" />
											<col width="" />
											<col width="" />
											<col width="" />
											<col width="40" />
											<col width="40" />
											<col width="40" />
											<col width="40" />
											<col width="40" />
											<col width="40" />
											<col width="40" />
											<col width="40" />
											<col width="40" />
											<col width="40" />
											<col width="40" />
											<col width="40" />
											<col width="40" />
											<col width="40" />
											<col width="40" />
										</colgroup>
										<thead>
											<tr>
												<th rowspan="2" style="height:50px;">기본정보</th>
												<th rowspan="2" colspan="3">상품정보</th>
												<th rowspan="3">재고수량</th>
												<th rowspan="2" colspan="15">사이즈정보(
												<?
												if($size_type == "상의"){
													echo "상의 사이즈 및 기타(FREE)";
												}else{
													echo $size_type;
												}
												?>
												)</th>
												<th rowspan="2" colspan="3">상품단가정보</th>
											</tr>

							
											<tr>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
											</tr>
		
											<tr>
												<th>매장명</th>
												<th>상품코드</th>
												<th>상품명</th>
												<th>색상</th>
												
										<?	if($size_type == "신발"){?>
												<th>225</th>
												<th>230</th>
												<th>235</th>
												<th>240</th>
												<th>245</th>
												<th>250</th>
												<th>255</th>
												<th>260</th>
												<th>265</th>
												<th>270</th>
												<th>275</th>
												<th>280</th>
												<th>285</th>
												<th>290</th>
												<th>300</th>
										<? } ?>	
										<?	if($size_type == "상의"){?>
												<th>85</th>
												<th>90</th>
												<th>95</th>
												<th>100</th>
												<th>105</th>
												<th>110</th>
												<th>S</th>
												<th>M</th>
												<th>L</th>
												<th>XL</th>
												<th>XXL</th>
												<th>FREE</th>
												<th></th>
												<th></th>
												<th></th> 
										<? } ?>	


										<?	if($size_type == "남성하의"){?>
												<th>64</th>
												<th>69</th>
												<th>74</th>
												<th>76</th>
												<th>79</th>
												<th>81</th>
												<th>84</th>
												<th>86</th>
												<th>91</th>
												<th>96</th>
												<th>101</th>
												<th>&nbsp;</th>
												<th>&nbsp;</th>
												<th>&nbsp;</th>
												<th>&nbsp;</th> 
										<? } ?>	
										<?	if($size_type == "허리사이즈"){?>
												<th>26</th>
												<th>28</th>
												<th>30</th>
												<th>32</th>
												<th>34</th>
												<th>36</th>
												<th>38</th>
												<th>65</th>
												<th>75</th>
												<th>80</th>
												<th>85</th>
												<th>90</th>
												<th>&nbsp;</th>
												<th>&nbsp;</th>
												<th>&nbsp;</th>
										<? } ?>	
												<th>정상가</th>
												<th>마진</th>
												<th>판매가</th>
											</tr>
										</thead>	
										<tbody>

						<?
						while($row = mysqli_fetch_array($result)){

								
								$g_cnt = $row['A'] + $row['B']+ $row['C']+ $row['D']+ $row['E']+ $row['F']+ $row['G']+ $row['H']+ $row['I']+ $row['J']+ $row['K']+ $row['L']+ $row['M']+ $row['N']+ $row['O'];
								
								$sum_g_cnt = $sum_g_cnt + $g_cnt;
								$sum_A = $sum_A + $row['A'];
								$sum_B = $sum_B + $row['B'];
								$sum_C = $sum_C + $row['C'];
								$sum_D = $sum_D + $row['D'];
								$sum_E = $sum_E + $row['E'];
								$sum_F = $sum_F + $row['F'];
								$sum_G = $sum_G + $row['G'];
								$sum_H = $sum_H + $row['H'];
								$sum_I = $sum_I + $row['I'];
								$sum_J = $sum_J + $row['J'];
								$sum_K = $sum_K + $row['K'];
								$sum_L = $sum_L + $row['L'];
								$sum_M = $sum_M + $row['M'];
								$sum_N = $sum_N + $row['N'];
								$sum_O = $sum_O + $row['O'];
								
								$price_normal = $price_normal + $row['price_normal'];
								$price_margin = $price_margin + $row['price_margin'];
								$price_one = $price_one + $row['price_one'];

						?>
											<tr>
												<td><?=$row['shop_name']?></td>
												<td><?=$row['goods_code']?></td>
												<td><?=$row['goods_name_front']?></td>
												<td><?=$row['goods_color']?></td>
												<td><?=$g_cnt?></td>
												<td><?=$row['A']?></td>
												<td><?=$row['B']?></td>
												<td><?=$row['C']?></td>
												<td><?=$row['D']?></td>
												<td><?=$row['E']?></td>
												<td><?=$row['F']?></td>
												<td><?=$row['G']?></td>
												<td><?=$row['H']?></td>
												<td><?=$row['I']?></td>
												<td><?=$row['J']?></td>
												<td><?=$row['K']?></td>
												<td>
													<?
														if($size_type != "남성하의"){ 
															echo $row['L'];
														}else{
															echo "&nbsp;";
														}
													?>											
												</td>
												<td>
													<?
														if($size_type == "신발"){ 
															echo $row['M'];
														}else{
															echo "&nbsp;";
														}
													?>
												</td>
												<td>
													<?
														if($size_type == "신발"){ 
															echo $row['N'];
														}else{
															echo "&nbsp;";
														}
													?>
												</td>
												<td>
												<?
														if($size_type == "신발"){ 
															echo $row['O'];
														}else{
															echo "&nbsp;";
														}
													?>												
												</td>
												<td><?=number_format($row['price_normal'])?></td>
												<td><?=number_format($row['price_margin'])?></td>
												<td><?=number_format($row['price_one'])?></td>
											</tr>
					<?
					}
						?>

											<tr>
												<td colspan="4">합계</td>
												
												<td><?=$sum_g_cnt?></td>
												<td><?=$sum_A?></td>
												<td><?=$sum_B?></td>
												<td><?=$sum_C?></td>
												<td><?=$sum_D?></td>
												<td><?=$sum_E?></td>
												<td><?=$sum_F?></td>
												<td><?=$sum_G?></td>
												<td><?=$sum_H?></td>
												<td><?=$sum_I?></td>
												<td><?=$sum_J?></td>
												<td><?=$sum_K?></td>
												<td>												
													<?
														if($size_type != "남성하의"){ 
															echo $sum_L;
														}else{
															echo "&nbsp;";
														}
													?>
													
												</td>
												<td>
<?
														if($size_type == "신발"){ 
															echo $sum_M;
														}else{
															echo "&nbsp;";
														}
?>												
												</td>
												<td>
<?
														if($size_type == "신발"){ 
															echo $sum_N;
														}else{
															echo "&nbsp;";
														}
?>												
												</td>
												<td>
<?
														if($size_type == "신발"){ 
															echo $sum_O;
														}else{
															echo "&nbsp;";
														}
?>												
												</td>
												<td><?=number_format($price_normal)?></td>
												<td><?=number_format($price_margin)?></td>
												<td><?=number_format($price_one)?></td>
											</tr>
										</tbody>
									</table>
								</div><!-- // listBottom -->
							</form>
						</div>
					</div><!-- // listWrap -->

				</div><!-- // contents -->
			</span><!-- 인쇄 영역 끝 //-->
		</div><!-- // container -->





<script>

 function fncExcelUpload(){
	
	if($("#size_type_").val() == ""){
		alert("업로드할 사이즈를 선택해주세요.");
		return false;
	}

	if($("#ufile1").val() == ""){
		alert("업로드할 파일을 등록해주세요.");
		return false;
	}

	var fom = document.excelfrm;

	var sUrl = "";
	if($("#size_type_").val() == "신발"){
		fom.action = "excelfileUpload.php";
	}else if($("#size_type_").val() == "상의"){
		fom.action = "excelfileUpload_1.php";
	}else if($("#size_type_").val() == "남의하의"){
		fom.action = "excelfileUpload_2.php";
	}else if($("#size_type_").val() == "허리사이즈"){
		fom.action = "excelfileUpload_3.php";
	}

	fom.submit();
	
 }
 

 function fncSearchList(){
	var fom = document.frmSearch;	
	fom.action = "store_inventory.php";
	fom.submit();
 
 }

 function CheckAll(checkBoxes,checked){
    var i;
    if(checkBoxes.length){
        for(i=0;i<checkBoxes.length;i++){
            checkBoxes[i].checked=checked;
        }
    }else{
        checkBoxes.checked=checked;
   }

}

function SELECT_DELETE() {
		if ($(".product_idx").is(":checked") == false)
		{
			alert_("삭제할 내용을 선택하셔야 합니다.");
			return;
		}
		if (confirm("삭제 하시겠습니까?\n삭제후에는 복구가 불가능합니다.") == false)
		{
			return;
		}

		$("#ajax_loader").removeClass("display-none");

        $.ajax({
			url: "del.php",
			type: "POST",
			data: $("#frm").serialize(),
			error : function(request, status, error) {
			 //통신 에러 발생시 처리
				alert_("code : " + request.status + "\r\nmessage : " + request.reponseText);
				$("#ajax_loader").addClass("display-none");
			}
			,complete: function(request, status, error) {
//				$("#ajax_loader").addClass("display-none");
			}
			, success : function(response, status, request) {
				if (response == "OK")
				{
					alert_("정상적으로 삭제되었습니다.");
						location.reload();
					return;
				} else {
					alert(response);
					alert_("오류가 발생하였습니다!!");
					return;
				}
			}
        });
 
}

function del_it(product_idx) {

		if (confirm("삭제 하시겠습니까?\n삭제후에는 복구가 불가능합니다.") == false)
		{
			return;
		}
		$("#ajax_loader").removeClass("display-none");
        $.ajax({
			url: "del.php",
			type: "POST",
			data: "product_idx[]="+product_idx,
			error : function(request, status, error) {
			 //통신 에러 발생시 처리
				alert_("code : " + request.status + "\r\nmessage : " + request.reponseText);
				$("#ajax_loader").addClass("display-none");
			}
			,complete: function(request, status, error) {
//				$("#ajax_loader").addClass("display-none");
			}
			, success : function(response, status, request) {
				if (response == "OK")
				{
					alert_("정상적으로 삭제되었습니다.");
					location.reload();
					return;
				} else {
					alert(response);
					alert_("오류가 발생하였습니다!!");
					return;
				}
			}
        });
 
}

		function get_code(strs, depth)
		{
				$.ajax({
					type:"GET"
					, url:"get_code.ajax.php"
					, dataType : "html" //전송받을 데이터의 타입
					, timeout : 30000 //제한시간 지정
					, cache : false  //true, false
					, data : "parent_code_no="+ encodeURI(strs) +"&depth="+depth //서버에 보낼 파라메터
					,error : function(request, status, error) {
					 //통신 에러 발생시 처리
						alert("code : " + request.status + "\r\nmessage : " + request.reponseText);
					}
					, success:function(json){
						//alert(json);
						if (depth <= 3)
						{
							$("#product_code_2").find('option').each(function() {
								$(this).remove();
							});
							$("#product_code_2").append("<option value=''>2차분류</option>");
						}
						if (depth <= 4)
						{
							$("#product_code_3").find('option').each(function() {
								$(this).remove();
							});
							$("#product_code_3").append("<option value=''>3차분류</option>");
						}
						if (depth <= 4)
						{
							$("#product_code_4").find('option').each(function() {
								$(this).remove();
							});
							$("#product_code_4").append("<option value=''>4차분류</option>");
						}
						var list = $.parseJSON(json);
						var listLen = list.length;
						var contentStr = "";
						for(var i=0; i<listLen; i++)
						{
							contentStr = "";
							if (list[i].code_status == "C")
							{
								contentStr = "[마감]";
							} else if (list[i].code_status == "N") {
								contentStr = "[사용안함]";
							}
							$("#product_code_"+(parseInt(depth)-1)).append("<option value='"+list[i].code_no+"'>"+list[i].code_name+""+contentStr+"</option>");
						}
					}
				});
		}
</script>


<? include "../_include/_footer.php"; ?>


<iframe style="width:0px; height:0px;" id="_excelFom" name="_excelFom"  ></iframe>