<?php
$setting = homeSetInfo();
?>
<!DOCTYPE HTML>
<html lang="ko">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
    <meta name="viewport"
          content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0 user-scalable=no">
    <meta name="format-detection" content="telephone=no"/>
    <meta http-equiv="Content-Script-Type" content="text/javascript"/>
    <meta http-equiv="Content-Style-Type" content="text/css"/>

    <meta name="author" content="유월커뮤니케이션">
    <meta property="og:description" content="<?= $setting['og_des'] ?>">
    <meta name="subject" content="<?= $setting['og_site'] ?>">
    <meta name="description" content="<?= $setting['og_des'] ?>">
    <meta name="keywords" content="<?= $setting['meta_keyword'] ?>">

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

    <link href="/uploads/home/<?= $setting['favico_img'] ?>" rel="icon" type="image/x-icon">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.css">

    <script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
    
    <link href="<?= base_url('assets/css/slick02.css') ?>" rel="stylesheet" type="text/css"/>
    <link href="<?= base_url('assets/css/common.css') ?>" rel="stylesheet" type="text/css"/>
    <link href="<?= base_url('assets/css/main.css') ?>" rel="stylesheet" type="text/css"/>
    <link href="<?= base_url('assets/css/sub.css') ?>" rel="stylesheet" type="text/css"/>
    <link href="<?= base_url('assets/css/member.css') ?>" rel="stylesheet" type="text/css"/>
    <link href="<?= base_url('assets/css/mypage.css') ?>" rel="stylesheet" type="text/css"/>

    <link href="<?= base_url('assets/css/coin.css') ?>" rel="stylesheet" type="text/css"/>
    <link href="<?= base_url('assets/css/animate.min.css') ?>" rel="stylesheet" type="text/css"/>
    <link href="<?= base_url('assets/css/swiper.min.css') ?>" rel="stylesheet" type="text/css"/>
    <link href="<?= base_url('assets/css/aos.css') ?>" rel="stylesheet" type="text/css"/>
    <link href="<?= base_url('assets/css/utilities/font.css') ?>" rel="stylesheet" type="text/css"/>
    <?php
    $path = (string)service('uri')->getPath();
    if (in_array($path, ['about/landing', 'about/s_landing.php', 'about/s_website.php', 'about/s_tour.php', 'about/s_detail.php'], true)) {
        echo '<link href="' . base_url('assets/css/landing.css') . '" rel="stylesheet" type="text/css"/>';
    }

    if (in_array($path, ['about/vietnam', 'about/recruite.php'], true)) {
        echo '<link href="' . base_url('assets/css/coin.css') . '" rel="stylesheet" type="text/css"/>';
    }
    ?>

    <script src="<?= base_url('assets/js/jquery-1.12.4.min.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/jquery-ui.min.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/slick.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/swiper.min.js') ?>" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js"></script>
    <script src="<?= base_url('assets/js/wow.min.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/isotope.pkgd.min.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/scroll.min.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/tween.min.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/gsap.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/js/aos.js') ?>" type="text/javascript"></script>

    <script src="//cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.7/ScrollMagic.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.7/plugins/debug.addIndicators.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/gsap/2.1.3/TweenMax.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.5/plugins/animation.gsap.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/lang/summernote-ko-KR.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://player.vimeo.com/api/player.js"></script>
    <script src="<?= base_url('assets/js/script.js') ?>" type="text/javascript"></script>

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
</head>