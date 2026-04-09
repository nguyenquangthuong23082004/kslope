<?
	include $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php"; 
	
	
	if($_GET['idx'] == ""){
		echo("오류!!!!!!");
		exit;
	}
	$status = $_GET['chg_type'];
	$idx	= $_GET['idx'];



	// 상품조회
	$sql = " select * from tbl_order where idx = '".$idx."' limit 1 ";
	$result = mysqli_query($connect, $sql) or die (mysql_error($connect));
	$row = mysqli_fetch_array($result);

	if( $row['idx'] == $idx){

		if($status == "E"){
			if($row['status'] == "B"){

				// 기존 상태값이 결제대기이면서 방금 결제 완료로 돌아간 경우에
				$code = "S03";
				$to_phone = str_replace("-","",$row['hp']);
				

				/*
				구분자 ||| 
				바꾸는 단어 구분자 :::
				*/
				$replace_text = "|||{{ORDER_DATE}}:::".date('Y-m-d')."|||{{ORDER_ID}}:::".$row['order_code'];

				autoSms($code, $to_phone, $replace_text);

			}
		}

		if($status == "R"){
			if($row['status'] != "R"){

				// 기존 상태값이 결제대기이면서 방금 결제 완료로 돌아간 경우에
				$code = "S06";
				$to_phone = str_replace("-","",$row['hp']);
				

				/*
				구분자 ||| 
				바꾸는 단어 구분자 :::
				*/
				$replace_text = "|||{{ORDER_NAME}}:::".$row['receive_name'];

				autoSms($code, $to_phone, $replace_text);

			}
		}

		if($status == "I"){
			if($row['status'] != "I"){

				// 기존 상태값이 결제대기이면서 방금 결제 완료로 돌아간 경우에
				$code = "S07";
				$to_phone = str_replace("-","",$row['hp']);
				

				/*
				구분자 ||| 
				바꾸는 단어 구분자 :::
				*/
				$replace_text = "|||{{ORDER_NAME}}:::".$row['receive_name'];

				autoSms($code, $to_phone, $replace_text);

			}
		}


		if($status == "C"){
			if($row['status'] != "C"){

				// 기존 상태값이 결제대기이면서 방금 결제 완료로 돌아간 경우에
				$code = "S09";
				$to_phone = str_replace("-","",$row['hp']);
				

				/*
				구분자 ||| 
				바꾸는 단어 구분자 :::
				*/
				$replace_text = "|||{{ORDER_NAME}}:::".$row['receive_name']."|||{{ORDER_ID}}:::".$row['order_code'];

				autoSms($code, $to_phone, $replace_text);



				// 메일전송 시작
				$sql_a    = "select * from tbl_homeset order by idx desc limit 0,1";
				$result_a = mysqli_query($connect, $sql_a) or die (mysql_error());
				$row_a	  = mysqli_fetch_array($result_a);
				
				$site_name	  = $row_a['site_name'];
				$domain_url	  = $row_a['domain_url'];
				$http_domain_url = $_IT_TOP_PROTOCOL.$domain_url;
				$logos		  = $row_a['logos'];
				$logos		  = $_IT_TOP_PROTOCOL.$domain_url."/data/home/".$logos;
				$admin_email  = $row_a['admin_email'];
				$mall_order   = $row_a['mall_order'];
				$info_owner   = $row_a['info_owner'];
				$comnum		  = $row_a['comnum'];
				$custom_phone = $row_a['custom_phone'];
				$home_name    = $row_a['home_name'];
				$addr1		  = $row_a['addr1'];
				$addr2		  = $row_a['addr2'];


				$code = "A07";
				$user_mail = $row['email'];

				$replace_text = "";
				$replace_text = "|||[site_name]:::".$site_name."|||[logos]:::".$logos."|||[admin_email]:::".$admin_email;
				$replace_text.= "|||[mall_order]:::".$mall_order."|||[info_owner]:::".$info_owner."|||[comnum]:::".$comnum;
				$replace_text.= "|||[custom_phone]:::".$custom_phone."|||[home_name]:::".$home_name."|||[addr1]:::".$addr1;
				$replace_text.= "|||[addr2]:::".$addr2."|||[domain_url]:::".$domain_url."|||[http_domain_url]:::".$http_domain_url;
				$replace_text.= "|||{{receive_name}}:::".$row['receive_name']."|||[order_id]:::".$row['user_id']."|||[order_date]:::".$row['regdate'];
				$replace_text.= "|||[price_total]:::".number_format($row['total_price'])."|||[pay_type]:::".$_pg_Method[$row['payMethod']]."|||[refund_date]:::".date('Y-m-d');

				autoEmail($code,$user_mail,$replace_text);
				// 메일전송 끝











			}
		}



		// 상태값 변경 시에 처리할 사항

		if($status == "M"){

			// 적립 예정 포인트 발급

			// 조회
			$sql_sub = " select * from tbl_order where idx = '$idx' ";
			$result_sub = mysqli_query($connect, $sql_sub) or die (mysqli_error($connect));
			$row_sub = mysqli_fetch_array($result_sub);

			$order_code = $row_sub['order_code'];

			$msg = "수취확인으로 인한 포인트 적립";


			if(chkPoint($row_sub['user_id'], $row_sub['order_code'], $row_sub['addcash'], $msg ) == 0){

				$sql_pp = "
						insert into tbl_point SET
							 user_id		= '".$row_sub['user_id']."'
							,o_idx			= '".$order_code."'
							,msg			= '".$msg."'
							,point			= '".$row_sub['addcash']."'
							,regdate		= now()
						";

				$message = "주문으로인한 포인트 적립 : " . $sql_pp;
				write_log_dir($message , $_SERVER['DOCUMENT_ROOT']."/AdmMaster/_order/log/");
				mysqli_query($connect, $sql_pp) or die (mysqli_error($connect));

			}

		}

		if($status == "C"){


			$sql_m	= " SELECT *
				  FROM tbl_order
				 WHERE idx = '$idx'
			  ";
			$result_m = mysqli_query($connect, $sql_m) or die (mysqli_error($connect));
			while($row_m = mysqli_fetch_array($result_m)){
				

				

				$sql_s	= " SELECT *
							  FROM tbl_order_sub
							 WHERE order_code = '".$row_m['order_code']."'
							   order by idx asc
						  ";
				$result_s = mysqli_query($connect, $sql_s) or die (mysqli_error($connect));
				while($row_s = mysqli_fetch_array($result_s)){


					if($row_s['options'] == 0){		// 기본 옵션일 때는 상품 테이블에서 직접 재고 감소
						$sql_u = " update tbl_goods
									  set good_cnt = good_cnt + ".$row_s['cnts']."
									where g_idx = '".$row_s['g_idx']."'
								";

					}else{

						$sql_u = " update tbl_goods_option
									  set goods_cnt = goods_cnt + ".$row_s['cnts']."
									where idx = '".$row_s['options']."'
								 ";

					}

					
					$message = "취소 주문건 자동 삭제 (재고 추가) : " . $sql_u;
					write_log_dir($message , $_SERVER['DOCUMENT_ROOT']."/AdmMaster/_order/log/");
					$db = mysqli_query($connect, $sql_u) or die (mysqli_error($connect));




					
					
				}

				if($row_m['usecash'] != ""){

					$msg = "주문 취소로 인한 포인트 환급";
					if(chkPoint($row_m['user_id'], $row_m['order_code'], $row_m['usecash'], $msg ) == 0){

						$sql_pp = "
								insert into tbl_point SET
									 user_id		= '".$row_m['user_id']."'
									,o_idx			= '".$row_m['order_code']."'
									,msg			= '".$msg."'
									,point			= '".$row_m['usecash']."'
									,regdate		= now()
								";

						$message = "주문 취소로 인한 포인트 환급 : " . $sql_pp;
						write_log_dir($message , $_SERVER['DOCUMENT_ROOT']."/AdmMaster/_order/log/");

						mysqli_query($connect, $sql_pp) or die (mysqli_error($connect));
					
					}
					//echo "사용캐쉬 : " .$row_m['usecash'] . "<br/>";

				}

				if($row_m['addcash'] != ""){

					$msg = "주문 취소로 인한 적립 포인트 취소";

					if(chkPoint($row_m['user_id'], $row_m['order_code'], $row_m['addcash'], $msg ) == 0){

						$sql_pp = "
								insert into tbl_point SET
									 user_id		= '".$row_m['user_id']."'
									,o_idx			= '".$row_m['order_code']."'
									,msg			= '".$msg."'
									,point			= '-".$row_m['addcash']."'
									,regdate		= now()
								";

						$message = "주문 취소로 인한 적립 포인트 취소 : " . $sql_pp;
						write_log_dir($message , $_SERVER['DOCUMENT_ROOT']."/AdmMaster/_order/log/");

						mysqli_query($connect, $sql_pp) or die (mysqli_error($connect));

					}

					//echo "사용캐쉬 : " .$row_m['usecash'] . "<br/>";

				}


				

			}


		}

		
		$sql_status = "";
		if($status == "M"){
			$sql_status = " , complete_date = now() ";
		}

		$sql = " update tbl_order
					set  status	= '$status'
				  where idx = '$idx'
			   ";

		$db1 = mysqli_query($connect, $sql) or die (mysqli_error($connect));


		if(!$db1){
			
			echo("오류!");
			exit;
		}


	

		$order_code	= $row['order_code'];
		$order_log = "[관리자]정보 변경 : 상태값 : " . $_deli_type[$status];
		$user_id = $_SESSION['member']['id'];

		$sql = " insert tbl_order_log
					set  order_code	= '$order_code'
					   , order_log	= '$order_log'
					   , user_id	= '$user_id'
					   , regdate	= now()
			   ";

		$db1 = mysqli_query($connect, $sql) or die (mysqli_error($connect));
	}

	


	if($db1){
		echo("OK");
		
	}else{
		echo("오류!");
		exit;
	}



	if (!$db1) {
		echo "NO";
		exit();
	}
?>