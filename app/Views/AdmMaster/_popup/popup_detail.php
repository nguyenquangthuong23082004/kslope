<?= $this->extend('AdmMaster/inc/layout') ?>
<?= $this->section('content') ?>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

<?php
$popup = $popup ?? null;
$idx = $idx ?? '';

$P_SUBJECT   = '';
$P_STARTDAY = '';
$P_START_HH = '';
$P_START_MM = '';
$P_ENDDAY   = '';
$P_END_HH   = '';
$P_END_MM   = '';
$P_MOVEURL  = '';
$P_WIN_LEFT = '';
$P_WIN_TOP  = '';
$is_mobile  = 'P'; 
$status     = 'B'; 
$num_files  = 0;

if (!empty($popup)) {
    $P_SUBJECT   = $popup['P_SUBJECT']   ?? '';
    $P_STARTDAY = $popup['P_STARTDAY']  ?? '';
    $P_START_HH = $popup['P_START_HH']  ?? '';
    $P_START_MM = $popup['P_START_MM']  ?? '';
    $P_ENDDAY   = $popup['P_ENDDAY']    ?? '';
    $P_END_HH   = $popup['P_END_HH']    ?? '';
    $P_END_MM   = $popup['P_END_MM']    ?? '';
    $P_MOVEURL  = $popup['P_MOVEURL']   ?? '';
    $P_WIN_LEFT = $popup['P_WIN_LEFT']  ?? '';
    $P_WIN_TOP  = $popup['P_WIN_TOP']   ?? '';
    $is_mobile  = $popup['is_mobile']   ?? 'P';
    $status     = $popup['status']      ?? 'B';
}

?>
<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800 font-weight-bold">팝업관리</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-end align-items-center">
            <div class="d-flex" style="gap: 5px;">
                <a href="/AdmMaster/_popup/list" class="btn btn-outline-secondary">
                    <i class="bi bi-list-task" aria-hidden="true"></i> 리스트
                </a>
                <a href="javascript:send_it();" class="btn btn-primary">
                    <i class="bi bi-save me-1" aria-hidden="true"></i> 글 등록
                </a>
            </div>
        </div>
        <div class="card-body">
            <form name="frm1" id="frm" method="post" enctype="multipart/form-data">
                <input type=hidden name="idx" value='<?=$idx?>'>
                <table class="table table-bordered">
                    <colgroup>
                        <col width="10%" />
                        <col width="*" />
                        <col width="10%" />
                        <col width="*" />
                    </colgroup>
                    <tbody>
                        <tr>
                            <th class="text-center align-middle" style="background-color: #d0ebff;">팝업창 제목</th>
                            <td colspan="3">
                                <input type="text" class="form-control w-100" name="P_SUBJECT" id="P_SUBJECT" value="<?=$P_SUBJECT?>">
                            </td>
                        </tr>
                        <tr>
                            <th class="text-center align-middle" style="background-color: #d0ebff;">팝업노출 기간</th>
                            <td colspan="3">
                                <div class="d-flex align-items-center" style="gap: 5px;">
                                    <span>부터</span>
                                    <input type="text" class="form-control datepicker" style="width: 200px;" name="P_STARTDAY" id="P_STARTDAY" value="<?=$P_STARTDAY?>">
                                    <input type="text" class="form-control" style="width: 50px;" name="P_START_HH" id="P_START_HH" value="<?=$P_START_HH?>" maxlength="2">
                                    <span>:</span>
                                    <input type="text" class="form-control" style="width: 50px;" name="P_START_MM" id="P_START_MM" value="<?=$P_START_MM?>" maxlength="2">
                                    <span>까지</span>
                                    <input type="text" class="form-control datepicker" style="width: 200px;" name="P_ENDDAY" id="P_ENDDAY" value="<?=$P_ENDDAY?>">
                                    <input type="text" class="form-control" style="width: 50px;" name="P_END_HH" id="P_END_HH" value="<?=$P_END_HH?>" maxlength="2">
                                    <span>:</span>
                                    <input type="text" class="form-control" style="width: 50px;" name="P_END_MM" id="P_END_MM" value="<?=$P_END_MM?>" maxlength="2">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th class="text-center align-middle" style="background-color: #d0ebff;">노출여부</th>
                            <td colspan="3">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" style="width: 18px; height: 18px; margin-top: 0;" name="status" id="statusB" value="B" <? if ($status == "B") { echo "checked"; } ?>>
                                    <label class="form-check-label" for="statusB">
                                        강제노출
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" style="width: 18px; height: 18px; margin-top: 0;" name="status" id="statusC" value="C" <? if ($status == "C") { echo "checked"; } ?>>
                                    <label class="form-check-label" for="statusC">
                                        강제 비노출
                                    </label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th class="text-center align-middle" style="background-color: #d0ebff;">노출 기기</th>
                            <td colspan="3">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" style="width: 18px; height: 18px; margin-top: 0;" onchange="chk_os('P')"
                                            name="is_mobile" id="is_pc" value="P" <? if ($is_mobile == "P" || $is_mobile == ""){echo "checked";} ?>>
                                    <label class="form-check-label" for="is_pc">
                                        PC
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" style="width: 18px; height: 18px; margin-top: 0;" onchange="chk_os('M')"
                                            name="is_mobile" id="is_mobile" value="M" <? if ($is_mobile == "M"){echo "checked";} ?> ?>
                                    <label class="form-check-label" for="is_mobile">
                                        모바일
                                    </label>
                                </div>
                            </td>
                        </tr>
                        <tr id="position">
                            <th class="text-center align-middle" style="background-color: #d0ebff;">팝업창 노출 위치</th>
                            <td colspan="3">                                
                                <div class="d-flex align-items-center" style="gap: 10px;">
                                    <input type="text" id="styleL" name="P_WIN_LEFT" value='<?=$P_WIN_LEFT?>' class="form-control text-center" rel="" style="width:100px;" maxlength="4" numberOnly=true/> X 
                                    <input type="text" id="styleF" name="P_WIN_TOP"  value='<?=$P_WIN_TOP?>' class="form-control text-center" rel="" style="width:100px;" maxlength="4" numberOnly=true/> 								
                                    <span class="text-danger font-weight-bold">* 가로 X 세로, 픽셀기준, 화면 좌상단 기준 (PC 레이어에서만 적용됩니다)</span>
                                </div>
                            </td>
                        </tr>                        
                        <tr>
                            <th class="text-center align-middle" style="background-color: #d0ebff;">링크주소</th>
                            <td colspan="3">
                                <input type="text" class="form-control w-100" name="P_MOVEURL" id="P_MOVEURL" value="<?=$P_MOVEURL?>">
                            </td>
                        </tr>
                        <tr style="display: none">
                            <th class="text-center align-middle" style="background-color: #d0ebff;">첨부파일</th>
                            <td colspan="3">
                                <input type="file" class="form-control-file w-100" name="ufile" id="ufile" accept="image/*">

                                <div id="images-list">
                                    <?
                                        $getFilesSql    = "select * from tbl_files where code = 'popup' and popup_idx = '$idx'";
                                        $fresult = $db->query($getFilesSql)->getResultArray();
	                                    $num_files = count($fresult);
                                        foreach($fresult as $frow){
                                    ?> 
                                        <div class="mt-4 d-flex align-items-center image_el" style="gap: 10px;" id="image_el_<?=$frow['file_idx']?>">
                                            <button type="button" data-file="<?=$frow['file_idx']?>" class="remove_image btn btn-danger btn-sm">삭제</button>
                                            <a href="<?=!empty($frow['u_file']) ? "/public/uploads/popup/{$frow['u_file']}" : null?>" download="<?=$frow['r_file']?>">
                                                <img src="<?=!empty($frow['u_file']) ? "/public/uploads/popup/{$frow['u_file']}" : null?>" style="width: 100px; height: 100px; object-fit: cover;">
                                            </a>
                                        </div>
                                    <?
                                        }
                                    ?>
                                </div>
                                <input type="hidden" id="num_files" value="<?=$num_files?>">
                            </td>
                        </tr>
                        
                    </tbody>
                </table>
            </form>
        </div>
        <div class="card-footer py-3 d-flex justify-content-end align-items-center">
            <div class="d-flex" style="gap: 5px;">
                <a href="/AdmMaster/_popup/list" class="btn btn-outline-secondary">
                    <i class="bi bi-list-task" aria-hidden="true"></i> 리스트
                </a>
                <a href="javascript:send_it();" class="btn btn-primary">
                    <i class="bi bi-save me-1" aria-hidden="true"></i> 글 등록
                </a>
            </div>
        </div>
    </div>
    

</div>
<!-- /.container-fluid -->

<script>
    $(document).ready(function(){
        $(".datepicker").datepicker({
            dateFormat: "yy-mm-dd" 
        });

        if($("#is_mobile").prop("checked")){
            $("#position").hide();
        }else{
            $("#position").show();
        }
    })

    var files = [];

    $("#ufile").change(function(event){
        var input = this;

        if (input.files && input.files.length) {   
            var reader = new FileReader();
            this.enabled = false;
            reader.onload = (function (e) {
                let html = `
                    <div class="mt-4 d-flex align-items-center image_el" style="gap: 10px;">
                        <button type="button" data-file="" class="remove_image btn btn-danger btn-sm">삭제</button>   
                        <img src="${e.target.result}" style="width: 100px; height: 100px; object-fit: cover;">       
                    </div>
                `;
                $("#images-list").append(html);
                files.push(input.files[0]);
                $(".remove_image").off('click');
                $(".remove_image").on('click', function(){
                    let id = $(this).attr("data-file");
                    if(!id){
                        let index = $(this).closest(".image_el").index();
                        let num = $("#num_files").val();
                        $(this).closest(".image_el").remove();
                        let index_real = index - num;
                        if (index_real >= 0 && index_real < files.length + num) { 
                            files.splice(index_real, 1); 
                        }

                    }else{
                        if (confirm("파일을 삭제하시겠습니까?") == false) {
                            return;
                        }
                        $.ajax({
                            url: "/AdmMaster/_popup/del_image",
                            type: "POST",
                            data: "file_idx=" + id,
                            error: function (request, status, error) {
                                alert("code : " + request.status + "\r\nmessage : " + request.reponseText);
                            }
                            , success: function (response, status, request) {
                                if(response.result == true){
                                    $("#num_files").val(response.count);
                                    $("#image_el_" + id).remove();       
                                }else{
                                    alert("오류가 발생하였습니다!!");
                                    return;
                                }
                            }
                        });
                    }
                });
            });
            reader.readAsDataURL(input.files[0]);

        }
    });

    $(".remove_image").click(function(){
        let id = $(this).attr("data-file");
        if(id){
            if (confirm("파일을 삭제하시겠습니까?") == false) {
                return;
            }
            $.ajax({
                url: "/AdmMaster/_popup/del_image",
                type: "POST",
                data: "file_idx=" + id,
                error: function (request, status, error) {
                    alert("code : " + request.status + "\r\nmessage : " + request.reponseText);
                }
                , success: function (response, status, request) {
                    if(response.result == true){
                        $("#num_files").val(response.count);
                        $("#image_el_" + id).remove();       
                    }else{
                        alert("오류가 발생하였습니다!!");
                        return;
                    }
                }
            });
        }
    });

    function chk_os(str){
        if(str == "M"){
            $("#position").hide();
        }else{
            $("#position").show();
        }
    }
    function send_it(){
        var url = '';
        <?
            if($idx){
        ?>
            url = '/AdmMaster/_popup/update/<?=$idx?>';        
        <?
            }else{
        ?> 
            url = '/AdmMaster/_popup/insert';        
        <?
            }    
        ?>
        var frm = document.frm1;
        formData = new FormData(frm);
        files.forEach(element => {
            formData.append("ufiles[]", element);
        });

        if (frm.P_SUBJECT.value == "")
        {
            frm.P_SUBJECT.focus();
            alert("제목을 입력해주세요.");
            return;

        }
        if (frm.P_STARTDAY.value == "")
        {
            frm.P_STARTDAY.focus();
            alert("시작일을 선택해주세요.");
            return;
        }
        if (frm.P_START_HH.value == "")
        {
            frm.P_START_HH.focus();
            alert("시작 시간을 입력해주세요.");
            return;
        }
        if (frm.P_START_MM.value == "")
        {
            frm.P_START_MM.focus();
            alert("시작 분을 입력해주세요.");
            return;
        }
        if (frm.P_ENDDAY.value == "")
        {
            frm.P_ENDDAY.focus();
            alert("종료일을 선택해주세요.");
            return;
        }
        if (frm.P_END_HH.value == "")
        {
            frm.P_END_HH.focus();
            alert("종료 시간을 입력해주세요.");
            return;
        }
        if (frm.P_END_MM.value == "")
        {
            frm.P_END_MM.focus();
            alert("종료 분을 입력해주세요.");
            return;
        }
        if (frm.status[0].checked == false && frm.status[1].checked == false)
        {
            alert("노출여부를 선택해주셔야 합니다.");
            return;
        }

        // if (frm.P_WIN_LEFT.value == "")
        // {
        //     frm.P_WIN_LEFT.focus();
        //     alert_("팝업 좌측위치를 입력해주세요.");
        //     return;
        // }

        // if (frm.P_WIN_TOP.value == "")
        // {
        //     frm.P_WIN_TOP.focus();
        //     alert_("팝업 상단위치를 입력해주세요.");
        //     return;
        // }

        // if (frm.P_MOVEURL.value == "")
        // {
        //     frm.P_MOVEURL.focus();
        //     alert_("링크주소를 입력해주세요.");
        //     return;
        // }
        
        
        // $("#frm").submit();

        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            error : function(request, status, error) {
                alert("code : " + request.status + "\r\nmessage : " + request.reponseText);
            }
            , success : function(response, status, request) {
                if (response.result == true) {
                    <? if ($idx == "") { ?>
                        alert("정상적으로 등록되었습니다.");
                        location.href="/AdmMaster/_popup/list";
                    <? } else { ?>
                        alert("정상적으로 수정되었습니다.");
                        location.reload();
                    <? } ?>
                    return;
                } else {
                    alert("오류가 발생하였습니다!!");
                    return;
                }
            }
        });
    }

</script>
<?= $this->endSection() ?>