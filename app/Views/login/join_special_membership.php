<?php $this->extend('inc/layout_index'); ?>
<?php $this->section('content'); ?>
<style>
    .btn-check.disabled {
        cursor: not-allowed;
        background-color: #215dbfa3;
    }
</style>
<main id="container" class="main main_new">
    <form name="frm" class="frm" method="post" action="#">
        <section class="join-account">
            <!-- <input type="hidden" name="member_type" id="member_type" value="G"> -->
            <input type="hidden" name="id_chk" id="id_chk" value="">
            <input type="hidden" name="phone_chk" id="phone_chk" value="">
            <h2 class="join-title">회원가입</h2>

            <div class="login_tab">
                <button type="button" class="" onclick="go_find_special_member();">개인회원</button>
                <button type="button" class="on">단체 및 특별회원</button>
            </div>

            <div class="agree-list spe">
                <label class="agree-row">
                    <input id="member_type_g" name="member_type" type="radio" value="G" checked>
                    <span class="agree-circle"></span>
                    <span class="agree-label">단체회원</span>
                </label>
                <label class="agree-row">
                    <input id="member_type_s" name="member_type" type="radio" value="S">
                    <span class="agree-circle"></span>
                    <span class="agree-label">특별회원</span>
                </label>
            </div>

            <div class="form-group">
                <label class="form-label">아이디<span class="required">*</span></label>

                <div class="form-inline">
                    <input name="user_id" id="user_id" type="text" class="form-input" value=""
                        placeholder="아이디를 입력해주세요">
                    <button type="button" class="btn-check" id="btnChkID" onclick="chkID();">중복확인</button>
                </div>

                <p class="form-guide">6~20자 이내로 입력해주세요.</p>
            </div>

            <div class="form-group">
                <label class="form-label">비밀번호<span class="required">*</span></label>
                <div class="password-wrap">
                    <input name="password" id="password" value="" type="password" class="form-input"
                        placeholder="대/소문자 구분은 없도록, 영문+숫자+특수문자 조합">
                    <button
                        type="button"
                        class="btn-eye"
                        onclick="togglePassword()"
                        aria-label="비밀번호 보기">
                        <img
                            src="/assets/img/member/ico_eye_close.png"
                            alt="비밀번호 보기"
                            id="eyeIcon">
                    </button>
                    <p class="form-guide">
                        8~16자리 영문, 숫자, 특수문자 조합으로만 구성(대+소문자 구별X)
                    </p>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">비밀번호 재입력<span class="required">*</span></label>
                <div class="password-wrap">
                    <input name="conf_password" id="conf_password" value="" type="password" class="form-input"
                        placeholder="대/소문자 구분은 없도록, 영문+숫자+특수문자 조합">
                    <button
                        type="button"
                        class="btn-eye"
                        onclick="togglePassword2()"
                        aria-label="비밀번호 보기">
                        <img
                            src="/assets/img/member/ico_eye_close.png"
                            alt="비밀번호 보기"
                            id="eyeIcon2">
                    </button>
                    <p class="form-guide">
                        8~16자리 영문, 숫자, 특수문자 조합으로만 구성(대+소문자 구별X)
                    </p>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">이메일<span class="required">*</span></label>

                <div class="form-inline email">
                    <input name="user_email1" id="user_email1" value="" type="text" class="form-input" placeholder="이메일을 입력해주세요">
                    <!-- <span class="email-at">@</span>
                        <select name="user_email2" id="user_email2" class="form-select">
                            <option>선택</option>
                            <option>naver.com</option>
                            <option>gmail.com</option>
                            <option>daum.net</option>
                        </select> -->
                </div>
            </div>

            <div class="join_group">
                <!-- 2 -->
                <div class="join-section">
                    <h3 class="section-title" id="company_section_title">단체정보</h3>

                    <div class="form-group">
                        <label class="form-label">기관명<span class="required">*</span></label>
                        <input name="company_name" id="company_name" value="" type="text" class="form-input"
                            placeholder="업체명을 입력해주세요">
                    </div>

                    <div class="form-group">
                        <label class="form-label">대표자성명<span class="required">*</span></label>
                        <input name="company_representative" id="company_representative" value="" type="text"
                            class="form-input" placeholder="대표자성명을 입력해주세요">
                    </div>

                    <!-- <div class="form-group">
                            <label class="form-label">사업자번호<span class="required">*</span></label>
                            <input name="business_number" id="business_number" value="" type="text" class="form-input"
                                   placeholder="사업자번호를 입력해주세요">
                        </div> -->

                    <div class="form-group">
                        <label class="form-label">업태<span class="required">*</span></label>
                        <input name="business_type" id="business_type" value="" type="text" class="form-input"
                            placeholder="업태를 입력해주세요">
                    </div>

                    <div class="form-group">
                        <label class="form-label">업종<span class="required">*</span></label>
                        <input name="business_industry" id="business_industry" value="" type="text" class="form-input"
                            placeholder="업종를 입력해주세요">
                    </div>

                    <div class="form-group">
                        <label class="form-label">단체 전화번호<span class="required">*</span></label>

                        <div class="form-inline phone">
                            <input name="b_phone1" id="b_phone1" type="text" class="form-input phone-input number-only">

                            <span class="phone-dash">-</span>

                            <input name="b_phone2" id="b_phone2" type="text" class="form-input phone-input number-only">

                            <span class="phone-dash">-</span>

                            <input name="b_phone3" id="b_phone3" type="text" class="form-input phone-input number-only">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">홈페이지<span class="required">*</span></label>
                        <input name="bussiness_web" id="bussiness_web" value="" type="text" class="form-input"
                            placeholder="홈페이지를 입력해주세요">
                    </div>

                    <div class="form-group">
                        <label class="form-label">사업자등록번호(고유등록번호)<span class="required">*</span></label>

                        <!-- <div class="form-inline">
                                <input
                                    type="text"
                                    class="form-input"
                                    placeholder=""
                                    readonly>
                                <button type="button" class="btn-upload">파일첨부</button>
                            </div> -->
                        <div class="form-inline phone">
                            <input name="business_number1" id="business_number1" type="text" class="form-input phone-input number-only">

                            <span class="phone-dash">-</span>

                            <input name="business_number2" id="business_number2" type="text" class="form-input phone-input number-only">

                            <span class="phone-dash">-</span>

                            <input name="business_number3" id="business_number3" type="text" class="form-input phone-input number-only">
                        </div>
                        <!-- <div class="form-inline">
                                <input type="text" class="form-input" id="bizFileName" placeholder="파일을 선택해주세요" readonly>
                                <button type="button" class="btn-upload" id="btnBizFile">
                                    파일첨부
                                </button>
                                <input name="company_file" type="file" id="bizFileInput" accept=".jpg,.jpeg,.png,.pdf"
                                       hidden>
                            </div> -->
                    </div>
                    <div class="form-group">
                        <label class="form-label">주소<span class="required">*</span></label>
                        <div class="form-inline">
                            <input name="zip" value="" type="text" id="zipcode" class="form-input" placeholder="우편번호"
                                readonly>
                            <button type="button" class="btn-check" onclick="execDaumPostcode()">
                                주소찾기
                            </button>
                        </div>

                        <div class="form-group mt-10">
                            <input name="addr1" value="" type="text" id="address" class="form-input" placeholder="주소"
                                readonly>
                        </div>

                        <div class="form-group mt-10">
                            <input name="addr2" value="" type="text" id="addressDetail" class="form-input"
                                placeholder="상세주소를 입력해주세요">
                        </div>
                    </div>
                </div>
                <!-- 3 -->
                <div class="join-section">
                    <h3 class="section-title">담당자정보</h3>

                    <div class="form-group">
                        <label class="form-label">성명<span class="required">*</span></label>
                        <input name="user_name" id="user_name" value="" type="text" class="form-input"
                            placeholder="성명을 입력해주세요">
                    </div>

                    <div class="form-group">
                        <label class="form-label">직책<span class="required">*</span></label>
                        <input name="work_position" id="work_position" value="" type="text" class="form-input"
                            placeholder="직책을 입력해주세요">
                    </div>

                    <div class="form-group">
                        <label class="form-label">부서<span class="required">*</span></label>
                        <input name="user_department" id="user_department" value="" type="text" class="form-input"
                            placeholder="부서을 입력해주세요">
                    </div>

                    <div class="form-group" style="display: none">
                        <label class="form-label">사무실 전화번호<span class="required">*</span></label>

                        <div class="form-inline phone">
                            <input name="phone1" id="phone1" type="text" class="form-input phone-input">
                            <!-- <select name="phone1" id="phone1" class="form-select phone-select">
                                    <option>선택</option>
                                    <option>02</option>
                                    <option>031</option>
                                    <option>032</option>
                                    <option>051</option>
                                </select> -->

                            <span class="phone-dash">-</span>

                            <input name="phone2" id="phone2" type="text" class="form-input phone-input">

                            <span class="phone-dash">-</span>

                            <input name="phone3" id="phone3" type="text" class="form-input phone-input">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">휴대번호<span class="required">*</span></label>

                        <div class="form-inline phone">
                            <input name="mobile1" id="mobile1" type="text" class="form-input phone-input number-only">
                            <!-- <select name="mobile1" id="mobile1" class="form-select phone-select">
                                    <option>선택</option>
                                    <option>010</option>
                                    <option>011</option>
                                    <option>016</option>
                                </select> -->

                            <span class="phone-dash">-</span>

                            <input name="mobile2" id="mobile2" type="text" class="form-input phone-input number-only">

                            <span class="phone-dash">-</span>

                            <input name="mobile3" id="mobile3" type="text" class="form-input phone-input number-only">
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="button" class="btn-auth-send" onclick="sendSms();">
                            인증번호 전송
                        </button>
                    </div>

                    <div class="form-group">
                        <div class="form-inline">
                            <input id="verify_code" name="verify_code" value="" type="text" class="form-input"
                                placeholder="인증번호를 입력해주세요">
                            <button type="button" class="btn-check" id="btnChkPhone" onclick="chkPhone();">
                                인증확인
                            </button>
                        </div>
                    </div>

                    <div class="form-group agree-group">
                        <label class="agree-item">
                            <input name="sms_yn" id="sms_yn" value="Y" type="checkbox" checked>
                            <span class="agree-check"></span>
                            <span class="agree-text">SMS 수신여부 동의함</span>
                        </label>

                        <label class="agree-item">
                            <input name="user_email_yn" id="user_email_yn" value="Y" type="checkbox" checked>
                            <span class="agree-check"></span>
                            <span class="agree-text">정보 메일 수신</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="join_special">
                <div class="form-group">
                    <label class="form-label">성명<span class="required">*</span></label>
                    <input name="user_name" id="user_name" value="" type="text" class="form-input"
                        placeholder="성명을 입력해주세요">
                </div>

                <div class="form-group">
                    <label class="form-label">주소<span class="required">*</span></label>

                    <div class="form-inline">
                        <input name="zip" value="" type="text" id="zipcode2" class="form-input" placeholder="우편번호"
                            readonly>
                        <button type="button" class="btn-check" onclick="execDaumPostcode2()">
                            주소찾기
                        </button>
                    </div>

                    <div class="form-group mt-10">
                        <input name="addr1" value="" type="text" id="address2" class="form-input" placeholder="주소"
                            readonly>
                    </div>

                    <div class="form-group mt-10">
                        <input name="addr2" value="" type="text" id="addressDetail2" class="form-input"
                            placeholder="상세주소를 입력해주세요">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">휴대번호<span class="required">*</span></label>

                    <div class="form-inline phone">
                        <input name="mobile1" id="mobile1_2" type="text" class="form-input phone-input number-only">

                        <span class="phone-dash">-</span>

                        <input name="mobile2" id="mobile2_2" type="text" class="form-input phone-input number-only">

                        <span class="phone-dash">-</span>

                        <input name="mobile3" id="mobile3_2" type="text" class="form-input phone-input number-only">
                    </div>
                </div>

                <div class="form-group">
                    <button type="button" class="btn-auth-send" onclick="sendSms2();">
                        인증번호 전송
                    </button>
                </div>

                <div class="form-group">
                    <div class="form-inline">
                        <input id="verify_code2" name="verify_code" value="" type="text" class="form-input"
                            placeholder="인증번호를 입력해주세요">
                        <button type="button" class="btn-check" id="btnChkPhone2" onclick="chkPhone2();">
                            인증확인
                        </button>
                    </div>
                </div>

                <div class="form-group agree-group">
                    <label class="agree-item">
                        <input name="sms_yn" id="sms_yn" value="Y" type="checkbox" checked>
                        <span class="agree-check"></span>
                        <span class="agree-text">SMS 수신여부 동의함</span>
                    </label>

                    <label class="agree-item">
                        <input name="user_email_yn" id="user_email_yn" value="Y" type="checkbox" checked>
                        <span class="agree-check"></span>
                        <span class="agree-text">정보 메일 수신</span>
                    </label>
                </div>
            </div>


            <!-- 4 -->
            <div class="join-section agree-section">
                <h3 class="section-title line">약관동의</h3>

                <div class="agree-list">
                    <label class="agree-row">
                        <input id="agree_all" name="agree_all" type="checkbox">
                        <span class="agree-circle"></span>
                        <span class="agree-label">모든 약관에 동의합니다.</span>
                    </label>

                    <label class="agree-row">
                        <input id="agree1" name="agree1" type="checkbox">
                        <span class="agree-circle"></span>
                        <span class="agree-label">
                            약관 동의 <em>(필수사항)</em>
                            <!-- <img src="/assets/img/member/ico_question.png" alt=""> -->
                            <!-- <img
                                    src="/assets/img/member/ico_question.png"
                                    alt=""
                                    class="btn-agree-info"
                                    data-type="required"> -->
                            <button
                                type="button"
                                class="btn-agree-info"
                                data-type="required">
                                보기
                            </button>
                        </span>
                    </label>

                    <label class="agree-row">
                        <input id="agree2" name="agree2" type="checkbox">
                        <span class="agree-circle"></span>
                        <span class="agree-label">
                            기본 정보 동의 <em>(선택사항)</em>
                            <!-- <img src="/assets/img/member/ico_question.png" alt=""> -->
                            <!-- <img
                                    src="/assets/img/member/ico_question.png"
                                    alt=""
                                    class="btn-agree-info"
                                    data-type="optional"> -->
                            <button
                                type="button"
                                class="btn-agree-info"
                                data-type="optional">
                                보기
                            </button>
                        </span>
                    </label>
                </div>
            </div>

            <div class="join-submit spe">
                <!-- <button onclick="submitForm()" type="button" class="btn-join">
                        회원가입
                    </button> -->
                <button type="button" onclick="submitForm()" class="btn-join">
                    홈페이지 계정 생성
                </button>
                <button type="button" onclick="send_it()" class="btn-send">
                    협회 회원가입
                </button>
            </div>
        </section>
    </form>
    <div class="agree-popup" id="agreePopup">
        <div class="agree-popup-inner">
            <button class="popup-close" type="button">&times;</button>

            <h4 id="popupTitle"></h4>
            <div id="popupContent">
                <div id="content1" style="display: none">
                    <div class="only_web">
                        <?= getPolicy('minfo3') ?>
                    </div>
                    <div class="only_mo">
                        <?= getPolicy('minfo3_m') ?>
                    </div>
                </div>
                <div id="content2" style="display: none">
                    <div class="only_web">
                        <?= getPolicy('minfo4') ?>
                    </div>
                    <div class="only_mo">
                        <?= getPolicy('minfo4_m') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- <div class="popup_step">
            <div class="popup_step_inner">
                <div class="step_ic">
                    <img src="/assets/img/member/register_ic.png" alt="">
                </div>
                <div class="step_info">
                    <p class="blue_txt">한국급경사지안전협회 공식 회원이 되시려면 <br> 추가 정보 입력이 필요합니다.</p>
                    <h2>한국급경사지안전협회 이사회 및 협회 승인 완료 후<br> 최종 회원 가입이 승인됩니다!</h2>
                </div>
                <div class="step_btn">
                    <a href="#" id="membership_link">정보 입력 시작하기</a>
                    <a href="/">나중에 할게요</a>
                </div>
            </div>
        </div> -->
</main>
<div id="layer" style="display:none;position:fixed;overflow:hidden;z-index:1999;-webkit-overflow-scrolling:touch;">
    <img src="//t1.daumcdn.net/postcode/resource/images/close.png" id="btnCloseLayer" style="cursor:pointer;position:absolute;right:-3px;top:-3px;z-index:1" onclick="closeDaumPostcode()" alt="닫기 버튼">
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const memberTypeG = document.getElementById('member_type_g');
        const memberTypeS = document.getElementById('member_type_s');
        const companySectionTitle = document.getElementById('company_section_title');
        const joinGroup = document.querySelector('.join_group');
        const joinSpecial = document.querySelector('.join_special');

        function toggleInputs(container, disabled) {
            const inputs = container.querySelectorAll('input, select, textarea');
            inputs.forEach(input => {
                input.disabled = disabled;
            });
        }

        function updateSectionTitle() {
            if (memberTypeS.checked) {
                companySectionTitle.textContent = '특별정보';
                joinSpecial.style.display = 'block';
                joinGroup.style.display = 'none';

                toggleInputs(joinSpecial, false);
                toggleInputs(joinGroup, true);
            } else {
                companySectionTitle.textContent = '단체정보';
                joinGroup.style.display = 'block';
                joinSpecial.style.display = 'none';

                toggleInputs(joinGroup, false);
                toggleInputs(joinSpecial, true);
            }
        }

        memberTypeG.addEventListener('change', updateSectionTitle);
        memberTypeS.addEventListener('change', updateSectionTitle);

        updateSectionTitle();
    });

    function execDaumPostcode2() {
        new daum.Postcode({
            oncomplete: function(data) {
                console.log("data", data);

                document.getElementById("zipcode2").value = data.zonecode;
                document.getElementById("address2").value = data.address;
                document.getElementById("addressDetail2").focus();

                element_layer.style.display = 'none';
            },
            width: '100%',
            height: '100%',
            maxSuggestItems: 5
        }).embed(element_layer);

        element_layer.style.display = 'block';

        initLayerPosition();
    }

    function go_find_special_member() {
        window.location.href = '/join_the_membership';
    }

    function togglePassword() {
        const input = document.getElementById('password');
        const icon = document.getElementById('eyeIcon');

        if (input.type === 'password') {
            input.type = 'text';
            icon.src = '/assets/img/member/ico_eye_open.png';
            icon.alt = '비밀번호 숨기기';
        } else {
            input.type = 'password';
            icon.src = '/assets/img/member/ico_eye_close.png';
            icon.alt = '비밀번호 보기';
        }
    }

    function togglePassword2() {
        const input = document.getElementById('conf_password');
        const icon = document.getElementById('eyeIcon2');

        if (input.type === 'password') {
            input.type = 'text';
            icon.src = '/assets/img/member/ico_eye_open.png';
            icon.alt = '비밀번호 숨기기';
        } else {
            input.type = 'password';
            icon.src = '/assets/img/member/ico_eye_close.png';
            icon.alt = '비밀번호 보기';
        }
    }
</script>

<script src="/js/auth/register.js"></script>
<?php $this->endSection(); ?>