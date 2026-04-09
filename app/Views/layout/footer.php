<?php $setting = homeSetInfo(); ?>

<footer id="footer">
    <div class="inner">
        <div class="ft_left">
            <div class="foot_logo">
                <a href="/">
                    <img src="/uploads/home/<?= $setting[''] ?>" alt="<?= $setting['site_name'] ?>" class="only_web">
                    <img src="../img/common/ft_logo_mo.png" alt="한국도선안전교육센터" class="only_mo">
                </a>
            </div>
            <div class="ft_info">
                <ul class="ft_top">
                    <li><a href="/contact/contact_terms.php">이용약관</a></li>
                    <li><a href="/contact/contact_policy.php">개인정보 처리방침</a></li>
                    <li><a href="/AdmMaster/">관리자로그인</a></li>
                </ul>
                <address class="add_web">
                    <div>
                        <dl>
                            <dd><?= $setting['home_name'] ?></dd>
                        </dl>
                        <dl>
                            <dt>주소</dt>
                            <dd>
                                <?= "(" . $setting['zip'] . ") " . $setting['addr1'] . " " . $setting['addr2'] ?>
                            </dd>
                        </dl>
                    </div>
                    <div>
                        <dl>
                            <dt>TEL</dt>
                            <dd>
                                <?= $setting['custom_phone'] ?>
                            </dd>
                        </dl>
                        <dl>
                            <dt>FAX</dt>
                            <dd><?= $setting['fax'] ?> </dd>
                        </dl>
                        <dl>
                            <dt>이메일</dt>
                            <dd><?= $setting['admin_email'] ?></dd>
                        </dl>
                    </div>
                    <p class="copy">
                        <?= $setting['buytext'] ?>
                    </p>
                </address>

                <address class="add_mo">
                    <dl>
                        <dd><?= $setting['home_name'] ?></dd>
                    </dl>
                    <div>
                        <p>주소 : <?= "(" .  $setting['zip'] . ") " . $setting['addr1'] . " " . $setting['addr2'] ?></p>
                    </div>
                    <div>
                        <dl>
                            <dt>Tel</dt>
                            <dd>
                                <?= $setting['custom_phone'] ?>
                            </dd>
                        </dl>
                        <dl>
                            <dt>Fax</dt>
                            <dd><?= $setting['fax'] ?> </dd>
                        </dl>
                    </div>
                    <div>
                        <p>이메일 : <?= $setting['admin_email'] ?></p>
                    </div>
                    <p class="copy">
                        <?= $setting['buytext'] ?>
                    </p>
                </address>
            </div>
        </div>
        <div class="footer_end">
            <p>패밀리사이트</p>
            <a href="https://www.kmpilot.or.kr/"
               onclick="window.open('https://www.kmpilot.or.kr/', '_blank'); return false;">
                <img class="only_web" src="/img/main/logo_ft_new.png"></a>
            <img class="only_mo" src="/img/main/logo_ft_mo.png">
        </div>
    </div>
</footer>