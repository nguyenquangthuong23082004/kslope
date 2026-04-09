<?

	include $_SERVER['DOCUMENT_ROOT']."/include/lib.inc.php"; 
	

	//error_reporting(E_ALL);

	//ini_set("display_errors", 1);


	$size_type_	= updateSQ($_POST["size_type_"]);

	$upload="../../data/icon/";
	
	$reutrnVal = ""; 
	
	if($size_type_ != ""){
	

					$excel_file = "";
				/*
					if($_FILES["ufile1"]['name'])
					{
						$wow=$_FILES["ufile1"]['name'];
						if (no_file_ext($_FILES["ufile1"]['name']) != "Y") {
							echo "NF";
							exit();
						}

						${"rfile_1"}=$wow;
						$wow2=$_FILES["ufile1"]['tmp_name'];//tmp 폴더의 파일
						${"ufile_1"}=file_check($wow,$wow2,$upload,"N");

						$excel_file = ${"ufile_1"};
						
					}
				*/		
					
					//파일 삭제 
					//unlink($upload . $excel_file);

	}





require_once("../../PHPExcel/PHPExcel.php"); // PHPExcel.php을 불러와야 하며, 경로는 사용자의 설정에 맞게 수정해야 한
require_once "../../PHPExcel/PHPExcel/IOFactory.php"; // IOFactory.php을 불러와야 하며, 경로는 사용자의 설정에 맞게 수정해야 한다.
require_once '/home/bornto/PHPExcel/PHPExcel/Reader/IReadFilter.php';
require_once '/home/bornto/PHPExcel/PHPExcel/Reader/Excel5.php';
require_once '/home/bornto/PHPExcel/PHPExcel/Reader/Excel2007.php';

$UpFile	= $_FILES["ufile1"];
$UpFileName = $UpFile["name"];

$UpFilePathInfo = pathinfo($UpFileName);
$UpFileExt		= strtolower($UpFilePathInfo["extension"]);

class MyReadFilter implements PHPExcel_Reader_IReadFilter
{
	public function readCell($column, $row, $worksheetName = '') {
		// Read rows 1 to 7 and columns A to E only
		if (in_array($column,range('B','B'))) {
			return true;
		}
//		return false;
	return true;
	}
}
$filterSubset = new MyReadFilter();



//업로드된 엑셀파일을 서버의 지정된 곳에 옮기기 위해 경로 적절히 설정
$upload_path = $_SERVER["DOCUMENT_ROOT"]."/data/icon";
$upfile_path = $upload_path."/".date("Ymd_His")."_".$UpFileName;



try {

	if(is_uploaded_file($UpFile["tmp_name"])) {

		if(!move_uploaded_file($UpFile["tmp_name"],$upfile_path)) {
			echo "업로드된 파일을 옮기는 중 에러가 발생했습니다.";
			exit;
		}

		//파일 타입 설정 (확자자에 따른 구분)
		$inputFileType = 'Excel2007';
		if($UpFileExt == "xls") {
			$inputFileType = 'Excel5';	
		}

		//엑셀리더 초기화
		$objReader = PHPExcel_IOFactory::createReader($inputFileType);

		//데이터만 읽기(서식을 모두 무시해서 속도 증가 시킴)
		$objReader->setReadDataOnly(true);	

		//범위 지정(위에 작성한 범위필터 적용)
		$objReader->setReadFilter($filterSubset);

		//업로드된 엑셀 파일 읽기
		$objPHPExcel = $objReader->load($upfile_path);


	  //시트의 지정된 범위 데이터를 모두 읽어 배열로 저장
		$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
		$total_rows = count($sheetData);
		$objWorksheet = $objPHPExcel->getActiveSheet();
		$rowIterator = $objWorksheet->getRowIterator();	
		foreach ($rowIterator as $row) { // 모든 행에 대해서
				   $cellIterator = $row->getCellIterator();
				   $cellIterator->setIterateOnlyExistingCells(false); 
		}

		$maxRow = $objWorksheet->getHighestRow();
		
		$reutrnVal = "";


		//있는 항목이 없으면 
		for ($i = 3 ; $i <= $maxRow ; $i++) {

			$shop_name = $objWorksheet->getCell("A" . $i)->getValue();
			$goods_code = $objWorksheet->getCell("B" . $i)->getValue();
			$goods_color = $objWorksheet->getCell("D" . $i)->getValue();

			//매장 코드
			$_sql_mk = " select * from tbl_market where shop_name = '".$shop_name."'limit 0,1 ";
			$_result = mysqli_query($connect, $_sql_mk) or die (mysql_error());
			$_row_mk = mysqli_fetch_array($_result);
			$_m_idx = $_row_mk["m_idx"];
			
			//echo $_m_idx."<br>";

			if($_m_idx == ""){
				$reutrnVal = "-1";
			}

		}

		



		for ($i = 3 ; $i <= $maxRow ; $i++) {

			$shop_name = $objWorksheet->getCell("A" . $i)->getValue();
			$goods_code = $objWorksheet->getCell("B" . $i)->getValue();
			$goods_color = $objWorksheet->getCell("D" . $i)->getValue();

			$price_normal = $objWorksheet->getCell("AL" . $i)->getValue();
			$price_margin = $objWorksheet->getCell("AM" . $i)->getValue();
			$price_one = $objWorksheet->getCell("AN" . $i)->getValue();	
			
			if(!isset($price_normal)) {
				$price_normal = 0;
			}
			if(!isset($price_margin)) {
				$price_margin = 0;
			}
			if(!isset($price_one)) {
				$price_one = 0;
			}					

			//매장 코드
			$sql_mk = " select * from tbl_market where shop_name = '".$shop_name."'limit 0,1 ";
			$result = mysqli_query($connect, $sql_mk) or die (mysql_error());
			$row_mk = mysqli_fetch_array($result);
			$m_idx = $row_mk["m_idx"];
			//echo $m_idx."<br>";
		
		

			//색상 코드 
			$sql = " select * from tbl_color where code_name = '".$goods_color."'limit 0,1 ";
			$result = mysqli_query($connect, $sql) or die (mysql_error());
			$row_color = mysqli_fetch_array($result);
			$color_code_no = $row_color["code_no"];
			//echo $sql."<br>";
		
		
			//기본 매장이 등록되어있을경우 처리 
			if($m_idx != "" && $reutrnVal != "-1"){

		
			for( $a="F"; $a != "AL"; $a++ ) {
		
				$code = $objWorksheet->getCell($a . $i)->getValue();


				if($code != ""){
				
					$size = $objWorksheet->getCell($a . 2)->getValue();


			
					//공용신발 ################################################
					if($a=="F" || $a=="G" || $a=="H" || $a=="I" || $a=="J" || $a=="K" || $a=="L" || $a=="M" || $a=="N" || $a=="O" || $a=="P" || $a=="Q" || $a=="R" || $a=="S" || $a=="T"){
						$sql = " select code_no from tbl_size where code_name='".$size."' and type='6' limit 0,1 ;";
						//echo $sql."<br>";
						$result = mysqli_query($connect, $sql) or die (mysql_error());
						$row_size = mysqli_fetch_array($result);
						$size_code = $row_size["code_no"];
						
						if($size_code != ""){
							
							//매장 ----------------------------------------
							$sql_mk = " select * from tbl_goods_agency_option where 
											m_idx='".$m_idx."' 
										and goods_code='".$goods_code."' 
										and goods_color='".$color_code_no."' 
										and goods_size='".$size_code."' ;";
							$result_mk = mysqli_query($connect, $sql_mk) or die (mysql_error());
							$row_mk = mysqli_fetch_array($result_mk);
							$m_idx_mk = $row_mk["m_idx"];
							$m_goods_cnt_mk = $row_mk["goods_cnt"];
							
							$m_goods_cnt_mk_tot = $m_goods_cnt_mk + $code;


							//기존건 지운다.
							$sql_del = "delete from tbl_goods_agency_option where 
											m_idx = '".$m_idx."'
										and	goods_code='".$goods_code."' 
										and goods_color='".$color_code_no."' 
										and goods_size='".$size_code."' ; ";
							mysqli_query($connect, $sql_del) or die (mysqli_error($connect));
							//합산해서 등록해준다 
							$sql_insert = "
									insert into tbl_goods_agency_option SET
										 m_idx=".$m_idx."
										,goods_code		= '".$goods_code."'
										,goods_color	= '".$color_code_no."'
										,goods_size		= '".$size_code."'
										,goods_cnt		= '".$m_goods_cnt_mk_tot."'
										,use_yn			= ''
							";
							mysqli_query($connect, $sql_insert) or die (mysqli_error($connect));
							//매장 //----------------------------------------

							
							//상품 기존 값 체크 
							$sql_g = " select * from tbl_goods_adm_option where goods_code='".$goods_code."' 
										and goods_color='".$color_code_no."' 
										and goods_size='".$size_code."'
										and m_idx = '".$m_idx."' ;";
										
							$result_g = mysqli_query($connect, $sql_g) or die (mysql_error());
							$row_good = mysqli_fetch_array($result_g);
							$goods_cnt = $row_good["goods_cnt"];
							
							$tot_cnt = $goods_cnt + $code;
							
							
							//기존건 지운다.
							$sql_del = "delete from tbl_goods_adm_option where goods_code='".$goods_code."' 
											and goods_color='".$color_code_no."' 
											and goods_size='".$size_code."'
											and m_idx = '".$m_idx."'  ; ";
							mysqli_query($connect, $sql_del) or die (mysqli_error($connect));
							//echo $sql_del."<br>";
							
							
							//합산해서 등록해준다 
							$sql_insert = "
								insert into tbl_goods_adm_option SET
									 goods_code		= '".$goods_code."'
									,goods_color	= '".$color_code_no."'
									,goods_size		= '".$size_code."'
									,goods_cnt		= '".$tot_cnt."'
									,use_yn			= ''
									,price_normal			= '".$price_normal."'
									,price_margin			= '".$price_margin."'
									,price_one			= '".$price_one."'
									,m_idx = '".$m_idx."' 

							";

							mysqli_query($connect, $sql_insert) or die (mysqli_error($connect));
						}
					}
					//여성신발 ################################################
					if($a=="U" || $a=="V" || $a=="W" || $a=="X" || $a=="Y" || $a=="Z" || $a=="AA"){
					
						$sql = " select code_no from tbl_size  where code_name='".$size."' and type='8' limit 0,1 ";
						$result = mysqli_query($connect, $sql) or die (mysql_error());
						$row_size = mysqli_fetch_array($result);
						$size_code = $row_size["code_no"];
						
						if($size_code != ""){		
							//매장--------------------------------------------------------------- 
							$sql_mk = " select * from tbl_goods_agency_option where m_idx='".$m_idx."' 
										and goods_code='".$goods_code."' 
										and goods_color='".$color_code_no."' 
										and goods_size='".$size_code."' ;";
							//echo $sql_mk."<br>";
							$result_mk = mysqli_query($connect, $sql_mk) or die (mysql_error());
							$row_mk = mysqli_fetch_array($result_mk);
							$m_idx_mk = $row_mk["m_idx"];
							$m_goods_cnt_mk = $row_mk["goods_cnt"];
							
							$m_goods_cnt_mk_tot = $m_goods_cnt_mk + $code;


							//기존건 지운다.
							$sql_del = "delete from tbl_goods_agency_option where 
											m_idx = '".$m_idx."'
										and	goods_code='".$goods_code."' 
										and goods_color='".$color_code_no."' 
										and goods_size='".$size_code."' ; ";
							mysqli_query($connect, $sql_del) or die (mysqli_error($connect));
							//합산해서 등록해준다 
							$sql_insert = "
									insert into tbl_goods_agency_option SET
										 m_idx=".$m_idx."
										,goods_code		= '".$goods_code."'
										,goods_color	= '".$color_code_no."'
										,goods_size		= '".$size_code."'
										,goods_cnt		= '".$m_goods_cnt_mk_tot."'
										,use_yn			= ''
							";
							mysqli_query($connect, $sql_insert) or die (mysqli_error($connect));
							//매장---------------------------------------------------------------//
							
							//상품 기존 값 체크 
							$sql_g = " select * from tbl_goods_adm_option where goods_code='".$goods_code."' 
										and goods_color='".$color_code_no."' 
										and goods_size='".$size_code."'
										and m_idx = '".$m_idx."';";
							$result_g = mysqli_query($connect, $sql_g) or die (mysql_error());
							$row_good = mysqli_fetch_array($result_g);
							$goods_cnt = $row_good["goods_cnt"];
							
							$tot_cnt = $goods_cnt + $code;
							
							//기존건 지운다.
							$sql_del = "delete from tbl_goods_adm_option where goods_code='".$goods_code."' 
											and goods_color='".$color_code_no."' 
											and goods_size='".$size_code."'
											and m_idx = '".$m_idx."' ; ";
							mysqli_query($connect, $sql_del) or die (mysqli_error($connect));
							//echo $sql_del."<br>";
							
							
							//합산해서 등록해준다 
							$sql_insert = "
								insert into tbl_goods_adm_option SET
									 goods_code		= '".$goods_code."'
									,goods_color	= '".$color_code_no."'
									,goods_size		= '".$size_code."'
									,goods_cnt		= '".$tot_cnt."'
									,use_yn			= ''
									,price_normal	= '".$price_normal."'
									,price_margin	= '".$price_margin."'
									,price_one		= '".$price_one."'
									,m_idx		='".$m_idx."' 
							";
							mysqli_query($connect, $sql_insert) or die (mysqli_error($connect));

							$m_goods_cnt_mk_tot = 0;
						}

						//echo $sql_insert."<br>";
					}

					//남성신발 ################################################
					if($a=="AB" || $a=="AC" || $a=="AD" || $a=="AE" || $a=="AF" || $a=="AG" || $a=="AH" || $a=="AI" || $a=="AJ" || $a=="AK" ){
						$sql = " select code_no from tbl_size  where code_name='".$size."' and type='9' limit 0,1 ";
						$result = mysqli_query($connect, $sql) or die (mysql_error());
						$row_size = mysqli_fetch_array($result);
						$size_code = $row_size["code_no"];
						
								if($size_code != ""){		
									//매장-------------------------------------------------------------------- 
									$sql_mk = " select * from tbl_goods_agency_option where m_idx='".$m_idx."' 
												and goods_code='".$goods_code."' 
												and goods_color='".$color_code_no."' 
												and goods_size='".$size_code."' ;";
									$result_mk = mysqli_query($connect, $sql_mk) or die (mysql_error());
									$row_mk = mysqli_fetch_array($result_mk);
									$m_goods_cnt_mk = $row_mk["goods_cnt"];
									
									$m_goods_cnt_mk_tot = $m_goods_cnt_mk + $code;


									//기존건 지운다.
									$sql_del = "delete from tbl_goods_agency_option where 
													m_idx = '".$m_idx."'
												and	goods_code='".$goods_code."' 
												and goods_color='".$color_code_no."' 
												and goods_size='".$size_code."' ; ";
									mysqli_query($connect, $sql_del) or die (mysqli_error($connect));
									//합산해서 등록해준다 
									$sql_insert = "
											insert into tbl_goods_agency_option SET
												 m_idx=".$m_idx."
												,goods_code		= '".$goods_code."'
												,goods_color	= '".$color_code_no."'
												,goods_size		= '".$size_code."'
												,goods_cnt		= '".$m_goods_cnt_mk_tot."'
												,use_yn			= ''
									";
									mysqli_query($connect, $sql_insert) or die (mysqli_error($connect));
									//매장--------------------------------------------------------------------// 
									
									//상품 기존 값 체크 
									$sql_g = " select * from tbl_goods_adm_option where goods_code='".$goods_code."' 
												and goods_color='".$color_code_no."' 
												and goods_size='".$size_code."'
												and m_idx= '".$m_idx."' ;";

									//echo $sql_g."<br>";
									$result_g = mysqli_query($connect, $sql_g) or die (mysql_error());
									$row_good = mysqli_fetch_array($result_g);
									$goods_cnt = $row_good["goods_cnt"];
									$tot_cnt = 0;
									$tot_cnt = $goods_cnt + $code;
									
									//기존건 지운다.
									$sql_del = "delete from tbl_goods_adm_option where goods_code='".$goods_code."' 
													and goods_color='".$color_code_no."' 
													and goods_size='".$size_code."'
													and m_idx = '".$m_idx."' ";
									mysqli_query($connect, $sql_del) or die (mysqli_error($connect));
									//echo $sql_del."<br>";
									
									
									//합산해서 등록해준다 
									$sql_insert = "
										insert into tbl_goods_adm_option SET
											 goods_code		= '".$goods_code."'
											,goods_color	= '".$color_code_no."'
											,goods_size		= '".$size_code."'
											,goods_cnt		= '".$tot_cnt."'
											,use_yn			= ''
											,price_normal			= '".$price_normal."'
											,price_margin			= '".$price_margin."'
											,price_one			= '".$price_one."'
											,m_idx		= '".$m_idx."'
									";
								
									mysqli_query($connect, $sql_insert) or die (mysqli_error($connect));		
									//echo $sql_insert."<br>";
								}
							}
					}

				}
			}
		//echo "<br>";
		}
			
	}

	//unlink($upfile_path);

?>

<script>

if("<?=$reutrnVal?>" == "-1"){
	alert("등록된 매장 코드가 없는 항목이 있습니다. \n엑셀파일을 확인해 주세요");
	parent.location.href="/AdmMaster/_stock/store_inventory.php";
}else{
	alert("정상적으로 등록되었습니다.");
	parent.location.href="/AdmMaster/_stock/store_inventory.php";
}
	
	
</script>

<?
} catch (exception $e) {
?>

<script>
	alert("등록 오류 입니다. <?=$e?>");
	parent.location.href="/AdmMaster/_stock/store_inventory.php";
</script>

<?
}
​?>