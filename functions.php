<?php

defined('ABSPATH') || exit;

define('THEME_DIR', get_template_directory());
define('THEME_URI', get_template_directory_uri());

function theme_setup()
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('editor-styles');
    add_editor_style('assets/css/editor-blocks.css');
    add_theme_support('align-wide');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));

    register_nav_menus(array(
        'primary' => __('Primary Menu', 'mastrade'),
        'footer' => __('Footer Menu', 'mastrade'),
    ));

    $autoload = THEME_DIR . '/vendor/autoload.php';
    if (file_exists($autoload)) {
        require_once $autoload;
    }

    if (class_exists('\Carbon_Fields\Carbon_Fields')) {
        \Carbon_Fields\Carbon_Fields::boot();
    }
}
add_action('after_setup_theme', 'theme_setup');

require_once THEME_DIR . '/inc/helpers.php';
require_once THEME_DIR . '/inc/theme-options.php';
require_once THEME_DIR . '/inc/blocks.php';
require_once THEME_DIR . '/inc/contact.php';
require_once THEME_DIR . '/inc/seed.php';
require_once THEME_DIR . '/inc/page-seed.php';
require_once THEME_DIR . '/inc/catalog.php';
require_once THEME_DIR . '/inc/projects.php';
require_once THEME_DIR . '/inc/blog.php';

function theme_enqueue_assets()
{
    $css_path = THEME_DIR . '/dist/app.css';
    $js_path  = THEME_DIR . '/dist/app.js';

    wp_enqueue_style('theme-style', get_stylesheet_uri(), array(), '1.0.0');

    if (file_exists($css_path)) {
        wp_enqueue_style('app-style', THEME_URI . '/dist/app.css', array(), filemtime($css_path));
    }

    if (file_exists($js_path)) {
        wp_enqueue_script('app-js', THEME_URI . '/dist/app.js', array(), filemtime($js_path), true);
    }
}
add_action('wp_enqueue_scripts', 'theme_enqueue_assets');

function theme_editor_block_borders()
{
    $path = THEME_DIR . '/assets/css/editor-blocks.css';
    if (!file_exists($path)) {
        return;
    }

    wp_enqueue_style(
        'theme-editor-blocks',
        THEME_URI . '/assets/css/editor-blocks.css',
        array(),
        filemtime($path)
    );
}
add_action('enqueue_block_editor_assets', 'theme_editor_block_borders');
