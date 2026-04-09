<?php $this->extend('inc/layout_index'); ?>
<?php $this->section('content'); ?>
    <main id="container" class="main main_new reservation_view">
        <section class="ci-intro dif">

            <div class="ci-bc">
                <a href="#" class="ci-bc__item">HOME</a>
                <a href="#" class="ci-bc__item">계측전문인력 교육</a>

                <a href="#" class="ci-bc__item ci-bc__item--select">
                    교육예약
                    <img class="ci-bc__ico" src="/assets/img/sub/ico_select_down.png" alt="">
                </a>
            </div>

            <h1 class="ci-title">교육예약</h1>

        </section>


        <section class="reservation_content">
            <div class="title_">
                추가정보입력
            </div>

            <div class="desc_">
                예약정보를 안내 받을 SMS 수신가능 연락처를 반드시 입력해 주십시오. 미입력 시 교육안내정보를 받을 수 없습니다.
                <br>
                신청자 정보를 정확하게 기입해주시기 바랍니다. 정보 오기재로 인한 수료증 수정 재발급이 불가합니다.
                <br>
                개인정보이용 미동의 시에도 예약접수 서비스를 이용하실 수 있습니다.
            </div>

            <div class="choice_">
                <table class="choice_table">
                    <colgroup>
                        <col style="width: 135px">
                        <col style="width: auto">
                        <col style="width: 135px">
                        <col style="width: auto">
                    </colgroup>
                    <tbody>
                    <tr>
                        <th>카테고리</th>
                        <td>
                            <input type="text" value="<?= getCodeCourse($course['idx']) ?>" disabled>
                        </td>
                        <th>교육차수</th>
                        <td>
                            <input type="text"
                                   value="<?= daysBetween($course['start_date'], $course['end_date']) ?>낮"
                                   disabled>
                        </td>
                    </tr>
                    <tr>
                        <th>교육명</th>
                        <td>
                            <input type="text" value="<?= $course['course_name'] ?>" disabled>
                        </td>
                        <th>교육기간</th>
                        <td>
                            <input type="text"
                                   value="<?= date('Y-m-d', strtotime($course['start_date'])) ?> ~ <?= date('Y-m-d', strtotime($course['end_date'])) ?>"
                                   disabled>
                        </td>
                    </tr>
                    <tr>
                        <th>강사</th>
                        <td>
                            <input type="text" value="<?= $course['mentor'] ?>" disabled>
                        </td>
                        <th>수강료</th>
                        <td>
                            <input type="text"
                                   value="<?= $course['price'] > 0 ? number_format($course['price']) . '원' : '무료' ?>"
                                   disabled>
                        </td>
                    </tr>
                    <tr>
                        <?php if ($member['member_type'] == 'G'): ?>
                            <th>신청법인</th>
                            <td>
                                <input type="text" value="<?= $member['company_name'] ?>" disabled>
                            </td>
                        <?php endif; ?>
                        <th>신청담당자</th>
                        <td colspan="<?= $member['member_type'] == 'G' ? '' : '3' ?>">
                            <input type="text" value="<?= $member['user_name'] ?>" disabled>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="board_table">
                <form action="#!" name="reservationForm" id="reservationForm" method="post">
                    <input type="hidden" name="user_id" value="<?= $member['user_id'] ?>">
                    <input type="hidden" name="course_idx" value="<?= $course['idx'] ?>">
                    <table class="res_table">
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
                        </tbody>
                    </table>

                    <div class="btn_wrap w_r">
                        <button type="button" class="delete_tab">삭제</button>
                        <button type="button" class="plus_tab full_bg">추가</button>
                    </div>
                </form>
            </div>

            <div class="reserv_guide">
                <p><strong>한국급경사지안전협회육연구센터</strong>는「개인정보보호법」을 준수하고, 모든 개인정보는 정보주체의 동의에 의해 적정하게 취급된 것이며<br>
                    상기 본인은 개인정보를 교육예약서비스의 적절한 수행을 위하여 활용함에 동의합니다.</p>

                <div class="radio_wrap">
                    <div class="radio_item">
                        <input type="radio" id="agree" name="agree" checked="">
                        <label for="agree">동의</label>
                    </div>
                    <div class="radio_item">
                        <input type="radio" id="agree_none" name="agree">
                        <label for="agree_none">미동의</label>
                    </div>
                </div>
            </div>

            <div class="btn_box">
                <a href="#!">이전으로</a>
                <button type="button" class="blue_bg" onclick="reservationSubmit();">교육예약</button>
            </div>
        </section>
    </main>
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
        async function reservationSubmit() {
            let frm = document.reservationForm;
            let formData = new FormData(frm);
            let url = '/reservation/store'

            await $.ajax({
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
<?php $this->endSection(); ?>