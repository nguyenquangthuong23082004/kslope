<?php $this->extend('inc/layout_index'); ?>
<?php $this->section('content'); ?>
    <style>
        .form-group {
            margin-bottom: 0;
        }

        .password-wrap {
            width: 100%;
        }

        .password-wrap .btn-eye {
            position: absolute;
            top: 50%;
        }

        .password-wrap input{
            width: 100%;
            max-width: 100%;
            box-sizing: border-box;
        }
    </style>
    <main id="container" class="main main_new">

        <section class="mypage-wrap">
            <div class="mypage-inner">

                <?= view('mypage/mypage_sidebar', ['active' => 'profile']) ?>

                <div class="mypage-content">
                    <div class="wrap_ttl_member">
                        <h3 class="content-title-welcome">회원정보수정</h3>
                        <!-- <p class="welcome_member">환영합니다! <span class="member_blue">Phong님</span></p> -->
                    </div>

                    <form action="#!" method="post" name="formEdit" id="formEdit" class="formEdit"
                          enctype="multipart/form-data">
                        <input type="hidden" name="user_id" id="user_id" value="<?= $row['user_id'] ?>">
                        <input type="hidden" name="m_idx" id="m_idx" value="<?= $row['m_idx'] ?>">
                        <input type="hidden" name="member_type" id="member_type" value="<?= $row['member_type'] ?>">
                        <div class="member-form-wrap">

                            <!-- BASIC INFO -->
                            <div class="member-section">
                                <div class="member-row dif">
                                    <div class="member-label">아이디</div>
                                    <div class="member-value"><?= $row['user_id'] ?></div>
                                </div>

                                <?php

                                $user_email = isset($row) ? $row['user_email'] : null;
                                if ($user_email) {
                                    $parts = explode("@", $user_email);
                                    $email1 = $parts[0] ?? '';
                                    $email2 = $parts[1] ?? '';
                                }

                                ?>

                                <div class="member-row">
                                    <div class="member-label">현재 <br> 비밀번호</div>
                                    <div class="password-wrap">
                                        <input type="password" name="old_password" id="old_password" placeholder="현재 비밀번호">
                                        <button
                                            type="button"
                                            class="btn-eye"
                                            onclick="togglePassword()"
                                            aria-label="비밀번호 보기">
                                            <img
                                                src="/assets/img/member/ico_eye_close.png"
                                                alt="비밀번호 보기"
                                                id="eyeIcon">
                                        </button>
                                     </div>
                                </div>

                                <div class="member-row">
                                    <div class="member-label">새 비밀번호</div>
                                    <div class="password-wrap">
                                        <input type="password" name="new_password" id="new_password" placeholder="새로운 비밀번호">
                                        <button
                                            type="button"
                                            class="btn-eye"
                                            onclick="togglePassword2()"
                                            aria-label="비밀번호 보기">
                                            <img
                                                src="/assets/img/member/ico_eye_close.png"
                                                alt="비밀번호 보기"
                                                id="eyeIcon2">
                                        </button>
                                     </div>
                                </div>

                                <div class="member-row">
                                    <div class="member-label">비밀번호 <br> 확인</div>
                                    <div class="password-wrap">
                                    <input type="password" name="password_confirm" id="password_confirm"
                                           placeholder="새로운 비밀번호 확인">
                                           <button
                                            type="button"
                                            class="btn-eye"
                                            onclick="togglePassword3()"
                                            aria-label="비밀번호 보기">
                                            <img
                                                src="/assets/img/member/ico_eye_close.png"
                                                alt="비밀번호 보기"
                                                id="eyeIcon3">
                                        </button>
                                    </div>
                                </div>

                                <div class="member-row email-row">
                                    <div class="member-label">이메일</div>
                                    <div class="member-flex">
                                        <input id="email1" name="email1" type="text" value="<?= $email1 ?? '' ?>">
                                        <span class="at">@</span>
                                        <div class="select_member">
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
                            </div>

                            <?php if (isset($row) && $row['member_type'] == 'G'): ?>
                                <div class="member-section">
                                    <h4 class="section-title">단체정보</h4>

                                    <div class="member-row">
                                        <div class="member-label">기관명</div>
                                        <input type="text" name="company_name" id="company_name"
                                               value="<?= $row['company_name'] ?>">
                                    </div>

                                    <div class="member-row">
                                        <div class="member-label">대표자성명</div>
                                        <input type="text" id="company_representative" name="company_representative"
                                               value="<?= $row['company_representative'] ?>">
                                    </div>

                                    <div class="member-row">
                                        <div class="member-label">업태</div>
                                        <input type="text" id="business_type" name="business_type"
                                               value="<?= $row['business_type'] ?>">
                                    </div>

                                    <div class="member-row">
                                        <div class="member-label">업종</div>
                                        <input type="text" id="business_industry" name="business_industry"
                                               value="<?= $row['business_industry'] ?>">
                                    </div>

                                    <?php

                                    $business_phone = isset($row) ? $row['business_phone'] : null;
                                    if ($business_phone) {
                                        $parts = explode("-", $business_phone);
                                        $b_phone1 = $parts[0] ?? '';
                                        $b_phone2 = $parts[1] ?? '';
                                        $b_phone3 = $parts[2] ?? '';
                                    }

                                    ?>
                                    <div class="member-row">
                                        <div class="member-label">단체 <br> 전화번호</div>
                                        <div class="phone-wrap">
                                            <input name="b_phone1" id="b_phone1" type="text" placeholder=""
                                                value="<?= $b_phone1 ?? '' ?>">
                                            <span>-</span>
                                            <input name="b_phone2" id="b_phone2" type="text" placeholder=""
                                                value="<?= $b_phone2 ?? '' ?>">
                                            <span>-</span>
                                            <input name="b_phone3" id="b_phone3" type="text" placeholder=""
                                                value="<?= $b_phone3 ?? '' ?>">
                                        </div>
                                    </div>

                                    <div class="member-row">
                                        <div class="member-label">홈페이지</div>
                                        <input type="text" id="bussiness_web" name="bussiness_web"
                                               value="<?= $row['bussiness_web'] ?>">
                                    </div>

                                    <?php

                                    $business_number = isset($row) ? $row['business_number'] : null;
                                    if ($business_number) {
                                        $parts = explode("-", $business_number);
                                        $business_number1 = $parts[0] ?? '';
                                        $business_number2 = $parts[1] ?? '';
                                        $business_number3 = $parts[2] ?? '';
                                    }

                                    ?>
                                    <div class="member-row">
                                        <div class="member-label">사업자등록번호 <br> (고유등록번호)</div>
                                        <div class="phone-wrap">
                                            <input name="business_number1" id="business_number1" type="text" placeholder=""
                                                value="<?= $business_number1 ?? '' ?>">
                                            <span>-</span>
                                            <input name="business_number2" id="business_number2" type="text" placeholder=""
                                                value="<?= $business_number2 ?? '' ?>">
                                            <span>-</span>
                                            <input name="business_number3" id="business_number3" type="text" placeholder=""
                                                value="<?= $business_number3 ?? '' ?>">
                                        </div>
                                    </div>

                                    <div class="member-row">
                                        <div class="member-label">주소</div>
                                        <div class="member-flex full">
                                            <div class="member-value" style="display: flex;gap: 10px;">
                                                <div class="form-group">
                                                    <input name="zip" value="<?= $row['zip'] ?>" type="text" id="zipcode"
                                                        class="form-input" placeholder="우편번호" readonly>
                                                </div>

                                                <div class="form-group">
                                                    <input name="addr1" value="<?= $row['addr1'] ?>" type="text"
                                                        id="address" class="form-input" placeholder="주소" readonly>
                                                </div>

                                                <div class="form-group">
                                                    <input name="addr2" value="<?= $row['addr2'] ?>" type="text"
                                                        id="addressDetail" class="form-input" placeholder="상세주소를 입력해주세요">
                                                </div>
                                            </div>
                                            <button type="button" class="btn-blue" onclick="execDaumPostcode()">
                                                주소찾기
                                            </button>
                                        </div>
                                    </div>

                                    <!-- <div class="member-row">
                                        <div class="member-label">사업자등록번호(고유등록번호)</div>
                                        <div class="file-name" id="file_name"><?= $row['company_file'] ?></div>
                                        <button type="button" class="btn-upload">
                                            파일첨부
                                        </button>
                                        <input type="file" name="file_upload" id="file_upload" class="file-hidden"/>
                                    </div> -->
                                </div>
                            <?php endif; ?>

                            <div class="member-section">
                                <h4 class="section-title">담당자정보</h4>

                                <div class="member-row">
                                    <div class="member-label">성명</div>
                                    <input type="text" name="user_name" id="user_name" value="<?= $row['user_name'] ?>">
                                </div>

                                <div class="member-row">
                                    <div class="member-label">직책</div>
                                    <input type="text" name="work_position" id="work_position"
                                           value="<?= $row['work_position'] ?>">
                                </div>
                                <?php if (isset($row) && $row['member_type'] == 'G'): ?>
                                <div class="member-row">
                                    <div class="member-label">부서</div>
                                    <input type="text" name="user_department" id="user_department"
                                           value="<?= $row['user_department'] ?>">
                                </div>
                                <?php endif; ?>
                                <?php if (isset($row) && $row['member_type'] != 'G'): ?>
                                <div class="member-row">
                                    <div class="member-label">사업장 주소</div>
                                    <div class="member-flex full">
                                        <div class="member-value" style="display: flex;gap: 10px;">
                                            <div class="form-group">
                                                <input name="zip" value="<?= $row['zip'] ?>" type="text" id="zipcode"
                                                       class="form-input" placeholder="우편번호" readonly>
                                            </div>

                                            <div class="form-group">
                                                <input name="addr1" value="<?= $row['addr1'] ?>" type="text"
                                                       id="address" class="form-input" placeholder="주소" readonly>
                                            </div>

                                            <div class="form-group">
                                                <input name="addr2" value="<?= $row['addr2'] ?>" type="text"
                                                       id="addressDetail" class="form-input" placeholder="상세주소를 입력해주세요">
                                            </div>
                                        </div>
                                        <button type="button" class="btn-blue" onclick="execDaumPostcode()">
                                            주소찾기
                                        </button>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <?php

                                $user_mobile = isset($row) ? $row['user_mobile'] : null;
                                if ($user_mobile) {
                                    $parts = explode("-", $user_mobile);
                                    $mobile1 = $parts[0] ?? '';
                                    $mobile2 = $parts[1] ?? '';
                                    $mobile3 = $parts[2] ?? '';
                                }

                                ?>
                                <div class="member-row">
                                    <div class="member-label">휴대번호</div>
                                    <div class="phone-wrap">
                                        <input name="mobile1" id="mobile1" type="text" placeholder=""
                                               value="<?= $mobile1 ?? '' ?>">
                                        <span>-</span>
                                        <input name="mobile2" id="mobile2" type="text" placeholder=""
                                               value="<?= $mobile2 ?? '' ?>">
                                        <span>-</span>
                                        <input name="mobile3" id="mobile3" type="text" placeholder=""
                                               value="<?= $mobile3 ?? '' ?>">
                                    </div>
                                </div>
                            </div>

                            <?php if (isset($row) && $row['member_type'] == 'N'): ?>
                                <div class="member-section">
                                    <h4 class="section-title">정보 추가</h4>

                                    <div class="member-row">
                                        <div class="member-label">개인회원 종류</div>
                                        <select disabled name="membership_type" id="membership_type" style="width: 100%">
                                            <option value="일반" <?= $row['membership_type'] == '일반' ? 'selected' : '' ?>>
                                                일반
                                            </option>
                                            <option value="종신" <?= $row['membership_type'] == '종신' ? 'selected' : '' ?>>
                                                종신
                                            </option>
                                            <option value="명예" <?= $row['membership_type'] == '명예' ? 'selected' : '' ?>>
                                                명예
                                            </option>
                                        </select>
                                    </div>

                                    <div class="member-row form-upload">
                                        <div class="member-label">사업자등록번호(고유등록번호)</div>
                                        <div class="file-name"><?= $row['membership_photo'] ?></div>
                                        <button type="button" class="btn-upload">
                                            파일첨부
                                        </button>
                                        <input type="file" name="membership_photo" id="membership_photo"
                                               class="file-hidden"/>
                                    </div>
                                </div>

                                <div class="member-section">
                                    <h4 class="section-title">소속</h4>

                                    <div class="member-row">
                                        <div class="member-label">기관 / 직위</div>
                                        <input type="text" id="membership_organization" name="membership_organization"
                                               value="<?= $row['membership_organization'] ?>">
                                    </div>

                                    <div class="member-row">
                                        <div class="member-label">사업자번호</div>
                                        <div class="member-flex full">
                                            <div class="member-value" style="display: flex;gap: 10px;">
                                                <div class="form-group">
                                                    <input name="membership_zip" value="<?= $row['membership_zip'] ?>"
                                                           type="text" id="zipcode2"
                                                           class="form-input" placeholder="우편번호" readonly>
                                                </div>

                                                <div class="form-group">
                                                    <input name="membership_addr1"
                                                           value="<?= $row['membership_addr1'] ?>" type="text"
                                                           id="address2" class="form-input" placeholder="주소" readonly>
                                                </div>

                                                <div class="form-group">
                                                    <input name="membership_addr2"
                                                           value="<?= $row['membership_addr2'] ?>" type="text"
                                                           id="addressDetail2" class="form-input"
                                                           placeholder="상세주소를 입력해주세요">
                                                </div>
                                            </div>
                                            <button type="button" class="btn-blue" onclick="execDaumPostcode2()">
                                                주소찾기
                                            </button>
                                        </div>
                                    </div>

                                    <div class="member-row">
                                        <div class="member-label">전화번호</div>
                                        <?php
                                        $phoneMemberShip = explode('-', $row['membership_phone'] ?? '');
                                        $s_phone1 = $phoneMemberShip[0] ?? '';
                                        $s_phone2 = $phoneMemberShip[1] ?? '';
                                        $s_phone3 = $phoneMemberShip[2] ?? '';

                                        ?>
                                        <div class="phone-wrap">
                                            <div class="select_member">
                                                <select name="s_phone1" id="s_phone1">
                                                    <option <?= isset($s_phone1) && $s_phone1 == '010' ? 'selected' : '' ?>
                                                            value="010">010
                                                    </option>
                                                    <option <?= isset($s_phone1) && $s_phone1 == '011' ? 'selected' : '' ?>
                                                            value="011">011
                                                    </option>
                                                </select>
                                            </div>
                                            <span>-</span>
                                            <input name="s_phone2" id="s_phone2" type="text" placeholder=""
                                                   value="<?= $s_phone2 ?? '' ?>">
                                            <span>-</span>
                                            <input name="s_phone3" id="s_phone3" type="text" placeholder=""
                                                   value="<?= $s_phone3 ?? '' ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="member-section">
                                    <h4 class="section-title">학력
                                        <button type="button" class="btnAdd">추가</button>
                                    </h4>

                                    <?php if (empty($educations)): ?>
                                        <div class="form-group">
                                            <div class="member-row">
                                                <div class="member-label">기간</div>
                                                <input type="text" name="membership_period[]" value="">
                                            </div>

                                            <div class="member-row">
                                                <div class="member-label">학교명</div>
                                                <input type="text" name="membership_school[]" value="">
                                            </div>

                                            <div class="member-row">
                                                <div class="member-label">학과명 (전공분야)</div>
                                                <input type="text" name="membership_department[]" value="">
                                            </div>

                                            <div class="member-row">
                                                <div class="member-label">학위</div>
                                                <input type="text" name="membership_degree[]" value="">
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <?php foreach ($educations as $education): ?>
                                            <div class="form-group">
                                                <div class="member-row">
                                                    <div class="member-label">기간</div>
                                                    <input type="text" name="membership_period[]" 
                                                        value="<?= esc($education['membership_period']) ?>">
                                                </div>

                                                <div class="member-row">
                                                    <div class="member-label">학교명</div>
                                                    <input type="text" name="membership_school[]" 
                                                        value="<?= esc($education['membership_school']) ?>">
                                                </div>

                                                <div class="member-row">
                                                    <div class="member-label">학과명 (전공분야)</div>
                                                    <input type="text" name="membership_department[]" 
                                                        value="<?= esc($education['membership_department']) ?>">
                                                </div>

                                                <div class="member-row">
                                                    <div class="member-label">학위</div>
                                                    <input type="text" name="membership_degree[]" 
                                                        value="<?= esc($education['membership_degree']) ?>">
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>

                                <div class="member-section">
                                    <h4 class="section-title">정보 추가
                                        <button type="button" class="btnAdd">추가</button>
                                    </h4>

                                    <?php if (empty($careers)): ?>
                                        <div class="form-group">
                                            <div class="member-row">
                                                <div class="member-label">기 간</div>
                                                <input type="text" name="active_period[]" value="">
                                            </div>

                                            <div class="member-row">
                                                <div class="member-label">소속</div>
                                                <input type="text" name="active_affiliation[]" value="">
                                            </div>

                                            <div class="member-row">
                                                <div class="member-label">담당부서</div>
                                                <input type="text" name="active_department[]" value="">
                                            </div>

                                            <div class="member-row">
                                                <div class="member-label">직위</div>
                                                <input type="text" name="active_position[]" value="">
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <?php foreach ($careers as $career): ?>
                                            <div class="form-group">
                                                <div class="member-row">
                                                    <div class="member-label">기 간</div>
                                                    <input type="text" name="active_period[]" 
                                                        value="<?= esc($career['active_period']) ?>">
                                                </div>

                                                <div class="member-row">
                                                    <div class="member-label">소속</div>
                                                    <input type="text" name="active_affiliation[]" 
                                                        value="<?= esc($career['active_affiliation']) ?>">
                                                </div>

                                                <div class="member-row">
                                                    <div class="member-label">담당부서</div>
                                                    <input type="text" name="active_department[]" 
                                                        value="<?= esc($career['active_department']) ?>">
                                                </div>

                                                <div class="member-row">
                                                    <div class="member-label">직위</div>
                                                    <input type="text" name="active_position[]" 
                                                        value="<?= esc($career['active_position']) ?>">
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>

                                <div class="member-section">
                                    <h4 class="section-title">대외활동
                                        <button type="button" class="btnAdd">추가</button>
                                    </h4>

                                    <?php if (empty($extras)): ?>
                                        <div class="form-group">
                                            <div class="member-row">
                                                <div class="member-label">소속</div>
                                                <input type="text" name="extra_affiliation[]" value="">
                                            </div>

                                            <div class="member-row">
                                                <div class="member-label">기간</div>
                                                <input type="text" name="extra_period[]" value="">
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <?php foreach ($extras as $extra): ?>
                                            <div class="form-group">
                                                <div class="member-row">
                                                    <div class="member-label">소속</div>
                                                    <input type="text" name="extra_affiliation[]" 
                                                        value="<?= esc($extra['extra_affiliation']) ?>">
                                                </div>

                                                <div class="member-row">
                                                    <div class="member-label">기간</div>
                                                    <input type="text" name="extra_period[]" 
                                                        value="<?= esc($extra['extra_period']) ?>">
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>

                                <div class="member-section">
                                    <h4 class="section-title">자격사항
                                        <button type="button" class="btnAdd">추가</button>
                                    </h4>

                                    <?php if (empty($qualifications)): ?>
                                        <div class="form-group">
                                            <div class="member-row">
                                                <div class="member-label">자격증명</div>
                                                <input type="text" name="membership_qualification[]" value="">
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <?php foreach ($qualifications as $qualification): ?>
                                            <div class="form-group">
                                                <div class="member-row">
                                                    <div class="member-label">자격증명</div>
                                                    <input type="text" name="membership_qualification[]" 
                                                        value="<?= esc($qualification['membership_qualification']) ?>">
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>

                                    <!-- <div class="member-row form-upload">
                                        <div class="member-label">사진 전문가</div>
                                        <div class="file-name"><?= $row['qualification_file'] ?></div>
                                        <button type="button" class="btn-upload">
                                            파일첨부
                                        </button>
                                        <input type="file" name="qualification_file" id="qualification_file"
                                               class="file-hidden"/>
                                    </div> -->
                                </div>

                            <?php endif; ?>

                            <?php if (isset($row) && $row['member_type'] == 'G'): ?>
                                <div class="member-section">
                                    <h4 class="section-title">청보추가</h4>

                                    <div class="member-row">
                                        <div class="member-label">단체회원 종류</div>
                                        <select name="membership_type" id="membership_type" style="width: 100%">
                                            <option value="일반" <?= $row['membership_type'] == '일반' ? 'selected' : '' ?>>
                                                일반
                                            </option>
                                            <option value="종신 (가급)" <?= $row['membership_type'] == '종신 (가급)' ? 'selected' : '' ?>>
                                                종신 (가급)
                                            </option>
                                            <option value="종신 (나급)" <?= $row['membership_type'] == '종신 (나급)' ? 'selected' : '' ?>>
                                                종신 (나급)
                                            </option>
                                        </select>
                                    </div>

                                    <div class="member-row form-upload">
                                        <div class="member-label">증명사진</div>
                                        <div class="file-name"><?= $row['membership_photo'] ?></div>
                                        <button type="button" class="btn-upload">
                                            파일첨부
                                        </button>
                                        <input type="file" name="membership_photo" id="membership_photo"
                                               class="file-hidden"/>
                                    </div>

                                    <div class="member-row">
                                        <div class="member-label">단체소개</div>
                                        <textarea id="group_introduction" name="group_introduction"
                                               rows="6" class="form-input"><?= $row['group_introduction'] ?></textarea>
                                    </div>

                                    <div class="member-row">
                                        <div class="member-label">주요 연혁</div>
                                        <textarea id="group_history" name="group_history"
                                               rows="6" class="form-input"><?= $row['group_history'] ?></textarea>
                                    </div>
                                </div>

                            <?php endif; ?>

                            <?php if (isset($row) && $row['member_type'] == 'S'): ?>
                                <div class="member-section">
                                    <h4 class="section-title">정보 추가</h4>

                                    <div class="member-row">
                                        <div class="member-label">특별회원</div>
                                        <select disabled name="membership_type" id="membership_type" style="width: 100%">
                                            <option value="정부" <?= $row['membership_type'] == '정부' ? 'selected' : '' ?>>
                                                정부
                                            </option>
                                            <option value="지방자치단체" <?= $row['membership_type'] == '지방자치단체' ? 'selected' : '' ?>>
                                                지방자치단체
                                            </option>
                                            <option value="기관" <?= $row['membership_type'] == '기관' ? 'selected' : '' ?>>
                                                기관
                                            </option>
                                            <option value="기타" <?= $row['membership_type'] == '기타' ? 'selected' : '' ?>>
                                                기타
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="member-section">
                                    <h4 class="section-title">기관 기본 정보</h4>

                                    <div class="member-row">
                                        <div class="member-label">기관명</div>
                                        <input type="text" id="organization_name" name="organization_name"
                                               value="<?= $row['organization_name'] ?>">
                                    </div>

                                    <div class="member-row">
                                        <div class="member-label">기관장성명</div>
                                        <input type="text" id="organization_director" name="organization_director"
                                               value="<?= $row['organization_director'] ?>">
                                    </div>

                                    <div class="member-row">
                                        <div class="member-label">주소</div>
                                        <div class="member-flex full">
                                            <div class="member-value" style="display: flex;gap: 10px;">
                                                <div class="form-group">
                                                    <input name="organization_zip" value="<?= $row['organization_zip'] ?>"
                                                           type="text" id="zipcode2"
                                                           class="form-input" placeholder="우편번호" readonly>
                                                </div>

                                                <div class="form-group">
                                                    <input name="organization_addr1"
                                                           value="<?= $row['organization_addr1'] ?>" type="text"
                                                           id="address2" class="form-input" placeholder="주소" readonly>
                                                </div>

                                                <div class="form-group">
                                                    <input name="organization_addr2"
                                                           value="<?= $row['organization_addr2'] ?>" type="text"
                                                           id="addressDetail2" class="form-input"
                                                           placeholder="상세주소를 입력해주세요">
                                                </div>
                                            </div>
                                            <button type="button" class="btn-blue" onclick="execDaumPostcode2()">
                                                주소찾기
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="member-section">
                                    <h4 class="section-title">담당부서 정보</h4>

                                    <div class="member-row">
                                        <div class="member-label">부서명</div>
                                        <input type="text" name="department_name"
                                               value="<?= $row['department_name'] ?>">
                                    </div>

                                    <div class="member-row">
                                        <div class="member-label">과장 성명</div>
                                        <input type="text" name="manager_name"
                                               value="<?= $row['manager_name'] ?>">
                                    </div>

                                    <div class="member-row">
                                        <div class="member-label">과장 전화번호</div>
                                        <?php
                                        $phoneManage = explode('-', $row['manager_phone'] ?? '');
                                        $m_mobile1 = $phoneManage[0] ?? '';
                                        $m_mobile2 = $phoneManage[1] ?? '';
                                        $m_mobile3 = $phoneManage[2] ?? '';

                                        ?>
                                        <div class="phone-wrap">
                                            <input name="m_mobile1" id="m_mobile1" type="text" placeholder=""
                                                   value="<?= $m_mobile1 ?? '' ?>">
                                            <span>-</span>
                                            <input name="m_mobile2" id="m_mobile2" type="text" placeholder=""
                                                   value="<?= $m_mobile2 ?? '' ?>">
                                            <span>-</span>
                                            <input name="m_mobile3" id="m_mobile3" type="text" placeholder=""
                                                   value="<?= $m_mobile3 ?? '' ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="member-section">
                                    <h4 class="section-title">담당자 정보</h4>

                                    <div class="member-row">
                                        <div class="member-label">성명</div>
                                        <input type="text" name="member_name"
                                               value="<?= $row['member_name'] ?>">
                                    </div>

                                    <div class="member-row">
                                        <div class="member-label">과장 전화번호</div>
                                        <?php
                                        $phoneMember = explode('-', $row['member_phone'] ?? '');
                                        $me_mobile1 = $phoneMember[0] ?? '';
                                        $me_mobile2 = $phoneMember[1] ?? '';
                                        $me_mobile3 = $phoneMember[2] ?? '';

                                        ?>
                                        <div class="phone-wrap">
                                            <input name="me_mobile1" id="me_mobile1" type="text" placeholder=""
                                                   value="<?= $me_mobile1 ?? '' ?>">
                                            <span>-</span>
                                            <input name="me_mobile2" id="me_mobile2" type="text" placeholder=""
                                                   value="<?= $me_mobile2 ?? '' ?>">
                                            <span>-</span>
                                            <input name="me_mobile3" id="me_mobile3" type="text" placeholder=""
                                                   value="<?= $me_mobile3 ?? '' ?>">
                                        </div>
                                    </div>
                                    <div class="member-row">
                                        <div class="member-label">이메일</div>
                                        <input type="text" name="member_email"
                                               value="<?= $row['member_email'] ?>">
                                    </div>

                                     <div class="member-row form-upload">
                                        <div class="member-label">사업자등록번호(고유등록번호)</div>
                                        <div class="file-name"><?= $row['membership_photo'] ?></div>
                                        <button type="button" class="btn-upload">
                                            파일첨부
                                        </button>
                                        <input type="file" name="membership_photo" id="membership_photo"
                                               class="file-hidden"/>
                                    </div>
                                </div>


                            <?php endif; ?>

                            <div class="member-section">

                                <div class="member-btns">
                                    <button type="button" class="btn-cancel">취소</button>
                                    <button type="button" class="btn-submit-pass" onclick="submitForm();">정보수정</button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </section>

    </main>
    <div id="layer" style="display:none;position:fixed;overflow:hidden;z-index:1999;-webkit-overflow-scrolling:touch;">
        <img src="//t1.daumcdn.net/postcode/resource/images/close.png" id="btnCloseLayer"
             style="cursor:pointer;position:absolute;right:-3px;top:-3px;z-index:1" onclick="closeDaumPostcode()"
             alt="닫기 버튼">
    </div>
    <script>
        var element_layer = document.getElementById('layer');

        function execDaumPostcode() {
            new daum.Postcode({
                oncomplete: function (data) {
                    console.log("data", data);

                    document.getElementById("zipcode").value = data.zonecode;
                    document.getElementById("address").value = data.address;
                    document.getElementById("addressDetail").focus();

                    element_layer.style.display = 'none';
                },
                width: '100%',
                height: '100%',
                maxSuggestItems: 5
            }).embed(element_layer);

            element_layer.style.display = 'block';

            initLayerPosition();
        }

        function execDaumPostcode2() {
            new daum.Postcode({
                oncomplete: function (data) {
                    console.log("data", data);

                    document.getElementById("zipcode2").value = data.zonecode;
                    document.getElementById("address2").value = data.address;
                    document.getElementById("addressDetail2").focus();

                    element_layer.style.display = 'none';
                },
                width: '100%',
                height: '100%',
                maxSuggestItems: 5
            }).embed(element_layer);

            element_layer.style.display = 'block';

            initLayerPosition();
        }

        function initLayerPosition() {
            var width = 300; //우편번호서비스가 들어갈 element의 width
            var height = 400; //우편번호서비스가 들어갈 element의 height
            var borderWidth = 5; //샘플에서 사용하는 border의 두께

            // 위에서 선언한 값들을 실제 element에 넣는다.
            element_layer.style.width = width + 'px';
            element_layer.style.height = height + 'px';
            element_layer.style.border = borderWidth + 'px solid';
            // 실행되는 순간의 화면 너비와 높이 값을 가져와서 중앙에 뜰 수 있도록 위치를 계산한다.
            element_layer.style.left = (((window.innerWidth || document.documentElement.clientWidth) - width) / 2 - borderWidth) + 'px';
            element_layer.style.top = (((window.innerHeight || document.documentElement.clientHeight) - height) / 2 - borderWidth) + 'px';
        }

        function closeDaumPostcode() {
            // iframe을 넣은 element를 안보이게 한다.
            element_layer.style.display = 'none';
        }
    </script>
    <script>
        function validatePassword(password) {
            const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,20}$/;
            return regex.test(password);
        }

        async function submitForm() {
            let frm = document.formEdit;
            let formData = new FormData(frm);
            let url = '/save_information';

            let password = $('#new_password').val();
            let conf_password = $('#password_confirm').val();

            if (password != '' || conf_password != '') {
                let isValid = validatePassword(password);
                if (!isValid) {
                    alert('비밀번호는 8~20자의 영문 대/소문자, 숫자, 특수문자를 모두 포함해야 합니다.');
                    $('#new_password').focus();
                    return false;
                }

                if (password !== conf_password) {
                    alert('비밀번호가 일치하지 않습니다.')
                    return false;
                }
            }

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
    <script>
        $(function () {

            $('.btn-upload').on('click', function () {
                $(this).closest('.form-upload').find('.file-hidden').click();
            });

            $('.file-hidden').on('change', function () {
                if (this.files && this.files.length > 0) {
                    $(this).closest('.form-upload').find('.file-name').text(this.files[0].name);
                } else {
                    $(this).closest('.form-upload').find('.file-name').text('선택된 파일이 없습니다');
                }
            });

            $(document).on('click', '.btnAdd', function () {
                let section = $(this).closest('.member-section');
                let firstForm = section.find('.form-group').first();
                let clone = firstForm.clone();
                clone.find('input').val('');
                section.append(clone);
            });
        });
    </script>
    <script>
        function togglePassword() {
            const input = document.getElementById('old_password');
            const icon = document.getElementById('eyeIcon');

            if (input.type === 'password') {
                input.type = 'text';
                icon.src = '/assets/img/member/ico_eye_open.png';
                icon.alt = '비밀번호 숨기기';
            } else {
                input.type = 'password';
                icon.src = '/assets/img/member/ico_eye_close.png';
                icon.alt = '비밀번호 보기';
            }
        }

        function togglePassword2() {
            const input = document.getElementById('new_password');
            const icon = document.getElementById('eyeIcon2');

            if (input.type === 'password') {
                input.type = 'text';
                icon.src = '/assets/img/member/ico_eye_open.png';
                icon.alt = '비밀번호 숨기기';
            } else {
                input.type = 'password';
                icon.src = '/assets/img/member/ico_eye_close.png';
                icon.alt = '비밀번호 보기';
            }
        }

        function togglePassword3() {
            const input = document.getElementById('password_confirm');
            const icon = document.getElementById('eyeIcon3');

            if (input.type === 'password') {
                input.type = 'text';
                icon.src = '/assets/img/member/ico_eye_open.png';
                icon.alt = '비밀번호 숨기기';
            } else {
                input.type = 'password';
                icon.src = '/assets/img/member/ico_eye_close.png';
                icon.alt = '비밀번호 보기';
            }
        }
    </script>
<?php $this->endSection(); ?>