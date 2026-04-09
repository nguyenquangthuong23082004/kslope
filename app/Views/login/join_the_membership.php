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
        <input type="hidden" name="member_type" id="member_type" value="N">
        <input type="hidden" name="id_chk" id="id_chk" value="">
        <input type="hidden" name="phone_chk" id="phone_chk" value="">
        <section class="join-account">

            <h2 class="join-title">회원가입</h2>

            <div class="login_tab">
                <button type="button" class="on">개인회원</button>
                <button type="button" class="" onclick="go_find_member();">단체 및 특별회원</button>
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
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">성명<span class="required">*</span></label>
                <input name="user_name" id="user_name" value="" type="text" class="form-input"
                    placeholder="성명을 입력해주세요">
            </div>

            <!-- <div class="form-group">
                <label class="form-label">직책<span class="required">*</span></label>
                <input name="work_position" id="work_position" value="" type="text" class="form-input"
                    placeholder="직책을 입력해주세요">
            </div> -->

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

            <div class="form-group">
                <label class="form-label">휴대번호<span class="required">*</span></label>

                <div class="form-inline phone">

                    <!-- <select name="mobile1" id="mobile1" class="form-select phone-select">
                        <option>선택</option>
                        <option>010</option>
                        <option>011</option>
                        <option>016</option>
                    </select> -->
                    <input name="mobile1" id="mobile1" type="text" class="form-input phone-input number-only">

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
                        <?= getPolicy('minfo1') ?>
                    </div>
                    <div class="only_mo">
                        <?= getPolicy('minfo1_m') ?>
                    </div>
                </div>
                <div id="content2" style="display: none">
                    <div class="only_web">
                        <?= getPolicy('minfo2') ?>
                    </div>
                    <div class="only_mo">
                        <?= getPolicy('minfo2_m') ?>
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
    function go_find_member() {
        window.location.href = '/join_special_membership';
    }
</script>
<script>
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