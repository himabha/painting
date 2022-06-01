<?php
if (! defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

$logo_img = get_theme_mod('image_logo'); // Getting from option your choice.
$sticky_logo_img = get_theme_mod('image_sticky_header_logo'); // Getting from option your choice.
if (! $sticky_logo_img) {
    $sticky_logo_img = $logo_img;
}

$layout_site_default = 'wide';
$layout_site = get_theme_mod('layout_site', $layout_site_default);
if (empty($layout_site) || ! in_array($layout_site, array( 'wide', 'boxed' ))) {
    $layout_site = $layout_site_default;
}

?>
<!DOCTYPE html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" <?php language_attributes(); ?>>
<!--<![endif]-->

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php wp_title('|', true, 'right'); ?></title>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <!--[if lt IE 7]><p class="chromeframe">Your browser is <em>ancient!</em>
	<a href="http://browsehappy.com/">Upgrade to a different browser</a> or
	<a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.
</p><![endif]-->

    <div id="container" class="<?php echo esc_attr(str_replace('_', '-', $layout_site)); ?>">

        <header>
            <nav class="navbar navbar-expand-lg navbar-light header-background">
                <div class="container-fluid">
                    <a class="navbar-brand" href="/">N</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                        <div class="navbar-nav">
                            <a class="nav-link active" aria-current="page" href="#"><i class="fab fa-facebook-f"></i></a>
                            <a class="nav-link" href="#"><i class="fab fa-instagram"></i></a>
                            <a class="nav-link" href="#">גיצירת תמונה חדשה/ </a>
                            <a class="nav-link" href="#">גלריית אומנות</a>
                            <a class="nav-link" href="#"><i class="far fa-heart"></i></a>
                            <a class="nav-link" href="#"><i class="fas fa-shopping-cart"></i></a>
                        </div>
                    </div>
                </div>
            </nav>
        </header>

        <div id="primary" role="document">
            <div class="<?php echo WRAP_CLASSES; ?>">
                <div id="content" class="<?php echo CONTAINER_CLASSES; ?>">