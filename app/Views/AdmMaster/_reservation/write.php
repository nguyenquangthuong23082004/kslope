<?= $this->extend('AdmMaster/inc/layout') ?>
<?= $this->section('content') ?>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/lang/summernote-ko-KR.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <div class="page-heading mb-4 d-flex justify-content-between align-items-center">
        <h4 class="mb-0">교육예약</h4>

        <div class="d-flex gap-2">
            <a href="<?= site_url('AdmMaster/_reservation/list') ?>"
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
            <form id="reservationForm" name="reservationForm" method="post" action="#!" enctype="multipart/form-data"
                  class="card">
                <input type="hidden" name="idx" id="idx" value="<?= isset($row) ? $row['idx'] : '' ?>">
                <input type="hidden" name="order_code" id="order_code"
                       value="<?= isset($row) ? $row['order_code'] : '' ?>">

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
                            <td colspan="4" class="text-secondary">
                                예약정보
                            </td>
                        </tr>
                        <tr>
                            <th style="background-color: #d0ebff;">예약번호</th>
                            <td colspan="">
                                <input type="text" readonly class="form-control bg-secondary bg-opacity-25"
                                       value="<?= esc(isset($row) ? $row['order_code'] : '') ?>">
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
                            <th style="background-color: #d0ebff;">신청담당자</th>
                            <td colspan="">
                                <input type="text" readonly class="form-control bg-secondary bg-opacity-25"
                                       value="<?= esc(isset($member) ? $member['user_name'] : '') ?>">
                            </td>
                            <th style="background-color: #d0ebff;">이메일</th>
                            <td colspan="">
                                <input type="text" readonly class="form-control bg-secondary bg-opacity-25"
                                       value="<?= esc(isset($member) ? $member['user_email'] : '') ?>">
                            </td>
                        </tr>
                        <tr>
                            <th style="background-color: #d0ebff;">사무실 전화번호</th>
                            <td colspan="">
                                <input type="text" readonly class="form-control bg-secondary bg-opacity-25"
                                       value="<?= esc(isset($member) ? $member['user_phone'] : '') ?>">
                            </td>
                            <th style="background-color: #d0ebff;">휴대번호</th>
                            <td colspan="">
                                <input type="text" readonly class="form-control bg-secondary bg-opacity-25"
                                       value="<?= esc(isset($member) ? $member['user_mobile'] : '') ?>">
                            </td>
                        </tr>

                        <?php if ($member['member_type'] == 'G'): ?>
                            <tr>
                                <th style="background-color: #d0ebff;">법인명</th>
                                <td colspan="">
                                    <input type="text" readonly class="form-control bg-secondary bg-opacity-25"
                                           value="<?= esc(isset($member) ? $member['company_name'] : '') ?>">
                                </td>
                                <th style="background-color: #d0ebff;">대표자명</th>
                                <td colspan="">
                                    <input type="text" readonly class="form-control bg-secondary bg-opacity-25"
                                           value="<?= esc(isset($member) ? $member['company_representative'] : '') ?>">
                                </td>
                            </tr>
                        <?php endif; ?>

                        <tr>
                            <th style="background-color: #d0ebff;">카테고리</th>
                            <td colspan="">
                                <input type="text" readonly class="form-control bg-secondary bg-opacity-25"
                                       value="<?= esc(isset($course) ? getCodeCourse($course['idx']) : '') ?>">
                            </td>
                            <th style="background-color: #d0ebff;">교육차수</th>
                            <td colspan="">
                                <input type="text" readonly class="form-control bg-secondary bg-opacity-25"
                                       value="<?= esc(isset($course) ? daysBetween($course['start_date'], $course['end_date']) . '낮' : '') ?>">
                            </td>
                        </tr>

                        <tr>
                            <th style="background-color: #d0ebff;">교육명</th>
                            <td colspan="">
                                <input type="text" readonly class="form-control bg-secondary bg-opacity-25"
                                       value="<?= esc(isset($course) ? $course['course_name'] : '') ?>">
                            </td>
                            <th style="background-color: #d0ebff;">교육기간</th>
                            <td colspan="">
                                <input type="text" readonly class="form-control bg-secondary bg-opacity-25"
                                       value="<?= esc(isset($course) ? (date('Y-m-d', strtotime($course['start_date'])) . '~' . date('Y-m-d', strtotime($course['end_date']))) : '') ?>">
                            </td>
                        </tr>

                        <tr>
                            <th style="background-color: #d0ebff;">강사</th>
                            <td colspan="">
                                <input type="text" readonly class="form-control bg-secondary bg-opacity-25"
                                       value="<?= esc(isset($course) ? $course['mentor'] : '') ?>">
                            </td>
                            <th style="background-color: #d0ebff;">수강료</th>
                            <td colspan="">
                                <input type="text" readonly class="form-control bg-secondary bg-opacity-25"
                                       value="<?= esc(isset($course) ? number_format($course['price']) . '원' : '무료') ?>">
                            </td>
                        </tr>

                        <tr>
                            <td colspan="4" class="text-secondary">
                                추가정보입력
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <table class="res_table table table-bordered">
                                    <colgroup>
                                        <col style="width: 70px">
                                        <col style="width: auto">
                                        <col style="width: 10.83%">
                                        <col style="width: 12.5%">
                                        <col style="width: 10.83%">
                                        <col style="width: 10.83%">
                                        <col style="width: 14.17%">
                                        <col style="width: 10.83%">
                                    </colgroup>
                                    <thead>
                                    <tr>
                                        <th>번호</th>
                                        <th>소속</th>
                                        <th>직급</th>
                                        <th>성명</th>
                                        <th>성별</th>
                                        <th>생년월일</th>
                                        <th>휴대폰번호</th>
                                        <th>거주지</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (count($orderItems) == 0): ?>
                                        <tr>
                                            <td class="num">1</td>
                                            <td>
                                                <p class="only_mo">소속 담당자</p>
                                                <input type="text" name="sub_company_name[]" value="">
                                            </td>
                                            <td>
                                                <p class="only_mo">직급</p>
                                                <select name="position[]">
                                                    <option value="사장">사장</option>
                                                    <option value="원장">원장</option>
                                                    <option value="팀장">팀장</option>
                                                </select>
                                            </td>
                                            <td>
                                                <p class="only_mo">성명</p>
                                                <input type="text" name="name[]" value="">
                                            </td>
                                            <td>
                                                <p class="only_mo">성별</p>
                                                <select name="gender[]">
                                                    <option value="M">남</option>
                                                    <option value="W">여</option>
                                                </select>
                                            </td>
                                            <td>
                                                <p class="only_mo">생년월일</p>
                                                <input type="text" name="birthday[]" class="datepicker" id="birthday"
                                                       value="" autocomplete="off" readonly="">
                                            </td>
                                            <td>
                                                <p class="only_mo">휴대폰번호</p>
                                                <input type="text" name="phone[]" value="" maxlength="13">
                                            </td>
                                            <td>
                                                <p class="only_mo">거주지</p>
                                                <select name="residence[]">
                                                    <option value="서울경기">서울경기</option>
                                                    <option value="대전시">대전시</option>
                                                    <option value="대구시">대구시</option>
                                                    <option value="부산시">부산시</option>
                                                    <option value="광주시">광주시</option>
                                                    <option value="울산시">울산시</option>
                                                    <option value="세종시">세종시</option>
                                                    <option value="강원도">강원도</option>
                                                    <option value="충청도">충청도</option>
                                                    <option value="전라도">전라도</option>
                                                    <option value="경상도">경상도</option>
                                                    <option value="제주도">제주도</option>
                                                    <option value="국외">국외</option>
                                                </select>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                    <?php foreach ($orderItems as $key => $orderItem): ?>
                                        <tr>
                                            <td class="num"><?= $key + 1 ?></td>
                                            <td>
                                                <input type="hidden" name="order_item[]"
                                                       value="<?= $orderItem['id'] ?>">
                                                <input class="form-control" type="text" name="sub_company_name[]"
                                                       value="<?= $orderItem['sub_company_name'] ?>">
                                            </td>
                                            <td>
                                                <select class="form-select" name="position[]">
                                                    <option <?= $orderItem['position'] == '사장' ? 'selected' : '' ?>
                                                            value="사장">사장
                                                    </option>
                                                    <option <?= $orderItem['position'] == '원장' ? 'selected' : '' ?>
                                                            value="원장">원장
                                                    </option>
                                                    <option <?= $orderItem['position'] == '팀장' ? 'selected' : '' ?>
                                                            value="팀장">팀장
                                                    </option>
                                                </select>
                                            </td>
                                            <td>
                                                <input class="form-control" type="text" name="name[]"
                                                       value="<?= $orderItem['name'] ?>">
                                            </td>
                                            <td>
                                                <select class="form-select" name="gender[]">
                                                    <option <?= $orderItem['gender'] == 'M' ? 'selected' : '' ?>
                                                            value="M">남
                                                    </option>
                                                    <option <?= $orderItem['gender'] == 'W' ? 'selected' : '' ?>
                                                            value="W">여
                                                    </option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" name="birthday[]" class="datepicker form-control"
                                                       id="birthday" value="<?= $orderItem['birthday'] ?>"
                                                       autocomplete="off" readonly="">
                                            </td>
                                            <td>
                                                <input class="form-control" type="text" name="phone[]"
                                                       value="<?= $orderItem['phone'] ?>" maxlength="13">
                                            </td>
                                            <td>
                                                <select class="form-select" name="residence[]">
                                                    <option <?= $orderItem['residence'] == '서울경기' ? 'selected' : '' ?>
                                                            value="서울경기">서울경기
                                                    </option>
                                                    <option <?= $orderItem['residence'] == '대전시' ? 'selected' : '' ?>
                                                            value="대전시">대전시
                                                    </option>
                                                    <option <?= $orderItem['residence'] == '대구시' ? 'selected' : '' ?>
                                                            value="대구시">대구시
                                                    </option>
                                                    <option <?= $orderItem['residence'] == '부산시' ? 'selected' : '' ?>
                                                            value="부산시">부산시
                                                    </option>
                                                    <option <?= $orderItem['residence'] == '광주시' ? 'selected' : '' ?>
                                                            value="광주시">광주시
                                                    </option>
                                                    <option <?= $orderItem['residence'] == '울산시' ? 'selected' : '' ?>
                                                            value="울산시">울산시
                                                    </option>
                                                    <option <?= $orderItem['residence'] == '세종시' ? 'selected' : '' ?>
                                                            value="세종시">세종시
                                                    </option>
                                                    <option <?= $orderItem['residence'] == '강원도' ? 'selected' : '' ?>
                                                            value="강원도">강원도
                                                    </option>
                                                    <option <?= $orderItem['residence'] == '충청도' ? 'selected' : '' ?>
                                                            value="충청도">충청도
                                                    </option>
                                                    <option <?= $orderItem['residence'] == '전라도' ? 'selected' : '' ?>
                                                            value="전라도">전라도
                                                    </option>
                                                    <option <?= $orderItem['residence'] == '경상도' ? 'selected' : '' ?>
                                                            value="경상도">경상도
                                                    </option>
                                                    <option <?= $orderItem['residence'] == '제주도' ? 'selected' : '' ?>
                                                            value="제주도">제주도
                                                    </option>
                                                    <option <?= $orderItem['residence'] == '국외' ? 'selected' : '' ?>
                                                            value="국외">국외
                                                    </option>
                                                </select>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-end gap-2 mt-3 w-100">
                        <button type="button" class="delete_tab btn btn-outline-danger">삭제</button>
                        <button type="button" class="plus_tab btn btn-outline-primary">추가</button>
                    </div>
                </div>

            </form>
        </div>
    </section>

    <div class="d-flex w-100 justify-content-end mb-2 gap-2">
        <a href="<?= site_url('AdmMaster/_reservation/list') ?>"
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
        $(function () {
            $(".datepicker").datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                showButtonPanel: true,
                yearRange: "1970:2020"
            });

            $(document).on('click', '.plus_tab', function () {
                const $tbody = $('.res_table tbody');
                const $lastRow = $tbody.find('tr:last');
                const $newRow = $lastRow.clone(true);

                $newRow.find('input').val('');
                $newRow.find('select').prop('selectedIndex', 0);

                $newRow.find('.hasDatepicker')
                    .removeClass('hasDatepicker')
                    .removeAttr('id');

                $newRow.find('input[name="birthday[]"]').datepicker({
                    dateFormat: 'yy-mm-dd',
                    changeMonth: true,
                    changeYear: true,
                    showButtonPanel: true,
                    yearRange: "1970:2020"
                });

                $tbody.append($newRow);
                reIndex();
            });

            $(document).on('click', '.delete_tab', function () {
                const $tbody = $('.res_table tbody');
                const rowCount = $tbody.find('tr').length;

                if (rowCount > 1) {
                    $tbody.find('tr:last').remove();
                    reIndex();
                } else {
                    alert('최소 1명은 입력해야 합니다.');
                }
            });

            function reIndex() {
                $('.res_table tbody tr').each(function (i) {
                    $(this).find('.num').text(i + 1);
                });
            }

        });
    </script>
    <script>
        async function submitForm() {
            let url = '<?= site_url('AdmMaster/_reservation/update') ?>';

            let frm = document.reservationForm;
            let formData = new FormData(frm);

            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    console.log(response);
                    alert(response.message);
                    location.reload();
                },
                error: function (exception) {
                    alert(exception.responseJSON.message ?? '오류가 발생했습니다!')
                    console.log(exception)
                }
            });
        }
    </script>
<?= $this->endSection() ?>