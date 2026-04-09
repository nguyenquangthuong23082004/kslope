<style>
    .frmsearch {
        display: none;
    }

    header#headerContainer {
        background: #fff;
        border: unset;
    }

    header#headerContainer div.inner {
        width: 98%;
    }

    header#headerContainer div.menus ul {
        margin-bottom: 0;
    }

    header#headerContainer div.menus ul.last {
        margin-left: 2px;
    }
</style>		
<div class="listBottom">
    <script type="text/javascript">
        $(function(){
            $("select[name='category']").change(function(){
                var cate =$(this).val();
                location.href="?code=<?= $code ?>&scategory="+cate;
            });
        });
    </script>
    <form name=lfrm id=lfrm>
    <table cellpadding="0" cellspacing="0" summary="" class="table table-hover table-bordered border-light schedule">
        <colgroup>
            <col width="5%">
            <col width="5%">
            <col width="400px">
            <col width="*">
            <col width="15%">
            <col width="10%">
            <col width="10%">
            <col width="10%">
        </colgroup>
    <thead>
        <tr class="table-dark">
            <th scope="col" class="text-center">선택</th>
            <th scope="col" class="text-center">번호</th>
            <th scope="col" class="text-center">이미지</th>
            <th scope="col" class="text-center">코드명</th>
            <th scope="col" class="text-center">타이틀</th>
            <th scope="col" class="text-center">롤링현황</th>
            <th scope="col" class="text-center">우선순위</th>
            <th scope="col" class="text-center">등록일</th>
            <th scope="col" class="text-center">관리</th>
        </tr>
    </thead>
    <tbody>
        <?
        $nPage = ceil($nTotalCount / $g_list_rows);
        if ($pg == '')
            $pg = 1;
        $nFrom = ($pg - 1) * $g_list_rows;

        $sql = $total_sql . " order by $orderStr onum desc,  b_ref desc, b_step asc limit $nFrom, $g_list_rows ";
        $result = mysqli_query($connect, $sql) or die(mysql_error());
        $num = $nTotalCount - $nFrom;
        while ($row = mysqli_fetch_array($result)) {
            if ($row[notice_yn] == 'Y') {
                $nums = 'Notice';
            } else {
                $nums = $num;
            }
            $newStr = '';
            if (listNew(24, $row[r_date]) == 0) {
                $newStr = '<img src="/img_board/new.gif" style="margin:1px 3px 0 5px;" alt="신규게시물" />';
            }

            $recStr = '';
            if ($row[recomm_yn] == 'Y') {
                $recStr = '<font color=red>[추천]</font>';
            }
            $file_chk = 'N';
            for ($i = 1; $i <= 5; $i++) {
                if ($row['rfile' . $i]) {
                    $file_chk = 'Y';
                }
            }
            $rstr = '';
            for ($i = 1; $i <= $row[b_level]; $i++) {
                $rstr = $rstr . '&nbsp;&nbsp;';
            }
            if ($row[b_level] > 0) {
                $rstr = $rstr . 'ㄴ';
            }
            $c_cnt = '';
            if ($row[comment_cnt] > 0) {
                $c_cnt = '(' . $row[comment_cnt] . ')';
            }
            $secureStr = '';
            if ($row[secure_yn] == 'Y') {
                $secureStr = "<img src='/img/ico/ico_lock.png'>";
            }
            ?>
        <tr style="height:40px">
            <td>
                <div class="form-check d-flex justify-content-center" >
                    <input type="checkbox" id="" name="bbs_idx[]" value="<?= $row[bbs_idx] ?>" class="bbs_idx input_check" />
                </div>
            </td>
            <td class="text-center"><?= $nums ?></td>
            <td scope="row" class="text-center">
                <img src="/data/bbs/<?= $row['ufile6'] ?>" style="width: 300px; max-height: 150px">
            </td>
            <td scope="row" class="text-center"><?=$row['category']?></td>
            <td scope="row" class="text-center"><?= $row['subject'] ?></td>
            <td scope="row" class="text-center">
                <?php if ($row['status'] == '1'): ?>
                    <span class="badge bg-success">사용</span>
                <?php else: ?>
                    <span class="badge bg-success">미사용</span>
                <?php endif ?>
            </td>
             <td scope="row" class="text-center">
                <input type="text" name="onum[<?= $row['bbs_idx'] ?>]" value="<?= $row["onum"] ?>"
                    class="form-control"
                    style="width:50px" />
                <!-- <input type="hidden" name="bbs_idx[]" value="<?= $row["bbs_idx"] ?>"
                    class="form-control" /> -->
            </td>
            <td scope="row" class="text-center"><?= date('Y-m-d', strtotime($row['r_date'])) ?></td>
            <td scope="row" class="text-center">
                <a href="board_write.php?scategory=<?= $scategory ?>&search_mode=<?= $search_mode ?>&search_word=<?= $search_word ?>&code=<?= $code ?>&bbs_idx=<?= $row[bbs_idx] ?>&pg=<?= $pg ?>"
                    class="btn btn-primary"><i class="bi bi-pencil"></i></a>
                <a href="javascript:del_chk(<?= $row['bbs_idx'] ?>)" class="btn btn-danger"><i
                        class="bi bi-trash"></i></a>
            </td>
        </tr>
        <?
            $num = $num - 1;
        }
        ?>
    </tbody>
    </table>
    </form>
</div><!-- // listBottom -->
