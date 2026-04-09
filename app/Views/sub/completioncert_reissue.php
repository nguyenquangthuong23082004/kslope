<?php $this->extend('inc/layout_index'); ?>
<?php $this->section('content'); ?>
    <link href="<?= base_url('admin/vendor/bootstrap-icons/bootstrap-icons.css') ?>" rel="stylesheet">

    <main id="container" class="main main_new">
        <section class="ci-intro dif">

            <div class="ci-bc">
                <a href="#" class="ci-bc__item">HOME</a>
                <a href="#" class="ci-bc__item">계측전문인력 교육</a>

                <a href="#" class="ci-bc__item ci-bc__item--select">
                    수료증 재발급 신청
                    <img class="ci-bc__ico" src="/assets/img/sub/ico_select_down.png" alt="">
                </a>
            </div>

            <h1 class="ci-title">수료증 재발급 신청</h1>

            <nav class="ci-tab">
                <a href="#">교육 안내</a>
                <a href="/apply_for_training">교육 신청</a>
                <a href="/take_training">교육 수강</a>
                <a href="/completioncert_reissue" class="is-active">수료증 재발급 신청</a>
            </nav>

            <div class="ci-visual">
                <img src="/assets/img/sub/ci_visual_completioncert_reissue.png" alt="">
                <div class="ci-visual-text">
                    <p class="text_dif">계측전문인력 교육</p>
                    <p class="text-en">Reissue Certificate</p>
                    <p class="text-en-small">Korea Slope Safety Association</p>
                </div>
            </div>

        </section>

        <section class="cert-search-section">
            <div class="form-inner">
                <div class="cert-form">
                    <div class="cert-row pc-only1">
                        <div class="cert-group">
                            <div class="cert-label">카테고리</div>
                            <div class="cert-input">
                                <select name="category" id="category" onchange="getCourses();">
                                    <option value="">선택하다</option>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?= $category['code_no'] ?>"><?= $category['code_name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="cert-group">
                            <div class="cert-label">교육명</div>
                            <div class="cert-input">
                                <select name="course" id="course">
                                    <option value="">선택하다</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="cert-row">
                        <div class="cert-group">
                            <div class="cert-label">성명</div>
                            <div class="cert-input">
                                <input name="user_name" id="user_name" value="" type="text" placeholder="입력">
                            </div>
                        </div>

                        <div class="cert-group">
                            <div class="cert-label">생년월일</div>
                            <div class="cert-input">
                                <input name="birthday" id="birthday" value="" type="text" class="datepicker"
                                       placeholder="입력" autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="cert-btn-wrap">
                    <button type="button" onclick="getDataCert();" class="btn-search-cert">조회</button>
                </div>
            </div>
            <div class="cert-inner">
                <div class="cert-result">
                    <table class="table_pass_">
                        <thead>
                        <tr>
                            <th>번호</th>
                            <th>성명</th>
                            <th>교육명</th>
                            <th>교육일자</th>
                            <th>이수여부</th>
                            <th>수료증 출력</th>
                        </tr>
                        </thead>
                        <tbody class="tbody_pass">


                        </tbody>
                    </table>
                </div>

            </div>
        </section
    </main>

    <script>
        $(document).ready(function () {
            $(".datepicker").datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                showButtonPanel: true,
                yearRange: "1970:2020",
                defaultDate: new Date(2000, 0, 1)
            });
        })

        async function getCourses() {
            let category = $('#category').val();

            let url = '/api/courses/list?category=' + category;

            await $.ajax({
                url: url,
                method: 'GET',
                success: function (response) {
                    console.log(response);
                    renderCourse(response.data);
                },
                error: function (exception) {
                    alert(exception.responseJSON.message ?? '오류가 발생했습니다!')
                    console.log(exception)
                }
            });
        }

        function renderCourse(data) {
            let num = data.length;
            let html = '<option value="">선택하다</option>';

            for (let i = 0; i < num; i++) {
                let item = data[i];

                html += `<option value="${item.idx}">${item.course_name}</option>`;
            }

            $('#course').empty().append(html);
        }

        async function getDataCert() {
            let course = $('#course').val();
            let user_name = $('#user_name').val();
            let birthday = $('#birthday').val();

            let url = '/api/find/cert';

            if (!course) {
                alert('과정을 선택해 주세요.');
                $('#course').focus();
                return;
            }

            if (!user_name) {
                alert('이름을 입력해 주세요.');
                $('#user_name').focus();
                return;
            }

            if (!birthday) {
                alert('생년월일을 선택해 주세요.');
                $('#birthday').focus();
                return;
            }

            let formData = new FormData();
            formData.append('course', course);
            formData.append('user_name', user_name);
            formData.append('birthday', birthday);

            await $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    console.log(response);
                    renderDataCert(response.data)
                },
                error: function (exception) {
                    alert(exception.responseJSON.message ?? '오류가 발생했습니다!')
                    console.log(exception)
                }
            });
        }

        function renderDataCert(data) {
            let html;

            if (data) {
                let act = '';
                if (data.valid < 1) {
                    act = `<a target="_blank" href="/print/certificates?idx=${data.id}" class="cert-print-btn">
                            <i class="bi bi-printer"></i>
                            </a>`;
                }
                html = `<tr>
                                                    <td>1</td>
                                                    <td>${data.name}</td>
                                                    <td>${data.course_name}</td>
                                                    <td>${data.start_date}</td>
                                                    <td>${data.state}</td>
                                                    <td>
                                                        ${act}
                                                    </td>
                                                </tr>`;
            } else {
                html = `<tr>
                            <td colspan="6">적합한 데이터가 없습니다.</td>
                        </tr>`;
            }

            $('.table_pass_').find('.tbody_pass').empty().append(html);
        }
    </script>
<?php $this->endSection(); ?>