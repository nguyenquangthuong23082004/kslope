<?php $this->extend('inc/layout_index'); ?>
<?php $this->section('content'); ?>
<main id="container" class="main main_new">

    <section class="mypage-wrap">
        <div class="mypage-inner">

            <?= view('mypage/mypage_sidebar', ['active' => 'edu']) ?>

            <div class="mypage-content">
                <h3 class="content-title">교육수료현황</h3>

                <div class="filter-box">

                    <!-- <div class="filter-row">
                        <div class="filter-item">
                            <label>카테고리</label>
                            <input type="text">
                        </div>
                        <div class="filter-item">
                            <label>교육차수</label>
                            <input type="text">
                        </div>
                    </div>

                    <div class="filter-row">
                        <div class="filter-item">
                            <label>교육명</label>
                            <input type="text">
                        </div>
                        <div class="filter-item">
                            <label>수강료</label>
                            <input type="text">
                        </div>
                    </div>

                    <div class="filter-row">
                        <div class="filter-item">
                            <label>강사</label>
                            <input type="text">
                        </div>
                        <div class="filter-item">
                            <label>신청담당자</label>
                            <input type="text">
                        </div>
                    </div>

                    <div class="filter-row">
                        <div class="filter-item is-date">
                            <label>교육기간</label>

                            <div class="date-wrap">
                                <div class="date-box">
                                    <input type="text" class="date-input">
                                    <span class="cal"></span>
                                </div>

                                <span class="dash">—</span>

                                <div class="date-box">
                                    <input type="text" class="date-input">
                                    <span class="cal"></span>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <form id="frm_search" name="frm_search" action="">
                        <div class="filter-box-new">
    
                            <div class="filter-grid">
                                <div class="staff-select">
                                    <select name="course_code_2" class="course_select">
                                        <option value="">카테고리</option>
                                        <?php foreach ($categories as $category): ?>
                                            <option <?= $category['code_no'] == $course_code_2 ? "selected" : "" ?>
                                                value="<?= $category['code_no'] ?>"><?= $category['code_name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="staff-select">
                                    <select name="course_idx" class="course_select">
                                        <option value="">교육명</option>
                                        <?php foreach ($list_courses as $course): ?>
                                            <option <?= $course['idx'] == $course_idx ? "selected" : "" ?>
                                                value="<?= $course['idx'] ?>"><?= $course['course_name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <input type="text" name="user_name" value="<?= $user_name ?>" placeholder="교육자 성명">
                                <div class="staff-select">
                                    <select name="status" class="course_select">
                                        <option value="">상태</option>
                                        <option value="in_progress" <?= $status == "in_progress" ? "selected" : "" ?>>미완료</option>
                                        <option value="completed" <?= $status == "completed" ? "selected" : "" ?>>완료</option>
                                    </select>
                                </div>
                                <!-- <input type="text" placeholder="강사">
                                <input type="text" placeholder="신청담당자">
    
                                <div class="filter-date">
                                    <input type="text" class="date-input" placeholder="2026-01-19">
                                    <span class="cal"></span>
                                </div>
    
                                <div class="filter-date">
                                    <input type="text" class="date-input" placeholder="2026-01-31">
                                    <span class="cal"></span>
                                </div> -->
    
                            </div>
                        </div>
    
                        <div class="filter-btns">
                            <button type="button" class="btn-reset" onclick="location.href='/mypage'">검색 초기화</button>
                            <button type="button" class="btn-submit" onclick="search_it()">확인</button>
                        </div>
                    </form>

                </div>

                <script>
                    function search_it() {
                        var frm = document.frm_search;
                        frm.submit();
                    }
                </script>

                <div class="table-wrap">
                    <table>
                        <colgroup>
                            <col width="10%">
                            <col width="25%">
                            <col width="*">
                            <col width="10%">
                            <col width="15%">
                            <col width="10%">
                        </colgroup>
                        <thead>
                            <tr>
                                <th>번호</th>
                                <th>카테고리</th>
                                <th>교육명</th>
                                <th>교육자</th>
                                <th>진도률</th>
                                <th>상태</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($courses as $key => $course) {
                            ?>
                                <tr>
                                    <td><?= $startNum - $key ?></td>
                                    <td><?= ($course["code_name_1"] ?? '') . " > " . ($course["code_name_2"] ?? '') ?></td>
                                    <td><?= $course["course_name"] ?? "" ?></td>
                                    <td><?= $course["user_name"] ?? "" ?></td>
                                    <?php
                                    $array_course = array_values(array_filter(explode(',', rtrim(($course["course_url"] ?? ""), ','))));
                                    $count_course = count($array_course);
                                    ?>
                                    <td>
                                        <?php
                                        if (!empty($course["course_progress_idx"])) {
                                            echo $course["progress_percent"] . "% " . "(" . $course["completed_videos"] . '/' . $course["total_videos"] . ")";
                                        } else {
                                            echo "0% " . "(" . "0/" . $count_course . ")";
                                        }
                                        ?>
                                    </td>
                                    <td><?= $course["status"] == "completed" ? "완료" : "미완료" ?></td>
                                </tr>
                            <?php
                            }
                            ?>

                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </section>

</main>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    flatpickr(".date-input", {
        dateFormat: "Y-m-d",
        allowInput: true
    });
</script>
<?php $this->endSection(); ?>