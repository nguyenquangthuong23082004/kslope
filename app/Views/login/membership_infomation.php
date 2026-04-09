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

            <h2 class="join-title">개인회원</h2>

            <div class="form-group">
                <label class="form-label">개인회원 종류<span class="required">*</span></label>

                <div class="form-inline">
                    <select name="membership_type" id="membership_type" class="form-select">
                        <option value="">선택</option>
                        <option value="일반">일반</option>
                        <option value="종신">종신</option>
                        <option value="명예">명예</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">증명사진<span class="required">*</span></label>
                <div class="form-inline">
                    <input type="text" class="form-input" id="bizFileName" placeholder="파일을 선택해주세요" readonly>
                    <button type="button" class="btn-upload" id="btnBizFile">
                        파일첨부
                    </button>
                    <input name="membership_photo" type="file" id="bizFileInput" accept=".jpg,.jpeg,.png,.pdf"
                            hidden>
                </div>
            </div>

            <div class="form-group join-section">
                <h3 class="section-title">소속</h3>
                <label class="form-label">기관 / 직위<span class="required">*</span></label>
                <div class="form-inline">
                    <input name="membership_organization" id="membership_organization" value="" type="text" class="form-input"
                        placeholder="기관명 / 직위를 입력해주세요">
                </div>

                <label class="form-label">주소<span class="required">*</span></label>
                <div class="form-inline">
                    <input name="membership_zip" value="" type="text" id="zipcode" class="form-input" placeholder="우편번호"
                        readonly>
                    <button type="button" class="btn-check" onclick="execDaumPostcode()">
                        주소찾기
                    </button>
                </div>

                <div class="form-group mt-10">
                    <input name="membership_addr1" value="" type="text" id="address" class="form-input" placeholder="주소"
                        readonly>
                </div>

                <div class="form-group mt-10">
                    <input name="membership_addr2" value="" type="text" id="addressDetail" class="form-input"
                        placeholder="상세주소를 입력해주세요">
                </div>

                <label class="form-label">전화번호<span class="required">*</span></label>

                <div class="form-inline phone">
                    <input name="mobile1" id="mobile1" type="text" class="form-input phone-input number-only" placeholder="010" maxlength="3">
                    <span class="phone-dash">-</span>
                    <input name="mobile2" id="mobile2" type="text" class="form-input phone-input number-only" placeholder="1234" maxlength="4">
                    <span class="phone-dash">-</span>
                    <input name="mobile3" id="mobile3" type="text" class="form-input phone-input number-only" placeholder="5678" maxlength="4">
                </div>
            </div>

            <div class="form-group join-section">
                <div class="title_flex">
                    <h3 class="section-title" >학력</h3>
                    <div class="btn_more" onclick="addEducation()">
                        <p>추가 +</p>
                    </div>
                </div>
                <div id="education-container">
                    <div class="education-item">
                        <label class="form-label">기 간<span class="required">*</span></label>
                        <div class="form-inline">
                            <input name="membership_period[]" class="membership_period form-input" value="" type="text"
                                placeholder=" 00.00 ~ 00.00">
                        </div>

                        <label class="form-label">학교명<span class="required">*</span></label>
                        <div class="form-group">
                            <input name="membership_school[]" class="membership_school form-input" value="" type="text"
                                placeholder="△△대학교">
                        </div>

                        <label class="form-label">학과명 (전공분야)<span class="required">*</span></label>
                        <div class="form-inline">
                            <input name="membership_department[]" class="membership_department form-input" type="text"
                                placeholder="△△공학과">
                        </div>

                        <label class="form-label">학위<span class="required">*</span></label>
                        <div class="form-inline">
                            <input name="membership_degree[]" class="membership_degree form-input" type="text"
                                placeholder="학사">
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group join-section">
                <div class="title_flex">
                    <h3 class="section-title">주요경력</h3>
                    <div class="btn_more" onclick="addCareer()">
                        <p>추가 +</p>
                    </div>
                </div>
                <div id="career-container">
                    <div class="career-item">
                        <label class="form-label">기 간<span class="required">*</span></label>
                        <div class="form-inline">
                            <input name="active_period[]" class="active_period form-input" value="" type="text"
                                placeholder=" 00.00 ~ 00.00">
                        </div>

                        <label class="form-label">소속<span class="required">*</span></label>
                        <div class="form-group">
                            <input name="active_affiliation[]" class="active_affiliation form-input" value="" type="text"
                                placeholder="△△건설">
                        </div>

                        <label class="form-label">담당부서<span class="required">*</span></label>
                        <div class="form-inline">
                            <input name="active_department[]" class="active_department form-input" type="text"
                                placeholder="△△사업부">
                        </div>

                        <label class="form-label">직위<span class="required">*</span></label>
                        <div class="form-inline">
                            <input name="active_position[]" class="active_position form-input" type="text"
                                placeholder="부장">
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group join-section">
                <div class="title_flex">
                    <h3 class="section-title">대외활동</h3>
                    <div class="btn_more" onclick="addExtra()">
                        <p>추가 +</p>
                    </div>
                </div>
                <div id="extra-container">
                    <div class="extra-item">
                        <label class="form-label">기간<span class="required">*</span></label>
                        <div class="form-inline">
                            <input name="extra_period[]" id="extra_period" value="" type="text" class="form-input"
                                placeholder=" 00.00 ~ 00.00">
                        </div>
                        <label class="form-label">소속<span class="required">*</span></label>
                        <div class="form-inline">
                            <input name="extra_affiliation[]" id="extra_affiliation" value="" type="text" class="form-input"
                                placeholder="△△건설">
                        </div>
                    </div>
                </div>

            </div>

            <div class="form-group join-section">
                <div class="title_flex">
                    <h3 class="section-title">자격사항</h3>
                    <div class="btn_more" onclick="addQualification()">
                        <p>추가 +</p>
                    </div>
                </div>
                <div id="qualification-container">
                    <div class="qualification-item">
                        <label class="form-label">자격증명<span class="required">*</span></label>
                        <div class="form-inline">
                            <input name="membership_qualification[]" id="membership_qualification" type="text" class="form-input"
                                placeholder="△△기술사">
                        </div>
                    </div>
                </div>
                <!-- <label class="form-label">사진 전문가<span class="required">*</span></label>
                <div class="form-inline">
                    <input type="text" class="form-input" id="quaFileName" placeholder="파일을 선택해주세요" readonly>
                    <button type="button" class="btn-upload" id="btnQuaFile">
                        파일첨부
                    </button>
                    <input name="qualification_file" type="file" id="quaFileInput" accept=".jpg,.jpeg,.png,.pdf"
                            hidden>
                </div> -->
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

function addEducation() {
    const container = document.getElementById('education-container');
    const itemNumber = container.children.length + 1;
    const educationItem = document.createElement('div');
    educationItem.className = 'education-item';
    educationItem.innerHTML = `
        <label class="form-label">기 간${itemNumber}<span class="required">*</span></label>
        <div class="form-inline">
            <input name="membership_period[]" class="membership_period form-input" value="" type="text"
                placeholder="00.00 ~ 00.00">
        </div>

        <label class="form-label">학교명${itemNumber}<span class="required">*</span></label>
        <div class="form-group">
            <input name="membership_school[]" class="membership_school form-input" value="" type="text"
                placeholder="△△대학교">
        </div>

        <label class="form-label">학과명 (전공분야)${itemNumber}<span class="required">*</span></label>
        <div class="form-inline">
            <input name="membership_department[]" class="membership_department form-input" type="text"
            placeholder="△△공학과">
        </div>

        <label class="form-label">학위${itemNumber}<span class="required">*</span></label>
        <div class="form-inline">
            <input name="membership_degree[]" class="membership_degree form-input" type="text"
            placeholder="학사">
        </div>
        <div class="btn_edu">
            <button type="button" class="btn_remove" onclick="removeEducation(this)">삭제</button>
        </div>
    `;
    container.appendChild(educationItem);
}

// 학력 삭제 함수
function removeEducation(btn) {
    const container = document.getElementById('education-container');
    if (container.children.length > 1) {
        btn.closest('.education-item').remove();
        updateEducationLabels();
    } else {
        alert('최소 1개의 학력 정보는 필요합니다.');
    }
}

function updateEducationLabels() {
    const container = document.getElementById('education-container');
    const items = container.querySelectorAll('.education-item');
    
    items.forEach((item, index) => {
        const labels = item.querySelectorAll('.form-label');
        const labelTexts = ['기 간', '학교명', '학과명 (전공분야)', '학위'];
        const number = index > 0 ? (index + 1) : '';
        
        labels.forEach((label, labelIndex) => {
            if (labelIndex < labelTexts.length) {
                label.innerHTML = `${labelTexts[labelIndex]}${number}<span class="required">*</span>`;
            }
        });
    });
}

function addCareer() {
    const container = document.getElementById('career-container');
    const itemNumber = container.children.length + 1;
    const careerItem = document.createElement('div');
    careerItem.className = 'career-item';
    careerItem.innerHTML = `
        <label class="form-label">기 간${itemNumber}<span class="required">*</span></label>
        <div class="form-inline">
            <input name="active_period[]" class="active_period form-input" value="" type="text"
                placeholder="00.00 ~ 00.00">
        </div>

        <label class="form-label">소속${itemNumber}<span class="required">*</span></label>
        <div class="form-group">
            <input name="active_affiliation[]" class="active_affiliation form-input" value="" type="text"
                placeholder="△△건설">
        </div>

        <label class="form-label">담당부서${itemNumber}<span class="required">*</span></label>
        <div class="form-inline">
            <input name="active_department[]" class="active_department form-input" type="text"
            placeholder="△△사업부">
        </div>

        <label class="form-label">직위${itemNumber}<span class="required">*</span></label>
        <div class="form-inline">
            <input name="active_position[]" class="active_position form-input" type="text"
            placeholder="부장">
        </div>
        <div class="btn_edu">
            <button type="button" class="btn_remove" onclick="removeCareer(this)">삭제</button>
        </div>
    `;
    container.appendChild(careerItem);
}

function removeCareer(btn) {
    const container = document.getElementById('career-container');
    if (container.children.length > 1) {
        btn.closest('.career-item').remove();
        updateCareerLabels();
    } else {
        alert('최소 1개의 경력 정보는 필요합니다.');
    }
}

function updateCareerLabels() {
    const container = document.getElementById('career-container');
    const items = container.querySelectorAll('.career-item');
    
    items.forEach((item, index) => {
        const labels = item.querySelectorAll('.form-label');
        const labelTexts = ['기 간', '소속', '담당부서', '직위'];
        const number = index > 0 ? (index + 1) : '';
        
        labels.forEach((label, labelIndex) => {
            if (labelIndex < labelTexts.length) {
                label.innerHTML = `${labelTexts[labelIndex]}${number}<span class="required">*</span>`;
            }
        });
    });
}

function addExtra() {
    const container = document.getElementById('extra-container');
    const itemNumber = container.children.length + 1;
    const extraItem = document.createElement('div');
    extraItem.className = 'extra-item';
    extraItem.innerHTML = `
        <label class="form-label">기간${itemNumber}<span class="required">*</span></label>
        <div class="form-inline">
            <input name="extra_period[]" class="extra_period form-input" value="" type="text"
                placeholder="00.00 ~ 00.00">
        </div>

        <label class="form-label">소속${itemNumber}<span class="required">*</span></label>
        <div class="form-group">
            <input name="extra_affiliation[]" class="extra_affiliation form-input" value="" type="text"
                placeholder="△△건설">
        </div>

        <div class="btn_edu">
            <button type="button" class="btn_remove" onclick="removeExtra(this)">삭제</button>
        </div>
    `;
    container.appendChild(extraItem);
}

function removeExtra(btn) {
    const container = document.getElementById('extra-container');
    if (container.children.length > 1) {
        btn.closest('.extra-item').remove();
        updateExtraLabels();
    } else {
        alert('최소 1개의 대외활동 정보는 필요합니다.');
    }
}

function updateExtraLabels() {
    const container = document.getElementById('extra-container');
    const items = container.querySelectorAll('.extra-item');
    
    items.forEach((item, index) => {
        const labels = item.querySelectorAll('.form-label');
        const labelTexts = ['기간', '소속'];
        const number = index > 0 ? (index + 1) : '';
        
        labels.forEach((label, labelIndex) => {
            if (labelIndex < labelTexts.length) {
                label.innerHTML = `${labelTexts[labelIndex]}${number}<span class="required">*</span>`;
            }
        });
    });
}

function addQualification() {
    const container = document.getElementById('qualification-container');
    const itemNumber = container.children.length + 1;
    const qualificationItem = document.createElement('div');
    qualificationItem.className = 'qualification-item';
    qualificationItem.innerHTML = `
        <label class="form-label">자격증명${itemNumber}<span class="required">*</span></label>
        <div class="form-inline">
            <input name="membership_qualification[]" class="membership_qualification form-input" value="" type="text"
                placeholder="△△기술사">
        </div>

        <div class="btn_edu">
            <button type="button" class="btn_remove" onclick="removeQualification(this)">삭제</button>
        </div>
    `;
    container.appendChild(qualificationItem);
}

function removeQualification(btn) {
    const container = document.getElementById('qualification-container');
    if (container.children.length > 1) {
        btn.closest('.qualification-item').remove();
        updateQualificationLabels();
    } else {
        alert('최소 1개의 자격사항 정보는 필요합니다.');
    }
}

function updateQualificationLabels() {
    const container = document.getElementById('qualification-container');
    const items = container.querySelectorAll('.qualification-item');
    
    items.forEach((item, index) => {
        const labels = item.querySelectorAll('.form-label');
        const number = index > 0 ? (index + 1) : '';
        
        labels.forEach((label) => {
            label.innerHTML = `자격증명${number}<span class="required">*</span>`;
        });
    });
}

async function send_it() {
    let frm = document.frm;
    let formData = new FormData(frm);
    let url = '/member/member_infomation_ok';

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

    // 증명사진
    let membership_photo = $('#bizFileInput').val();
    if (!membership_photo) {
        alert('증명사진을 첨부해주세요.');
        return false;
    }

    let membership_organization = $('#membership_organization').val();
    if (!membership_organization) {
        alert('기관/직위를 입력해주세요.');
        $('#membership_organization').focus();
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

    let mobile1 = $('#mobile1').val();
    let mobile2 = $('#mobile2').val();
    let mobile3 = $('#mobile3').val();
    if (!mobile1 || !mobile2 || !mobile3) {
        alert('전화번호를 입력해주세요.');
        if (!mobile1) $('#mobile1').focus();
        else if (!mobile2) $('#mobile2').focus();
        else $('#mobile3').focus();
        return false;
    }

    let educationItems = document.querySelectorAll('.education-item');
    let hasValidEducation = false;
    
    for (let i = 0; i < educationItems.length; i++) {
        let period = educationItems[i].querySelector('.membership_period').value;
        let school = educationItems[i].querySelector('.membership_school').value;
        let department = educationItems[i].querySelector('.membership_department').value;
        let degree = educationItems[i].querySelector('.membership_degree').value;
        
        if (period || school || department || degree) {
            if (!period) {
                alert('학력 기간을 입력해주세요.');
                educationItems[i].querySelector('.membership_period').focus();
                return false;
            }
            if (!school) {
                alert('학교명을 입력해주세요.');
                educationItems[i].querySelector('.membership_school').focus();
                return false;
            }
            if (!department) {
                alert('학과명(전공분야)을 입력해주세요.');
                educationItems[i].querySelector('.membership_department').focus();
                return false;
            }
            if (!degree) {
                alert('학위를 입력해주세요.');
                educationItems[i].querySelector('.membership_degree').focus();
                return false;
            }
            hasValidEducation = true;
        }
    }
    
    if (!hasValidEducation) {
        alert('최소 1개의 학력 정보를 입력해주세요.');
        return false;
    }

    let careerItems = document.querySelectorAll('.career-item');
    let hasValidCareer = false;
    
    for (let i = 0; i < careerItems.length; i++) {
        let period = careerItems[i].querySelector('.active_period').value;
        let affiliation = careerItems[i].querySelector('.active_affiliation').value;
        let department = careerItems[i].querySelector('.active_department').value;
        let position = careerItems[i].querySelector('.active_position').value;
        
        if (period || affiliation || department || position) {
            if (!period) {
                alert('주요경력 기간을 입력해주세요.');
                careerItems[i].querySelector('.active_period').focus();
                return false;
            }
            if (!affiliation) {
                alert('주요경력 소속을 입력해주세요.');
                careerItems[i].querySelector('.active_affiliation').focus();
                return false;
            }
            if (!department) {
                alert('담당부서를 입력해주세요.');
                careerItems[i].querySelector('.active_department').focus();
                return false;
            }
            if (!position) {
                alert('직위를 입력해주세요.');
                careerItems[i].querySelector('.active_position').focus();
                return false;
            }
            hasValidCareer = true;
        }
    }
    
    if (!hasValidCareer) {
        alert('최소 1개의 경력 정보를 입력해주세요.');
        return false;
    }

    let membership_qualification = $('#membership_qualification').val();
    if (!membership_qualification) {
        alert('자격증명을 입력해주세요.');
        $('#membership_qualification').focus();
        return false;
    }

    // let qualification_file = $('#quaFileInput').val();
    // if (!qualification_file) {
    //     alert('자격사항 파일을 첨부해주세요.');
    //     return false;
    // }

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