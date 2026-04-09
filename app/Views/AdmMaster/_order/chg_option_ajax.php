<?
	include $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php"; 


	if(!isset($_POST['idx'])) exit;


	for ($i=0;$i < count($idx) ; $i++) {
		

		$fsql    = "select * from tbl_order_sub where idx='".$idx[$i]."' ";
		$fresult = mysqli_query($connect, $fsql) or die (mysql_error());
		$frow = mysqli_fetch_array($fresult);

		// 주문코드
		$_tmp_order_code = $frow['order_code'];

		// 기존옵션
		$_tmp_old_option = $frow['options'];

		// 주문한 수량
		$_tmp_cnt = $frow['cnts'];

		// 상품 정보 받아오기
		$g_row = returnGoods($frow['g_idx']);

		// 상품 코드값
		$tmp_goods_code = $g_row['goods_code'];


		//echo $i . " | idx : " . $idx[$i] . " | option1 : " . $option1[$idx[$i]] . " | option2 : " . $option2[$idx[$i]] . " | tmp_goods_code : " . $tmp_goods_code;

		
		// 기존 상품 재고 증가
		$sql1	= " update tbl_goods_option set goods_cnt = goods_cnt + ".$_tmp_cnt." where idx = '".$_tmp_old_option."' ";
		$db1	= mysqli_query($connect, $sql1);


		//echo " | sql1 : " . $sql1;


		// 새 상품 재고 가감

		$fsql2    = "select * from tbl_goods_option where goods_code='".$tmp_goods_code."' and goods_color='".$option1[$idx[$i]]."' and goods_size='".$option2[$idx[$i]]."' ";
		$fresult2 = mysqli_query($connect, $fsql2) or die (mysql_error());
		$frow2 = mysqli_fetch_array($fresult2);

		$_new_option = $frow2['idx'];

		//echo " | _new_option : " . $_new_option;

		$sql1	= " update tbl_goods_option set goods_cnt = goods_cnt - ".$_tmp_cnt." where idx = '".$_new_option."' ";
		$db1	= mysqli_query($connect, $sql1);

		//echo " | sql1 : " . $sql1;


		// 최종 수정
		$sql1	= " update tbl_order_sub set options = '".$_new_option."' where idx='".$idx[$i]."' ";
		$db1	= mysqli_query($connect, $sql1);


		$message = "교환반품 : " . $sql1;
		write_log_dir($message , $_SERVER['DOCUMENT_ROOT']."/AdmMaster/_order/log/");





		$order_code	= $_tmp_order_code;
		$order_log = "[관리자]상품 교환/변경 (옵션) " . $_tmp_old_option . " -> " . $_new_option . " ";
		$user_id = $_SESSION['member']['id'];

		$sql = " insert tbl_order_log
					set  order_code	= '$order_code'
					   , order_log	= '$order_log'
					   , user_id	= '$user_id'
					   , regdate	= now()
			   ";

		$db1 = mysqli_query($connect, $sql) or die (mysqli_error($connect));
		

		//echo  "<br/>";
		
		
	}
?>
<script type="text/javascript">
alert("수정되었습니다.");
parent.location.reload();
</script>