<?php $this->extend('inc/layout_index'); ?>
<?php $this->section('content'); ?>
<style>
    .btn-check.disabled {
        cursor: not-allowed;
        background-color: #215dbfa3;
    }
</style>
<main id="container" class="main main_new member_infomation">
    <form name="frm" class="frm" method="post" action="#">
        <input type="hidden" name="m_idx" id="m_idx" value="<?= esc($m_idx) ?>">
        <section class="join-account">

            <h2 class="join-title">단체회원</h2>

            <div class="form-group">
                <label class="form-label">단체회원 종류<span class="required">*</span></label>

                <div class="form-inline">
                    <select name="membership_type" id="membership_type" class="form-select">
                        <option value="">선택</option>
                        <option value="일반">일반</option>
                        <option value="종신 (가급)">종신 (가급)</option>
                        <option value="종신 (나급)">종신 (나급)</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">단체소개<span class="required">*</span></label>
                <div class="form-inline">
                    <textarea name="group_introduction" id="group_introduction" rows="6" class="form-input" placeholder=""></textarea>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">주요 연혁<span class="required">*</span></label>
                <div class="form-inline">
                    <textarea name="group_history" id="group_history" rows="6" class="form-input" placeholder=""></textarea>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">증명사진<span class="required">*</span></label>
                <div class="form-inline">
                    <input type="text" class="form-input" id="bizFileName" placeholder="" readonly>
                    <button type="button" class="btn-upload" id="btnBizFile">
                        파일첨부
                    </button>
                    <input name="membership_photo" type="file" id="bizFileInput" accept=".jpg,.jpeg,.png,.pdf"
                            hidden>
                </div>
            </div>

            <div class="join-submit">
                <button type="button" onclick="send_it()" class="btn-join">
                    회원가입
                </button>
            </div>

        </section>
    </form>
</main>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const btnBiz = document.getElementById("btnBizFile");
    const bizFileInput = document.getElementById("bizFileInput");
    const bizFileName = document.getElementById("bizFileName");

    btnBiz.addEventListener("click", function () {
        bizFileInput.click();
    });

    bizFileInput.addEventListener("change", function () {
        if (this.files.length > 0) {
            bizFileName.value = this.files[0].name;
        } else {
            bizFileName.value = "";
        }
    });

    const btnQua = document.getElementById("btnQuaFile");
    const quaFileInput = document.getElementById("quaFileInput");
    const quaFileName = document.getElementById("quaFileName");

    btnQua.addEventListener("click", function () {
        quaFileInput.click();
    });

    quaFileInput.addEventListener("change", function () {
        if (this.files.length > 0) {
            quaFileName.value = this.files[0].name;
        } else {
            quaFileName.value = "";
        }
    });
});

async function send_it() {
    let frm = document.frm;
    let formData = new FormData(frm);
    let url = '/member/member_group_ok';

    let m_idx = $('#m_idx').val();
    if (!m_idx) {
        alert('회원 정보를 찾을 수 없습니다.');
        return false;
    }

    let membership_type = $('#membership_type').val();
    if (!membership_type) {
        alert('개인회원 종류를 선택해주세요.');
        $('#membership_type').focus();
        return false;
    }

    let group_introduction = $('#group_introduction').val();
    if (!group_introduction) {
        alert('단체소개 입력해주세요.');
        return false;
    }

    let group_history = $('#group_history').val();
    if (!group_history) {
        alert('주요 연혁 입력해주세요.');
        $('#group_history').focus();
        return false;
    }

    // 증명사진
    let membership_photo = $('#bizFileInput').val();
    if (!membership_photo) {
        alert('증명사진을 첨부해주세요.');
        return false;
    }


    $.ajax({
        url: url,
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            console.log(response);
            alert(response.message);
            window.location.href = '/';
        },
        error: function (exception) {
            alert(exception.responseJSON.message ?? '오류가 발생했습니다!')
            console.log(exception)
        }
    });
}

</script>
<?php $this->endSection(); ?>