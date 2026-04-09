
function get_code(strs, depth)
{
	$.ajax({
		type:"GET"
		, url:"get_group.ajax.php"
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
			if (depth <= 2)
			{
				$("#product_code_2").find('option').each(function() {
					$(this).remove();
				});
				$("#product_code_2").append("<option value=''>2차분류</option>");
			}

			if (depth <= 3)
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
				$("#product_code_"+(parseInt(depth))).append("<option value='"+list[i].code_no+"'>"+list[i].code_name+""+contentStr+"</option>");
			}
		}
	});
}





function del_it() {
	if(confirm(" 삭제후 복구하실수 없습니다. \n\n 삭제하시겠습니까?")) {
		hiddenFrame22.location.href = "del.php?idx[]=<?=$idx?>&mode=view";
	}
 
}


$(document).ready(function(){
	// 카테고리 추가 부분 시작
	$("#btn_reg_cate").click(function(){

		var tmp_code = "";
		var tmp_code_txt = "";

		var cate_code1 = $("#product_code_1").val();
		var cate_text1 = $("#product_code_1 option:selected").text();
		
		if(cate_code1!=""){	
			tmp_code = cate_code1;
			tmp_code_txt += cate_text1;
		}

		var cate_code2 = $("#product_code_2").val();
		var cate_text2 = $("#product_code_2 option:selected").text();

		if(cate_code2!=""){
			tmp_code = cate_code2;
			tmp_code_txt += " > " + cate_text2;
		}

		var cate_code3 = $("#product_code_3").val();
		var cate_text3 = $("#product_code_3 option:selected").text();

		if(cate_code3!=""){
			tmp_code = cate_code3;
			tmp_code_txt += " > " + cate_text3;
		}

		var cate_code4 = $("#product_code_4").val();
		var cate_text4 = $("#product_code_4 option:selected").text();

		if(cate_code4!=""){
			tmp_code = cate_code4;
			tmp_code_txt += " > " + cate_text4;
		}

		if(tmp_code == ""){
			alert("카테고리를 선택해주세요.");
			return false;
		}
		addCategory(tmp_code, tmp_code_txt);
		
	});

	

	// 코드 중복 체크 검색창 변경 시에 체크 초기화
	$("#pop_search").change(function(){
		$("#chk_codeCnt").val("");
	});


	// 코드 중복 체크 닫기 버튼
	$(".btn_box > .close_btn").click(function(){
		// 검색 관련 전체 초기화
		$("#chk_codeType").val("");
		$("#chk_codeCnt").val("");
		$(".result_text").html("<strong>코드</strong>를 입력하신 후 조회해주세요.");
		$(".popup").hide();
	});

	// 코드 중복 체크 사용 버튼
	$(".btn_box > .ok_btn").click(function(){
		// 검색 관련 전체 초기화
		var chk_codeType = $("#chk_codeType").val();
		var chk_codeCnt = $("#chk_codeCnt").val();
		var pop_search = $("#pop_search").val();
		$(".result_text").html("<strong>코드</strong>를 입력하신 후 조회해주세요.");

		if(pop_search.trim() == ""){
			alert("코드를 입력해주세요.");
			return false;
		}

		if(chk_codeCnt==""){
			alert("코드를 조회해주세요.");
			return false;
		}

		// 중복된 코드가 없을 때
		if(chk_codeCnt=="0"){

			if(chk_codeType == "code"){
				$("#goods_code").val(pop_search);
			}else if(chk_codeType == "erp"){
				$("#goods_erp").val(pop_search);
			}


			$("#chk_codeType").val("");
			$("#chk_codeCnt").val("");
			$(".popup").hide();

		}else{
			alert("해당 코드를 사용할 수 없습니다.");
			return false;
		}
	});

	$(".name_search").click(function(){
		selectCode();
	});


	$("#pop_search").keyup(function(e){
		if( e.keyCode == 13 ){
			selectCode();
		}
	});
	

});



function selectCode(){
	var codeType = $("#chk_codeType").val();
	var searchCode = $("#pop_search").val();

	$.ajax({
		url: "search_code.php",
		type: "POST",
		data: "codeType="+codeType+"&searchCode="+searchCode,
		error : function(request, status, error) {
		 //통신 에러 발생시 처리
			alert_("code : " + request.status + "\r\nmessage : " + request.reponseText);
			$("#ajax_loader").addClass("display-none");
		}
		,complete: function(request, status, error) {

		}
		, success : function(response, status, request) {
			$("#chk_codeCnt").val(response);

			response = parseInt(response);
			
			if(response==0){
				$(".result_text").html("<p class='result_text'>요청하신 <strong>코드</strong>는 사용 <span>가능</span> 합니다.</p>");
			}else if(response > 0){
				$(".result_text").html("<p class='result_text'>요청하신 <strong>코드</strong>는 사용 <span>불가능</span> 합니다.</p>");
			}

			
		}
	});
}


// 카테고리 추가 함수
function addCategory(code, cateText){
	// 코드 추가 부분
	if(chkCategory(code) > -1){
		alert("이미 등록된 카테고리입니다.");
		return false;
	}
	var tmp_product_code = $("#product_code").val();
	tmp_product_code = tmp_product_code + "|" + code + "|";
	$("#product_code").val(tmp_product_code);

	var newList =  "<li>["+code+"] "+cateText+" <span onclick=\"delCategory('"+code+"', this);\" >삭제</span></li>";
	$("#reg_cate").append(newList);
}

// 카테고리 삭제 함수
function delCategory(code,obj){
	
	if(chkCategory(code) > -1){

		var tmp_product_code = $("#product_code").val();		
		var re_tmp_product_code = tmp_product_code.substr(1,tmp_product_code.length-2);

		var code_array = re_tmp_product_code.split('||');

		var tmp_product_code_re = "";

		$.each(code_array , function(key, val){
			if(val != code){
				tmp_product_code_re = tmp_product_code_re + "|" + val + "|";
			}
		});

		$("#product_code").val(tmp_product_code_re);
		obj.closest("li").remove();
		
	}
}

// 카테고리 중복확인
function chkCategory(chkcode){
	var tmp_product_code = $("#product_code").val();
	var re_tmp_product_code = tmp_product_code.substr(1,tmp_product_code.length-2);

	var code_array = re_tmp_product_code.split('||');
	
	return( $.inArray(chkcode, code_array) );
}