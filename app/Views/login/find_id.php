<?php $this->extend('inc/layout_index'); ?>
<?php $this->section('content'); ?>
    <style>
        .btn-check.disabled {
            cursor: not-allowed;
            background-color: #215dbfa3;
        }

        .radio-group {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 40px;
        }

        .radio-item {
            width: 50%;
            display: flex;
            align-items: center;
            cursor: pointer;
            font-size: 20px;
            user-select: none;
        }

        .radio-item input {
            display: none;
        }

        .custom-radio {
            width: 20px;
            height: 20px;
            border: 2px solid #999;
            border-radius: 50%;
            margin-right: 6px;
            position: relative;
        }

        .radio-item input:checked + .custom-radio::after {
            content: "";
            width: 10px;
            height: 10px;
            background: #333;
            border-radius: 50%;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style>
    <main id="container" class="main main_new">
        <form name="frm" class="frm" method="post" action="#">
            <input type="hidden" name="sns_check" id="sns_check" value="N">
            <section class="join-account">

                <h2 class="join-title">ID 찾기</h2>

                <div class="login_tab">
                    <button type="button" class="on">ID 찾기</button>
                    <button type="button" class="" onclick="go_find_password();">비밀번호 찾기</button>
                </div>

                <div class="radio-group">
                    <label class="radio-item">
                        <input type="radio" name="type" value="phone" checked>
                        <span class="custom-radio"></span>
                        휴대폰 번호로 검색
                    </label>

                    <label class="radio-item">
                        <input type="radio" name="type" value="email">
                        <span class="custom-radio"></span>
                        이메일로 검색
                    </label>
                </div>

                <div class="form-group">
                    <label class="form-label">성명<span class="required">*</span></label>
                    <input name="user_name" id="user_name" value="" type="text" class="form-input"
                           placeholder="성명을 입력해주세요">
                </div>

                <div class="form-group" id="formEmail" style="display: none">
                    <label for="user_email1" class="form-label">이메일<span class="required">*</span></label>

                    <div class="form-inline email">
                        <input name="user_email1" id="user_email1" value="" type="text" class="form-input">
                        <span class="email-at">@</span>
                        <select name="user_email2" id="user_email2" class="form-select">
                            <option>선택</option>
                            <option>naver.com</option>
                            <option>gmail.com</option>
                            <option>daum.net</option>
                        </select>
                    </div>
                </div>

                <div class="form-group" id="formPhone">
                    <label class="form-label">휴대번호<span class="required">*</span></label>

                    <div class="form-inline phone">
                        <select name="mobile1" id="mobile1" class="form-select phone-select">
                            <option>선택</option>
                            <option>010</option>
                            <option>011</option>
                            <option>016</option>
                        </select>

                        <span class="phone-dash">-</span>

                        <input name="mobile2" id="mobile2" type="text" class="form-input phone-input">

                        <span class="phone-dash">-</span>

                        <input name="mobile3" id="mobile3" type="text" class="form-input phone-input">
                    </div>
                </div>

                <div class="form-group">
                    <button type="button" class="btn-auth-send" onclick="sendVerifyCode();">
                        인증번호 전송
                    </button>
                </div>

                <div class="form-group">
                    <div class="form-inline">
                        <input id="verify_code" name="verify_code" value="" type="text" class="form-input"
                               placeholder="인증번호를 입력해주세요">
                        <button type="button" class="btn-check" id="btnChk" onclick="handleVerifyCode();">
                            인증확인
                        </button>
                    </div>
                </div>

                <div class="join-submit">
                    <button type="button" onclick="submit_it()" class="btn-join">
                        확인
                    </button>
                </div>
            </section>
        </form>
    </main>

    <script>
        function go_find_password() {
            window.location.href = '/find_password';
        }
    </script>
    <script>
        $(document).ready(function () {
            $('.form-check-input').change(function () {
                let type = $(this).val();

                if (type === "phone") {
                    $('#formPhone').show();
                    $('#formEmail').hide();
                } else {
                    $('#formPhone').hide();
                    $('#formEmail').show();
                }
            })
        })

        async function sendVerifyCode() {
            let url = '/member/find_id/send_verify_code';

            let checkedValue = $('input[name="type"]:checked').val();

            let data = null;

            if (checkedValue == 'phone') {
                let mobile1 = $('#mobile1').val();
                let mobile2 = $('#mobile2').val();
                let mobile3 = $('#mobile3').val();

                if (!mobile1 || !mobile2 || !mobile3) {
                    alert('전화번호를 입력해주세요.');
                    $('#mobile2').focus();
                    return false;
                }

                let phone = mobile1 + mobile2 + mobile3;

                data = {
                    type: checkedValue,
                    phone: phone,
                }
            } else {
                let user_email1 = $('#user_email1').val();
                let user_email2 = $('#user_email2').val();

                if (!user_email1 || !user_email2) {
                    alert('이메일 주소를 입력해 주세요.');
                    $('#user_email1').focus();
                    return false;
                }

                let email = user_email1 + '@' + user_email2;

                data = {
                    type: checkedValue,
                    email: email,
                }
            }

            $.ajax({
                url: url,
                method: 'POST',
                data: data,
                success: function (response) {
                    console.log(response)
                    alert(response.message);
                    $('#verify_code').focus();
                },
                error: function (exception) {
                    alert(exception.responseJSON.message ?? '오류가 발생했습니다!')
                    console.log(exception)
                }
            });
        }

        async function handleVerifyCode() {
            let url = '/member/find_id/verify_code';

            let verify_code = $('#verify_code').val();
            if (!verify_code) {
                alert('인증 코드를 입력해 주세요.');
                $('#verify_code').focus();
                return false;
            }

            let data = {
                verify_code: verify_code
            }

            $.ajax({
                url: url,
                method: 'POST',
                data: data,
                success: function (response) {
                    console.log(response)
                    alert(response.message);
                    $('#sns_check').val('Y');
                    $('#btnChk').prop('disabled', true).addClass('disabled');
                },
                error: function (exception) {
                    alert(exception.responseJSON.message ?? '오류가 발생했습니다!')
                    console.log(exception)
                }
            });
        }

        async function submit_it() {
            let url = '/member/find_id/final';

            let checkedValue = $('input[name="type"]:checked').val();

            let user_name = $('#user_name').val();

            let sns_check = $('#sns_check').val();
            if (sns_check != 'Y') {
                alert('휴대폰 번호 중복 여부를 확인해 주세요.');
                return false;
            }

            let data = null;

            if (checkedValue == 'phone') {
                let mobile1 = $('#mobile1').val();
                let mobile2 = $('#mobile2').val();
                let mobile3 = $('#mobile3').val();

                if (!mobile1 || !mobile2 || !mobile3) {
                    alert('전화번호를 입력해주세요.');
                    $('#mobile2').focus();
                    return false;
                }

                let phone = mobile1 + '-' + mobile2 + '-' + mobile3;

                data = {
                    type: checkedValue,
                    user_name: user_name,
                    phone: phone,
                }
            } else {
                let user_email1 = $('#user_email1').val();
                let user_email2 = $('#user_email2').val();

                if (!user_email1 || !user_email2) {
                    alert('이메일 주소를 입력해 주세요.');
                    $('#user_email1').focus();
                    return false;
                }

                let email = user_email1 + '@' + user_email2;

                data = {
                    type: checkedValue,
                    user_name: user_name,
                    email: email,
                }
            }

            $.ajax({
                url: url,
                method: 'POST',
                data: data,
                success: function (response) {
                    console.log(response)
                    alert(response.message);
                },
                error: function (exception) {
                    alert(exception.responseJSON.message ?? '오류가 발생했습니다!')
                    console.log(exception)
                }
            });
        }
    </script>
<?php $this->endSection(); ?>