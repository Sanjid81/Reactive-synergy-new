<?php

defined('ABSPATH') || exit;

$logo_id = function_exists('carbon_get_theme_option') ? carbon_get_theme_option('site_logo') : 0;
$button_text = function_exists('carbon_get_theme_option') ? carbon_get_theme_option('header_button_text') : '';
$button_link = function_exists('carbon_get_theme_option') ? carbon_get_theme_option('header_button_link') : '';
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script>document.documentElement.classList.add("has-motion");</script>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php if (mastrade_has_content(array($logo_id, $button_text)) || has_nav_menu('primary')) : ?>
<header class="site-header">
    <div class="header-bar">
        <a class="site-logo" href="<?php echo esc_url(home_url('/')); ?>">
            <?php
            if ($logo_id) {
                echo wp_get_attachment_image($logo_id, 'full', false, array('alt' => esc_attr(get_bloginfo('name'))));
            } else {
                echo esc_html(get_bloginfo('name'));
            }
            ?>
        </a>
        <button class="nav-toggle" type="button" aria-expanded="false" aria-controls="site-nav" aria-label="<?php esc_attr_e('Menu', 'mastrade'); ?>">
            <span></span>
        </button>
        <div class="header-nav" id="site-nav">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'container' => false,
                'menu_class' => 'menu navbar-text',
                'fallback_cb' => false,
            ));
            ?>
            <?php if ($button_text && $button_link) : ?>
                <a class="btn button-text header-button" href="<?php echo esc_url($button_link); ?>"><?php echo esc_html($button_text); ?></a>
            <?php endif; ?>
        </div>
    </div>
</header>
<?php endif; ?>

<main class="site-main">
