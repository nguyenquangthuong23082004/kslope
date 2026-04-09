<?php
include $_SERVER['DOCUMENT_ROOT'] . "/include/lib.inc.php";
if ($_SESSION['member']['level'] > 2 || $_SESSION['member']['level'] == "") {
    header('Location:/AdmMaster/');
    exit();
}
?>
<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="apple-mobile-web-app-title" content="">

    <title><?= _IT_BROWSER_TITLE ?></title>

    <link rel="shortcut icon" type="image/x-icon" href="/AdmMaster/_images/favicon.ico">
    <link rel="apple-touch-icon" href="/AdmMaster/_images/apple-touch-icon.png"/>
    <meta property="og:title" content="<?= _IT_OG_TITLE ?>">
    <meta property="og:site_name" content="<?= _IT_OG_SITE ?>">
    <meta property="og:description" content="<?= _IT_OG_DES ?>">
    <meta property="og:url" content="<?= _IT_OG_URL ?>">
    <meta property="og:image" content="<?= _IT_OG_IMG ?>">
    <meta content="<?= _IT_META_KEYWORD ?>" name="Keyword">
    <meta content="<?= _IT_META_TAG ?>" name="Title"/>
    <meta name="Generator" content="">
    <meta name="Author" content="">
    <meta name="Keywords" content="<?= _IT_META_KEYWORD ?>">
    <meta name="Description" content="<?= _IT_META_TAG ?>">

    <script type="text/javascript" src="/AdmMaster/_common/js/jquery-1.8.3.min.js"></script>

    <link rel="stylesheet" href="/js/jquery-ui-1.11.2.custom/jquery-ui.css">
    <script type="text/javascript" src="/js/jquery.number.js"></script>

    <script src="/js/jquery-ui.min.js" type="text/javascript"></script>
    <script src="/js/notifIt.js" type="text/javascript"></script>
    <link href="/js/notifIt.css" type="text/css" rel="stylesheet">

    <script src="/js/common.js"></script>
    <script src="/js/jquery.form.js"></script>

    <!-- Vendor CSS Files -->
    <link href="/admin/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/admin/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="/admin/vendor/simple-datatables/style.css" rel="stylesheet">
    <link href="/admin/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="/AdmMaster/_common/css/import.css" type="text/css"/>
    <link rel="stylesheet" href="/AdmMaster/_common/css/pop.css" type="text/css"/>
    <link rel="stylesheet" href="/admin/css/template/app.css">
    <link rel="stylesheet" href="/admin/css/template/app-dark.css">
    <link rel="stylesheet" href="/admin/css/template/reset.css">
    <link rel="stylesheet" href="/admin/css/template/iconly.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

    <!-- Template Main CSS File -->

    <script src="https://ssl.daumcdn.net/dmaps/map_js_init/postcode.v2.js"></script>
</head>

<body>
<?php

$sql_home = "select * from tbl_homeset order by idx desc limit 0, 1";
$result_home = mysqli_query($connect, $sql_home) or die (mysqli_error($connect));
$row_home = mysqli_fetch_array($result_home);
$logos = $row_home['logos'];
$logo_footer = $row_home['logo_footer'];
?>
<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <!-- <a href="/AdmMaster" class="logo d-flex align-items-center">
            <span class="d-none d-lg-block"> <?= _IT_SITE_NAME ?> 관리자</span>
        </a> -->
        <!-- <i class="bi bi-list toggle-sidebar-btn"></i> -->
    </div><!-- End Logo -->

    <div class="search-bar">
        <a href="/" class="btn btn-primary" target="_blank">홈페이지 바로가기</a>
    </div><!-- End Search Bar -->
    <div class="navbar-expand topbar " style="margin-left: auto; padding: 0 1.5rem">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item d-flex align-items-center">
                <span style="color: #252525 ;">
                    <?= $row_home["browser_title"] ?> / IP : <?= ($_SERVER['REMOTE_ADDR']) ?> / 최근접속일시 : <span
                            style=" min-width: 174px; display: inline-block;" id="clock">0000-00-00 00:00:00</span>
                </span>
            </li>
            <div class="topbar-divider d-none d-sm-block"></div>
            <li>
                <div class="dropdown">
                    <span class="text-end me-3 d-none d-xl-inline"><?= $_SESSION['member']['name'] ?>님 접속중</span>
                    <img src="https://picsum.photos/200" data-bs-toggle="dropdown"
                         class="dropdown-toggle rounded-circle" style="cursor:pointer;width:35px;height:35px;"
                         alt="image" data-bs-auto-close="outside">
                    <div class="dropdown-menu mt-2">
                        <!-- <div class="dropdown-item d-flex align-items-center justify-content-between mt-2" for="toggle-dark">
                            <span>주제</span>
                            <div class="theme-toggle d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--system-uicons" width="20" height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 21 21">
                                    <g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M10.5 14.5c2.219 0 4-1.763 4-3.982a4.003 4.003 0 0 0-4-4.018c-2.219 0-4 1.781-4 4c0 2.219 1.781 4 4 4zM4.136 4.136L5.55 5.55m9.9 9.9l1.414 1.414M1.5 10.5h2m14 0h2M4.135 16.863L5.55 15.45m9.899-9.9l1.414-1.415M10.5 19.5v-2m0-14v-2" opacity=".3"></path>
                                        <g transform="translate(-210 -1)">
                                            <path d="M220.5 2.5v2m6.5.5l-1.5 1.5"></path>
                                            <circle cx="220.5" cy="11.5" r="4"></circle>
                                            <path d="m214 5l1.5 1.5m5 14v-2m6.5-.5l-1.5-1.5M214 18l1.5-1.5m-4-5h2m14 0h2"></path>
                                        </g>
                                    </g>
                                </svg>
                                <div class="form-check form-switch ms-1 fs-6">
                                    <input class="form-check-input me-0" type="checkbox" id="toggle-dark" style="cursor: pointer">
                                    <label class="form-check-label"></label>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--mdi" width="20" height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="m17.75 4.09l-2.53 1.94l.91 3.06l-2.63-1.81l-2.63 1.81l.91-3.06l-2.53-1.94L12.44 4l1.06-3l1.06 3l3.19.09m3.5 6.91l-1.64 1.25l.59 1.98l-1.7-1.17l-1.7 1.17l.59-1.98L15.75 11l2.06-.05L18.5 9l.69 1.95l2.06.05m-2.28 4.95c.83-.08 1.72 1.1 1.19 1.85c-.32.45-.66.87-1.08 1.27C15.17 23 8.84 23 4.94 19.07c-3.91-3.9-3.91-10.24 0-14.14c.4-.4.82-.76 1.27-1.08c.75-.53 1.93.36 1.85 1.19c-.27 2.86.69 5.83 2.89 8.02a9.96 9.96 0 0 0 8.02 2.89m-1.64 2.02a12.08 12.08 0 0 1-7.8-3.47c-2.17-2.19-3.33-5-3.49-7.82c-2.81 3.14-2.7 7.96.31 10.98c3.02 3.01 7.84 3.12 10.98.31Z">
                                    </path>
                                </svg>
                            </div>
                        </div> -->
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item align-self-center" href="/AdmMaster/logout.php">
                            <i class="bi bi-box-arrow-right me-2"></i> Logout
                        </a>
                    </div>
                </div>
            </li>
        </ul>
    </div>
    <nav class="header-nav ms-auto" style="display: none">
        <ul class="d-flex align-items-center">

            <li class="nav-item d-block d-lg-none">
                <a class="nav-link nav-icon search-bar-toggle " href="#">
                    <i class="bi bi-search"></i>
                </a>
            </li><!-- End Search Icon-->

            <li class="nav-item dropdown pe-3">

                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <img src="https://picsum.photos/200" alt="Profile" class="rounded-circle">
                    <span class="d-none d-md-block dropdown-toggle ps-2"><?= $_SESSION['member']['name'] ?>님 접속중</span>
                </a>

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6><?= $_SESSION['member']['name'] ?>님 접속중</h6>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center"
                           href="/AdmMaster/_adminrator/adm_setting.php">
                            <i class="bi bi-gear"></i>
                            <span>계정 설정</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="/AdmMaster/logout.php">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>로그아웃</span>
                        </a>
                    </li>

                </ul>
            </li>

        </ul>
    </nav>

</header><!-- End Header -->

<?php
$code = $_GET['code'];
$scategory = $_GET['scategory'];

if (strpos($_SERVER['PHP_SELF'], "/AdmMaster/_bbs/") !== false && $code == 'event') {

}
?>
<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">
    <div class="d-flex justify-content-center align-items-center mb-3 mt-3">
        <a href="/AdmMaster/_inquiry/list_join.php">
            <img class="img-fluid rounded-3" style="width: max-content;height: 3rem;" src="/data/home/<?= $logos ?>"
                 alt="Logo" loading="lazy">
        </a>
        <div class="sidebar-toggler x">
            <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
        </div>
    </div>
    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link <?= strpos($_SERVER['PHP_SELF'], "/AdmMaster/_adminrator/") !== false ? '' : 'collapsed' ?>"
               data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-gear"></i><span>기본설정</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="charts-nav"
                class="nav-content collapse <?= strpos($_SERVER['PHP_SELF'], "/AdmMaster/_adminrator/") !== false ? 'show' : '' ?>"
                data-bs-parent="#sidebar-nav">
                <li>
                    <a class="<?= strpos($_SERVER['PHP_SELF'], "/AdmMaster/_adminrator/setting.php") !== false ? 'active' : '' ?>"
                       href="/AdmMaster/_adminrator/setting.php">
                        <span>쇼핑몰 기본설정</span>
                    </a>
                </li>
            </ul>
        </li>

        
        
        <li class="nav-heading">Pages</li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="/AdmMaster/logout.php">
                <i class="bi bi-box-arrow-right"></i>
                <span>로그아웃</span>
            </a>
        </li><!-- End Blank Page Nav -->

    </ul>

</aside><!-- End Sidebar-->
<script>
    function updateClock() {
        var now = new Date();
        var hours = now.getHours();
        var minutes = now.getMinutes();
        var seconds = now.getSeconds();

        var year = now.getFullYear();
        var month = ('0' + (now.getMonth() + 1)).slice(-2);
        var day = ('0' + now.getDate()).slice(-2);

        hours = hours < 10 ? '0' + hours : hours;
        minutes = minutes < 10 ? '0' + minutes : minutes;
        seconds = seconds < 10 ? '0' + seconds : seconds;

        document.getElementById('clock').innerHTML = year + '-' + month + '-' + day + ' &nbsp;&nbsp ' + hours + ':' + minutes + ':' + seconds;
    }

    updateClock();
    setInterval(updateClock, 1000);


    const THEME_KEY = "theme"

    function toggleDarkTheme() {
        setTheme(
            document.documentElement.getAttribute("data-bs-theme") === 'dark'
                ? "light"
                : "dark"
        )
    }

    /**
     * Set theme for mazer
     * @param {"dark"|"light"} theme
     * @param {boolean} persist
     */
    function setTheme(theme, persist = false) {
        document.body.classList.add(theme)
        document.documentElement.setAttribute('data-bs-theme', theme)

        if (persist) {
            localStorage.setItem(THEME_KEY, theme)
        }
    }

    /**
     * Init theme from setTheme()
     */
    function initTheme() {
        //If the user manually set a theme, we'll load that
        const storedTheme = localStorage.getItem(THEME_KEY)
        if (storedTheme) {
            return setTheme(storedTheme)
        }
    }

    window.addEventListener('DOMContentLoaded', () => {
        const toggler = document.getElementById("toggle-dark")
        const theme = localStorage.getItem(THEME_KEY)

        if (toggler) {
            toggler.checked = theme === "dark"

            toggler.addEventListener("input", (e) => {
                setTheme(e.target.checked ? "dark" : "light", true)
            })
        }

    });

    initTheme()

</script>
<main id="main" class="main">
    <section class="section">

