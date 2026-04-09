<?php $this->extend('inc/layout_index'); ?>
<?php $this->section('content'); ?>
    <style>
        .btn-check.disabled {
            cursor: not-allowed;
            background-color: #215dbfa3;
        }

        input.disabled {
            background-color: rgba(196, 196, 196, 0.25);
            cursor: not-allowed;
        }
    </style>

    <main id="container" class="main main_new">
        <section class="mypage-wrap">
            <div class="mypage-inner">

                <?= view('mypage/mypage_sidebar', ['active' => 'staff']) ?>

                <div class="mypage-content">
                    <h3 class="content-title">직원관리</h3>
                    <div class="mypage-content">
                        <div class="staff-form-wrap">

                            <form class="formStore" id="formStore" method="post" action="#!">
                                <input type="hidden" name="id_chk" id="id_chk" value="<?= isset($user) ? 'Y' : 'N' ?>">
                                <input type="hidden" name="manager_id" id="manager_id" value="<?= $id ?>">

                                <?php if (isset($user)): ?>
                                    <input type="hidden" name="m_idx" id="m_idx" value="<?= $user['m_idx'] ?>">
                                <?php endif; ?>

                                <div class="staff-row">
                                    <label for="user_id">아이디</label>

                                    <?php if (isset($user)): ?>
                                        <input type="hidden" name="m_idx" id="m_idx" value="<?= $user['m_idx'] ?>">
                                        <div class="staff-field">
                                            <input type="text" name="user_id" id="user_id" placeholder=""
                                                   class="disabled"
                                                   value="<?= $user['user_id'] ?>" disabled readonly>
                                        </div>
                                    <?php else: ?>
                                        <div class="staff-field id-field">
                                            <input type="text" id="user_id" name="user_id" placeholder="">
                                            <button type="button" id="btnChkID" class="btn-check" onclick="chkID()">중복체크
                                            </button>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="staff-row">
                                    <label for="password">패스워드</label>
                                    <div class="staff-field">
                                        <input type="password" name="password" id="password" placeholder="">
                                    </div>
                                </div>

                                <div class="staff-row">
                                    <label for="user_name">성명</label>
                                    <div class="staff-field">
                                        <input type="text" name="user_name" id="user_name" placeholder=""
                                               value="<?= isset($user) ? $user['user_name'] : '' ?>">
                                    </div>
                                </div>
                                <?php

                                $user_email = isset($user) ? $user['user_email'] : null;
                                if ($user_email) {
                                    $parts = explode("@", $user_email);
                                    $email1 = $parts[0] ?? '';
                                    $email2 = $parts[1] ?? '';
                                }

                                ?>
                                <div class="staff-row">
                                    <label for="email1">이메일</label>

                                    <div class="staff-field email-field">
                                        <input id="email1" name="email1" type="text" placeholder=""
                                               value="<?= $email1 ?? '' ?>">

                                        <span class="email-sep">@</span>
                                        <div class="select_staff">
                                            <select id="email2" name="email2">
                                                <option <?= isset($email2) && $email2 == 'naver.com' ? 'selected' : '' ?>
                                                        value="naver.com">naver.com
                                                </option>
                                                <option <?= isset($email2) && $email2 == 'gmail.com' ? 'selected' : '' ?>
                                                        value="gmail.com">gmail.com
                                                </option>
                                                <option <?= isset($email2) && $email2 == 'daum.net' ? 'selected' : '' ?>
                                                        value="daum.net">daum.net
                                                </option>
                                            </select>
                                        </div>

                                    </div>
                                </div>
                                <?php

                                $user_phone = isset($user) ? $user['user_phone'] : null;
                                if ($user_phone) {
                                    $parts = explode("-", $user_phone);
                                    $phone1 = $parts[0] ?? '';
                                    $phone2 = $parts[1] ?? '';
                                    $phone3 = $parts[2] ?? '';
                                }

                                ?>
                                <div class="staff-row">
                                    <label for="phone2">연락처</label>

                                    <div class="staff-field phone-field">
                                        <div class="select_staff">
                                            <select name="phone1" id="phone1">
                                                <option <?= isset($phone1) && $phone1 == '010' ? 'selected' : '' ?>
                                                        value="010">010
                                                </option>
                                                <option <?= isset($phone1) && $phone1 == '011' ? 'selected' : '' ?>
                                                        value="011">011
                                                </option>
                                            </select>
                                        </div>
                                        <span>-</span>

                                        <input name="phone2" id="phone2" type="text" placeholder=""
                                               value="<?= $phone2 ?? '' ?>">

                                        <span>-</span>

                                        <input name="phone3" id="phone3" type="text" placeholder=""
                                               value="<?= $phone3 ?? '' ?>">

                                    </div>
                                </div>

                                <div class="staff-row">
                                    <label for="work_position">직급</label>
                                    <div class="staff-field">
                                        <input name="work_position" id="work_position" type="text" placeholder=""
                                               value="<?= isset($user) ? $user['work_position'] : '' ?>">
                                    </div>
                                </div>

                                <div class="staff-row spe" style="align-items: flex-start;">
                                    <label>교육 수강</label>
                                    <div class="staff-field">
                                        <div class="course-list-wrap">
                                            <?php
                                            $selectedCourses = [];
                                            if (isset($user) && !empty($user['course_idx'])) {
                                                $selectedCourses = explode(',', $user['course_idx']);
                                            }
                                            ?>
                                            <?php if (!empty($courses)): ?>
                                                <div class="course-select-all">
                                                    <input type="checkbox" id="select_all_courses" onclick="toggleAllCourses(this)">
                                                    <label for="select_all_courses">전체 선택</label>
                                                </div>
                                                <?php foreach ($courses as $course): ?>
                                                    <div class="course-item">
                                                        <input type="checkbox"
                                                            class="course-checkbox"
                                                            name="course_idx[]"
                                                            value="<?= esc($course['idx']) ?>"
                                                            id="course_<?= esc($course['idx']) ?>"
                                                            <?= in_array($course['idx'], $selectedCourses) ? 'checked' : '' ?>>
                                                        <label for="course_<?= esc($course['idx']) ?>">
                                                            <?= esc($course['course_name']) ?>
                                                        </label>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <p class="text-muted">사용 가능한 교육 과정이 없습니다.</p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="staff-btns">
                                    <button type="button" onclick="backList()" class="btn-gray">목록</button>
                                    <button type="button" class="btn-blue" onclick="storeStaff();">등록</button>
                                </div>

                            </form>

                        </div>

                    </div>

                </div>
            </div>
        </section>

    </main>

    <script>
        function toggleAllCourses(source) {
            document.querySelectorAll('.course-checkbox').forEach(function (cb) {
                cb.checked = source.checked;
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            const courseCheckboxes = document.querySelectorAll('.course-checkbox');
            const selectAll        = document.getElementById('select_all_courses');

            if (courseCheckboxes.length && selectAll) {
                courseCheckboxes.forEach(function (cb) {
                    cb.addEventListener('change', function () {
                        selectAll.checked = Array.from(courseCheckboxes).every(c => c.checked);
                    });
                });
                selectAll.checked = Array.from(courseCheckboxes).every(c => c.checked);
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('formStore').addEventListener('submit', function (e) {
                e.preventDefault();
            });
        });

        function backList() {
            window.location.href = '/staff_management';
        }

        function validateLength(value) {
            return value.length >= 6 && value.length <= 20;
        }

        function validatePassword(password) {
            const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,20}$/;
            return regex.test(password);
        }

        async function chkID() {
            let user_id = $('#user_id').val();

            if (!user_id) {
                alert('ID를 입력해 주세요.');
                $('#user_id').focus();
                return false;
            }

            let isValid = validateLength(user_id);
            if (!isValid) {
                alert('6~20자 이내로 입력해주세요.');
                return false;
            }

            let url = '/member/chk_id';
            let data = {
                user_id: user_id,
            }

            await $.ajax({
                url: url,
                method: 'POST',
                data: data,
                success: function (response) {
                    console.log(response)
                    alert(response.message);
                    $('#id_chk').val('Y');
                    $('#btnChkID').prop('disabled', true).addClass('disabled');
                },
                error: function (exception) {
                    alert(exception.responseJSON.message ?? '오류가 발생했습니다!')
                    console.log(exception)
                }
            });
        }

        async function storeStaff() {
            let manager_id    = $('#manager_id').val();
            let user_id       = $('#user_id').val();
            let password      = $('#password').val();
            let id_chk        = $('#id_chk').val();
            let user_name     = $('#user_name').val();
            let email1        = $('#email1').val();
            let email2        = $('#email2').val();
            let phone1        = $('#phone1').val();
            let phone2        = $('#phone2').val();
            let phone3        = $('#phone3').val();
            let work_position = $('#work_position').val();
            let m_idx         = $('#m_idx').val();

            if (!m_idx) {
                if (!user_id) {
                    alert('ID를 입력해 주세요.');
                    $('#user_id').focus();
                    return false;
                }
                if (!validateLength(user_id)) {
                    alert('6~20자 이내로 입력해주세요.');
                    return false;
                }
                if (!id_chk || id_chk !== 'Y') {
                    alert('ID 중복 여부를 확인해 주세요.');
                    return false;
                }
                if (!validatePassword(password)) {
                    alert('비밀번호는 8~20자의 영문 대/소문자, 숫자, 특수문자를 모두 포함해야 합니다.');
                    $('#password').focus();
                    return false;
                }
            }

            let courseIds = [];
            document.querySelectorAll('.course-checkbox:checked').forEach(function (cb) {
                courseIds.push(cb.value);
            });

            let data = {
                m_idx:         m_idx,
                manager_id:    manager_id,
                user_id:       user_id,
                password:      password,
                user_name:     user_name,
                email1:        email1,
                email2:        email2,
                phone1:        phone1,
                phone2:        phone2,
                phone3:        phone3,
                work_position: work_position,
                course_idx:    courseIds,
            };

            await $.ajax({
                url:    '/staff_store',
                method: 'POST',
                data:   data,
                success: function (response) {
                    console.log(response);
                    alert(response.message);
                    window.location.reload();
                },
                error: function (exception) {
                    alert(exception.responseJSON.message ?? '오류가 발생했습니다!');
                    console.log(exception);
                }
            });
        }
    </script>
<?php $this->endSection(); ?>