<?php
/** @var CodeIgniter\Pager\PagerRenderer $pager */
$pager->setSurroundCount(2);
?>

<?php if ($pager->getPageCount('order') >= 1) : ?>

    <div class="pagination">

        <!-- first -->
        <button class="pg-btn <?= $pager->hasPrevious() ? '' : 'disabled' ?>"
                onclick="location.href='<?= $pager->getFirst() ?>'"
                aria-label="first">
            <img src="/assets/img/sub/ico_pg_first.png" alt="">
        </button>

        <!-- prev -->
        <button class="pg-btn <?= $pager->hasPrevious() ? '' : 'disabled' ?>"
                onclick="location.href='<?= $pager->getPrevious() ?>'"
                aria-label="prev">
            <img src="/assets/img/sub/ico_pg_prev.png" alt="">
        </button>

        <!-- pages -->
        <ul class="pg-list">
            <?php foreach ($pager->links() as $link): ?>
                <li class="pg-item <?= $link['active'] ? 'active' : '' ?>">
                    <a href="<?= $link['uri'] ?>"><?= $link['title'] ?></a>
                </li>
            <?php endforeach ?>
        </ul>

        <!-- next -->
        <button class="pg-btn <?= $pager->hasNext() ? 'primary' : 'disabled' ?>"
                onclick="location.href='<?= $pager->getNext() ?>'"
                aria-label="next">
            <img src="/assets/img/sub/ico_pg_next.png" alt="">
        </button>

        <!-- last -->
        <button class="pg-btn <?= $pager->hasNext() ? 'primary' : 'disabled' ?>"
                onclick="location.href='<?= $pager->getLast() ?>'"
                aria-label="last">
            <img src="/assets/img/sub/ico_pg_last.png" alt="">
        </button>

    </div>
<?php endif ?>
