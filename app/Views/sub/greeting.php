<?php $this->extend('inc/layout_index'); ?>
<?php $this->section('styles'); ?>
    <link rel="stylesheet" href="/assets/css/pages/subs/greeting.css">
<?php $this->endSection(); ?>
<?php $this->section('content'); ?>
<main id="container" class="main main_new">
    <section class="ci-intro dif">

        <div class="ci-bc">
            <a href="#" class="ci-bc__item">HOME</a>
            <a href="#" class="ci-bc__item">협회 소개</a>

            <a href="#" class="ci-bc__item ci-bc__item--select">
                협회인사말
                <img class="ci-bc__ico" src="/assets/img/sub/ico_select_down.png" alt="">
            </a>
        </div>

        <h1 class="ci-title">협회인사말</h1>

        <nav class="ci-tab">
            <a href="/greeting" class="is-active">협회 인사말</a>
            
            <a href="/history">설립 목적 및 연혁</a>
            <a href="/vision">비전</a>
            <a href="/organization_guide">조직 안내</a>
            <a href="/ci_introduction">CI 소개</a>
            <a href="/past_presidents">역대회장</a>
            <a href="/directions">오시는 길</a>
        </nav>

        <div class="ci-visual">
            <img src="/assets/img/sub/ci_visual.png" alt="">
            <div class="ci-visual-text">
                
                <p class="text-en">About k-slope</p>
                <p class="text-en-small">Korea Slope Safety Association</p>
            </div>
        </div>

    </section>
    <section class="chairman-message">

        <div class="message-box">
            <div class="message-text">
                <span class="message-badge">회장님 Message</span>

                <p class="message-title">
                    안녕하십니까,<br>
                    <strong>한국급경사지안전협회</strong>의 홈페이지<br>
                    방문을 진심으로 환영합니다.
                </p>
            </div>
        </div>

        <!-- letter content -->
        <div class="message-content">
            <p>
                한국급경사지안전협회는 급경사지 재해예방에 관한 법률 제32조의2에 따라 2020년에 <br>
                설립된 특수법인입니다.
            </p>

            <p>
                우리나라는 산지비율(72%, KOSIS)이 매우 높아 지형 특성상의 자연비탈면 급경사지 뿐만 아니라 <br>
                도시화와 산업화의 영향으로 만들어진 도로, 택지 등의 인공비탈면 급경사지에서 해마다 태풍과 <br>
                집중호우로 인한 피해가 지속적으로 발생하고 있습니다. <br>
                이에 「한국급경사지안전협회」는 급경사지에 대한 재해예방활동, 조사, 점검, 평가 및 계측 등의 <br>
                전문기관으로서 거듭 태어나기 위해 다음의 사항을 노력하겠습니다.
            </p>

            <p>
                첫째, 「급경사지 재해예방에 관한 법률」의 개정을 통해 협회의 위탁업무를 확대하여 협회 발전의 <br>
                안정적인 기틀을 마련하겠습니다.
            </p>

            <p>
                둘째, 「전국 급경사지 실태조사」의 지속 추진으로 증가하는 급경사지 관리지역의 안전점검,<br>
                정밀진단 등 정부 및 지방자치단체 지원을 위한 협회의 전문성을 강화하겠습니다.
            </p>

            <p>
                셋째, 급경사지 관리 DB와 상시계측관리를 하나로 통합하는 「급경사지 통합 플렛폼」을 구축하여<br>
                급경사지 DB 관리의 효율성 및 계측 예·경보의 신뢰성 향상 등 급경사지 정보체계를 고도화하여<br>
                국민의 인명 및 재산피해 저감을 도모하겠습니다.
            </p>

            <p>
                마지막으로, 「한국급경사지안전협회」는 정부, 지방자치단체, 급경사지 관련 기관 및 회원 간의<br>
                소통과 협력을 통해 급경사지 분야 성장과 발전에 최선을 다하겠습니다.
            </p>

            <p>
                감사합니다.
            </p>
            <div class="wrap_signature">
                <p class="signature">
                    특수법인 한국급경사지안전협회 회장
                </p>
                <img src="/assets/img/sub/signature_img.png" alt="">
            </div>
        </div>

        <div class="message-deco">
            <img src="/assets/img/sub/mountain_line.png" alt="">
        </div>

    </section>



</main>
<?php $this->endSection(); ?>