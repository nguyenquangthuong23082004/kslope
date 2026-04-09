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

	
	var m_idx = $("#selectMarket").val();
	var pg = Number($("#hidItmPage").val());
	var search_keyword = $("#search_keyword").val();

	var params = "pg=" + pg + "&m_idx="+m_idx;
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
		url: "./agency_item_list.php",
		data: params,
		cache: false,
		success: function (sHtml) {
			//alert(sHtml);
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


function fncMarketSelectClick(){
	
	$("#hidItmPage").val("1");
	$("#ITEM_LIST").empty();
	fncItemList();


}



function onlyNumber(obj) {

    $(obj).keyup(function(){
         $(this).val($(this).val().replace(/[^0-9]/g,""));
    }); 
}