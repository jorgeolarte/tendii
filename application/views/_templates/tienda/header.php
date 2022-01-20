<!doctype html>
<html class="no-js" lang="es">

<head>
    <script>
        dataLayer = [];
    </script>
    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-N437HC3');
    </script>
    <!-- End Google Tag Manager -->

    <meta charset="utf-8">
    <title><?= $title ?> - Tienda Emprendedores</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="domicilio, tienda emprendedores, emprendedores cartago, valle del cauca, tortas a domicilio, d1 domicilios, hamburguesas, comida, cartago, mercados a domicilio, mercado a domicilio en cartago, carne, domicilio de mercado">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= asset_url(); ?>css/theme.css">
    <link rel="stylesheet" href="<?= asset_url(); ?>css/animate.min.css">
    <!-- <link rel="stylesheet" href="<?= asset_url(); ?>css/snowflake.css"> -->
    <!-- <link rel="stylesheet" href="<?= asset_url(); ?>css/floating-wpp.min.css"> -->
    <link rel="stylesheet" href="<?= base_url('assets/css/jquery.filer.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/jquery.filer-dragdropbox-theme.css'); ?>">
    <link rel="stylesheet" href="<?= asset_url(); ?>css/main.css">

    <link rel="icon" href="<?= asset_url(); ?>img/favicon.ico">

    <!-- Open Graph data -->
    <meta property="og:title" content="<?= $title ?> - Tienda Emprendedores">
    <meta property="og:type" content="website">

    <?php
    // Valida si la imagen fue cargada, sino carga la por defecto
    $thumb_url = (isset($thumbnail)) ? base_url() . "assets/img/$thumbnail?v=" . time() : base_url() . "assets/img/thumbnail.jpg?v=" . time();
    $thumb_urls = (isset($thumbnail)) ? base_url() . "assets/img/$thumbnail?v=" . time() : base_url() . "assets/img/thumbnail.jpg?v=" . time();
    ?>

    <meta property="fb:app_id" content="2838970696193160" />
    <meta property="og:image" itemprop="image" content="<?= $thumb_url ?>">
    <meta property="og:image:secure_url" itemprop="image" content="<?= $thumb_urls ?>">
    <meta property="og:image:type" content="image/jpeg" />
    <meta property="og:url" content="<?= current_url() ?>">
    <meta property="og:description" content="<?= $descripcion ?>">
    <meta property="og:image:alt" content="<?= $descripcion ?>" />
    <meta property="og:locale" content="es_es">
    <meta property="og:site_name" content="Tienda Emprendedores">
    <meta property="og:updated_time" content="1546705013">

    <link rel="base" href="<?= base_url(); ?>">
    <link rel="canonical" href="<?= current_url() ?>">
    <link rel="manifest" href="<?= asset_url(); ?>manifest.json">
    <link rel="shortcut icon" href="<?= asset_url(); ?>favicon.ico">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= asset_url(); ?>img/favicon-16x16.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= asset_url(); ?>img/favicon-32x32.png">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="Tienda Emprendedores">
    <link rel="apple-touch-startup-image" href="<?= asset_url(); ?>img/splash/launch-640x1136.png" media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)">
    <link rel="apple-touch-startup-image" href="<?= asset_url(); ?>img/splash/launch-750x1294.png" media="(device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)">
    <link rel="apple-touch-startup-image" href="<?= asset_url(); ?>img/splash/launch-1125x2436.png" media="(device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)">
    <link rel="apple-touch-startup-image" href="<?= asset_url(); ?>img/splash/launch-1242x2148.png" media="(device-width: 414px) and (device-height: 736px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)">
    <link rel="apple-touch-startup-image" href="<?= asset_url(); ?>img/splash/launch-1536x2048.png" media="(min-device-width: 768px) and (max-device-width: 1024px) and (-webkit-min-device-pixel-ratio: 2) and (orientation: portrait)">
    <link rel="apple-touch-startup-image" href="<?= asset_url(); ?>img/splash/launch-1668x2224.png" media="(min-device-width: 834px) and (max-device-width: 834px) and (-webkit-min-device-pixel-ratio: 2) and (orientation: portrait)">
    <link rel="apple-touch-startup-image" href="<?= asset_url(); ?>img/splash/launch-2048x2732.png" media="(min-device-width: 1024px) and (max-device-width: 1024px) and (-webkit-min-device-pixel-ratio: 2) and (orientation: portrait)">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= asset_url(); ?>img/apple-icon-180x180.png">
    <link rel="apple-touch-icon" sizes="57x57" href="<?= asset_url(); ?>img/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?= asset_url(); ?>img/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?= asset_url(); ?>img/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?= asset_url(); ?>img/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?= asset_url(); ?>img/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?= asset_url(); ?>img/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?= asset_url(); ?>img/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?= asset_url(); ?>img/apple-icon-152x152.png">
    <link rel="icon" type="image/png" sizes="192x192" href="<?= asset_url(); ?>img/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?= asset_url(); ?>img/favicon-96x96.png">
    <meta name="msapplication-TileColor" content="#128C7E">
    <meta name="msapplication-TileImage" content="<?= asset_url(); ?>img/ms-icon-144x144.png">
    <meta name="theme-color" content="#128C7E">
    <script src="<?= asset_url(); ?>js/jquery-3.4.0.min.js"></script>
</head>

<body class="animated fadeIn slower">
    <!--[if IE]>
		<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a ref="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
	<![endif]-->
    <!-- Navbar -->