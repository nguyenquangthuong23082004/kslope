$(document).ready(function(){

	$(".contact_btn_box .contact_btn").click(function(){
		resetClass();
		$(this).addClass("active");

		
		var date1 = $(this).attr("rel");
		var date2 = $.datepicker.formatDate('yy-mm-dd',new Date());

		$("#s_date").val(date1);
		$("#e_date").val(date2);

	});

	function resetClass(){
		$(".contact_btn_box .contact_btn").each(function(){
			$(this).removeClass("active");
		});
	}

	$("#chk_all_order_item_state").click(function(){
		var chk_bool = $(this).prop("checked");
		
		$(".state_chker").each(function(){
			$(this).prop("checked", chk_bool);
		});
	});

	$("#s_date")
		.on("change", function() {
			var sDate = $("#s_date").val();
			var eDate = $("#e_date").val();

			if($.trim(sDate) != "" || $.trim(eDate) != "") {
				$("#time_layer").show();
			} else {
				$("#time_layer").hide();
			}
		});
	$("#e_date")
		.on("change", function() {
			var sDate = $("#s_date").val();
			var eDate = $("#e_date").val();

			if($.trim(sDate) != "" || $.trim(eDate) != "") {
				$("#time_layer").show();
			} else {
				$("#time_layer").hide();
			}
		});
});





function fn_mod(idx, obj){

	if( confirm("정말 수정하시겠습니까??") ){
		var trs = $(obj).closest("tr");
		var status = $(trs).find("select[name=status]").val();
		//alert(idx + " / " + status);

		$.ajax({
			url: "order_chg_list.php",
			type: "GET",
			data: "idx="+idx+"&chg_type="+status,
			error : function(request, status, error) {
			 //통신 에러 발생시 처리
				alert_("code : " + request.status + "\r\nmessage : " + request.reponseText);
				$("#ajax_loader").addClass("display-none");
			}
			,complete: function(request, status, error) {
	//				$("#ajax_loader").addClass("display-none");
			}
			, success : function(response, status, request) {
				
				//response = response.trim();

				setTimeout( function() {
					alert("수정되었습니다.");
					location.reload();					

				}, 2000);	
				

				
			
			}
		});

		/*
		var invo_corp = $(trs).find("select[name=invo_corp]").val();
		var invoice = $(trs).find("input[name=invoice]").val();
		var status = $(trs).find("input[name=status]").val();

		
		$.ajax({
			url: "./invo_update.php",
			type: "GET",
			data: "idx="+idx+"&invo_corp="+invo_corp+"&invoice="+invoice+"&status="+status,
			error : function(request, status, error) {
			 //통신 에러 발생시 처리
				alert_("code : " + request.status + "\r\nmessage : " + request.reponseText);
				$("#ajax_loader").addClass("display-none");
			}
			,complete: function(request, status, error) {
	//				$("#ajax_loader").addClass("display-none");
			}
			, success : function(response, status, request) {
				response = response.trim();

				if(response == "L"){
					alert("수정되었습니다.");
					location.reload();
					
					return false;
				}else if(response == "E"){
					alert("에러! 주문건이 없습니다.");
					$(obj).removeClass("active");
					return false;
				}

			}
		});
		*/
	}
}




function fn_mod2(obj){

	if( confirm("정말 수정하시겠습니까??") ){
		var trs = $(obj).closest(".coupon_pop");
		

		var invo_corp = $(trs).find("select[name=invo_corp]").val();
		var invoice = $(trs).find("input[name=invoice]").val();
		var idx = $(trs).find("input[name=idx]").val();

		//alert(idx + " | " + invo_corp + " | " + invoice);
		//return false;
		
		$.ajax({
			url: "./invo_update.php",
			type: "GET",
			data: "idx="+idx+"&invo_corp="+invo_corp+"&invoice="+invoice,
			error : function(request, status, error) {
			 //통신 에러 발생시 처리
				alert_("code : " + request.status + "\r\nmessage : " + request.reponseText);
				$("#ajax_loader").addClass("display-none");
			}
			,complete: function(request, status, error) {
	//				$("#ajax_loader").addClass("display-none");
			}
			, success : function(response, status, request) {
				response = response.trim();

				
				setTimeout( function() {
					alert("수정되었습니다.");
					location.reload();					

				}, 2000);	
					
				

			}
		});
		
	}
}

function fn_chg_option(order_code){
	
	$("#pop_ordernum").text(order_code);

	$.ajax({
		url: "./select_goods_info.php",
		type: "GET",
		data: "order_code="+order_code,
		error : function(request, status, error) {
		 //통신 에러 발생시 처리
			alert_("code : " + request.status + "\r\nmessage : " + request.reponseText);
			$("#ajax_loader").addClass("display-none");
		}
		,complete: function(request, status, error) {
//				$("#ajax_loader").addClass("display-none");
		}
		, success : function(response, status, request) {
			
			$(".chg_orders").html(response).ready(function(){
				
				//=========수정 할 상품에 대한 옵션들=====================================================

				// 첫번째 옵션 변경 시  (위)
				$(".option1").change(function(){

					var tmp_color = $(this).val();
					var goods_code = $(this).closest("div").attr("rel");
					
					
					$(this).closest("ul").find(".option2").val("");
					// 색상 선택 시
					if(tmp_color==""){
						$(this).closest("ul").find(".option2").attr("disabled",true);
						return false;
					}else{
						$(this).closest("ul").find(".option2").attr("disabled",false);
						chg_sizeOption(tmp_color, goods_code);

					}		
				
				});


				// 두번째 옵션 변경 시
				
				$(".option2").change(function(){

					var obj = $(this);
					var tmp_size = $(this).val();
					var goods_code = $(this).closest("ul").attr("rel");
					var bidx = $(this).closest("ul").attr("bidx");
					
					
					
					// 색상 선택 시
					if(tmp_size==""){
						return false;
					}else{
						var option1 = $(this).closest("ul").find(".option1").val();
						var option2 = $(this).val();

						//alert( "goods_code : " + goods_code + " / option1 : " + option1 + " / option2 : " + option2 );
						addOption(goods_code, option1, option2, bidx, obj);
					}
					
				});

				//==============================================================

			});

		}
	});

}


function select_chg() {

	$("#chg_type").val( $("#change_order_item_state").val() );

	if ($(".code_idx").is(":checked") == false)
	{
		alert_("변경할 내용을 선택하셔야 합니다.");
		return;
	}
	if (confirm("변경 하시겠습니까?\n변경 후에는 복구가 불가능합니다.") == false)
	{
		return;
	}

	
	$("#ajax_loader").removeClass("display-none");

	$.ajax({
		url: "order_chg.php",
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
			
			
			setTimeout( function() {
				alert("정상적으로 변경되었습니다.");
					location.reload();
				return;
			}, 5000);	
			

			
			/*
			if (response == "OK")
			{
				alert("정상적으로 변경되었습니다.");
					location.reload();
				return;
			} else {
				alert(response);
				alert("오류가 발생하였습니다!!");
				return;
			}
			*/
		}
	});
 
}



// 엑셀 다운
function get_excel(limits){
	$("#limits").val(limits);
	var frm = document.search;
	frm.action = "./excel_down.php";
	frm.submit();
}


// 선택 엑셀 다운
function get_excel_chk(){

	if ($(".code_idx").is(":checked") == false)
	{
		alert_("다운받을 내용을 선택하셔야 합니다.");
		return;
	}
	
	var frm = document.frm;
	frm.method = "post";
	frm.action = "./excel_down_chk.php";
	frm.submit();
	
}



function addOption(goodcode, option1, option2, bidx, obj){
	
	
	//alert( "goodcode : " + goodcode + " / option1 : " + option1 + " / option2 : " + option2 + " / bidx : " + bidx );
	
	$.ajax({
		url: "setting_option.php",
		type: "POST",
		data: "goodcode="+goodcode+"&option1="+option1+"&option2="+option2,
		error : function(request, status, error) {
		 //통신 에러 발생시 처리
			alert_("code : " + request.status + "\r\nmessage : " + request.reponseText);
			$("#ajax_loader").addClass("display-none");
		}
		,complete: function(request, status, error) {

		}
		, success : function(response, status, request) {

			if(response == ""){
				alert("해당 옵션의 재고가 없습니다.");

				// 사이즈 초기화
				obj.val("");
				// 색상 초기화
				obj.closest("ul").find(".option1").val("");

				return false;
			}

			
		}
	});
	

}

function fn_chg_goods(){
	if ($(".idx").is(":checked") == false)
	{
		alert("교환할 내용을 선택하셔야 합니다.");
		return;
	}

	var chk_re = false;

	$(".idx").each(function(){
		if( $(this).prop("checked") ){
			
			if( $(this).closest("div").find(".option1").val() == ""){
				alert("색상을 선택해주세요.");
				$(this).closest("div").find(".option1").focus();
				chk_re = true;
				return false;
			}

			if( $(this).closest("div").find(".option2").val() == ""){
				alert("사이즈를 선택해주세요.");
				$(this).closest("div").find(".option2").focus();
				chk_re = true;
				return false;
			}
			
		}
	
	
	});


	if(chk_re == true){
		return false;
	}
	

	if( confirm("정말 교환 처리하시겠습니까?") ){
		var frm = document.frm_os;
		frm.submit();
	}

}



function chg_sizeOption(colors,goods_code){
	
	
	$.ajax({
		url: "/item/color_option_chg.php",
		type: "GET",
		data: "colors="+colors+"&goodcode="+goods_code,
		error : function(request, status, error) {
		 //통신 에러 발생시 처리
			alert("code : " + request.status + "\r\nmessage : " + request.reponseText);
			$("#ajax_loader").addClass("display-none");
		}
		,complete: function(request, status, error) {
//				$("#ajax_loader").addClass("display-none");
		}
		, success : function(response, status, request) {
			response = response.trim();
			//console.log(response);
			
			$("#option2").html(response);
		}
	});

}