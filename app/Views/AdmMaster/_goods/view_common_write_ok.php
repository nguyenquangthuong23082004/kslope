<?
    include $_SERVER['DOCUMENT_ROOT'].'/include/lib.inc.php';

    $idx = $_POST['idx'];
    $useYN1 = $_POST['useYN1'];
    $useYN2 = $_POST['useYN2'];

    $upload="../../data/goods_banner/";

    for ($i=1;$i<=4;$i++)
    {
        if (${"del_".$i} =="Y"){
            $sql = "
                UPDATE tbl_goods_banner SET
                ufile".$i."='',
                rfile".$i."=''
                WHERE idx='$idx'
            ";
            mysqli_query($connect, $sql) or die (mysqli_error($connect));

        } elseif($_FILES["ufile".$i]['name']){

            $wow=$_FILES["ufile".$i]['name'];
            if (no_file_ext($_FILES["ufile".$i]['name']) != "Y") {
                echo "NF";
                exit();
            }

            ${"rfile_".$i}=$wow;
            $wow2=$_FILES["ufile".$i]['tmp_name'];//tmp 폴더의 파일
            ${"ufile_".$i}=file_check($wow,$wow2,$upload,"N");

            if ($idx) {
                    $sql = "
                        UPDATE tbl_goods_banner SET
                        ufile".$i."='".${"ufile_".$i}."',
                        rfile".$i."='".${"rfile_".$i}."'
                        WHERE idx='$idx';
                    ";
                    mysqli_query($connect, $sql) or die (mysqli_error($connect));
            }

        }
    }

    if($idx){
        $sql = "
            update tbl_goods_banner SET
                useYN1 = '".$useYN1."'
                ,useYN2 = '".$useYN2."'
            where idx = '".$idx."'
        ";
        mysqli_query($connect, $sql);
    }else{
        $sql = "
            insert into 
            tbl_goods_banner(useYN1, useYN2, ufile1, rfile1, ufile2, rfile2, ufile3, rfile3, ufile4, rfile4)
            values('".$useYN1."', '".$useYN2."', '".$ufile_1."', '".$rfile_1."', '".$ufile_2."', '".$rfile_2."', '".$ufile_3."', '".$rfile_3."', '".$ufile_4."', '".$rfile_4."')
        ";
        mysqli_query($connect,$sql);
    }

    ?>
    <script>
    <?
        if($idx){
    ?>
        alert("수정되었습니다.");
        parent.location.reload();
    <?
        }else{
    ?>
        alert("등록되었습니다.");
        parent.location.reload();
        <?}?>
    </script>
  