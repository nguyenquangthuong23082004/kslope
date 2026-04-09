<?php
$session = session();
$member  = $session->get('member');

if (!$member || ($member['level'] ?? 99) > 2) {
    header('Location: ' . site_url('AdmMaster/login'));
    exit;
}

$request = service('request');
?>

    <!-- ===== HEADER ===== -->
    <header id="header" class="header fixed-top d-flex align-items-center px-4">

        <a href="<?= base_url('/') ?>" target="_blank" class="btn btn-primary" style="margin-left: 13vw">
            홈페이지 바로가기
        </a>

        <div class="ms-auto d-flex align-items-center gap-3">
            <span class="text-muted d-none d-xl-inline">
                <?= esc($site['browser_title'] ?? '') ?>
                / IP : <?= $request->getIPAddress() ?>
                / <span id="clock"></span>
            </span>

            <div class="dropdown">
                <span class="me-2 d-none d-xl-inline">
                    <?= esc($member['name']) ?>님
                </span>

                <img src="https://picsum.photos/200"
                    class="rounded-circle dropdown-toggle"
                    data-bs-toggle="dropdown"
                    style="width:35px;height:35px;cursor:pointer">

                <ul class="dropdown-menu dropdown-menu-end">
                    <li class="dropdown-item text-center fw-bold">
                        <?= esc($member['name']) ?>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item" href="<?= site_url('AdmMaster/logout') ?>">
                            <i class="bi bi-box-arrow-right me-2"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    

    <script>
        function updateClock() {
            const d = new Date();
            document.getElementById('clock').innerText =
                d.getFullYear() + '-' +
                String(d.getMonth() + 1).padStart(2, '0') + '-' +
                String(d.getDate()).padStart(2, '0') + ' ' +
                String(d.getHours()).padStart(2, '0') + ':' +
                String(d.getMinutes()).padStart(2, '0') + ':' +
                String(d.getSeconds()).padStart(2, '0');
        }
        updateClock();
        setInterval(updateClock, 1000);
    </script>