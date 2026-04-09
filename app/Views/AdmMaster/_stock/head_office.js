$(function(){
		
	fncItemList();

	$("#item_1_scroll").scroll( function() { 
		var elem = $("#item_1_scroll"); 				
		if (Math.floor(elem[0].scrollHeight - elem.scrollTop()) == elem.outerHeight()) { 			
			
			fncItemList();
		} 
	});


	
});



$(document).ready(function(){
 
    $("input[name=search_keyword]").keydown(function (key) {
 
        if(key.keyCode == 13){//키가 13이면 실행 (엔터는 13)
            fncSerchKeyword();			
        }
 
    });         
});


function fncSerchKeyword(){
	$("#hidItmPage").val("1");
	$("#ITEM_LIST").empty();
	fncItemList();
}


//상품 리스트 출력 
function fncItemList() {

	var group_code_1 = $("#product_group_1").val();
	var group_code_2 = $("#product_group_2").val();
	var group_code_3 = $("#product_group_3").val();
	var group_code_4 = $("#product_group_4").val();

	var product_group = "";
	var depthe = Number($("#hidDepthe").val());
	
	var search_keyword = $("#search_keyword").val();
	
	if(depthe == 2){
		product_group = group_code_1;
		$("#product_group_2").val("");
		$("#product_group_3").val("");
		$("#product_group_4").val("");
	}
	if(depthe == 3){
		product_group = group_code_2;
		$("#product_group_3").val("");
		$("#product_group_4").val("");
		group_code_3 = "";
		group_code_4 = "";
	}
	if(depthe == 4){
		product_group = group_code_3;
		group_code_4 = "";
		$("#product_group_4").val("");
	}
	

	var pg = Number($("#hidItmPage").val());
	
	var params = "pg=" + pg;
		params += "&product_group=" + product_group;
		params += "&search_keyword=" + search_keyword;

	if(pg > 1){
		var nTotalCount = Number($("#hid_Item_nTotalCount").val());
		var nPageSize = Number($("#hid_Item_nPageSize").val());
		if((pg * nPageSize) >= nTotalCount ){
			return false;
		}
	}

	$.ajax({
		type: "GET",
		url: "./head_office_item_list.php",
		data: params,
		cache: false,
		success: function (sHtml) {
			$("#ITEM_LIST").append(sHtml);                    
		}
		, beforeSend: function () {
			// 로딩중....      
		}
		, complete: function () {                    
			// 로딩 완료시    
			pg = pg + 1;
			$("#hidItmPage").val(pg);

		}
	});
}




//분류별 검색 
function get_group(strs, depth)
{

	if(Number(depth) < 5){
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
	}

	$("#hidItmPage").val("1");
	$("#ITEM_LIST").empty();
	$("#hidDepthe").val(depth);
	fncItemList();


	return this;
}



function onlyNumber(obj) {

    $(obj).keyup(function(){
         $(this).val($(this).val().replace(/[^0-9]/g,""));
    }); 
}