<?
	ini_set('memory_limit', '-1');
	include  $_SERVER[DOCUMENT_ROOT]."/include/lib.inc.php";

	$upload = "../data/product/";

	$m_idx		= $_SESSION["member"]["mIdx"];


	$i			= $preview_cnt;	

	if (${"del_".$i} =="Y")
	{ 

		$sql = "
			UPDATE tbl_order SET 
			ufile".$i."='',
			rfile".$i."=''
			WHERE order_idx='$order_idx';
		";
		${"u_file".$i} = "noimg";
		$db1 = mysql_query($sql);
	} elseif($_FILES["rfile".$i]['name']) {
		$wow=$_FILES["rfile".$i]['name'];
		${"r_file".$i} = $wow;
		${"rfile_".$i}==$_FILES["rfile".$i]['tmp_name'];
		$wow2=$_FILES["rfile".$i]['tmp_name'];//tmp 폴더의 파일
		$tmp_file = $wow2;
//		echo $tmp_file;
		$exifData = @exif_read_data($tmp_file); 
		if($exifData['Orientation'] == 6) { 
            // 시계방향으로 90도 돌려줘야 정상인데 270도 돌려야 정상적으로 출력됨 
            $degree = 270; 
        } 
        else if($exifData['Orientation'] == 8) { 
            // 반시계방향으로 90도 돌려줘야 정상 
            $degree = 90; 
        } 
        else if($exifData['Orientation'] == 3) { 
            $degree = 180; 
        } 
		$dest_file = $upload.$_FILES["rfile".$i]['name'];
        if($degree) { 
            if($exifData[FileType] == 1) { 
                $source = imagecreatefromgif($tmp_file); 
                $source = imagerotate ($source , $degree, 0); 
                imagegif($source, $dest_file); 
            } 
            else if($exifData[FileType] == 2) { 
                $source = imagecreatefromjpeg($tmp_file); 
                $source = imagerotate ($source , $degree, 0); 
                imagejpeg($source, $dest_file); 
            } 
            else if($exifData[FileType] == 3) { 
                $source = imagecreatefrompng($tmp_file); 
                $source = imagerotate ($source , $degree, 0); 
                imagepng($source, $dest_file); 
            } 

            imagedestroy($source); 
        } 
        else { 
            // 업로드가 안된다면 에러메세지 출력하고 죽어버립니다. 
            $error_code = move_uploaded_file($tmp_file, $dest_file) or die($_FILES["rfile".$i]['error'][$i]); 
        } 
		$aa=date('YmdHms');

		$ext = substr(strrchr($wow,"."),1);	 //확장자앞 .을 제거하기 위하여 substr()함수를 이용
		$ext = strtolower($ext);			 //확장자를 소문자로 변환

		$check1="img_".$aa;
		$check2=strtolower($ext);

		$ok_filename=$check1."_".$i.".".$check2;
		${"u_file".$i} = $ok_filename;
		$ok_filename = "../data/clean/".$ok_filename;
		rename($dest_file, $ok_filename);
		GD2_make_thumb(600,600,str_replace("img_","thumb_",$ok_filename),$ok_filename);


				$sql = "
					UPDATE tbl_order SET 
					ufile".$i."='".${"u_file".$i}."',
					rfile".$i."='".${"r_file".$i}."'
					WHERE order_idx='$order_idx';

				";
				//echo $sql;
				$db1 = mysql_query($sql);

	}
	if ($db1) {
		echo ${"u_file".$i};
		mysql_query("COMMIT");
	} else {        
		//rollback
		mysql_query("ROLLBACK");
		echo "NO";
	}
	mysql_close($connect);

?>