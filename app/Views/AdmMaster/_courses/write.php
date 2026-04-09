<?= $this->extend('AdmMaster/inc/layout') ?>
<?= $this->section('content') ?>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/lang/summernote-ko-KR.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

    <div class="page-heading mb-4 d-flex justify-content-between align-items-center">
        <h4 class="mb-0 fw-semibold">교육 수강 상세</h4>

        <div class="d-flex gap-2">
            <a href="<?= site_url('AdmMaster/_courses/list') ?>"
               class="btn btn-outline-secondary">
                <i class="bi bi-list-task"></i> 목록
            </a>

            <button type="button"
                    onclick="submitForm();"
                    class="btn btn-primary">
                <i class="bi bi-gear-fill me-1"></i> 저장
            </button>
        </div>
    </div>

    <section class="section">
        <div class="col-lg-12">
            <form id="courseForm" name="courseForm" method="post" action="#!" enctype="multipart/form-data"
                  class="card">
                <input type="hidden" name="idx" id="idx" value="<?= isset($row) ? $row['idx'] : '' ?>">
                <div class="card-body">
                    <table class="table table-bordered align-middle">
                        <colgroup>
                            <col width="10%">
                            <col width="40%">
                            <col width="10%">
                            <col width="40%">
                        </colgroup>
                        <tbody>
                        <tr>
                            <th style="background-color: #d0ebff;">카테고리</th>
                            <td colspan="3">
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <select id="course_code_1" name="course_code_1" class="form-select"
                                                onchange="getCode(this.value, 2)">
                                            <option <?= $category1['code_no'] == (isset($row) ? $row['course_code_1'] : '') ? 'selected' : '' ?>
                                                    value="<?= $category1['code_no'] ?>"><?= $category1['code_name'] ?></option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <select id="course_code_2" name="course_code_2" class="form-select"
                                                onchange="getCode(this.value, 3)">
                                            <option value="">...</option>
                                            <?php foreach ($categories2 as $category): ?>
                                                <option <?= $category['code_no'] == (isset($row) ? $row['course_code_2'] : '') ? 'selected' : '' ?>
                                                        value="<?= $category['code_no'] ?>"><?= $category['code_name'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <select id="course_code_3" name="course_code_3" class="form-select">
                                            <option value="">...</option>
                                            <?php if (isset($row)): ?>
                                                <?php foreach ($categories3 as $category): ?>
                                                    <option <?= $category['code_no'] == $row['course_code_3'] ? 'selected' : '' ?>
                                                            value="<?= $category['code_no'] ?>"><?= $category['code_name'] ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th style="background-color: #d0ebff;">교육명</th>
                            <td colspan="3">
                                <input type="text" name="course_name" id="course_name" class="form-control"
                                       value="<?= esc(isset($row) ? $row['course_name'] : '') ?>">
                            </td>
                        </tr>

                        <tr>
                            <th style="background-color: #d0ebff;">강사</th>
                            <td colspan="3">
                                <input type="text" name="mentor" id="mentor" class="form-control"
                                       value="<?= esc(isset($row) ? $row['mentor'] : '') ?>">
                            </td>
                        </tr>

                        <tr>
                            <th style="background-color: #d0ebff;">시작일</th>
                            <td colspan="">
                                <input type="text" name="start_date" id="start_date" class="form-control datepicker"
                                       readonly value="<?= esc(isset($row) ? $row['start_date'] : '') ?>">
                            </td>
                            <th style="background-color: #d0ebff;">종료일</th>
                            <td colspan="">
                                <input type="text" name="end_date" id="end_date" class="form-control datepicker"
                                       readonly value="<?= esc(isset($row) ? $row['end_date'] : '') ?>">
                            </td>
                        </tr>

                        <tr>
                            <th style="background-color: #d0ebff;">강의수</th>
                            <td colspan="">
                                <input type="number" name="number_lecture" id="number_lecture" class="form-control"
                                       value="<?= esc(isset($row) ? $row['number_lecture'] : '') ?>">
                            </td>
                            <th style="background-color: #d0ebff;">기간</th>
                            <td colspan="">
                                <input type="number" name="duration" id="duration" class="form-control"
                                       value="<?= esc(isset($row) ? $row['duration'] : '') ?>">
                            </td>
                        </tr>
                        <tr>
                            <th style="background-color: #d0ebff;">교재명</th>
                            <td colspan="">
                                <input type="text" name="textbook" id="textbook" class="form-control"
                                       value="<?= esc(isset($row) ? $row['textbook'] : '') ?>">
                            </td>
                            <th style="background-color: #d0ebff;">쎔네일</th>
                            <td colspan="">
                                <input type="file" name="file_upload" id="file_upload" class="form-control"
                                       accept="image/*">
                                <?php if (isset($row)): ?>
                                    <img class="mt-2" src="/uploads/course/<?= $row['u_file'] ?>"
                                         alt="<?= $row['r_file'] ?>" width="100">
                                    <br>
                                    <a href="/uploads/course/<?= $row['u_file'] ?>"
                                       download="<?= $row['r_file'] ?>">
                                        <?= $row['r_file'] ?>
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>

                        <tr>
                            <th style="background-color: #d0ebff;">동영상</th>
                            <td colspan="3">
                                <div class="w-100 p-3">
                                    <table class="table table-bordered">
                                        <colgroup>
                                            <col width="90%">
                                            <col width="10%">
                                        </colgroup>
                                        <thead>
                                        <tr class="text-center">
                                            <th scope="col">비디오의 URL</th>
                                            <th scope="col">
                                                <button type="button" class="btn btn-outline-primary" id="btnPlusVideo">
                                                    <i class="bi bi-plus-lg"></i>
                                                </button>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody id="tbodyVideoUrl">
                                        <?php $course_url = isset($row) ? explode(',', $row['course_url']) : []; ?>
                                        <?php foreach ($course_url as $url): ?>
                                            <tr class="text-center">
                                                <th scope="row">
                                                    <select class="form-control" name="course_url[]" id="course_url[]">
                                                        <option value="">옵션 선택</option>
                                                        <?php foreach ($videos as $video): ?>
                                                            <option <?= $url == $video['video_idx'] ? 'selected' : '' ?>
                                                                    value="<?= $video['video_idx'] ?>"><?= $video['title'] ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </th>
                                                <td>
                                                    <button type="button" class="btn btn-outline-danger removeVideUrl">
                                                        <i class="bi bi-trash3"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <tr class="text-center">
                                            <th scope="row">
                                                <select class="form-control" name="course_url[]" id="course_url[]">
                                                    <option value="">옵션 선택</option>
                                                    <?php foreach ($videos as $video): ?>
                                                        <option value="<?= $video['video_idx'] ?>"><?= $video['title'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </th>
                                            <td>
                                                <button type="button" class="btn btn-outline-danger removeVideUrl">
                                                    <i class="bi bi-trash3"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <th style="background-color: #d0ebff;">수강료</th>
                            <td colspan="">
                                <input type="text" name="price" class="form-control"
                                       value="<?= esc(isset($row) ? $row['price'] : '0') ?>">
                            </td>
                            <th style="background-color: #d0ebff;">상태</th>
                            <td colspan="">
                                <select name="status" id="status" class="form-select">
                                    <option value="1" <?= isset($row) && $row['status'] == '1' ? 'selected' : '' ?>>
                                        정상
                                    </option>
                                    <option value="0" <?= isset($row) && $row['status'] == '0' ? 'selected' : '' ?>>
                                        잠김
                                    </option>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <th style="background-color: #d0ebff;">우선순위</th>
                            <td colspan="">
                                <input type="text" name="onum" id="onum" class="form-control"
                                       value="<?= esc(isset($row) ? $row['onum'] : '') ?>">
                            </td>
                            <?php if (isset($row)): ?>
                                <th style="background-color: #d0ebff;">수정된 날짜</th>
                                <td colspan="">
                                    <?= $row['updated_at'] ?>
                                </td>
                            <?php else: ?>
                                <th style="background-color: #d0ebff;">생성일</th>
                                <td colspan="">
                                    <?= date('Y-m-d H:i:s') ?>
                                </td>
                            <?php endif; ?>
                        </tr>

                        <tr>
                            <th style="background-color: #d0ebff;">프로그램소개</th>
                            <td colspan="3">
                                <textarea class="form-control summernote" id="course_introduction"
                                          name="course_introduction"><?= esc($row['course_introduction'] ?? '') ?></textarea>
                            </td>
                        </tr>

                        <tr>
                            <th style="background-color: #d0ebff;">교재 소개</th>
                            <td colspan="3">
                                <textarea class="form-control summernote" id="course_description"
                                          name="course_description"><?= esc($row['course_description'] ?? '') ?></textarea>
                            </td>
                        </tr>

                        <tr>
                            <th style="background-color: #d0ebff;">목차</th>
                            <td colspan="3">
                                <textarea class="form-control summernote" id="table_contents"
                                          name="table_contents"><?= esc($row['table_contents'] ?? '') ?></textarea>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>

            </form>
        </div>
    </section>

    <div class="d-flex w-100 justify-content-end mb-2 gap-2">
        <a href="<?= site_url('AdmMaster/_courses/list') ?>"
           class="btn btn-outline-secondary">
            <i class="bi bi-list-task"></i> 목록
        </a>

        <button type="button"
                onclick="submitForm();"
                class="btn btn-primary">
            <i class="bi bi-gear-fill me-1"></i> 저장
        </button>
    </div>

    <script>
        $(document).ready(function () {
            $(".datepicker").datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                showButtonPanel: true
            });
            $('.summernote').summernote({
                height: 400,
                lang: 'ko-KR',
                toolbar: [
                    ['style', ['style', 'bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph', 'height']],
                    ['insert', ['link', 'picture', 'video', 'table', 'hr']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ],
                callbacks: {
                    onImageUpload: function (files) {
                        for (let i = 0; i < files.length; i++) {
                            uploadImage(files[i]);
                        }
                    }
                }
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $('#btnPlusVideo').on('click', function () {
                let $tbody = $('#tbodyVideoUrl');
                let $lastTr = $tbody.find('tr:last');
                let $newTr = $lastTr.clone();

                $newTr.find('select').val('');

                $tbody.append($newTr);
            });

            $(document).on('click', '.removeVideUrl', function () {
                let $tbody = $('#tbodyVideoUrl');

                if ($tbody.find('tr').length <= 1) {
                    alert('최소 한 개의 비디오 URL은 필요합니다.');
                    return;
                }

                $(this).closest('tr').remove();
            });

        });
    </script>
    <script>
        async function getCode(parent_code_no, depth) {
            let url = '/api/code/list?parent_code_no=' + parent_code_no + '&depth=' + depth;

            $.ajax({
                url: url,
                method: 'GET',
                success: function (response) {
                    console.log(response);
                    renderCode(response.data, depth);
                },
                error: function (exception) {
                    alert(exception.responseJSON.message ?? '오류가 발생했습니다!')
                    console.log(exception)
                }
            });
        }

        function renderCode(data, depth) {
            let num = data.length;
            let html = '<option value="">...</option>';

            for (let i = 0; i < num; i++) {
                let item = data[i];

                html += `<option value="${item.code_no}">${item.code_name}</option>`;
            }

            $('#course_code_' + depth).empty().append(html);

            let bigDepth = parseInt(depth) + 1;
            $('#course_code_' + bigDepth).empty();
        }

        async function submitForm() {
            let frm = document.courseForm;
            let formData = new FormData(frm);
            let url = '/AdmMaster/_courses/write_ok';

            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    console.log(response);
                    alert(response.message);
                    window.location.reload();
                },
                error: function (exception) {
                    alert(exception.responseJSON.message ?? '오류가 발생했습니다!')
                    console.log(exception)
                }
            });
        }
    </script>
<?= $this->endSection() ?>