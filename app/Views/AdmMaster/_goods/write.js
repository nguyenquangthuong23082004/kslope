
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


function get_group(strs, depth)
{
	$.ajax({
		type:"GET"
		, url:"../_code/get_group.ajax.php"
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
				$("#product_group_2").find('option').each(function() {
					$(this).remove();
				});
				$("#product_group_2").append("<option value=''>2차분류</option>");
			}

			if (depth <= 3)
			{
				$("#product_group_3").find('option').each(function() {
					$(this).remove();
				});
				$("#product_group_3").append("<option value=''>3차분류</option>");
			}

			if (depth <= 4)
			{
				$("#product_group_4").find('option').each(function() {
					$(this).remove();
				});
				$("#product_group_4").append("<option value=''>4차분류</option>");
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
				$("#product_group_"+(parseInt(depth))).append("<option value='"+list[i].code_no+"'>"+list[i].code_name+""+contentStr+"</option>");
			}
		}
	});

	return this;
}



function send_it()
{
	var frm = document.frm;

	$('#content').summernote('code');
	//$('#caution').summernote('code');

		
	if (frm.product_code.value == "")
	{
		alert("카테고리를 등록해주세요.");
		frm.product_code_1.focus();
		return;
	}

	if (frm.goods_code.value == "")
	{
		alert("상품코드(모델명)를 입력해주세요.");
		frm.goods_code.focus();
		return;
	}


	if (frm.goods_name_front.value == "")
	{
		alert("상품명(앞)을 입력해주세요.");
		frm.goods_name_front.focus();
		return;
	}
	//셀프약정기간이 중복됬는지 확인
	// var self_period1 = '';
	// var self_period2 = '';
	// var self_period3 = '';
	// var self_period4 = '';
	// var arrChkself = new Array();
	
	// if ( frm.self_period1.value != '' )
	// {
	// 	self_period1 = frm.self_period1.value;
	// 	if ( arrChkself.includes(self_period1) == true )
	// 	{
	// 		alert("약정기간이 중복되었습니다..");
	// 		return false;
	// 	}else{
	// 		arrChkself.push(self_period1);
	// 	}
	// }
	// if ( frm.self_period2.value != '' )
	// {
	// 	self_period2 = frm.self_period2.value;
	// 	if ( arrChkself.includes(self_period2) == true )
	// 	{
	// 		alert("약정기간이 중복되었습니다..");
	// 		return false;
	// 	}else{
	// 		arrChkself.push(self_period2);
	// 	}
	// }
	// if ( frm.self_period3.value != '' )
	// {
	// 	self_period3 = frm.self_period3.value;
	// 	if ( arrChkself.includes(self_period3) == true )
	// 	{
	// 		alert("약정기간이 중복되었습니다..");
	// 		return false;
	// 	}else{
	// 		arrChkself.push(self_period3);
	// 	}
	// }
	// if ( frm.self_period4.value != '' )
	// {
	// 	self_period4 = frm.self_period4.value;
	// 	if ( arrChkself.includes(self_period4) == true )
	// 	{
	// 		alert("약정기간이 중복되었습니다..");
	// 		return false;
	// 	}else{
	// 		arrChkself.push(self_period4);
	// 	}
	// }

	// //방문약정기간이 중복됬는지 확인
	// var visit_period1 = '';
	// var visit_period2 = '';
	// var visit_period3 = '';
	// var visit_period4 = '';
	// var arrChkvisit = new Array();
	
	// if ( frm.visit_period1.value != '' )
	// {
	// 	visit_period1 = frm.visit_period1.value;
	// 	if ( arrChkvisit.includes(visit_period1) == true )
	// 	{
	// 		alert("약정기간이 중복되었습니다..");
	// 		return false;
	// 	}else{
	// 		arrChkvisit.push(visit_period1);
	// 	}
	// }
	// if ( frm.visit_period2.value != '' )
	// {
	// 	visit_period2 = frm.visit_period2.value;
	// 	if ( arrChkvisit.includes(visit_period2) == true )
	// 	{
	// 		alert("약정기간이 중복되었습니다..");
	// 		return false;
	// 	}else{
	// 		arrChkvisit.push(visit_period2);
	// 	}
	// }
	// if ( frm.visit_period3.value != '' )
	// {
	// 	visit_period3 = frm.visit_period3.value;
	// 	if ( arrChkvisit.includes(visit_period3) == true )
	// 	{
	// 		alert("약정기간이 중복되었습니다..");
	// 		return false;
	// 	}else{
	// 		arrChkvisit.push(visit_period3);
	// 	}
	// }
	// if ( frm.visit_period4.value != '' )
	// {
	// 	visit_period4 = frm.visit_period4.value;
	// 	if ( arrChkvisit.includes(visit_period4) == true )
	// 	{
	// 		alert("약정기간이 중복되었습니다..");
	// 		return false;
	// 	}else{
	// 		arrChkvisit.push(visit_period4);
	// 	}
	// }



	//사은품 선택중 약정기간 겹치는지 확인
	var fp_sel1 = '';
	var fp_sel2 = '';
	var fp_sel3 = '';
	var fp_sel4 = '';
	var arrChkval = new Array();

	if ( frm.f_p_use1.checked == true && frm.f_p_sel1.value != '' )
	{
		fp_sel1 = frm.f_p_sel1.value;
		if ( arrChkval.includes(fp_sel1) == true )
		{
			alert("사은품이 중복되었습니다.");
			return false;
		}else{
			arrChkval.push(fp_sel1);
		}
	}
	if ( frm.f_p_use2.checked == true && frm.f_p_sel2.value != '' )
	{
		fp_sel2 = frm.f_p_sel2.value;
		if ( arrChkval.includes(fp_sel2) == true )
		{
			alert("사은품이 중복되었습니다.");
			return false;
		}else{
			arrChkval.push(fp_sel2);
		}
	}
	if ( frm.f_p_use3.checked == true && frm.f_p_sel3.value != '' )
	{
		fp_sel3 = frm.f_p_sel3.value;
		if ( arrChkval.includes(fp_sel3) == true )
		{
			alert("사은품이 중복되었습니다.");
			return false;
		}else{
			arrChkval.push(fp_sel3);
		}
	}
	if ( frm.f_p_use4.checked == true && frm.f_p_sel4.value != '' )
	{
		fp_sel4 = frm.f_p_sel4.value;
		if ( arrChkval.includes(fp_sel4) == true )
		{
			alert("사은품이 중복되었습니다.");
			return false;
		}else{
			arrChkval.push(fp_sel4);
		}
	}

	frm.submit();
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

//		var cate_code3 = $("#product_code_3").val();
//		var cate_text3 = $("#product_code_3 option:selected").text();

//		if(cate_code3!=""){
//			tmp_code = cate_code3;
//			tmp_code_txt += " > " + cate_text3;
//		}

//		var cate_code4 = $("#product_code_4").val();
//		var cate_text4 = $("#product_code_4 option:selected").text();

//		if(cate_code4!=""){
//			tmp_code = cate_code4;
//			tmp_code_txt += " > " + cate_text4;
//		}

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


// 색상 추가 함수
function addColor(code, cateText){
	// 코드 추가 부분
	if(chkColor(code) > -1){
		alert("이미 등록된 색상입니다.");
		return false;
	}
	var tmp_product_code = $("#product_color").val();
	tmp_product_code = tmp_product_code + "|" + code + "|";
	$("#product_color").val(tmp_product_code);

	//var newList =  "<li>["+code+"] "+cateText+" <span onclick=\"delCategory('"+code+"', this);\" >삭제</span></li>";

	var newList = "";
	newList +=  "<tr rel='"+code+"'>";
	newList +=  "	<td>";
	newList +=  "		"+cateText;
	newList +=  "	</td>";
	newList +=  "	<td>";
	newList +=  "		<select name='color"+code+"' id='color"+code+"' onchange='fn_color(this)' >";
	newList +=  "			<option value='Y'>사용</option>";
	newList +=  "			<option value='N'>중지</option>";
	newList +=  "		</select>";
	newList +=  "	</td>";
	newList +=  "	<td>";
	newList +=  "		<input type='text' name='' id='' readonly>";
	newList +=  "	</td>";
	newList +=  "	<td>";
	newList +=  "		<button class='btn_02' type='button' onclick='delColor(\""+code+"\" , this)' >삭제</button>";
	newList +=  "	</td>";
	newList +=  "</tr>";

	$("#color_body").append(newList);
	sizeSetting();
}

// 색상 중복확인
function chkColor(chkcode){
	var tmp_product_code = $("#product_color").val();
	var re_tmp_product_code = tmp_product_code.substr(1,tmp_product_code.length-2);

	var code_array = re_tmp_product_code.split('||');
	
	return( $.inArray(chkcode, code_array) );
}

// 색상 삭제 함수
function delColor(code,obj){
	
	if(chkColor(code) > -1){

		var tmp_product_code = $("#product_color").val();		
		var re_tmp_product_code = tmp_product_code.substr(1,tmp_product_code.length-2);

		var code_array = re_tmp_product_code.split('||');

		var tmp_product_code_re = "";

		$.each(code_array , function(key, val){
			if(val != code){
				tmp_product_code_re = tmp_product_code_re + "|" + val + "|";
			}
		});

		$("#product_color").val(tmp_product_code_re);
		obj.closest("tr").remove();
		sizeSetting();
	}
}




/* 
////////////////////////////////////////////
*/

// 대표색상 추가 함수
function addDbColor(code, cateText){
	// 코드 추가 부분
	if(chkDbColor(code) > -1){
		alert("이미 등록된 대표색상입니다.");
		return false;
	}
	var tmp_product_code = $("#product_dbcolor").val();
	tmp_product_code = tmp_product_code + "|" + code + "|";
	$("#product_dbcolor").val(tmp_product_code);

	//var newList =  "<li>["+code+"] "+cateText+" <span onclick=\"delCategory('"+code+"', this);\" >삭제</span></li>";

	var newList = "";
	newList +=  "<span title='"+cateText+"' style='border: 1px solid rgb(204, 204, 204); border-image: none; background:"+code+";margin-right:10px;cursor:pointer;' ondblclick='delDbColor(\""+code+"\",this)' >&nbsp;&nbsp;&nbsp;&nbsp;</span> ";

	$("#selectColor").append(newList);
	
}

// 대표색상 중복확인
function chkDbColor(chkcode){
	var tmp_product_code = $("#product_dbcolor").val();
	var re_tmp_product_code = tmp_product_code.substr(1,tmp_product_code.length-2);

	var code_array = re_tmp_product_code.split('||');
	
	return( $.inArray(chkcode, code_array) );
}

// 대표색상 삭제 함수
function delDbColor(code,obj){
	
	if(chkDbColor(code) > -1){

		var tmp_product_code = $("#product_dbcolor").val();		
		var re_tmp_product_code = tmp_product_code.substr(1,tmp_product_code.length-2);

		var code_array = re_tmp_product_code.split('||');

		var tmp_product_code_re = "";

		$.each(code_array , function(key, val){
			if(val != code){
				tmp_product_code_re = tmp_product_code_re + "|" + val + "|";
			}
		});

		$("#product_dbcolor").val(tmp_product_code_re);
		obj.remove();
		
	}
}


// 재고 중복확인
function chkOption(chkcode){
	var tmp_product_code = $("#product_option").val();
	var re_tmp_product_code = tmp_product_code.substr(1,tmp_product_code.length-2);

	var code_array = re_tmp_product_code.split('||');
	
	return( $.inArray(chkcode, code_array) );
}

// 재고 삭제 함수
function delOption(idx, obj){
	if(confirm("정말 삭제하시겠습니까?")){
		
		if(idx!=""){
			$.ajax({
				url: "del_option.php",
				type: "POST",
				data: "idx="+idx,
				error : function(request, status, error) {
				 //통신 에러 발생시 처리
					alert_("code : " + request.status + "\r\nmessage : " + request.reponseText);
					$("#ajax_loader").addClass("display-none");
				}
				,complete: function(request, status, error) {

				}
				, success : function(response, status, request) {
					

					response = response.trim();
					
					if(response=="OK"){
						alert("삭제되었습니다.");
					}else{
						alert("오류!");
						location.reload();
					}

					
				}
			});

		}
		$(obj).closest("tr").remove();
	}
	
}

$(document).ready(function(){


	$(".realsize li").click(function(){
		var rel = $(this).attr("rel");

		$(".realsize li").each(function(){
			$(this).removeClass("on");
		});
		
		$(this).addClass("on");
		$("#realsize_dif").val(rel);

	});



	$(".seasonchk li").click(function(){
		var rel = $(this).attr("rel");

		$(".seasonchk li").each(function(){
			$(this).removeClass("on");
		});
		
		$(this).addClass("on");

		var mon_array = [];

		switch(rel){
			case "1" : 
				mon_array.push('1');
				mon_array.push('2');
				mon_array.push('3');
				mon_array.push('4');
				mon_array.push('5');
				mon_array.push('6');
				mon_array.push('7');
				mon_array.push('8');
				mon_array.push('9');
				mon_array.push('10');
				mon_array.push('11');
				mon_array.push('12');
			break;

			case "2" : 
				mon_array.push('3');
				mon_array.push('4');
				mon_array.push('5');
			break;

			case "3" : 
				mon_array.push('5');
				mon_array.push('6');
				mon_array.push('7');
				mon_array.push('8');
				mon_array.push('9');
			break;

			case "4" : 
				mon_array.push('9');
				mon_array.push('10');
				mon_array.push('11');
			break;

			case "5" : 
				mon_array.push('12');
				mon_array.push('1');
				mon_array.push('2');
			break;

			case "6" : 
				mon_array.push('3');
				mon_array.push('4');
				mon_array.push('5');
				mon_array.push('6');
				mon_array.push('7');
				mon_array.push('8');
			break;

			case "7" : 
				mon_array.push('1');
				mon_array.push('2');
				mon_array.push('9');
				mon_array.push('10');
				mon_array.push('11');
				mon_array.push('12');
			break;

			case "8" : 
				mon_array.push('3');
				mon_array.push('4');
				mon_array.push('5');
				mon_array.push('9');
				mon_array.push('10');
				mon_array.push('11');
			break;

		}

		seoson_setting(mon_array);
	});



	$(".monthchk li").click(function(){
		var rel = $(this).attr("rel");

		$(".seasonchk li").each(function(){
			$(this).removeClass("on");
		});
		
		$(this).toggleClass("on");

		seoson_setting_val();
	});



	$("#btn_tmp_option").click(function(){

		if( confirm("임시 저장을 하시겠습니까?\r삭제된 옵션은 복구 되지 않으며, 기존 주문에 영향을 끼칠 수 있습니다 반드시 확인해주세요.") ){

			var g_idx = $("#g_idx").val();
			if(g_idx == ""){
				alert("올바른 접근이 아닙니다.");
				return false;
			}
			
			var frm = document.frm;
			frm.action = "alter_option.php";
			frm.target = "hiddenFrame22";
			frm.submit();

		}

		
	});

	$("#btn_add_option").click(function(){

		var addOption = "";
		addOption += "<tr color='' size='' >												  ";

		addOption += "	<td>																  ";
		addOption += "		<input type='hidden' name='o_idx[]'  value='' />	  ";
		addOption += "		<input type='hidden' name='option_type[]'  value='M' />	  ";
		addOption += "		<input type='file' name='a_file[]'  value='' style='display:none;' />					  ";
		addOption += "		<input type='text' name='o_name[]'  value='' size='70' />	  ";
		addOption += "	</td>																  ";
		addOption += "	<td>																  ";
		addOption += "		<input type='text' class='onlynum' name='o_price[]'  value='' />	  ";
		addOption += "	</td>																  ";
		addOption += "	<td>																  ";
		addOption += "		<input type='text' class='onlynum' name='o_jaego[]'  value='' />	  ";
		addOption += "	</td>																  ";
		addOption += "	<td>																  ";
		addOption += '		<button type="button" onclick="delOption(\'\',this)" >삭제</button>	  ';
		addOption += "	</td>																  ";
		addOption += "</tr>																	  ";
	
		$("#settingBody").append(addOption);

	});


	$("#btn_add_option2").click(function(){

		var addOption = "";
		addOption += "<tr color='' size='' >												  ";

		addOption += "	<td>																  ";
		addOption += "		<input type='file' name='a_file[]'  value='' />					  ";
		addOption += "	</td>																  ";

		addOption += "	<td>																  ";
		addOption += "		<input type='hidden' name='o_idx[]'  value='' />	  ";
		addOption += "		<input type='hidden' name='option_type[]'  value='S' />	  ";
		addOption += "		<input type='text' name='o_name[]'  value='' size='70' />	  ";
		addOption += "	</td>																  ";
		addOption += "	<td>																  ";
		addOption += "		<input type='text' class='onlynum' name='o_price[]'  value='' />	  ";
		addOption += "	</td>																  ";
		addOption += "	<td>																  ";
		addOption += "		<input type='text' class='onlynum' name='o_jaego[]'  value='' />	  ";
		addOption += "	</td>																  ";
		addOption += "	<td>																  ";
		addOption += '		<button type="button" onclick="delOption(\'\',this)" >삭제</button>	  ';
		addOption += "	</td>																  ";
		addOption += "</tr>																	  ";
	
		$("#settingBody2").append(addOption);

	});
/*
	$("input[name='type_chk']").click(function(){
		var period_cnt = $("#period_inp_cnt").val();
		//체크한 값이 있을때 
		if($("input[name='type_chk']:checked").length > 0){
			//약정입력 값이 있을때
			if(period_cnt !=''){
				$('input:checkbox[name="type_chk"]:checked').each(function() {
					if (this.value == 'self')
					{
						$('.self_wrap').show();
						var self_input = "";
						self_input += "<table>";
						self_input += "		<colgroup>";
						self_input += "		<col width='10%' />";
						self_input += "		<col width='90%' />";
						self_input += "		</colgroup>";
						self_input += "		<tbody>";
						for(var i=1; i<= period_cnt; i++){
							
								self_input += "<tr rowspan='"+period_cnt+"'>							";
								self_input += "		<th rowspan='"+period_cnt+"'>							";
								self_input += "			사용안함:<input type='checkbox' name='self_use"+i+"' id='self_use"+i+"'>	";
								self_input += "			<select name='self_period"+i+"' id='self_period"+i+"'>					";
								self_input += "			<option value=''>선택</option>				";
								self_input += period_option();
								self_input += "			</select>									";
								self_input += "		</th>										";
								self_input += "		<td>											";
								//self_input += "		<input type='checkbox' name='' id=''>		";
								self_input += "		<span>표 제목:</span><input type='text' name='self_subject"+i+"_1' id='self_subject"+i+"_1'>";
								self_input += "		<span>가격:</span><input type='text' name='self_price"+i+"_1' id='self_price"+i+"_1'>";
								self_input += "		</td>										";
								self_input += "</tr>										";
								
								if ( period_cnt > 1 )
								{
									for(var j=2; j <= period_cnt; j++){
										self_input += "<tr>";
										self_input += "		<td>";
										//self_input += "		<input type='checkbox' name='' id=''>		";
										self_input += "		<span>표 제목:</span><input type='text' name='self_subject"+i+"_"+j+"' id='self_subject"+i+"_"+j+"'>	";
										self_input += "		<span>가격:</span><input type='text' name='self_price"+i+"_"+j+"' id='self_price"+i+"_"+j+"'>		";
										self_input += "		</td>";
										self_input += "</tr>";
									}
								}
							
						}
						self_input += "		</tbody>";
						self_input += "</table>";
						$('.self_table').html(self_input);
					}
					if (this.value == 'visit')
					{
						$('.visit_wrap').show();
						var self_input = "";
						self_input += "<table>";
						self_input += "		<colgroup>";
						self_input += "		<col width='10%' />";
						self_input += "		<col width='90%' />";
						self_input += "		</colgroup>";
						self_input += "		<tbody>";
						for(var i=1; i<= period_cnt; i++){
							
							self_input += "<tr rowspan='"+period_cnt+"'>							";
							self_input += "		<th rowspan='"+period_cnt+"'>							";
							self_input += "			사용안함:<input type='checkbox' name='visit_use"+i+"' id='visit_use"+i+"'>	";
							self_input += "			<select name='visit_period"+i+"' id='visit_period"+i+"'>						";
							self_input += "			<option value=''>선택</option>				";
							self_input += period_option();
							self_input += "			</select>									";
							self_input += "		</th>										";
							self_input += "		<td>											";
							//self_input += "		<input type='checkbox' name='' id=''>		";
							self_input += "		<span>표 제목:</span><input type='text' name='visit_subject"+i+"_1' id='visit_subject"+i+"_1'>		";
							self_input += "		<span>가격:</span><input type='text' name='visit_price"+i+"_1' id='visit_price"+i+"_1'>			";
							self_input += "		</td>										";
							self_input += "</tr>										";
							
							if ( period_cnt > 1 )
							{
								for(var j=2; j <= period_cnt; j++){
									self_input += "<tr>";
									self_input += "		<td>";
									//self_input += "		<input type='checkbox' name='' id=''>		";
									self_input += "		<span>표 제목:</span><input type='text' name='visit_subject"+i+"_"+j+"' id='visit_subject"+i+"_"+j+"'>		";
									self_input += "		<span>가격:</span><input type='text' name='visit_price"+i+"_"+j+"' id='visit_price"+i+"_"+j+"'>			";
									self_input += "		</td>";
									self_input += "</tr>";
								}
							}
							
							
						}
						self_input += "		</tbody>";
						self_input += "</table>";
						$('.visit_table').html(self_input);
					}
				});
				
			}
			//약정입력 값이 없을때
			else{

				//alert(22);
			}
		}
		//체크한 값이 없을때
		else{
		}
	});

	$('#period_inp_cnt').off('change').on('change',function(){
		var period_cnt = $(this).val();
		$('input:checkbox[name="type_chk"]:checked').each(function() {
			if (this.value == 'self')
			{
				$('.self_wrap').show();
				var self_input = "";
				self_input += "<table>";
				self_input += "		<colgroup>";
				self_input += "		<col width='10%' />";
				self_input += "		<col width='90%' />";
				self_input += "		</colgroup>";
				self_input += "		<tbody>";
				for(var i=1; i<= period_cnt; i++){
							
					self_input += "<tr rowspan='"+period_cnt+"'>							";
					self_input += "		<th rowspan='"+period_cnt+"'>							";
					self_input += "			사용안함:<input type='checkbox' name='self_use"+i+"' id='self_use"+i+"'>	";
					self_input += "			<select name='self_period"+i+"' id='self_period"+i+"'>					";
					self_input += "			<option value=''>선택</option>				";
					self_input += period_option();
					self_input += "			</select>									";
					self_input += "		</th>										";
					self_input += "		<td>											";
					//self_input += "		<input type='checkbox' name='' id=''>		";
					self_input += "		<span>표 제목:</span><input type='text' name='self_subject"+i+"_1' id='self_subject"+i+"_1'>";
					self_input += "		<span>가격:</span><input type='text' name='self_price"+i+"_1' id='self_price"+i+"_1'>";
					self_input += "		</td>										";
					self_input += "</tr>										";
					
					if ( period_cnt > 1 )
					{
						for(var j=2; j <= period_cnt; j++){
							self_input += "<tr>";
							self_input += "		<td>";
							//self_input += "		<input type='checkbox' name='' id=''>		";
							self_input += "		<span>표 제목:</span><input type='text' name='self_subject"+i+"_"+j+"' id='self_subject"+i+"_"+j+"'>	";
							self_input += "		<span>가격:</span><input type='text' name='self_price"+i+"_"+j+"' id='self_price"+i+"_"+j+"'>		";
							self_input += "		</td>";
							self_input += "</tr>";
						}
					}
				
			}
				self_input += "		</tbody>";
				self_input += "</table>";
				$('.self_table').html(self_input);
			}
			if (this.value == 'visit')
			{
				$('.visit_wrap').show();
				var self_input = "";
				self_input += "<table>";
				self_input += "		<colgroup>";
				self_input += "		<col width='10%' />";
				self_input += "		<col width='90%' />";
				self_input += "		</colgroup>";
				self_input += "		<tbody>";
				for(var i=1; i<= period_cnt; i++){
							
					self_input += "<tr rowspan='"+period_cnt+"'>							";
					self_input += "		<th rowspan='"+period_cnt+"'>							";
					self_input += "			사용안함:<input type='checkbox' name='visit_use"+i+"' id='visit_use"+i+"'>	";
					self_input += "			<select name='visit_period"+i+"' id='visit_period"+i+"'>						";
					self_input += "			<option value=''>선택</option>				";
					self_input += period_option();
					self_input += "			</select>									";
					self_input += "		</th>										";
					self_input += "		<td>											";
					//self_input += "		<input type='checkbox' name='' id=''>		";
					self_input += "		<span>표 제목:</span><input type='text' name='visit_subject"+i+"_1' id='visit_subject"+i+"_1'>		";
					self_input += "		<span>가격:</span><input type='text' name='visit_price"+i+"_1' id='visit_price"+i+"_1'>			";
					self_input += "		</td>										";
					self_input += "</tr>										";
					
					if ( period_cnt > 1 )
					{
						for(var j=2; j <= period_cnt; j++){
							self_input += "<tr>";
							self_input += "		<td>";
							//self_input += "		<input type='checkbox' name='' id=''>		";
							self_input += "		<span>표 제목:</span><input type='text' name='visit_subject"+i+"_"+j+"' id='visit_subject"+i+"_"+j+"'>		";
							self_input += "		<span>가격:</span><input type='text' name='visit_price"+i+"_"+j+"' id='visit_price"+i+"_"+j+"'>			";
							self_input += "		</td>";
							self_input += "</tr>";
						}
					}
					
				}
				self_input += "		</tbody>";
				self_input += "</table>";
				$('.visit_table').html(self_input);
			}
		});
	});
*/
	$('#detail_cate').change(function(){
        var g_idx = $('#g_idx').val();
		if ($(this).val() != '')
		{
			$.ajax({
				url:"detail_cate_ajax.php",
				data:"code_no="+$(this).val()+"&g_idx="+g_idx,
				type:"POST",
				dataType:"JSON",
				error:function(request, status, error){
					alert("CODE = " + request.status + "\r\nmessage : " + request.reponseText);
					return false;
				},
				success:function(response, status, request){
					
					if ( response.chk == "OK" ){
						//alert(response.content);
						$('.detail_wrap').html(response.content);
					}else{
						
					}
				}
			})
		}
    });
    $(function(){
        if( $('#detail_cate').val() != '' ){
            var g_idx = $('#g_idx').val();
            var code_no = $('#detail_cate').val();
            $.ajax({
				url:"detail_cate_ajax.php",
				data:"code_no="+code_no+"&g_idx="+g_idx,
				type:"POST",
				dataType:"JSON",
				error:function(request, status, error){
					alert("CODE = " + request.status + "\r\nmessage : " + request.reponseText);
					return false;
				},
				success:function(response, status, request){
					
					if ( response.chk == "OK" ){
						//alert(response.content);
						$('.detail_wrap').html(response.content);
					}else{
						
					}
				}
			})
        }
    })

	$('input:file').off('click').on('click',function(){
		var file_num = $(this).closest('div').find('.file_num').val();
		
		$('#file_add0'+file_num).off('change').on('change',function(){
			var form = $('#frm')[0]; //전송할 폼
			var formData = new FormData(form);
			var file_chk = file_num - 1 ;
			formData.append('file', $('input[name=file]')[file_chk].files[0]); //데이터 추가 또는 업로드할 파일
			
			$.ajax({
				url:"goods_file_ajax.php",
				data:formData,
				type:"POST",
				dataType:"JSON",
				processData: false,
				contentType: false,
				error:function(request, status, error){
					alert("CODE : " + request.status + "\r\nmessage : " + request.reponseText);
					return false;
				},
				success:function(response, status, request){
					if(response.result == 'OK'){
						$('#file_img0'+file_num).css({"background-image":"url(/data/product/"+response.ufile+")"});
						$('#ufile'+file_num).val(response.ufile);
						$('#rfile'+file_num).val(response.rfile);
					}else{
					
					}
				}
			});
			$(this).closest('div').addClass('applied');
		});
		
    });
    
    // $('.remove_btn').on('click',function(){
	// 	$(this).closest('div').find('label').css({"background-image" : ""});
	// 	var file_num = $(this).closest('div').find('.file_num').val();
	// 	$('#ufile'+file_num).val('');
	// 	$('#rfile'+file_num).val('');
	// 	$(this).closest('div').removeClass('applied');
	// })

	$('.remove_btn').on('click', function() {

		var file_num = $(this).closest('div').find('.file_num').val();
		var fileName = $('#ufile'+file_num).val(); 

		console.log(fileName);
		

		$(this).closest('div').find('label').css({"background-image" : ""});
		$('#ufile'+file_num).val('');
		$('#rfile'+file_num).val('');
		$(this).closest('div').removeClass('applied');

		if (fileName !== '') {
			$.ajax({
				url: "goods_file_delete.php",
				type: "POST",
				dataType: "JSON",
				data: { file: fileName },
				success: function(res){
					if (res.result !== "OK") {
						alert("파일 삭제 실패!");
					}
				}
			});
		}
	});

        
    
});


function seoson_setting(mon_array){

	$(".monthchk li").each(function(){
		$(this).removeClass("on");
	});

	$(".monthchk li").each(function(){
		var rel = $(this).attr("rel");
		
		if( $.inArray(rel, mon_array) > -1 ){
			$(this).addClass("on");
		}
		
	});
	seoson_setting_val();
}

function seoson_setting_val(){

	var tmp_product_code = "";
	$("#use_month").val("");

	$(".monthchk li").each(function(){
		
		if( $(this).hasClass("on") ){
			var rel = $(this).attr("rel");

			tmp_product_code = tmp_product_code + "|" + rel + "|";
		}
	});

	$("#use_month").val(tmp_product_code);

}

function fn_pop(c_type){
	$(".popup").show();
	$("#chk_codeType").val(c_type);
	
	var codeText = "";
	if(c_type=="code"){
		codeText = "상품";
	}else if(c_type=="erp"){
		codeText = "ERP";
	}
	$(".code_text").text(codeText);
	$("#pop_search").val("");
	$("#pop_search").focus();
}

// 색상 사용여부 변경 시
function fn_color(obj){
	var val = $(obj).val();
	var code = $(obj).closest("tr").attr("rel");

	$("#settingBody tr").each(function(){
		if( $(this).attr("color") == code){
			$(this).find("select").val(val);
		}
	});

}


// 사이즈 사용여부 변경 시
function fn_size(obj){
	var val = $(obj).val();
	var code = $(obj).closest("tr").attr("rel");

	$("#settingBody tr").each(function(){
		if( $(this).attr("size") == code){
			$(this).find("select").val(val);
		}
	});

}

