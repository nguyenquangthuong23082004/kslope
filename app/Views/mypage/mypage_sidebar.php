<?php $session = session();?>
<aside class="mypage-side">
    <h2 class="side-title">마이페이지</h2>
    <ul class="side-menu">
        <?php if (!empty($session->get('member.member_type')) && $session->get('member.member_type') != 'N'): ?>
            <li class="<?= ($active ?? '') === 'edu' ? 'active' : '' ?>">
                <a href="/mypage">교육수료현황</a>
            </li>
            <li class="<?= ($active ?? '') === 'staff' ? 'active' : '' ?>">
                <a href="/staff_management">직원관리</a>
            </li>
            <!-- <li class="<?= ($active ?? '') === 'profile' ? 'active' : '' ?>">
                <a href="/verify_password">회원정보수정</a>
            </li>
            <li class="<?= ($active ?? '') === 'withdraw' ? 'active' : '' ?>">
                <a href="#">회원탈퇴</a>
            </li> -->
        <?php endif; ?>
        <li class="<?= ($active ?? '') === 'lecture' ? 'active' : '' ?>">
            <a href="/lecture_video">수강영상</a>
        </li>

        <li class="has-sub <?= in_array(($active ?? ''), ['profile', 'withdraw']) ? 'open active' : '' ?>">
            <a href="javascript:void(0)" class="sub-toggle">
                계정관리
                <span class="arrow"></span>
            </a>

            <ul class="sub-menu">
                <li class="<?= ($active ?? '') === 'profile' ? 'active' : '' ?>">
                    <a href="/verify_password">회원정보수정</a>
                </li>
                <li class="<?= ($active ?? '') === 'withdraw' ? 'active' : '' ?>">
                    <a href="#">회원탈퇴</a>
                </li>
            </ul>
        </li>
    </ul>
</aside>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.sub-toggle').forEach(toggle => {
            toggle.addEventListener('click', function () {
                const parent = this.closest('.has-sub');
                parent.classList.toggle('open');
            });
        });
    });
</script>