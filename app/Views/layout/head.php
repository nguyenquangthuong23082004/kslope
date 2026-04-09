<?php $setting = homeSetInfo(); ?>

<meta name="format-detection" content="telephone=no"/>
<meta property="og:title" content="<?= $setting['og_title'] ?>">
<meta property="og:site_name" content="<?= $setting['og_site'] ?>">
<meta property="og:description" content="<?= $setting['og_des'] ?>">
<meta property="og:url" content="<?= $setting['og_url'] ?>">
<meta property="og:image" content="/uploads/home/<?= $setting['og_img'] ?>">
<meta content="<?= $setting['meta_keyword'] ?>" name="Keyword">
<meta content="<?= $setting['meta_tag'] ?>" name="Title"/>
<meta content="<?= $setting['og_des'] ?>" name="description"/>
<link rel="canonical" href="<?= $setting['og_url'] ?>">

<!-- 개발 추가-->
<script src="/js/jquery-1.12.4.min.js" type="text/javascript"></script>
<script src="/js/jquery.validate.min.js"></script>
<script src="/js/additional-methods.min.js"></script>
<script src="/js/messages_ko.min.js"></script>
<script src="/js/formChk.js"></script>

<script src="/js/swiper.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js"></script>
<script src="//code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script src="/js/jquery.counterup.min.js" type="text/javascript"></script>
<script src="/js/session.js" type="text/javascript"></script>
<script src="/js/common.js" type="text/javascript"></script>
<script src="/js/script.js" type="text/javascript"></script>

<!-- 다음 우편번호 -->
<script src="https://ssl.daumcdn.net/dmaps/map_js_init/postcode.v2.js"></script>
<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>

<link href="/uploads/home/<?= $setting['favico_img'] ?>" rel="icon" type="image/x-icon">
<link href="/css/reset.css" rel="stylesheet" type="text/css"/>
<link href="/css/common.css" rel="stylesheet" type="text/css"/>
<link href="/css/sub.css" rel="stylesheet" type="text/css"/>
<link href="/css/fonts.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>