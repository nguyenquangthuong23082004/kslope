<?
	include $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php";

	mysqli_query($connect, "SET AUTOCOMMIT=0");
	mysqli_query($connect, "START TRANSACTION");

	$upload="../../data/bbs/";
	$category		= updateSQ($_POST[category]);
	$search_mode	= updateSQ($_POST[search_mode]);
	$search_word	= updateSQ($_POST[search_word]);
	$scategory		= updateSQ($_POST[scategory]);
	$pg				= updateSQ($_POST[pg]);
	$subject		= updateSQ($_POST[subject]);
	$simple			= updateSQ($_POST[simple]);
	$code			= updateSQ($_POST[code]);
	$color			= updateSQ($_POST['color']);
	$writer			= updateSQ($_POST[writer]);
	$email			= updateSQ($_POST["email"]);
	$contents		= updateSQ($_POST[contents]);
	$url			= updateSQ($_POST[url]);
	$hit			= updateSQ($_POST[hit]);
	$mode			= updateSQ($_POST[mode]);
	$reply			= updateSQ($_POST[reply]);

	$b_ref			= updateSQ($_POST[b_ref]);
	$b_step			= updateSQ($_POST[b_step]);
	$recomm_yn		= updateSQ($_POST[recomm_yn]);
	$b_level		= updateSQ($_POST[b_level]);
	$user_id		= $_SESSION[member][id];
	if ($writer == "") {
		$writer		= $_SESSION[member][name];
	}
//	$r_date			= $wYY."-".$wMM."-".$wDD." ".$wHH.":".$wII.":".$wSS;
	if ($wdate)
	{
		$r_date			= "'".$wdate."'";
	} else {
		$r_date			= "now()";
	}

for ($i=1;$i<=6;$i++)
{
	if (${"del_".$i} =="Y")
	{
		$sql = "
			UPDATE tbl_bbs_list SET
			ufile".$i."='',
			rfile".$i."=''
			WHERE bbs_idx='$bbs_idx'
		";
		mysqli_query($connect, $sql) or die (mysqli_error($connect));
	} elseif($_FILES["ufile".$i]['name'])
	{
		$maxSize = 3 * 1024 * 1024; // 3MB
		if ($_FILES["ufile".$i]['size'] > $maxSize) {
			echo "파일 크기가 3MB를 초과했습니다. 더 작은 파일을 선택해주세요.";
			exit;
		}
		$wow=$_FILES["ufile".$i]['name'];
		if (no_file_ext($_FILES["ufile".$i]['name']) != "Y") {
			echo "NF";
			exit();
		}

		${"rfile_".$i}=$wow;
		$wow2=$_FILES["ufile".$i]['tmp_name'];//tmp 폴더의 파일
		${"ufile_".$i}=file_check($wow,$wow2,$upload,"N");
		if ($bbs_idx) {
				$sql = "
					UPDATE tbl_bbs_list SET
					ufile".$i."='".${"ufile_".$i}."',
					rfile".$i."='".${"rfile_".$i}."'
					WHERE bbs_idx='$bbs_idx';
				";
				mysqli_query($connect, $sql) or die (mysqli_error($connect));
		}
	}
}
	if ($mode == "reply") {
		$sql = "update tbl_bbs_list set b_step = b_step + 1 where b_ref = '$b_ref' and b_step > $b_step";
		mysqli_query($connect, $sql) or die (mysqli_error($connect));
		$b_step	 = $b_step + 1;
		$b_level = $b_level + 1;

		$sql = "INSERT INTO tbl_bbs_list (subject, code, category, simple, writer, notice_yn, secure_yn, contents, hit, user_id, url, ufile1, rfile1, ufile2, rfile2, ufile3, rfile3, ufile4, rfile4, ufile5, rfile5, ufile6, rfile6, ip_address, onum, b_ref, b_step, b_level, recomm_yn, color, r_date)
				VALUES ('$subject', '$code', '$category', '$simple', '$writer', '$notice_yn', '$secure_yn', '$contents', 0, '$user_id', '$url', '$ufile_1', '$rfile_1', '$ufile_2', '$rfile_2', '$ufile_3', '$rfile_3', '$ufile_4', '$rfile_4', '$ufile_5', '$rfile_5','$ufile_6', '$rfile_6', '".$_SERVER["REMOTE_ADDR"]."', '$b_ref', '$b_ref', '$b_step', '$b_level', '$recomm_yn', '$color', $r_date);";
		$db = mysqli_query($connect, $sql);

	} else if ($bbs_idx) {

		if($reply!=""){
			$sql_s = " select l.user_id, m.user_email, m.user_name, l.r_date, l.contents, l.reply
			             from tbl_bbs_list l 
						 left outer join tbl_member m 
						   on l.user_id = m.user_id
						where bbs_idx='$bbs_idx'";
			$result_s = mysqli_query($connect, $sql_s) or die (mysqli_error($connect));
			$row_s = mysqli_fetch_array($result_s);

			if($row_s['reply']==""){
				if($row_s['user_email'] != ""){


					//  메일전송 시작///
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


					$code = "A03";
					$user_mail = $row_s['user_email'];

					$replace_text = "";
					$replace_text = "|||[site_name]:::".$site_name."|||[logos]:::".$logos."|||[admin_email]:::".$admin_email;
					$replace_text.= "|||[mall_order]:::".$mall_order."|||[info_owner]:::".$info_owner."|||[comnum]:::".$comnum;
					$replace_text.= "|||[custom_phone]:::".$custom_phone."|||[home_name]:::".$home_name."|||[addr1]:::".$addr1;
					$replace_text.= "|||[addr2]:::".$addr2."|||[domain_url]:::".$domain_url."|||[http_domain_url]:::".$http_domain_url;
					$replace_text.= "|||[name]:::".$user_name;
					$replace_text.= "|||{{receive_name}}:::".$row_s['user_name']."|||[date]:::".$row_s['r_date']."|||[contents]:::".nl2br(viewSQ($row_s['contents']))."|||[reply]:::".nl2br(viewSQ($reply));
					autoEmail($code,$user_mail,$replace_text);

				}
				
			}

		}



		$sql = "update tbl_bbs_list set subject='$subject', hit='$hit', simple='$simple', s_date='$s_date', email='$email', e_date='$e_date', secure_yn='$secure_yn', category='$category', contents='$contents', notice_yn = '$notice_yn', reply = '$reply', color= '$color'";
		if ($wdate)
		{
			$sql = $sql.",  r_date = $r_date ";
		}
		$sql = $sql.",  recomm_yn = '$recomm_yn', url='$url' where bbs_idx='$bbs_idx'";
		$db = mysqli_query($connect, $sql);
	} else {
		$total_sql	= " select ifnull(max(bbs_idx),0)+1 as maxbbs_idx from tbl_bbs_list";
		$result		= mysqli_query($connect, $total_sql) or die (mysqli_error($connect));
		$row		= mysqli_fetch_array($result);
		$b_ref		= $row[maxbbs_idx];

		$sql = "INSERT INTO tbl_bbs_list (subject, simple, s_date, e_date, code, category, country_code, writer, notice_yn, secure_yn, contents, hit, user_id, url, ufile1, rfile1, ufile2, rfile2, ufile3, rfile3, ufile4, rfile4, ufile5, rfile5, ufile6, rfile6, ip_address, onum, b_ref, b_step, b_level, recomm_yn, email, color, r_date) VALUES ('$subject', '$simple', '$s_date', '$e_date', '$code', '$category',  '', '$writer', '$notice_yn', '$secure_yn', '$contents', $hit, '$user_id', '$url', '$ufile_1', '$rfile_1', '$ufile_2', '$rfile_2', '$ufile_3', '$rfile_3', '$ufile_4', '$rfile_4', '$ufile_5', '$rfile_5', '$ufile_6', '$rfile_6',  '".$_SERVER["REMOTE_ADDR"]."', '$b_ref', '$b_ref', 0, 0, '$recomm_yn', '$email', '$color', $r_date);";

		//$db = mysqli_query($connect, $sql) or die (mysqli_error($connect));
		$db = mysqli_query($connect, $sql);
	}

	if ($db) {
		echo "OK";
		mysqli_query($connect, "COMMIT");
	} else {
		//rollback
		mysqli_query($connect, "ROLLBACK");
		echo "NO";
	}
?>
