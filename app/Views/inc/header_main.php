<?php
$member = session()->get("member");
$site = homeSetInfo();
?>
<?php
$currentPath = '/' . trim(service('uri')->getPath(), '/');
?>
<script src="https://www.google.com/recaptcha/api.js?hl=ko" async defer></script>
<link href="<?= base_url('assets/css/new_header.css') ?>" rel="stylesheet" type="text/css" />

<style>
    .kssa-header .form_search .inner {
        position: relative;
        margin: 0 auto;
        max-width: 1200px;
        width: calc(100% - 1.875rem);
    }

    .kssa-header .form_search {
        display: none;
        position: absolute;
        top: 150px;
        left: 50%;
        transform: translateX(-50%);
        width: 100vw;
        background-color: #fff;
        border-bottom: 1px solid #ececec;
        z-index: 505;
        min-height: 200px;
    }

    .kssa-header .form_search .close_search_btn {
        position: absolute;
        right: 0;
        width: 50px;
        height: 50px;
        background: url(/img/btn/search_close_btn_w.png) no-repeat center;
    }

    .kssa-header .search_board {
        max-width: 800px;
        padding-top: 70px;
        margin: 0 auto;
    }

    .kssa-header .search_board .btn_search {
        width: 800px;
        border-bottom: 2px solid;
        padding-right: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .kssa-header .search_board .btn_search input[type="text"] {
        width: 100%;
        height: 40px;
        padding: 10px;
    }

    .kssa-header .search_board .btn_search input[type="text"]:focus {
        border: none;
        outline: none;
        box-shadow: none;
    }

    .kssa-header .search_board .btn_search .txt {
        font-size: 20px;
        color: #999999;
        font-weight: 500;
        border: none;
        width: 100%;
    }

    .kssa-header .search_board .btn_search .btn {
        height: 3.25rem;
        padding: 0 0.9375rem;
        color: #252525;
        font-size: 1rem;
        font-weight: 500;
        text-align: center;
        background: url(/img/btn/search_btn_b.png) no-repeat center;
        width: 31px;
        border: none;
    }


    .kssa-header .search_board .hashtag_list_title {
        font-size: 22px;
        font-weight: 700;
        padding-top: 50px;
    }

    .kssa-header .search_board .hashtag_list_content {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        padding-top: 30px;
        font-size: 16px;
        font-weight: 500;
        min-height: 160px;
    }

    .kssa-header .search_board .hashtag_list_content li a {
        padding: 12px 20px;
        background-color: #f4f5f7;
        border-radius: 23px;
    }



    .kssa-menu {
        display: flex;
        gap: 30px;
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .kssa-menu li a {
        position: relative;
        text-decoration: none;
        color: #333;
        padding: 10px 0;
        display: inline-block;
    }


    .kssa-menu li a::after {
        content: "";
        position: absolute;
        left: 0;
        bottom: -3px;
        width: 0;
        height: 2px;
        background: #215dbf;
        transition: width 0.3s ease;
    }


    .kssa-menu li a:hover::after {
        width: 100%;
    }


    .kssa-menu li a.active {
        color: #215dbf;
        font-weight: 600;
    }

    .kssa-menu li a.active::after {
        width: 100%;
    }
</style>

<body>
    <div id="wrap">
        <header class="kssa-header">
            <div class="kssa-wrap">

                <div class="kssa-top">
                    <a href="/" class="kssa-logo">
                        <img src="<?= base_url('uploads/home/' . $site['logos']) ?>" alt="KSSA" />
                    </a>

                    <div class="kssa-mobile-icons">
                        <button class="btn-search" type="button" aria-label="search">
                            <img src="/assets/img/header/ico_search_mo.png" alt="search" />
                        </button>

                        <button class="btn-hamburger-mo" type="button" aria-label="menu">
                            <img src="/assets/img/header/ico_hamburger.png" alt="menu" />
                        </button>
                    </div>
                    <div class="kssa-auth">
                        <?php if (isset($member) && isset($member['name'])): ?>
                            <?php
                                $memberTypeLabel = match($member['member_type'] ?? '') {
                                    'N' => '개인회원 (일반)',
                                    'G' => '단체회원',
                                    'S' => '특별회원',
                                    default => ''
                                };
                            ?>
                            <a href="#!">안녕하세요! <span style="color: #0d6efd"><?= $member['name'] ?></span><?php if ($memberTypeLabel): ?>, <span style="color: #6c757d; font-size: 0.9em"><?= $memberTypeLabel ?></span><?php endif; ?></a> <span
                                class="sep">|</span> <a href="/logout">로그아웃</a> <a href="/lecture_video"
                                class="mypage-link"> <img src="/assets/img/header/ico_mypage.png" alt="mypage" /> <span
                                    class="mypage-txt">Mypage</span> </a>
                        <?php else: ?>
                            <a href="/login">로그인</a>
                            <span class="sep">|</span>
                            <a href="/join_the_membership">회원가입</a>
                        <?php endif; ?>
                    </div>
                </div>

            </div>

            <div class="kssa-wrap">
                <div class="kssa-bottom">
                    <nav class="kssa-gnb">
                        <button class="btn-hamburger" type="button" aria-label="menu">
                            <img src="/assets/img/header/ico_hamburger.png" alt="menu" />
                        </button>

                        <ul class="kssa-menu">
                            <li>
                                <a href="/main_tasks"
                                    class="<?= in_array($currentPath, ['/main_tasks', '/contract_information', '/slope_safety', '/safety_inspection', '/detailed_investigation', '/disaster_risk', '/slope_topography_map']) ? 'active' : '' ?>">
                                    업무 안내
                                </a>
                            </li>

                            <li>
                                <a href="/notice"
                                    class="<?= in_array($currentPath, ['/notice', '/recruitment_infor', '/promotion', '/competition', '/association_journal']) ? 'active' : '' ?>">
                                    알림마당
                                </a>
                            </li>

                            <li>
                                <a href="/greeting"
                                    class="<?= in_array($currentPath, ['/greeting', '/history', '/vision', '/organization_guide', '/ci_introduction', '/past_presidents', '/directions']) ? 'active' : '' ?>">
                                    협회 소개
                                </a>
                            </li>

                            <li>
                                <a href="/sign_up_instructions"
                                    class="<?= in_array($currentPath, ['/sign_up_instructions', '/member_resource']) ? 'active' : '' ?>">
                                    회원 안내
                                </a>
                            </li>

                            <li>
                                <a href="/training_information"
                                    class="<?= in_array($currentPath, ['/training_information', '/apply_for_training', '/take_training', '/completioncert_reissue']) ? 'active' : '' ?>">
                                    계측전문인력 교육
                                </a>
                            </li>
                        </ul>
                    </nav>

                    <button class="btn-search" type="button" aria-label="search" onclick="openSearch();">
                        <img src="/assets/img/header/ico_search.png" alt="search" />
                    </button>
                </div>
            </div>

            <div class="form_search" id="form_search">
                <div class="inner">
                    <button class="close_search_btn" onclick="closeSearch()"></button>
                </div>
                <div class="search_board">
                    <form method="get" name="sfrm2" id="sfrm2" action="#1" onsubmit="return search_it2();">
                        <div class="btn_search flex_b_c">
                            <input type="text" class="txt" id="top_search" name="search_name" value=""
                                placeholder="검색어를 입력해주세요!">
                            <input type="submit" id="" name="" value="" class="btn" style="cursor:pointer;">
                        </div>
                    </form>
                    <script>
                        function search_it2() {
                            if (document.sfrm2.search_name.value == "") {
                                document.sfrm2.search_name.focus();
                                alert("검색어를 입력하셔야 합니다.");
                                return false;
                            }
                        }
                    </script>
                </div>
            </div>
        </header>
        <ul class="kssa-menu-mobile only_mo">

            <li class="menu-mobile-header">
                <a href="/">
                    <img src="/assets/img/header/logo_kssa.png" alt="KSSA" class="menu-mobile-logo">
                </a>

                <button class="btn-menu-close" type="button" aria-label="close">
                    <img src="/assets/img/common/ico_close.png" alt="close">
                </button>
            </li>

            <li><a href="/main_tasks">업무 안내</a></li>
            <li><a href="/notice">알림마당</a></li>
            <li><a href="/greeting">협회 소개</a></li>
            <li><a href="/sign_up_instructions">회원 안내</a></li>
            <li><a href="/training_information">계측전문인력 교육</a></li>

        </ul>
        <div class="mobile-overlay"></div>
    </div>

    <script>
        const btnHamburgerMo = document.querySelector('.btn-hamburger-mo');
        const mobileMenu = document.querySelector('.kssa-menu-mobile');
        const overlay = document.querySelector('.mobile-overlay');
        const btnClose = document.querySelector('.btn-menu-close');

        btnHamburgerMo.addEventListener('click', openMenu);
        overlay.addEventListener('click', closeMenu);
        btnClose.addEventListener('click', closeMenu);

        mobileMenu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', closeMenu);
        });

        function openMenu() {
            mobileMenu.classList.add('is-open');
            overlay.classList.add('is-open');
            document.body.style.overflow = 'hidden';
        }

        function closeMenu() {
            mobileMenu.classList.remove('is-open');
            overlay.classList.remove('is-open');
            document.body.style.overflow = '';
        }

        function openSearch() {
            $('#form_search').show();
        }

        function closeSearch() {
            $('#form_search').hide();
        }
    </script>
    <!-- <script>
        document.addEventListener("DOMContentLoaded", function () {

            let currentPath = window.location.pathname.replace(/\/$/, "");

            const menuLinks = document.querySelectorAll(".kssa-menu a");

            menuLinks.forEach(link => {

                let linkPath = new URL(link.href).pathname.replace(/\/$/, "");

                if (currentPath.startsWith(linkPath)) {
                    link.classList.add("active");
                }

            });
        });
    </script> -->