<div class="job-top">
    <div class="job-total">Total: <strong><?= number_format($total) ?></strong></div>

    <form id="frmSearch" name="frmSearch" action="" method="get">
        <input type="hidden" name="category_no" value="<?= $category_no ?>">
        <div class="job-filter">

            <div class="job-select">
                <select name="search_name" id="search_name">
                    <option <?= !empty($search_name) && $search_name == '' ? 'selected' : '' ?>
                            value="">전체
                    </option>
                    <option <?= !empty($search_name) && $search_name == 'subject' ? 'selected' : '' ?>
                            value="subject">제목
                    </option>
                    <option <?= !empty($search_name) && $search_name == 'writer' ? 'selected' : '' ?>
                            value="writer">작성자
                    </option>
                </select>
            </div>

            <div class="job-search">
                <input id="search_word" name="search_word" value="<?= $search_word ?? '' ?>"
                       type="text" placeholder="">
                <button type="button" aria-label="search" onclick="processSearch();">
                    <img src="/assets/img/sub/ico_search.png" alt="">
                </button>
            </div>

        </div>
    </form>

    <script>
        function processSearch() {
            document.getElementById('frmSearch').submit();
        }
    </script>
</div>