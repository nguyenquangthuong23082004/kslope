<?
	include $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php"; 

//error_reporting(E_ALL);
//ini_set("display_errors", 1);

	$upload="../../data/home/";

	$site_name				= updateSQ($_POST["site_name"]);
	$domain_url				= updateSQ($_POST["domain_url"]);
	$admin_name				= updateSQ($_POST["admin_name"]);
	$admin_email			= updateSQ($_POST["admin_email"]);
	$browser_title			= updateSQ($_POST["browser_title"]);
	$meta_tag				= updateSQ($_POST["meta_tag"]);
	$meta_keyword			= updateSQ($_POST["meta_keyword"]);

	$og_title				= updateSQ($_POST["og_title"]);
	$og_des					= updateSQ($_POST["og_des"]);
	$og_url					= updateSQ($_POST["og_url"]);
	$og_site				= updateSQ($_POST["og_site"]);

	$buytext				= updateSQ($_POST["buytext"]);
	$trantext				= updateSQ($_POST["trantext"]);

	$home_name				= updateSQ($_POST["home_name"]);
	$home_name_en			= updateSQ($_POST["home_name_en"]);
	$store_service01		= updateSQ($_POST["store_service01"]);
	$store_service02		= updateSQ($_POST["store_service02"]);
	$zip					= updateSQ($_POST["zip"]);
	$addr1					= updateSQ($_POST["addr1"]);
	$addr2					= updateSQ($_POST["addr2"]);

	$comnum					= updateSQ($_POST["comnum"]);
	$mall_order				= updateSQ($_POST["mall_order"]);
	$com_owner				= updateSQ($_POST["com_owner"]);
	$info_owner				= updateSQ($_POST["info_owner"]);
	$custom_phone			= updateSQ($_POST["custom_phone"]);
	$fax					= updateSQ($_POST["fax"]);



	
	$sms_phone				= updateSQ($_POST["sms_phone"]);
	$email					= updateSQ($_POST["email"]);
	$munnote_code			= updateSQ($_POST["munnote_code"]);
	$dels					= updateSQ($_POST["dels"]);
	$main_country			= updateSQ($_POST["main_country"]);
	$main_member			= updateSQ($_POST["main_member"]);
	$banks					= updateSQ($_POST["banks"]);
	$bank_account			= updateSQ($_POST["bank_account"]);
	$bank_user				= updateSQ($_POST["bank_user"]);
	$ssl_chk				= updateSQ($_POST["ssl_chk"]);


	$naver_verfct			= updateSQ($_POST["naver_verfct"]);
	$google_verfct			= updateSQ($_POST["google_verfct"]);
	

	$sms_id					= updateSQ($_POST["sms_id"]);
	$sms_key				= updateSQ($_POST["sms_key"]);
	$npay_but_key			= updateSQ($_POST["npay_but_key"]);
	$npay_shop_id			= updateSQ($_POST["npay_shop_id"]);
	$npay_certikey			= updateSQ($_POST["npay_certikey"]);

	$counsel1				= updateSQ($_POST["counsel1"]);
	$counsel2				= updateSQ($_POST["counsel2"]);
	$counsel3				= updateSQ($_POST["counsel3"]);
	$kakao_chat				= updateSQ($_POST["kakao_chat"]);
	$link_kakao_chat		= updateSQ($_POST["link_kakao_chat"]);


	$allim_apikey			= updateSQ($_POST["allim_apikey"]);
	$allim_userid			= updateSQ($_POST["allim_userid"]);
	$allim_senderkey		= updateSQ($_POST["allim_senderkey"]);
	$smtp_host				= updateSQ($_POST["smtp_host"]);
	$smtp_id				= updateSQ($_POST["smtp_id"]);
	$smtp_pass				= updateSQ($_POST["smtp_pass"]);
	$admin_email_list		= updateSQ($_POST["admin_email_list"]);



	//print_r( $language);
	
	$language2 = "";
	foreach( $language as $value){
		$language2 .= "||" . $value;
	}

	$language = $language2;
	
	if($dels == "y"){

		$total_sql = " select * from tbl_homeset where idx='1' ";
		$result = mysqli_query($connect, $total_sql) or die (mysqli_error($connect));
		$row=mysqli_fetch_array($connect, $result);	

		unlink($upload . $row['logos']);

		$sql = "
			update tbl_homeset SET 
			logos		= ''
			where idx = '1'
		";
		mysqli_query($connect, $sql) or die (mysqli_error($connect));
	}


	for ($i=1;$i<=1;$i++)
	{
		if($_FILES["favico_img".$i]['name'])
		{
			$wow = $_FILES["favico_img".$i]['name'];
			if (no_file_ext($_FILES["favico_img".$i]['name']) != "Y") {
				echo "NF";
				exit();
			}

			//${"rfile_".$i}=$wow;

			$wow2=$_FILES["favico_img".$i]['tmp_name'];//tmp 폴더의 파일

			${"favico_img_".$i}=file_check($wow,$wow2,$upload,"N");

			$sql = "
				update tbl_homeset SET 
				favico_img	= '".${"favico_img_".$i}."'
				where idx = '1'
			";
			mysqli_query($connect, $sql) or die (mysqli_error($connect));
		}
	}




	for ($i=1;$i<=1;$i++)
	{
		if($_FILES["ufile".$i]['name'])
		{
			$wow=$_FILES["ufile".$i]['name'];
			if (no_file_ext($_FILES["ufile".$i]['name']) != "Y") {
				echo "NF";
				exit();
			}

			${"rfile_".$i}=$wow;
			$wow2=$_FILES["ufile".$i]['tmp_name'];//tmp 폴더의 파일
			${"ufile_".$i}=file_check($wow,$wow2,$upload,"N");
			$sql = "
				update tbl_homeset SET 
				logos		= '".${"ufile_".$i}."'
				where idx = '1'
			";
			mysqli_query($connect, $sql) or die (mysqli_error($connect));
		}
	}


	for ($i=2;$i<=2;$i++)
	{
		if($_FILES["ufile".$i]['name'])
		{
			$wow=$_FILES["ufile".$i]['name'];
			if (no_file_ext($_FILES["ufile".$i]['name']) != "Y") {
				echo "NF";
				exit();
			}

			${"rfile_".$i}=$wow;
			$wow2=$_FILES["ufile".$i]['tmp_name'];//tmp 폴더의 파일
			${"ufile_".$i}=file_check($wow,$wow2,$upload,"N");
			$sql = "
				update tbl_homeset SET 
				og_img		= '".${"ufile_".$i}."'
				where idx = '1'
			";
			mysqli_query($connect, $sql) or die (mysqli_error($connect));
		}
	}



if($dels_f == "y"){

		$total_sql = " select * from tbl_homeset where idx='1' ";
		$result = mysqli_query($connect, $total_sql) or die (mysqli_error($connect));
		$row=mysqli_fetch_array($connect, $result);	

		unlink($upload . $row['logo_footer']);

		$sql = "
			update tbl_homeset SET 
			logo_footer		= ''
			where idx = '1'
		";
		mysqli_query($connect, $sql) or die (mysqli_error($connect));
	}

for ($i=3;$i<=3;$i++)
{
	if($_FILES["ufile".$i]['name'])
	{
		$wow=$_FILES["ufile".$i]['name'];
		if (no_file_ext($_FILES["ufile".$i]['name']) != "Y") {
			echo "NF";
			exit();
		}

		${"rfile_".$i}=$wow;
		$wow2=$_FILES["ufile".$i]['tmp_name'];//tmp 폴더의 파일
		${"ufile_".$i}=file_check($wow,$wow2,$upload,"N");
		$sql = "
			update tbl_homeset SET 
			logo_footer		= '".${"ufile_".$i}."'
			where idx = '1'
		";
		mysqli_query($connect, $sql) or die (mysqli_error($connect));
	}
}

	



		$sql = "
			UPDATE tbl_homeset SET 
				   site_name		= '".$site_name."'
				 , domain_url		= '".$domain_url."'
				 , admin_name		= '".$admin_name."'
				 , admin_email		= '".$admin_email."'
				 , browser_title	= '".$browser_title."'
				 , meta_tag			= '".$meta_tag."'
				 , meta_keyword		= '".$meta_keyword."'

				 , og_title			= '".$og_title."'
				 , og_des			= '".$og_des."'
				 , og_url			= '".$og_url."'
				 , og_site			= '".$og_site."'

				 , buytext			= '".$buytext."'
				 , trantext			= '".$trantext."'

				 , home_name		= '".$home_name."'
				 , home_name_en		= '".$home_name_en."'
				 , store_service01	= '".$store_service01."'
				 , store_service02	= '".$store_service02."'
				 , zip				= '".$zip."'
				 , addr1			= '".$addr1."'
				 , addr2			= '".$addr2."'
				 , comnum			= '".$comnum."'
				 , mall_order		= '".$mall_order."'
				 , com_owner		= '".$com_owner."'
				 , info_owner		= '".$info_owner."'
				 , custom_phone		= '".$custom_phone."'
				 , fax				= '".$fax."'


				 , sms_phone		= '".$sms_phone."'
				 , email			= '".$email."'
				 , munnote_code		= '".$munnote_code."'
				 , language			= '".$language."'
				 , ssl_chk			= '".$ssl_chk."'
				 , bank_user		= '".$bank_user."'
				 , banks			= '".$banks."'
				 , bank_account		= '".$bank_account."'

				 , naver_verfct		= '".$naver_verfct."'
				 , google_verfct	= '".$google_verfct."'

				 ,sms_id			= '".$sms_id."'
				 ,sms_key			= '".$sms_key."'
				 ,npay_but_key		= '".$npay_but_key."'
				 ,npay_shop_id		= '".$npay_shop_id."'
				 ,npay_certikey		= '".$npay_certikey."'

				 ,counsel1			= '".$counsel1."'
				 ,counsel2			= '".$counsel2."'
				 ,counsel3			= '".$counsel3."'
				 ,kakao_chat		= '".$kakao_chat."'
				 ,link_kakao_chat	= '".$link_kakao_chat."'

				 ,allim_apikey		= '".$allim_apikey."'
				 ,allim_userid		= '".$allim_userid."'
				 ,allim_senderkey	= '".$allim_senderkey."'
				 ,smtp_host			= '".$smtp_host."'
				 ,smtp_id			= '".$smtp_id."'
				 ,smtp_pass			= '".$smtp_pass."'
				 ,admin_email_list	= '".$admin_email_list."'

			 WHERE idx = '1'
		";
		/*
		 , sms_phone		= '".$sms_phone."'
		 , email			= '".$email."'
		 , munnote_code		= '".$munnote_code."'
		 , language			= '".$language."'
		 , ssl_chk			= '".$ssl_chk."'
		 , banks			= '".$banks."'
		 */

		//echo $sql . "<br/>";
		mysqli_query($connect, $sql) or die (mysqli_error($connect));

?>
<script>
	alert("수정하였습니다.");
	location.href="/AdmMaster/_adminrator/setting.php";
</script>