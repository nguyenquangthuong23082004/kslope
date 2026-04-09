<?php $this->extend('inc/layout_index'); ?>
<?php $this->section('content'); ?>
<main id="container" class="main main_new">


    <section class="mypage-wrap">
        <div class="mypage-inner">

            <?= view('mypage/mypage_sidebar', ['active' => 'profile']) ?>

            <div class="mypage-content">
                <h3 class="content-title">회원정보수정</h3>
                <div class="password-check-wrap">
                    <div class="password-check-box">

                        <h4 class="password-title">비밀번호 확인</h4>

                        <div class="password-body">
                            <div class="password-icon">
                                <img src="/assets/img/ico/ico_lock.png" alt="lock">
                            </div>

                            <div class="password-form">
                                <input type="text" placeholder="아이디">
                                <input type="password" placeholder="비밀번호">

                            </div>
                        </div>
                        <button type="button" class="btn-login" onclick="location.href='/edit_member_information'">로그인</button>

                        <p class="password-desc">
                            회원님의 안전한 개인정보 보호를 위해 비밀번호를 다시 한번 확인합니다.
                        </p>

                    </div>
                </div>
            </div>
        </div>
    </section>

</main>
<?php $this->endSection(); ?>