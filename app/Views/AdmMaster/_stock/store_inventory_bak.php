<? include "../_include/_header.php"; ?>
	
		

		<div id="container">
			<span id="print_this"><!-- 인쇄영역 시작 //-->

				<header id="headerContainer" >
					
					<div class="inner">
						<h2>매장재고현황</h2>
					</div><!-- // inner -->

				</header><!-- // headerContainer -->

				<div id="contents">
					<form name="search" id="search">		
						<header id="headerContents" class="edit1">
							<select id="" name="" class="input_select" onchange="">
								<option value="">1차분류</option>
								<option value=""></option>
							</select>

							<input type="text" id="" name="" value="" class="input_txt placeHolder" placeholder="검색어 입력"/>

							<a href="#!" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> <span class="txt">검색하기</span></a>
						</header><!-- // headerContents -->
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
											<col width="" />
											<col width="" />
											<col width="" />
											<col width="" />
											<col width="" />
											<col width="" />
											<col width="" />
											<col width="" />
											<col width="" />
											<col width="" />
											<col width="" />
											<col width="" />
											<col width="" />
											<col width="" />
											<col width="" />
										</colgroup>
										<thead>
											<tr>
												<th rowspan="5">기본정보</th>
												<th rowspan="5" colspan="3">상품정보</th>
												<th rowspan="6">재고수량</th>
												<th colspan="15">사이즈정보</th>
												<th rowspan="5"colspan="3">상품단가정보</th>
											</tr>
											<tr>
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
											</tr>

											<tr>
												<th>FREE</th>
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
												<th></th>
												<th></th>
												<th></th>
											</tr>
											<tr>
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
												<th></th>
												<th></th>
												<th></th>
												<th></th>
											</tr>
											<tr>
												<th>26</th>
												<th>28</th>
												<th>30</th>
												<th>32</th>
												<th>34</th>
												<th>36</th>
												<th>38</th>
												<th>65</th>
												<th>70</th>
												<th>75</th>
												<th>80</th>
												<th>85</th>
												<th>90</th>
												<th></th>
												<th></th>
											</tr>
											<tr>
												<th>매장명</th>
												<th>상품코드</th>
												<th>상품명</th>
												<th>색상</th>
												<th></th>
												<th></th>
												<th class="stock"></th>
												<th></th>
												<th></th>
												<th></th>
												<th></th>
												<th></th>
												<th></th>
												<th></th>
												<th></th>
												<th></th>
												<th></th>
												<th></th>
												<th></th>
												<th>정상가</th>
												<th>마진</th>
												<th>판매가</th>
											</tr>
										</thead>	
										<tbody>

											<tr>
												<td>(서울영등포)롯데영등포점 엘트레일</td>
												<td>C1B5MT1001</td>
												<td>히페리온</td>
												<td>KH</td>
												<td>1</td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td>-1</td>
												<td></td>
												<td>1</td>
												<td>1</td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td>278,400</td>
												<td>88,582</td>
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