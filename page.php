<?php

defined('ABSPATH') || exit;

get_header();

while (have_posts()) :
    the_post();
    $product = function_exists('mastrade_current_product') ? mastrade_current_product() : null;
    if ($product) {
        include THEME_DIR . '/components/page/catalog.php';
    } else {
        the_content();
    }
endwhile;

get_footer();
