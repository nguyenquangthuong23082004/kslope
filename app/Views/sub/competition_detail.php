<?php $this->extend('inc/layout_index'); ?>
<?php $this->section('content'); ?>
<?php
$listUrl = '/competition';
$detailUrl = '/competition_detail';

$cData = [
    'listUrl' => $listUrl,
    'detailUrl' => $detailUrl,
];
?>
    <main id="container" class="main main_new notice_detail view_main">
        <section class="board-view">
            <?php echo view("sub/inc/view-detail.php", $cData); ?>
        </section>
    </main>
    <script>
        document.querySelectorAll('.board-nav .nav-item').forEach(item => {
            const label = item.querySelector('.nav-label');

            label.addEventListener('click', () => {
                item.classList.toggle('is-open');
            });
        });
    </script>
<?php $this->endSection(); ?>