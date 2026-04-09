<?
$site = homeSetInfo();
?>

<div class="floating-buttons">
    <div class="floating-btn floating-btn--scroll" style="display: flex;"></div>
</div>

<footer class="footer-kssa">

    <div class="footer-kssa-top">
        <div class="footer-kssa-wrap">

            <ul class="footer-kssa-links">
                <li><a href="#">이용약관</a></li>
                <li><a href="#">개인정보처리방침</a></li>
                <!-- <li><a href="#">이메일주소무단수집거부</a></li> -->
                <li><a href="/greeting"></a>협회소개</li>
            </ul>

            <div class="footer-kssa-sns">
                <a href="#" aria-label="youtube">
                    <img src="/assets/img/footer/ico_youtube.png" alt="youtube">
                </a>
                <a href="#" aria-label="blog">
                    <img src="/assets/img/footer/ico_blog.png" alt="blog">
                </a>
            </div>

        </div>
    </div>

    <div class="footer-kssa-main">
        <div class="footer-kssa-wrap footer-kssa-main-wrap">

            <div class="footer-kssa-info">
                <img src="<?= base_url('uploads/home/' . $site['logo_footer']) ?>" alt="KSSA" class="footer-kssa-logo">

                <p class="info_text only_web">
                    한국급경사지안전협회 | 대표자 : 전상률 | 사업자등록번호 : 505-82-12007<br>
                    전화번호 : 044-868-5680 | 팩스번호 : 044-868-5681 | E-Mail : korea-slope@naver.com<br>
                    주소 : 세종특별자치시 나성북로 21, 센트럴타워 8층
                </p>
                <p class="info_text only_mo">
                    한국급경사지안전협회 <br>
                    대표자명 : 진상률 <br>
                    사업자등록번호 : 505-82-12007 <br>
                    전화번호 : 044-868-5680 <br>
                    팩스번호 : 044-868-5681 <br>
                    E-Mail : korea-slope@naver.com <br>
                    주소 : 세종특별자치시 나성북로 21, 센트럴타워 8층
                </p>

                <p class="footer-kssa-copy">
                    Copyright (c) 한국급경사지안전협회. All rights reserved.
                </p>
                <div class="footer-kssa-sns-mo dif">
                    <a href="#" aria-label="youtube">
                        <img src="/assets/img/footer/ico_youtube.png" alt="youtube">
                    </a>
                    <a href="#" aria-label="blog">
                        <img src="/assets/img/footer/ico_blog.png" alt="blog">
                    </a>
                </div>
            </div>

          <div class="footer-kssa-site">
    <select onchange="if(this.value) window.open(this.value, '_blank')">
        <option value="">관련사이트</option>
        <option value="/main_tasks">업무 안내</option>
        <option value="/notice">알림마당</option>
        <option value="/greeting">협회 소개</option>
        <option value="/sign_up_instructions">회원 안내</option>
        <option value="/training_information">계측전문인력 교육</option>
    </select>
</div>

        </div>
    </div>

</footer>


<!-- <div class="top_btn" id="top_btn">
    <a href="#wrap"><img src="/img/btn/top_btn.png" alt="화살표이미지"></a>
    <script>
        $(function () {
            $(window).scroll(function () {
                var $el = $('.top_btn');

                if ($(this).scrollTop() >= 1000) $el.addClass('shown');
                else $el.removeClass('shown');
            });
        });
    </script>
</div> -->
</div>

<script type="text/javascript">
    (function() {
        var user_ip = '';
        var pop_count = 0;

        function favorite_set(mode, idx) {
            return $.ajax({
                type: 'POST',
                url: '<?= base_url('ajax/portfolio/favorite_set') ?>',
                data: {
                    mode: mode,
                    idx: idx,
                    user_ip: user_ip
                },
                cache: false
            });
        }

        function favorite_list() {
            return $.ajax({
                type: 'POST',
                url: '<?= base_url('ajax/portfolio/favorite_list.php') ?>',
                data: {
                    mode: 'list'
                },
                cache: false
            }).done(function(data) {
                if (!data || data === '0') {
                    $('.potfolio_pop_list li').remove();
                    $('.sub_title span').text('0');
                    $('.add_num span').text('0');
                    $('.potfolio_favorite .add_num img').attr('src', '<?= base_url('assets/img/ico/non_heart.png') ?>');
                    return;
                }

                $('.potfolio_pop_list li').remove();
                $('.potfolio_pop_list').append(data);

                pop_count = $('.potfolio_pop_list li').length;
                $('.add_num span').text(pop_count);
                $('.sub_title span').text(pop_count);
                $('.potfolio_favorite .add_num img').attr('src', '<?= base_url('assets/img/ico/favorite_heart.png') ?>');
            });
        }

        $(function() {
            user_ip = '<?= esc(service('request')->getIPAddress()) ?>';
            if ($('#potfolio_pop').length) {
                favorite_list();
            }
        });

        $(document).on('click', '.social_box .favorite_add', function(e) {
            e.preventDefault();
            var $btn = $(this);
            var idx = parseInt($btn.attr('fa_idx'), 10) || 0;
            if (!idx) return;

            var mode = $btn.hasClass('active') ? 'del' : 'add';
            favorite_set(mode, idx).done(function(num) {
                if (mode === 'del') {
                    $btn.removeClass('active');
                } else {
                    $btn.addClass('active');
                }

                if (num !== undefined && num !== null) {
                    $('.add_num span').text(num);
                }
                favorite_list();
            });
        });

        $(document).on('click', '#potfolio_pop b.close, .layer_bg', function(e) {
            e.preventDefault();
            $('#potfolio_pop').removeClass('block');
            $('.layer_bg').hide();
        });

        $(document).on('click', 'ul.potfolio_favorite > li > p.add_num', function(e) {
            e.preventDefault();
            $('.potfolio_pop_list li').remove();
            favorite_list();
            $('#potfolio_pop').addClass('block');
            $('.layer_bg').show();
        });

        $(document).on('click', '.potfolio_pop_list .delete img', function(e) {
            e.preventDefault();
            var idx = parseInt($(this).attr('fa_idx'), 10) || 0;
            if (!idx) return;

            favorite_set('del', idx).done(function() {
                favorite_list();
                $('.list-content').each(function() {
                    var $fa = $(this).find('.favorite_add');
                    if (parseInt($fa.attr('fa_idx'), 10) === idx) {
                        $fa.removeClass('active');
                    }
                });
            });
        });

        $(document).on('click', '.share-facebook', function(e) {
            e.preventDefault();
            var r_idx = $(this).attr('r_idx');
            if (!r_idx) return;
            var url = '<?= base_url('portfolio/portfolio_list_view.php') ?>?idx=' + encodeURIComponent(r_idx);
            url = 'https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(url);
            window.open(url, 'win_facebook', 'menubar=1,resizable=1,width=600,height=400');
        });

        $(document).on('click', '.share-twitter', function(e) {
            e.preventDefault();
            var url = $(this).attr('link_url') || '';
            if (!url) return;
            url = 'https://twitter.com/intent/tweet?text=[%EA%B3%B5%EC%9C%A0]%20=' + encodeURIComponent(url) + '%20-%20' + encodeURIComponent(document.title);
            window.open(url, 'win_twitter', 'menubar=1,resizable=1,width=600,height=400');
        });
    })();
</script>
<script>
    $(".agree").click(function(e) {
        e.preventDefault()
        $(".inquiry_box").show();
        $(".agree_layer").show();
        $(".inquiry_box").children(".inquiry_wrap").hide();
    });
    $(".btn_small_layer_close").click(function(e) {
        e.preventDefault()
        $(".agree_layer").hide();
        $(".inquiry_box").hide();
    });

    $((window)).load(function() {
        // 하단배너

        setTimeout(function() {
            $('.bottom_banner').addClass('shown');
        }, 0);

        $('.bottom_banner_slider').slick({
            autoplay: true,
            speed: 1000,
            vertical: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            verticalSwiping: true,
            dots: false,
            arrows: false
        });

        $('.bottom_banner .btn_closed').on('click', function() {
            $('.bottom_banner').toggleClass('shown');
        });
    });
</script>

<script type="text/javascript">
    var sc_project = 12915632;
    var sc_invisible = 1;
    var sc_security = "3d9de263";
</script>
<script type="text/javascript" src="https://www.statcounter.com/counter/counter.js" async></script>
<noscript>
    <div class="statcounter"><a title="Web Analytics" href="https://statcounter.com/" target="_blank"><img class="statcounter" src="https://c.statcounter.com/12915632/0/3d9de263/1/" alt="Web Analytics" referrerPolicy="no-referrer-when-downgrade"></a></div>
</noscript>

</body>

</html>