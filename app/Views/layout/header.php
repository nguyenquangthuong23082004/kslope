<?php
$lang = getLocale();
$uri = service('request')->uri->getPath();
$session = session();
$uri = service('uri');
$setting = homeSetInfo();
?>
<!-- header -->
<header id="header">
    <div class="inner">
        <div class="logo">
            <a href="/">
                <img src="/uploads/home/<?= $setting['logos'] ?>" alt="" class="">
            </a>
            <div class="lang-switch">
                <a href="https://edukopec.or.kr/main/main.php"
                   class="<?= ($lang == 'kr' || !$lang) ? 'on' : '' ?>">KR</a>
                <span style="margin: 0 2px;">•</span>
                <a href="https://edukopec.or.kr/en/main/main.php" class="<?= ($lang == 'en') ? 'on' : '' ?>">EN</a>
            </div>
        </div>

        <nav class="gnb">
            <ul class="depth01">
                <li class="<?= (strpos($uri, 'center') !== false) ? 'on' : '' ?>">
                    <button type="button">센터소개</button>
                    <ul class="depth02">
                        <li>
                            <a href="/center/history.php">연혁 및 실적</a>
                        </li>
                        <li>
                            <a href="/center/facilities_new.php">시설 및 장비</a>
                        </li>
                        <li>
                            <a href="/center/organization.php">조직구성</a>
                        </li>
                        <li>
                            <a href="/center/promotion.php">홍보자료</a>
                        </li>
                        <li>
                            <a href="/center/contact.php">위치안내</a>
                        </li>
                    </ul>
                </li>
                <li class="<?= (strpos($uri, 'reservation') !== false) ? 'on' : '' ?>">
                    <button type="button">교육예약</button>
                    <ul class="depth02">
                        <li>
                            <a href="/reservation/education_list.php">교육안내</a>
                        </li>
                        <li>
                            <a href="/reservation/reservation01.php">교육예약</a>
                        </li>
                        <li>
                            <a href="/reservation/my_reservation.php">교육예약 확인 및 취소</a>
                        </li>
                    </ul>
                </li>
                <li class="<?= (strpos($uri, 'education') !== false) ? 'on' : '' ?>">
                    <button type="button">교육지원</button>
                    <ul class="depth02">
                        <li>
                            <a href="/education/notice.php">공지사항</a>
                        </li>
                        <li>
                            <a href="/education/calendar_list.php">교육일정</a>
                        </li>
                        <li>
                            <a href="/education/room.php">교육자료실</a>
                        </li>
                    </ul>
                </li>
                <li class="<?= (strpos($uri, 'mypage') !== false) ? 'on' : '' ?>">
                    <button type="button">회원정보</button>
                    <ul class="depth02">
                        <li>
                            <a href="/mypage/my_status.php">교육수료현황</a>
                        </li>
                        <li>
                            <a href="/mypage/mypage_user_login.php">회원정보수정</a>
                        </li>
                        <li>
                            <a href="/mypage/withdrawal_pw_check.php">회원탈퇴</a>
                        </li>
                    </ul>
                </li>

                <?php if (!empty($session->get('member.id'))): ?>
                    <li class="<?= str_contains($uri->getPath(), 'completed') ? 'on' : '' ?>">
                        <button type="button">이수자 조회</button>
                        <ul class="depth02">
                            <li>
                                <a href="<?= site_url('completed/completed') ?>">이수자 조회</a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>

            </ul>
        </nav>
        <div class="member_link">
            <?php if (empty($session->get('member.id'))): ?>

                <a href="<?= site_url('login') ?>" class="login"><span>로그인</span></a>
                <a href="<?= site_url('member/register') ?>" class="join"><span>회원가입</span></a>

            <?php else: ?>

                <p class="ment">
                    <?= esc($session->get('member.company_name')) ?>
                    <strong><?= esc($session->get('member.name')) ?> 님</strong>
                    <span>반갑습니다.</span>
                </p>

                <a href="<?= site_url('logout') ?>" class="logout"><span>로그아웃</span></a>
                <a href="<?= site_url('mypage') ?>" class="mypage"><span>정보수정</span></a>

            <?php endif; ?>
        </div>
        <button type="button" class="ham_btn">
            <div>
                <span></span>
                <span></span>
                <span></span>
            </div>
        </button>
    </div>
</header>
<!-- //header -->
<!-- all_menu_wrap -->
<div class="all_menu_wrap only_mo">
    <div class="all_menu_head">
        <div class="all_menu_logo">
            <a href="/" class="all_menu_logo">
                <img src="../img/common/logo_mo.png" alt="">
            </a>
        </div>
        <div class="lang-switch">
            <a href="?lang=kr" class="<?= ($lang == 'kr' || !$lang) ? 'on' : '' ?>">KR</a>
            <span style="margin: 0 2px;">•</span>
            <a href="?lang=en" class="<?= ($lang == 'en') ? 'on' : '' ?>">EN</a>
        </div>
        <button type="button" class="all_menu_close">닫기</button>
    </div>
    <div class="all_menu_mid">

        <ul class="mem_link">
            <?php if (empty($session->get('member.id'))): ?>
                <li>
                    <a href="<?= site_url('login') ?>" class="login"><span>로그인</span></a>
                </li>
                <li>
                    <a href="<?= site_url('member/register') ?>" class="join"><span>회원가입</span></a>
                </li>
            <?php else: ?>
                <p class="ment">
                    <?= esc($session->get('member.company_name')) ?>해운
                    <strong><?= esc($session->get('member.name')) ?> 님</strong>
                    <span>반갑습니다.</span>
                </p>
                <li>
                    <a href="<?= site_url('logout') ?>" class="logout"><span>로그아웃</span></a>
                </li>
                <li>
                    <a href="<?= site_url('mypage') ?>" class="mypage"><span>정보수정</span></a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
    <div class="all_menu_body">
        <nav class="all_menu">
            <ul>
                <li>
                    <button type="button" class="all_menu01">센터소개</button>
                    <div class="all_menu02">
                        <ul>
                            <li>
                                <a href="/center/history.php">연혁및실적</a>
                            </li>
                            <li>
                                <a href="/center/facilities.php">시설및장비</a>
                            </li>
                            <li>
                                <a href="/center/organization.php">조직구성</a>
                            </li>
                            <li>
                                <a href="/center/promotion.php">홍보자료</a>
                            </li>
                            <li>
                                <a href="/center/contact.php">위치안내</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <button type="button" class="all_menu01">교육예약</button>
                    <div class="all_menu02">
                        <ul>
                            <li><a href="/reservation/notice.php">공지사항</a></li>
                            <li><a href="/reservation/reservation01.php">교육예약</a></li>
                            <li><a href="/reservation/my_reservation.php">교육예약 확인 및 취소</a></li>
                        </ul>
                    </div>
                </li>
                <li>
                    <button type="button" class="all_menu01">교육안내</button>
                    <div class="all_menu02">
                        <ul>
                            <li><a href="/education/education_list.php">교육안내</a></li>
                            <li><a href="/education/calendar_list.php">교육일정안내</a></li>
                        </ul>
                    </div>
                </li>
                <li>
                    <button type="button" class="all_menu01">회원정보</button>
                    <div class="all_menu02">
                        <ul>
                            <li><a href="/mypage/my_status.php">교육수료현황</a></li>
                            <li><a href="/mypage/mypage_user_login.php">회원정보수정</a></li>
                            <li><a href="/mypage/withdrawal_pw_check.php">회원탈퇴</a></li>
                        </ul>
                    </div>
                </li>
                <li>
                    <button type="button" class="all_menu01">이수자 조회</button>
                    <div class="all_menu02">
                        <ul>
                            <li><a href="/completed/completed.php">이수자 조회</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </nav>

    </div>
</div>
<!-- //all_menu_wrap -->