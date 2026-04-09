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

            <h2 class="join-title">특별회원</h2>

            <div class="form-group">
                <label class="form-label">특별회원<span class="required">*</span></label>

                <div class="form-inline">
                    <select name="membership_type" id="membership_type" class="form-select">
                        <option value="">선택</option>
                        <option value="정부">정부</option>
                        <option value="지방자치단체">지방자치단체</option>
                        <option value="기관">기관</option>
                        <option value="기타">기타</option>
                    </select>
                </div>
            </div>

            <div class="form-group join-section">
                <h3 class="section-title">기관 기본 정보</h3>
                <label class="form-label">기관명<span class="required">*</span></label>
                <div class="form-inline">
                    <input name="organization_name" id="organization_name" value="" type="text" class="form-input"
                        placeholder="">
                </div>

                <label class="form-label">기관장성명<span class="required">*</span></label>
                <div class="form-inline">
                    <input name="organization_director" id="organization_director" value="" type="text" class="form-input"
                        placeholder="">
                </div>

                <label class="form-label">주소<span class="required">*</span></label>
                <div class="form-inline">
                    <input name="organization_zip" value="" type="text" id="zipcode" class="form-input" placeholder="우편번호"
                        readonly>
                    <button type="button" class="btn-check" onclick="execDaumPostcode()">
                        주소찾기
                    </button>
                </div>

                <div class="form-group mt-10">
                    <input name="organization_addr1" value="" type="text" id="address" class="form-input" placeholder="주소"
                        readonly>
                </div>

                <div class="form-group mt-10">
                    <input name="organization_addr2" value="" type="text" id="addressDetail" class="form-input"
                        placeholder="상세주소를 입력해주세요">
                </div>

                <!-- <label class="form-label">전화번호<span class="required">*</span></label>

                <div class="form-inline phone">
                    <input name="mobile1" id="mobile1" type="text" class="form-input phone-input">
                    <span class="phone-dash">-</span>
                    <input name="mobile2" id="mobile2" type="text" class="form-input phone-input">
                    <span class="phone-dash">-</span>
                    <input name="mobile3" id="mobile3" type="text" class="form-input phone-input">
                </div> -->
            </div>

            <div class="form-group join-section">
                <h3 class="section-title">담당부서 정보</h3>
                <label class="form-label">부서명<span class="required">*</span></label>
                <div class="form-inline">
                    <input name="department_name" id="department_name" value="" type="text" class="form-input"
                        placeholder="">
                </div>

                <label class="form-label">과장 성명<span class="required">*</span></label>
                <div class="form-group">
                    <input name="manager_name" value="" type="text" id="manager_name" class="form-input"
                        placeholder="">
                </div>

                <label class="form-label">과장 전화번호<span class="required">*</span></label>
                <div class="form-inline phone">
                    <input name="m_mobile1" id="m_mobile1" type="text" class="form-input phone-input number-only">
                    <span class="phone-dash">-</span>
                    <input name="m_mobile2" id="m_mobile2" type="text" class="form-input phone-input number-only">
                    <span class="phone-dash">-</span>
                    <input name="m_mobile3" id="m_mobile3" type="text" class="form-input phone-input number-only">
                </div>
            </div>

            <div class="form-group join-section">
                <h3 class="section-title">담당자 정보</h3>
                <label class="form-label">성명<span class="required">*</span></label>
                <div class="form-inline">
                    <input name="member_name" id="member_name" value="" type="text" class="form-input"
                        placeholder="">
                </div>

                <label class="form-label">전화번호<span class="required">*</span></label>
                <div class="form-inline phone">
                    <input name="me_mobile1" id="me_mobile1" type="text" class="form-input phone-input number-only">
                    <span class="phone-dash">-</span>
                    <input name="me_mobile2" id="me_mobile2" type="text" class="form-input phone-input number-only">
                    <span class="phone-dash">-</span>
                    <input name="me_mobile3" id="me_mobile3" type="text" class="form-input phone-input number-only">
                </div>

                <label class="form-label">이메일<span class="required">*</span></label>
                <div class="form-inline">
                    <input name="member_email" id="member_email" type="text" class="form-input">
                </div>

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

<div id="layer" style="display:none;position:fixed;overflow:hidden;z-index:1999;-webkit-overflow-scrolling:touch;">
    <img src="//t1.daumcdn.net/postcode/resource/images/close.png" id="btnCloseLayer" 
         style="cursor:pointer;position:absolute;right:-3px;top:-3px;z-index:1" 
         onclick="closeDaumPostcode()" alt="닫기 버튼">
</div>

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
    let url = '/member/member_special_ok';

    let m_idx = $('#m_idx').val();
    if (!m_idx) {
        alert('회원 정보를 찾을 수 없습니다.');
        return false;
    }

    let membership_type = $('#membership_type').val();
    if (!membership_type) {
        alert('특별회원 선택해주세요.');
        $('#membership_type').focus();
        return false;
    }

    let organization_name = $('#organization_name').val();
    if (!organization_name) {
        alert('기관/직위를 입력해주세요.');
        $('#organization_name').focus();
        return false;
    }

    // 주소
    let membership_zip = $('#zipcode').val();
    if (!membership_zip) {
        alert('우편번호를 입력해주세요.');
        return false;
    }

    let membership_addr1 = $('#address').val();
    if (!membership_addr1) {
        alert('주소를 입력해주세요.');
        return false;
    }

    let membership_addr2 = $('#addressDetail').val();
    if (!membership_addr2) {
        alert('상세주소를 입력해주세요.');
        $('#addressDetail').focus();
        return false;
    }


    // 학력 - 기간
    let department_name = $('#department_name').val();
    if (!department_name) {
        alert('부서명 입력해주세요.');
        $('#department_name').focus();
        return false;
    }

    // 학력 - 학교명
    let manager_name = $('#manager_name').val();
    if (!manager_name) {
        alert('과장 성명 입력해주세요.');
        $('#manager_name').focus();
        return false;
    }

        // 전화번호
    let m_mobile1 = $('#m_mobile1').val();
    let m_mobile2 = $('#m_mobile2').val();
    let m_mobile3 = $('#m_mobile3').val();
    if (!m_mobile1 || !m_mobile2 || !m_mobile3) {
        alert('과장 전화번호 입력해주세요.');
        if (!m_mobile1) $('#m_mobile1').focus();
        else if (!m_mobile2) $('#m_mobile2').focus();
        else $('#m_mobile3').focus();
        return false;
    }

    // 학력 - 학과명
    let member_name = $('#member_name').val();
    if (!member_name) {
        alert('성명 입력해주세요.');
        $('#member_name').focus();
        return false;
    }

    let me_mobile1 = $('#me_mobile1').val();
    let me_mobile2 = $('#me_mobile2').val();
    let me_mobile3 = $('#me_mobile3').val();
    if (!me_mobile1 || !me_mobile2 || !me_mobile3) {
        alert('전화번호 입력해주세요.');
        if (!me_mobile1) $('#me_mobile1').focus();
        else if (!me_mobile2) $('#me_mobile2').focus();
        else $('#me_mobile3').focus();
        return false;
    }

    let member_email = $('#member_email').val();
    if (!member_email) {
        alert('학위를 입력해주세요.');
        $('#member_email').focus();
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

var element_layer = document.getElementById('layer');

function execDaumPostcode() {
    new daum.Postcode({
        oncomplete: function(data) {
            document.getElementById('zipcode').value = data.zonecode;
            document.getElementById('address').value = data.address;
            document.getElementById('addressDetail').focus();
            element_layer.style.display = 'none';
        },
        width: '100%',
        height: '100%'
    }).embed(element_layer);
    
    element_layer.style.display = 'block';
    initLayerPosition();
}

function initLayerPosition() {
    var width = 500;
    var height = 600;
    var borderWidth = 1;
    
    element_layer.style.width = width + 'px';
    element_layer.style.height = height + 'px';
    element_layer.style.border = borderWidth + 'px solid #ccc';
    element_layer.style.left = (((window.innerWidth || document.documentElement.clientWidth) - width) / 2 - borderWidth) + 'px';
    element_layer.style.top = (((window.innerHeight || document.documentElement.clientHeight) - height) / 2 - borderWidth) + 'px';
}

function closeDaumPostcode() {
    element_layer.style.display = 'none';
}
</script>
<?php $this->endSection(); ?>