<style>

</style>
<?php
$current = current_url(true);

$supportedLocales = config('App')->supportedLocales ?? [];
$seg1 = $current->getSegment(1);
if (in_array($seg1, $supportedLocales, true)) {
    $current->setSegment(1, '');
}

$segments = array_values(array_filter($current->getSegments()));

$inAdmMaster = ($segments[0] ?? '') === 'AdmMaster';
$seg2 = $segments[1] ?? '';
$seg3 = $segments[2] ?? '';

$activeSetting = $inAdmMaster && ($seg2 === '_adminrator') && ($seg3 === 'setting');

$activeCourse = $inAdmMaster && ($seg2 === '_courses');
$courseList = $inAdmMaster && ($seg2 === '_courses') && ($seg3 === 'list');
$courseParentActive = $activeCourse || $courseList;

$settingGeneral = $inAdmMaster && ($seg2 === '_adminrator') && ($seg3 === 'setting');
$settingPolicy = $inAdmMaster && ($seg2 === '_adminrator') && ($seg3 === 'policy');
$settingPopup = $inAdmMaster && ($seg2 === '_popup') && ($seg3 === 'list');

$settingParentActive = $activeSetting || $settingGeneral || $settingPolicy || $settingPopup;

$activeCode = $inAdmMaster && ($seg2 === '_code');
$codeManage = $inAdmMaster && ($seg2 === '_code');
$codeParentActive = $activeCode || $codeManage;

$activeReservation = $inAdmMaster && ($seg2 === '_reservation');
$reservationManage = $inAdmMaster && ($seg2 === '_reservation');
$reservationParentActive = $activeReservation || $reservationManage;

$activePass = $inAdmMaster && ($seg2 === '_pass');
$passManage = $inAdmMaster && ($seg2 === '_pass');
$passParentActive = $activePass || $passManage;

$activeVideo = $inAdmMaster && ($seg2 === '_video');
$videoManage = $inAdmMaster && ($seg2 === '_video');
$videoParentActive = $videoManage || $activeVideo;

$activeLearning = $inAdmMaster && ($seg2 === '_learning');
$learningManage = $inAdmMaster && ($seg2 === '_learning');
$learningParentActive = $learningManage || $activeLearning;

$activeBoard = $inAdmMaster && ($seg2 === '_bbs');

$memberList = $inAdmMaster && ($seg2 === '_members') && ($seg3 === 'list');
$activeMember = $inAdmMaster && ($seg2 === '_members');
$memberEmail = $inAdmMaster && ($seg2 === '_member') && ($seg3 === 'email');
$memberParentActive = $activeMember || $memberList || $memberEmail;

$request = service('request');
$type = $request->getGet('type');
$code = $request->getGet('code');

$uri = service('uri');
$currentPath = trim($uri->getPath(), '/');

?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<aside id="sidebar" class="sidebar">
    <div class="text-center my-3">
        <a href="<?= site_url('AdmMaster/_adminrator/setting') ?>">
            <img src="/uploads/home/<?= esc($site['logos'] ?? '') ?>" class="img-fluid">
        </a>
    </div>

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link <?= $activeBoard ? '' : 'collapsed' ?>"
               data-bs-toggle="collapse"
               data-bs-target="#board-nav"
               href="#"
               aria-expanded="<?= $activeBoard ? 'true' : 'false' ?>">
                <i class="bi bi-journal-text"></i>
                <span>알림마당</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>

            <ul id="board-nav"
                class="nav-content collapse <?= $activeBoard ? 'show' : '' ?>"
                data-bs-parent="#sidebar-nav">

                <li>
                    <a href="<?= site_url('AdmMaster/_bbs/list') ?>?code=notice"
                       class="<?= $activeBoard && $code === 'notice' ? 'active' : '' ?>">
                        <span>공지사항</span>
                    </a>
                </li>

                <li>
                    <a href="<?= site_url('AdmMaster/_bbs/list') ?>?code=recruitment"
                       class="<?= $activeBoard && $code === 'recruitment' ? 'active' : '' ?>">
                        <span>채용정보</span>
                    </a>
                </li>

                <li>
                    <a href="<?= site_url('AdmMaster/_bbs/list') ?>?code=promotion"
                       class="<?= $activeBoard && $code === 'promotion' ? 'active' : '' ?>">
                        <span>홍보자료</span>
                    </a>
                </li>

                <li>
                    <a href="<?= site_url('AdmMaster/_bbs/list') ?>?code=competition"
                       class="<?= $activeBoard && $code === 'competition' ? 'active' : '' ?>">
                        <span>입찰/공모</span>
                    </a>
                </li>

                <li>
                    <a href="<?= site_url('AdmMaster/_bbs/list') ?>?code=association"
                       class="<?= $activeBoard && $code === 'association' ? 'active' : '' ?>">
                        <span>협회지</span>
                    </a>
                </li>
                <li>
                    <a href="<?= site_url('AdmMaster/_bbs/list') ?>?code=member_resource"
                       class="<?= $activeBoard && $code === 'member_resource' ? 'active' : '' ?>">
                        <span>회원 자료실</span>
                    </a>
                </li>
            </ul>
        </li>


        <li class="nav-item">
            <a class="nav-link <?= $codeParentActive ? '' : 'collapsed' ?>"
               data-bs-toggle="collapse"
               data-bs-target="#code-nav"
               href="#"
               aria-expanded="<?= $codeParentActive ? 'true' : 'false' ?>">
                <i class="bi bi-menu-button-wide"></i>
                <span>공통코드</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="code-nav"
                class="nav-content collapse <?= $codeParentActive ? 'show' : '' ?>"
                data-bs-parent="#sidebar-nav">
                <li>
                    <a href="<?= site_url('AdmMaster/_code/list') ?>"
                       class="<?= $codeManage ? 'active' : '' ?>">
                        <span>코드 리스트</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link <?= $courseParentActive || $reservationParentActive || $passManage || $videoManage || $learningManage ? '' : 'collapsed' ?>"
               data-bs-toggle="collapse"
               data-bs-target="#course-nav"
               href="#"
               aria-expanded="<?= $courseParentActive || $reservationParentActive || $passManage || $videoManage || $learningManage ? 'true' : 'false' ?>">
                <i class="bi bi-card-checklist"></i>
                <span>교육 관리</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="course-nav"
                class="nav-content collapse <?= $courseParentActive || $reservationParentActive || $passManage || $videoManage || $learningManage ? 'show' : '' ?>"
                data-bs-parent="#sidebar-nav">
                <li>
                    <a href="<?= site_url('AdmMaster/_courses/list') ?>"
                       class="<?= $activeCourse ? 'active' : '' ?>">
                        <span>교육 수강</span>
                    </a>
                </li>
                <!-- <li>
                    <a href="<?= site_url('AdmMaster/_reservation/list') ?>"
                       class="<?= $reservationManage ? 'active' : '' ?>">
                        <span>교육예약</span>
                    </a>
                </li> -->
                <li>
                    <a href="<?= site_url('AdmMaster/_pass/list') ?>"
                       class="<?= $passManage ? 'active' : '' ?>">
                        <span>수료증 발급</span>
                    </a>
                </li>
                <li>
                    <a href="<?= site_url('AdmMaster/_video/list') ?>"
                       class="<?= $videoManage ? 'active' : '' ?>">
                        <span>동영상관리</span>
                    </a>
                </li>
                <li>
                    <a href="<?= site_url('AdmMaster/_learning/list') ?>"
                       class="<?= $learningManage ? 'active' : '' ?>">
                        <span>수강진행 관리</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link <?= $memberParentActive ? '' : 'collapsed' ?>"
               data-bs-toggle="collapse"
               data-bs-target="#members-nav"
               href="#"
               aria-expanded="<?= $memberParentActive ? 'true' : 'false' ?>">
                <i class="bi bi-people-fill"></i>
                <span>회원관리</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="members-nav"
                class="nav-content collapse <?= $memberParentActive ? 'show' : '' ?>"
                data-bs-parent="#sidebar-nav">
                <li>
                    <a href="<?= site_url('AdmMaster/_members/list?type=N') ?>"
                       class="<?= $activeMember && $type == 'N' ? 'active' : '' ?>">
                        <span>일반회원관리</span>
                    </a>
                </li>
                <li>
                    <a href="<?= site_url('AdmMaster/_members/list?type=G') ?>"
                       class="<?= $activeMember && $type == 'G' ? 'active' : '' ?>">
                        <span>기업회원관리</span>
                    </a>
                </li>

                <li>
                    <a href="<?= site_url('AdmMaster/_members/email') ?>"
                       class="<?= $memberEmail ? 'active' : '' ?>">
                        <span>이메일 관리</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link <?= $settingParentActive ? '' : 'collapsed' ?>"
               data-bs-toggle="collapse"
               data-bs-target="#setting-nav"
               href="#"
               aria-expanded="<?= $settingParentActive ? 'true' : 'false' ?>">
                <i class="bi bi-gear"></i>
                <span>일반 설정</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="setting-nav"
                class="nav-content collapse <?= $settingParentActive ? 'show' : '' ?>"
                data-bs-parent="#sidebar-nav">
                <li>
                    <a href="<?= site_url('AdmMaster/_adminrator/setting') ?>"
                       class="<?= $settingGeneral ? 'active' : '' ?>">
                        <span>일반 설정</span>
                    </a>
                </li>

                <li>
                    <a href="<?= site_url('AdmMaster/_adminrator/policy') ?>"
                       class="<?= $settingPolicy ? 'active' : '' ?>">
                        <span>약관정보 관리</span>
                    </a>
                </li>

                <li>
                    <a href="<?= site_url('AdmMaster/_popup/list') ?>"
                       class="<?= $settingPopup ? 'active' : '' ?>">
                        <span>팝업관리</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-heading">Pages</li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="<?= site_url('AdmMaster/logout') ?>">
                <i class="bi bi-box-arrow-right"></i>
                <span>로그아웃</span>
            </a>
        </li>

    </ul>
</aside>