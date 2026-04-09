<?php
$pager->setSurroundCount(4);
?>

<nav>
    <ul class="pagination justify-content-center">

        <!-- FIRST -->
        <?php if ($pager->hasPreviousPage()): ?>
            <li class="page-item">
                <a class="page-link" href="<?= $pager->getFirst() ?>">« 처음</a>
            </li>
        <?php else: ?>
            <li class="page-item disabled"><span class="page-link">« 처음</span></li>
        <?php endif ?>

        <!-- PREV -->
        <?php if ($pager->hasPreviousPage()): ?>
            <li class="page-item">
                <a class="page-link" href="<?= $pager->getPreviousPage() ?>">‹ 이전</a>
            </li>
        <?php else: ?>
            <li class="page-item disabled"><span class="page-link">‹ 이전</span></li>
        <?php endif ?>

        <!-- PAGE NUMBERS -->
        <?php foreach ($pager->links() as $link): ?>
            <li class="page-item <?= $link['active'] ? 'active' : '' ?>">
                <a class="page-link" href="<?= $link['uri'] ?>">
                    <?= $link['title'] ?>
                </a>
            </li>
        <?php endforeach ?>

        <!-- NEXT -->
        <?php if ($pager->hasNextPage()): ?>
            <li class="page-item">
                <a class="page-link" href="<?= $pager->getNextPage() ?>">다음 ›</a>
            </li>
        <?php else: ?>
            <li class="page-item disabled"><span class="page-link">다음 ›</span></li>
        <?php endif ?>

        <!-- LAST -->
        <?php if ($pager->hasNextPage()): ?>
            <li class="page-item">
                <a class="page-link" href="<?= $pager->getLast() ?>">맨끝 »</a>
            </li>
        <?php else: ?>
            <li class="page-item disabled"><span class="page-link">맨끝 »</span></li>
        <?php endif ?>

    </ul>
</nav>
<style>
    .pagination .page-link {
        min-width: 38px;
        text-align: center;
        font-size: 14px;
    }

    .pagination .active .page-link {
        background-color: #1e40af;
        border-color: #1e40af;
    }
</style>