<?php $this->extend('inc/layout_index'); ?>
<?php $this->section('content'); ?>
    <main id="container" class="main main_new">
        <div class="login-page">
            <form class="login-card">

                <h2 class="login-title">LOGIN</h2>

                <div class="login-field">
                    <input name="user_id" id="user_id" value="" type="text" placeholder="아이디">
                </div>

                <div class="login-field">
                    <input name="password" id="password" value="" type="password" placeholder="비밀번호">
                </div>

                <button onclick="login_it();" type="button" class="login-btn">로그인</button>

                <div class="login-util">
                    <label class="login-save">
                        <input type="checkbox" checked>
                        <span class="check-ui"></span>
                        <span class="check-text">아이디 저장</span>
                    </label>

                    <div class="login-links">
                        <a href="/find_id">아이디 찾기</a>
                        <a href="/find_password">비밀번호 찾기</a>
                    </div>
                </div>

                <button type="button" onclick="go_join_member();" class="login-signup">회원가입</button>

            </form>
        </div>

    </main>
    <script>
        function go_join_member() {
            window.location.href = '/join_the_membership';
        }
    </script>
    <script>
        document.getElementById("password").addEventListener("keydown", function (e) {
            if (e.key === "Enter") {
                e.preventDefault();
                login_it();
            }
        });

        document.getElementById("user_id").addEventListener("keydown", function (e) {
            if (e.key === "Enter") {
                e.preventDefault();
                login_it();
            }
        });

        async function login_it() {
            let user_id = $('#user_id').val();
            let password = $('#password').val();

            let url = '/member/login'
            let data = {
                user_id: user_id,
                password: password,
            }

            $.ajax({
                url: url,
                method: 'POST',
                data: data,
                success: function (response) {
                    console.log(response)
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