<?php $this->extend('inc/layout_index'); ?>
<?php $this->section('content'); ?>
<main id="container" class="main main_new">
    <section class="ci-intro dif">

        <div class="ci-bc">
            <a href="#" class="ci-bc__item">HOME</a>
            <a href="#" class="ci-bc__item">회원 안내</a>

            <a href="#" class="ci-bc__item ci-bc__item--select">
                가입 안내
                <img class="ci-bc__ico" src="/assets/img/sub/ico_select_down.png" alt="">
            </a>
        </div>

        <h1 class="ci-title">가입 안내</h1>

        <nav class="ci-tab">
            <a href="/sign_up_instructions" class="is-active">가입 안내</a>
            <a href="/member_resource">회원 자료실</a>
        </nav>

        <div class="ci-visual">
            <img src="/assets/img/sub/ci_visual_instructions.png" alt="">
            <div class="ci-visual-text">
                <p class="text_dif">회원 안내</p>
                <p class="text-en">Membership Information</p>
                <p class="text-en-small">Korea Slope Safety Association</p>
            </div>
        </div>

    </section>
    <section class="mem-join-area" style="display: none">
        <div class="mem-join-watermark">Member <br> ship</div>

        <div class="mem-join-inner">
            <h2 class="mem-join-title">회원 가입</h2>

            <div class="mem-join-cards">

                <div class="mem-card mem-card-personal">
                    <div class="mem-card-text">
                        <p class="mem-card-heading mem-green">개인회원 신청</p>
                        <!-- <a href="#" class="mem-apply-btn mem-green">
                            가입신청 <img src="/assets/img/sub/btn_download_w.png" alt="">
                        </a> -->
                        <a href="/assets/files/join_us_individual.hwp"
                            class="mem-apply-btn mem-green"
                            download>
                            가입신청 <img src="/assets/img/sub/btn_download_w.png" alt="">
                        </a>
                    </div>
                    <div class="mem-card-icon mem-icon-personal">
                        <img src="/assets/img/sub/icon_personal.png" alt="개인회원">
                    </div>
                </div>

                <div class="mem-card dif mem-card-group">
                    <div class="mem-card-text">
                        <p class="mem-card-heading mem-blue">단체 및 특별회원 신청</p>
                        <!-- <a href="#" class="mem-apply-btn mem-blue">
                            가입신청 <img src="/assets/img/sub/btn_download_w.png" alt="">
                        </a> -->
                        <a href="/assets/files/join_us_group.hwp"
                            class="mem-apply-btn mem-blue"
                            download>
                            가입신청 <img src="/assets/img/sub/btn_download_w.png" alt="">
                        </a>
                    </div>
                    <div class="mem-card-icon mem-icon-group">
                        <img src="/assets/img/sub/icon_group.png" alt="개인회원">
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="qualify-area">
        <div class="qualify-inner">

            <div class="qualify-left">
                <h2 class="qualify-title">자격 안내</h2>
            </div>

            <div class="qualify-right">
                <h3 class="qualify-subtitle">회원의 종류 및 자격</h3>

                <ul class="qualify-list">
                    <li>회원은 개인회원과 단체회원 및 특별회원으로 구성</li>
                    <li>
                        개인회원은 「금강사지 재해예방에 관한 법률(이하 법)」 제32조
                        제4항에 규정된 자로서 금강사지에 관한 학식과 경험이 풍부한 사람
                    </li>
                    <li>
                        단체회원은 법 제32조 제4항에 규정된 자로서 금강사지 안전관리에
                        관련된 연구단체, 용역단체, 물자의 생산 및 공급 등을 하는 단체
                    </li>
                    <li>
                        특별회원은 개인회원과 단체회원 이외의 자로서 정부, 지방자치단체,
                        금강사지관리기관, 공공기관 및 정부투자기관 등을 포함
                    </li>
                </ul>
                <h3 class="qualify-subtitle dif">회원가입 절차</h3>

                <ul class="qualify-list">
                    <li>협회에 가입하고자 하는 회원은 가입신청서·약력사항 제출 및 회비를 납부 후 이사회의 승인을 받아 회원이 됨(납부일 기준)</li>
                    <li>
                        단체회원의 경우 가입 당시 임직원을 대상으로 가급은 5인, 나급은 3인에 한하여 별도 연회비 없이 개인회원 인정, 퇴사시 자동 탈퇴
                    </li>
                </ul>

                <div class="apply-criteria-wrap">

                    <h3 class="apply-criteria-title">
                        회원별 가입신청서 및 이력사항 작성 기준
                    </h3>

                    <table class="member-apply-table">
                        <colgroup>
                            <col class="col-kind">
                            <col class="col-grade">
                            <col class="col-form">
                            <col class="col-person">
                            <col class="col-org">
                        </colgroup>

                        <thead>
                            <tr>
                                <th colspan="2">구분</th>
                                <th>가입신청서</th>
                                <th>개인 이력사항</th>
                                <th>단체(특별) 이력사항</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td class="td-kind" rowspan="1">개인</td>
                                <td class="td-grade">일반, 종신, 명예</td>
                                <td>작성</td>
                                <td>작성</td>
                                <td></td>
                            </tr>

                            <tr>
                                <td class="td-kind" rowspan="3">단체</td>
                                <td class="td-grade">일반</td>
                                <td>작성</td>
                                <td>대표자 1인 작성</td>
                                <td>작성</td>
                            </tr>
                            <tr>
                                <td class="td-grade">종신 가급</td>
                                <td>작성</td>
                                <td>대표자 외 4인 작성</td>
                                <td>작성</td>
                            </tr>
                            <tr>
                                <td class="td-grade">종신 나급</td>
                                <td>작성</td>
                                <td>대표자 외 2인 작성</td>
                                <td>작성</td>
                            </tr>

                            <tr>
                                <td class="td-kind" rowspan="1">특별</td>
                                <td class="td-grade">정부, 지자체, 기관 등</td>
                                <td>작성</td>
                                <td></td>
                                <td>작성</td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Mobile cards: 가입신청서 작성 기준 -->
                    <div class="m-table-cards">
                        <!-- 개인 -->
                        <div class="m-table-card">
                            <div class="m-table-card-head">개인</div>
                            <div class="m-table-card-body">
                                <div class="m-table-row">
                                    <span class="m-table-label">구분 :</span>
                                    <span class="m-table-value">일반, 종신, 명예</span>
                                </div>
                                <div class="m-table-row">
                                    <span class="m-table-label">가입신청서 :</span>
                                    <span class="m-table-value">작성</span>
                                </div>
                                <div class="m-table-row">
                                    <span class="m-table-label">개인 이력사항 :</span>
                                    <span class="m-table-value">작성</span>
                                </div>
                            </div>
                        </div>

                        <!-- 단체 -->
                        <div class="m-table-card">
                            <div class="m-table-card-head">단체</div>
                            <div class="m-table-card-body">
                                <!-- 일반 -->
                                <div class="m-table-sub-section">
                                    <div class="m-table-row">
                                        <span class="m-table-label">구분 :</span>
                                        <span class="m-table-value">일반</span>
                                    </div>
                                    <div class="m-table-row">
                                        <span class="m-table-label">가입신청서 :</span>
                                        <span class="m-table-value">작성</span>
                                    </div>
                                    <div class="m-table-row">
                                        <span class="m-table-label">개인 이력사항 :</span>
                                        <span class="m-table-value">대표자 1인 작성</span>
                                    </div>
                                    <div class="m-table-row">
                                        <span class="m-table-label">단체(특별) 이력사항 :</span>
                                        <span class="m-table-value">작성</span>
                                    </div>
                                </div>

                                <!-- 종신 가급 -->
                                <div class="m-table-sub-section">
                                    <div class="m-table-row">
                                        <span class="m-table-label">구분 :</span>
                                        <span class="m-table-value">종신 가급</span>
                                    </div>
                                    <div class="m-table-row">
                                        <span class="m-table-label">가입신청서 :</span>
                                        <span class="m-table-value">작성</span>
                                    </div>
                                    <div class="m-table-row">
                                        <span class="m-table-label">개인 이력사항 :</span>
                                        <span class="m-table-value">대표자 외 4인 작성</span>
                                    </div>
                                    <div class="m-table-row">
                                        <span class="m-table-label">단체(특별) 이력사항 :</span>
                                        <span class="m-table-value">작성</span>
                                    </div>
                                </div>

                                <!-- 종신 나급 -->
                                <div class="m-table-sub-section">
                                    <div class="m-table-row">
                                        <span class="m-table-label">구분 :</span>
                                        <span class="m-table-value">종신 나급</span>
                                    </div>
                                    <div class="m-table-row">
                                        <span class="m-table-label">가입신청서 :</span>
                                        <span class="m-table-value">작성</span>
                                    </div>
                                    <div class="m-table-row">
                                        <span class="m-table-label">개인 이력사항 :</span>
                                        <span class="m-table-value">대표자 외 2인 작성</span>
                                    </div>
                                    <div class="m-table-row">
                                        <span class="m-table-label">단체(특별) 이력사항 :</span>
                                        <span class="m-table-value">작성</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 특별 -->
                        <div class="m-table-card">
                            <div class="m-table-card-head">특별</div>
                            <div class="m-table-card-body">
                                <div class="m-table-row">
                                    <span class="m-table-label">구분 :</span>
                                    <span class="m-table-value">정부, 지자체, 기관 등</span>
                                </div>
                                <div class="m-table-row">
                                    <span class="m-table-label">가입신청서 :</span>
                                    <span class="m-table-value">작성</span>
                                </div>
                                <div class="m-table-row">
                                    <span class="m-table-label">단체(특별) 이력사항 :</span>
                                    <span class="m-table-value">작성</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <h3 class="qualify-subtitle dif">회비</h3>

                <ul class="qualify-list">
                    <li>회비는 회원 종류 및 납부방식(종신회비 또는 연회비) 중 하나를 선택(입회비는 없음)</li>
                    <li>
                        단체회원 종신 가급은 임직원 50인 이상 규모, 나급은 50인 미만을 기본으로 하되, 해당 단체의 상황에 따라 선택 가능
                    </li>
                    <li>회비 납부 : 회원 가입신청서 제출자에 한하여 개별 안내 예정</li>
                    <li>
                        개인은 개인명의(요청시 영수증 발행)로 입금하여야 하며, 단체는 단체명의(요청시 계산서 발행)로 입금
                    </li>
                </ul>
                <div class="apply-criteria-wrap">

                    <table class="member-apply-table">


                        <thead>
                            <tr>
                                <th colspan="3">구분</th>
                                <th colspan="2">종신회비 (1회 납부)</th>
                                <th colspan="2">연회비 (매년 납부)</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td class="td-kind" rowspan="3">개인</td>
                                <td colspan="2" class="td-grade">일반회원</td>
                                <!-- <td colspan="2">0원</td> -->
                                <td colspan="2">-</td>
                                <td colspan="2">100,000원</td>
                            </tr>
                            <tr>
                                <td colspan="2" class="td-grade">종신회원</td>
                                <td colspan="2">1,000,000원</td>
                                <!-- <td colspan="2">0원</td> -->
                                <td colspan="2">-</td>
                            </tr>
                            <tr>
                                <td colspan="2" class="td-grade">명예회원</td>
                                <!-- <td colspan="2">0원</td>
                                <td colspan="2">0원</td> -->
                                <td colspan="2">-</td>
                                <td colspan="2">-</td>
                            </tr>

                            <tr>
                                <td class="td-kind" rowspan="3">단체회원</td>
                                <td colspan="2" class="td-grade">일반회원</td>
                                <!-- <td colspan="2">0원</td> -->
                                <td colspan="2">-</td>
                                <td colspan="2">1,000,000원</td>
                            </tr>
                            <tr>
                                <td class="td-grade td-sub" rowspan="2">종신회원</td>
                                <td colspan="" class="td-sub">가급</td>
                                <td colspan="2">10,000,000원</td>
                                <!-- <td colspan="2">0원</td> -->
                                <td colspan="2">-</td>
                            </tr>
                            <tr>
                                <td colspan="" class="td-sub">나급</td>
                                <td colspan="2">5,000,000원</td>
                                <!-- <td colspan="2">0원</td> -->
                                <td colspan="2">-</td>
                            </tr>

                            <tr>
                                <td class="td-kind">특별회원</td>
                                <td colspan="2" class="td-grade">정부, 지자체, 기관 등</td>
                                <!-- <td colspan="2">0원</td> -->
                                <td colspan="2">-</td>
                                <td colspan="2">1,000,000원</td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Mobile cards: 회비 -->
                    <div class="m-table-cards">
                        <!-- 개인 -->
                        <div class="m-table-card">
                            <div class="m-table-card-head">개인</div>
                            <div class="m-table-card-body">
                                <!-- 일반회원 -->
                                <div class="m-table-sub-section">
                                    <div class="m-table-row">
                                        <span class="m-table-label">구분 :</span>
                                        <span class="m-table-value">일반회원</span>
                                    </div>
                                    <div class="m-table-row">
                                        <span class="m-table-label">종신회비 (1회 납부) :</span>
                                        <span class="m-table-value">0원</span>
                                    </div>
                                    <div class="m-table-row">
                                        <span class="m-table-label">연회비 (매년 납부) :</span>
                                        <span class="m-table-value">100,000원</span>
                                    </div>
                                </div>

                                <!-- 종신회원 -->
                                <div class="m-table-sub-section">
                                    <div class="m-table-row">
                                        <span class="m-table-label">구분 :</span>
                                        <span class="m-table-value">종신회원</span>
                                    </div>
                                    <div class="m-table-row">
                                        <span class="m-table-label">종신회비 (1회 납부) :</span>
                                        <span class="m-table-value">1,000,000원</span>
                                    </div>
                                    <div class="m-table-row">
                                        <span class="m-table-label">연회비 (매년 납부) :</span>
                                        <span class="m-table-value">0원</span>
                                    </div>
                                </div>

                                <!-- 명예회원 -->
                                <div class="m-table-sub-section">
                                    <div class="m-table-row">
                                        <span class="m-table-label">구분 :</span>
                                        <span class="m-table-value">명예회원</span>
                                    </div>
                                    <div class="m-table-row">
                                        <span class="m-table-label">종신회비 (1회 납부) :</span>
                                        <span class="m-table-value">0원</span>
                                    </div>
                                    <div class="m-table-row">
                                        <span class="m-table-label">연회비 (매년 납부) :</span>
                                        <span class="m-table-value">0원</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 단체회원 -->
                        <div class="m-table-card">
                            <div class="m-table-card-head">단체회원</div>
                            <div class="m-table-card-body">
                                <!-- 일반회원 -->
                                <div class="m-table-sub-section">
                                    <div class="m-table-row">
                                        <span class="m-table-label">구분 :</span>
                                        <span class="m-table-value">일반회원</span>
                                    </div>
                                    <div class="m-table-row">
                                        <span class="m-table-label">종신회비 (1회 납부) :</span>
                                        <span class="m-table-value">0원</span>
                                    </div>
                                    <div class="m-table-row">
                                        <span class="m-table-label">연회비 (매년 납부) :</span>
                                        <span class="m-table-value">1,000,000원</span>
                                    </div>
                                </div>

                                <!-- 종신회원 가급 -->
                                <div class="m-table-sub-section">
                                    <div class="m-table-row">
                                        <span class="m-table-label">구분 :</span>
                                        <span class="m-table-value">종신회원 가급</span>
                                    </div>
                                    <div class="m-table-row">
                                        <span class="m-table-label">종신회비 (1회 납부) :</span>
                                        <span class="m-table-value">10,000,000원</span>
                                    </div>
                                    <div class="m-table-row">
                                        <span class="m-table-label">연회비 (매년 납부) :</span>
                                        <span class="m-table-value">0원</span>
                                    </div>
                                </div>

                                <!-- 종신회원 나급 -->
                                <div class="m-table-sub-section">
                                    <div class="m-table-row">
                                        <span class="m-table-label">구분 :</span>
                                        <span class="m-table-value">종신회원 나급</span>
                                    </div>
                                    <div class="m-table-row">
                                        <span class="m-table-label">종신회비 (1회 납부) :</span>
                                        <span class="m-table-value">5,000,000원</span>
                                    </div>
                                    <div class="m-table-row">
                                        <span class="m-table-label">연회비 (매년 납부) :</span>
                                        <span class="m-table-value">0원</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 특별회원 -->
                        <div class="m-table-card">
                            <div class="m-table-card-head">특별회원</div>
                            <div class="m-table-card-body">
                                <div class="m-table-row">
                                    <span class="m-table-label">구분 :</span>
                                    <span class="m-table-value">정부, 지자체, 기관 등</span>
                                </div>
                                <div class="m-table-row">
                                    <span class="m-table-label">종신회비 (1회 납부) :</span>
                                    <span class="m-table-value">0원</span>
                                </div>
                                <div class="m-table-row">
                                    <span class="m-table-label">연회비 (매년 납부) :</span>
                                    <span class="m-table-value">1,000,000원</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <h3 class="qualify-subtitle dif">회원 가입 혜택</h3>
                <div class="member-benefit-group">
                    <div class="member-benefit-head">
                        <!-- <input type="radio" name="member_benefit" checked> -->
                        <strong>개인 및 단체회원</strong>
                    </div>

                    <ul class="member-benefit-list">
                        <li>정부, 지방자치단체 및 공공기관 등 급경사지 분야자문·평가위원 우선 추천</li>
                        <li>급경사지 안전관리 관련 용역 공동수행, 참여 및 지원</li>
                        <li>급경사지 전문가 및 현장대응단 인력-POOL 우선 참여</li>
                        <li>회원사 홍보 및 기술 교류 협력을 통한 역량강화</li>
                        <li>급경사지 협회지 및 협회 홈페이지 각종 자료 이용</li>
                        <li>급경사지 관련 세미나 및 워크숍 등 우선 초청</li>
                    </ul>
                </div>
                <div class="member-benefit-group dif">
                    <div class="member-benefit-head">
                        <!-- <input type="radio" name="member_benefit" checked> -->
                        <strong>특별회원</strong>
                    </div>

                    <ul class="member-benefit-list">
                        <li>[급경사지 재해예방에 관한 법률]법 제30조 및 같은 법 시행규칙 제16조와 제17조에 따른 상시계측관리 전문교육과정 : <br>
                            연 1회 1인 한정 강의 제공(관련법에 따라 수료증 발급)</li>
                        <li>[급경사지 재해예방에 관한 법률 시행령]제15조의2에 따른 재해 발생 시 신속한 피해 원인조사 등 현장지원 : 조사 및 전문가 지원</li>
                        <li>[급경사지 재해예방에 관한 법률]법 제20조에 따른 급경사지 통합정보시스템(NDMS) 급경사지 DB관리 : 수정, 삭제 등 지원</li>
                        <li>[급경사지 재해예방에 관한 법률]법 제22조에 따른 계측업 등록 : 행정절차 지원</li>
                        <li>[급경사지 재해예방에 관한 법률]법 제5조, 제6조에 따른 급경사지 안전관리 업무 컨설팅 및 헬프데스크 : 무상 지원</li>
                        <li>[급경사지 재해예방에 관한 법률]법 제5조에 따른 급경사지 안전점검 : 업무 위탁, 대행 비용 할인</li>
                        <li>[급경사지 재해예방에 관한 법률]법 제6조에 따른 급경사지 재해위험도 평가 및 붕괴위험지역 해제 평가 : <br>
                            업무 위탁·대행 비용 할인</li>
                        <li>[급경사지 재해예방에 관한 법률]법 제12조 및 제13조 정비 중기·실시계획 수립을 위한 급경사지 정밀조사(정밀안전진단) : <br>
                            정밀조사 업무 위탁·대행 비용 할인</li>
                        <li>[급경사지 재해예방에 관한 법률]법 제8조에 따른 붕괴위험지역의 계측관리 : 상시계측관리, 모니터링, 유지관리, 검수 및 시운전 <br>
                            업무 위탁·대행 비용 할인</li>
                        <li>급경사지 설계·시공심의 등 급경사지 안전관리 전문인력 Pool 지원</li>
                    </ul>
                </div>
            </div>

        </div>

    </section>





</main>
<script>
    $(function() {
        $(".ci-subtab__item").on("click", function(e) {
            e.preventDefault();

            $(".ci-subtab__item").removeClass("is-active");
            $(this).addClass("is-active");
        });
    });
</script>
<?php $this->endSection(); ?>