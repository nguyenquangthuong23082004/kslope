<!DOCTYPE HTML>
<html lang="ko">
<?php $setting = homeSetInfo(); ?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
    <meta name="viewport"
          content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0 user-scalable=no">
    <meta name="format-detection" content="telephone=no"/>
    <meta http-equiv="Content-Script-Type" content="text/javascript"/>
    <meta http-equiv="Content-Style-Type" content="text/css"/>
    <meta name="author" content="유월커뮤니케이션">
    <meta property="og:description" content="홈페이지제작,쇼핑몰제작,어플리케이션제작, 상세세페이지제작,사진촬영,마케팅까지 온라인에 필요한 모든것을 유월커뮤니케이션과 함께하세요">
    <meta name="subject" content="홈페이지제작,쇼핑몰제작,어플리케이션제작, 상세세페이지제작,사진촬영,마케팅까지 온라인에 필요한 모든것을 유월커뮤니케이션과 함께하세요 ">
    <meta name="description" content="홈페이지제작,쇼핑몰제작,어플리케이션제작, 상세세페이지제작,사진촬영,마케팅까지 온라인에 필요한 모든것을 유월커뮤니케이션과 함께하세요">
    <meta name="keywords"
          content="홈페이지제작,홈페이지구축,홈페이지비용,모바일웹,모바일앱,모바일웹제작,모바일앱제작,어플리케이션,상세세페이지제작,사진촬영,마케팅,랜딩페이지,랜딩페이지제작,네이티브앱,하이브리드앱,쇼핑몰제작,쇼핑몰,기업홈페이지,기업홈페이지제작,반응형웹,반응형웹제작,웹표준코딩,웹표준코딩제작,로고디자인,브로슈어,리플렛,카다로그">

    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">

    <!-- SITE -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="한국급경사지안전협회">
    <meta property="og:url" content="<?= $setting['og_url'] ?>">
    <meta property="og:title" content="<?= $setting['og_title'] ?>">
    <meta property="og:image" content="/uploads/home/<?= $setting['og_img'] ?>">

    <!-- Twitter(X) -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= $setting['og_title'] ?>">
    <meta name="twitter:description" content="<?= $setting['og_des'] ?>">
    <meta name="twitter:image" content="/uploads/home/<?= $setting['og_img'] ?>">

    <!-- App Links (필요할 때만 유지) -->
    <meta property="al:web:url" content="<?= $setting['og_url'] ?>">

    <link rel="canonical" href="<?= $setting['og_url'] ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.css">

    <link href="/uploads/home/<?= $site['favico_img'] ?>" rel="icon" type="image/x-icon">

    <link href="<?= base_url('css/slick02.css') ?>" rel="stylesheet" type="text/css"/>
    <link href="<?= base_url('css/common.css') ?>" rel="stylesheet" type="text/css"/>
    <link href="<?= base_url('css/main.css') ?>" rel="stylesheet" type="text/css"/>
    <link href="<?= base_url('css/sub.css') ?>" rel="stylesheet" type="text/css"/>
    <link href="<?= base_url('css/animate.min.css') ?>" rel="stylesheet" type="text/css"/>
    <link href="<?= base_url('css/swiper.min.css') ?>" rel="stylesheet" type="text/css"/>
    <link href="<?= base_url('css/aos.css') ?>" rel="stylesheet" type="text/css"/>
    <link href="<?= base_url('css/new_header.css') ?>" rel="stylesheet" type="text/css"/>

    <script src="<?= base_url('js/jquery-1.12.4.min.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('js/jquery-ui.min.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('js/slick.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('js/swiper.min.js') ?>" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js"></script>
    <script src="<?= base_url('js/wow.min.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('js/isotope.pkgd.min.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('js/scroll.min.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('js/tween.min.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('js/gsap.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('js/aos.js') ?>" type="text/javascript"></script>

    <script src="//cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.7/ScrollMagic.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.7/plugins/debug.addIndicators.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/gsap/2.1.3/TweenMax.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.5/plugins/animation.gsap.js"></script>

    <script src="<?= base_url('js/script.js') ?>" type="text/javascript"></script>

    <title><?= $setting['browser_title'] ?></title>

    <script type="text/javascript">
        var protect_id = 'c271';
    </script>
    <script type="text/javascript" src="//script.boraware.kr/protect_script.js"></script>

    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-502834144"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());
        gtag('config', 'AW-502834144');
    </script>

    <script>
        gtag('event', 'conversion', {
            'send_to': 'AW-502834144/kFWXCJb1lfYBEODH4u8B'
        });
    </script>

    <span itemscope="" itemtype="http://schema.org/Organization">
        <link itemprop="url" href="https://uwal.co.kr">
        <a itemprop="sameAs" href="https://www.facebook.com/uwal.co.kr"></a>
        <a itemprop="sameAs" href="https://blog.naver.com/uwalworks"></a>
        <a itemprop="sameAs" href="https://www.instagram.com/uwalworks"></a>
    </span>
</head>