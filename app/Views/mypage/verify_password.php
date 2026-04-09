<?php $this->extend('inc/layout_index'); ?>
<?php $this->section('content'); ?>
<main id="container" class="main main_new">
<style>
    .password-wrap {
        width: 352px;
    }

    .password-wrap .btn-eye {
        position: absolute;
        top: 50%;
    }
</style>

    <section class="mypage-wrap">
        <div class="mypage-inner">

            <?= view('mypage/mypage_sidebar', ['active' => 'profile']) ?>

            <div class="mypage-content">
                <h3 class="content-title">회원정보수정</h3>
                <div class="mypage-content">
                    <div class="sub_content imfor_change">
                        <div class="imfor_tb">
                            <form method="post" name="frm" id="frm">
                                <input type="hidden" name="user_id" value="phongpx">
                                <input type="hidden" name="mode" id="mode" value="mypage">
                                <input type="hidden" name="sns_key" id="sns_key" value="">

                                <fieldset>
                                    <legend>회원 정보 수정</legend>
                                    <table>
                                        <caption>회원 정보 수정 작성 표</caption>
                                        <colgroup>
                                            <col width="15%">
                                            <col width="*">
                                        </colgroup>
                                        <tbody>
                                            <tr>
                                                <th>
                                                    <p>ID</p>
                                                </th>
                                                <td colspan="3">
                                                    <p class="no_write"><?= $user_id ?></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <p>비밀번호</p>
                                                </th>
                                                <td colspan="3" class="wrap_pass">
                                                    <div class="password-wrap">
                                                        <input type="password" id="password" class="pass_input"
                                                            name="password" maxlength="20" value="">
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
                                                    </div>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                    <div class="color_btn_box">
                                        <!--  <button type="button" class="gray_btn">취소</button>-->
                                        <button type="button" class="btn_submit mar_r" onclick="verifyPassword();">
                                            확인
                                        </button>
                                    </div>
                                </fieldset>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main>
<script>
    document.getElementById('password').addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            verifyPassword();
        }
    });
    async function verifyPassword() {
        let password = $('#password').val();

        if (!password) {
            alert('비밀번호를 입력해 주세요.');
            $('#password').focus();
            return false;
        }

        let url = '/handle_verify_password';
        let data = {
            password: password,
        }

        await $.ajax({
            url: url,
            method: 'POST',
            data: data,
            success: function(response) {
                console.log(response)
                window.location.href = '/edit_member_information';
            },
            error: function(exception) {
                alert(exception.responseJSON.message ?? '오류가 발생했습니다!')
                console.log(exception)
            }
        });
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
</script>
<?php $this->endSection(); ?>