<?php

defined('ABSPATH') || exit;

use Carbon_Fields\Block;
use Carbon_Fields\Field;

function mastrade_block_label($title)
{
    $html = '<div class="mastrade-block-label"><span>Section</span><strong>' . esc_html($title) . '</strong></div>';

    return Field::make('html', 'block_label', '')->set_html($html);
}

add_action('carbon_fields_register_fields', function () {
    Block::make('mastrade-hero', __('Hero', 'mastrade'))
        ->set_icon('cover-image')
        ->set_category('theme', __('Mastrade', 'mastrade'), 'admin-home')
        ->add_fields(array(
            mastrade_block_label('Hero'),
            Field::make('image', 'background', __('Background Image', 'mastrade')),
            Field::make('file', 'video', __('Background Video', 'mastrade'))
                ->set_type('video'),
            Field::make('text', 'heading', __('Heading', 'mastrade')),
            Field::make('text', 'text', __('Text', 'mastrade')),
            Field::make('text', 'button_text', __('Button Text', 'mastrade')),
            Field::make('text', 'button_link', __('Button Link', 'mastrade')),
        ))
        ->set_render_callback(function ($fields) {
            include THEME_DIR . '/components/home/hero.php';
        });

    Block::make('mastrade-excellence', __('Manufacturing Excellence', 'mastrade'))
        ->set_icon('analytics')
        ->set_category('theme', __('Mastrade', 'mastrade'))
        ->add_fields(array(
            mastrade_block_label('Manufacturing Excellence'),
            Field::make('text', 'heading', __('Heading', 'mastrade')),
            Field::make('rich_text', 'content', __('Content', 'mastrade')),
            Field::make('complex', 'stats', __('Stats', 'mastrade'))
                ->add_fields(array(
                    Field::make('text', 'text', __('Text', 'mastrade')),
                )),
            Field::make('text', 'button_text', __('Button Text', 'mastrade')),
            Field::make('text', 'button_link', __('Button Link', 'mastrade')),
            Field::make('image', 'image_main', __('Main Image', 'mastrade')),
            Field::make('image', 'image_detail', __('Detail Image', 'mastrade')),
        ))
        ->set_render_callback(function ($fields) {
            include THEME_DIR . '/components/home/excellence.php';
        });

    Block::make('mastrade-reasons', __('Why Mastrade', 'mastrade'))
        ->set_icon('slides')
        ->set_category('theme', __('Mastrade', 'mastrade'))
        ->add_fields(array(
            mastrade_block_label('Why Mastrade'),
            Field::make('text', 'heading', __('Heading', 'mastrade')),
            Field::make('rich_text', 'intro', __('Intro', 'mastrade')),
            Field::make('complex', 'cards', __('Cards', 'mastrade'))
                ->add_fields(array(
                    Field::make('text', 'number', __('Number', 'mastrade')),
                    Field::make('text', 'title', __('Title', 'mastrade')),
                    Field::make('textarea', 'text', __('Text', 'mastrade')),
                )),
        ))
        ->set_render_callback(function ($fields) {
            include THEME_DIR . '/components/home/reasons.php';
        });

    Block::make('mastrade-products', __('Product Capabilities', 'mastrade'))
        ->set_icon('products')
        ->set_category('theme', __('Mastrade', 'mastrade'))
        ->add_fields(array(
            mastrade_block_label('Product Capabilities'),
            Field::make('text', 'heading', __('Heading', 'mastrade')),
            Field::make('rich_text', 'intro', __('Intro', 'mastrade')),
            Field::make('complex', 'items', __('Products', 'mastrade'))
                ->add_fields(array(
                    Field::make('image', 'image', __('Image', 'mastrade')),
                    Field::make('text', 'title', __('Title', 'mastrade')),
                    Field::make('rich_text', 'content', __('Content', 'mastrade')),
                    Field::make('text', 'slug', __('Gallery Slug', 'mastrade')),
                    Field::make('text', 'button_text', __('Button Text', 'mastrade')),
                    Field::make('text', 'button_link', __('Button Link', 'mastrade')),
                    Field::make('complex', 'gallery', __('Gallery Images', 'mastrade'))
                        ->add_fields(array(
                            Field::make('image', 'image', __('Image', 'mastrade')),
                        )),
                )),
        ))
        ->set_render_callback(function ($fields) {
            include THEME_DIR . '/components/home/products.php';
        });

    Block::make('mastrade-process', __('Manufacturing Process', 'mastrade'))
        ->set_icon('editor-ol')
        ->set_category('theme', __('Mastrade', 'mastrade'))
        ->add_fields(array(
            mastrade_block_label('Manufacturing Process'),
            Field::make('text', 'heading', __('Heading', 'mastrade')),
            Field::make('rich_text', 'content', __('Content', 'mastrade')),
            Field::make('image', 'image_main', __('Main Image', 'mastrade')),
            Field::make('image', 'image_detail', __('Detail Image', 'mastrade')),
        ))
        ->set_render_callback(function ($fields) {
            include THEME_DIR . '/components/home/process.php';
        });

    Block::make('mastrade-compliance', __('Compliance', 'mastrade'))
        ->set_icon('awards')
        ->set_category('theme', __('Mastrade', 'mastrade'))
        ->add_fields(array(
            mastrade_block_label('Compliance'),
            Field::make('image', 'image_main', __('Main Image', 'mastrade')),
            Field::make('image', 'image_detail', __('Detail Image', 'mastrade')),
            Field::make('text', 'heading', __('Heading', 'mastrade')),
            Field::make('rich_text', 'content', __('Content', 'mastrade')),
            Field::make('text', 'button_text', __('Button Text', 'mastrade')),
            Field::make('text', 'button_link', __('Button Link', 'mastrade')),
        ))
        ->set_render_callback(function ($fields) {
            include THEME_DIR . '/components/home/compliance.php';
        });

    Block::make('mastrade-brands', __('Trusted Brands', 'mastrade'))
        ->set_icon('star-filled')
        ->set_category('theme', __('Mastrade', 'mastrade'))
        ->add_fields(array(
            mastrade_block_label('Trusted Brands'),
            Field::make('text', 'heading', __('Heading', 'mastrade')),
            Field::make('rich_text', 'intro', __('Intro', 'mastrade')),
            Field::make('complex', 'logos', __('Logos', 'mastrade'))
                ->add_fields(array(
                    Field::make('image', 'image', __('Logo', 'mastrade')),
                )),
            Field::make('text', 'button_text', __('Button Text', 'mastrade')),
            Field::make('text', 'button_link', __('Button Link', 'mastrade')),
        ))
        ->set_render_callback(function ($fields) {
            include THEME_DIR . '/components/home/brands.php';
        });

    Block::make('mastrade-snapshot', __('Business Snapshot', 'mastrade'))
        ->set_icon('chart-bar')
        ->set_category('theme', __('Mastrade', 'mastrade'))
        ->add_fields(array(
            mastrade_block_label('Business Snapshot'),
            Field::make('text', 'heading', __('Heading', 'mastrade')),
            Field::make('rich_text', 'content', __('Content', 'mastrade')),
            Field::make('text', 'button_text', __('Button Text', 'mastrade')),
            Field::make('text', 'button_link', __('Button Link', 'mastrade')),
            Field::make('image', 'image', __('Chart', 'mastrade')),
        ))
        ->set_render_callback(function ($fields) {
            include THEME_DIR . '/components/home/snapshot.php';
        });

    Block::make('mastrade-split', __('Text and Photos', 'mastrade'))
        ->set_icon('columns')
        ->set_category('theme', __('Mastrade', 'mastrade'))
        ->add_fields(array(
            mastrade_block_label('Text and Photos'),
            Field::make('select', 'media_side', __('Photo Side', 'mastrade'))
                ->add_options(array(
                    'right' => __('Right', 'mastrade'),
                    'left' => __('Left', 'mastrade'),
                )),
            Field::make('select', 'background', __('Background', 'mastrade'))
                ->add_options(array(
                    'white' => __('White', 'mastrade'),
                    'soft' => __('Soft gold', 'mastrade'),
                )),
            Field::make('select', 'text_style', __('Text Style', 'mastrade'))
                ->add_options(array(
                    'body' => __('Body', 'mastrade'),
                    'lead' => __('Lead', 'mastrade'),
                )),
            Field::make('select', 'list_style', __('List Style', 'mastrade'))
                ->add_options(array(
                    'bullet' => __('Bullet', 'mastrade'),
                    'check' => __('Check', 'mastrade'),
                    'icon' => __('Icon', 'mastrade'),
                    'chips' => __('Icon chips', 'mastrade'),
                )),
            Field::make('select', 'heading_size', __('Heading Size', 'mastrade'))
                ->add_options(array(
                    'display' => __('Large', 'mastrade'),
                    'section' => __('Section', 'mastrade'),
                )),
            Field::make('select', 'image_layout', __('Image Layout', 'mastrade'))
                ->add_options(array(
                    'overlap' => __('Overlap', 'mastrade'),
                    'poster' => __('Single photo', 'mastrade'),
                )),
            Field::make('text', 'intro_heading', __('Intro Heading', 'mastrade')),
            Field::make('text', 'heading', __('Heading', 'mastrade')),
            Field::make('rich_text', 'content', __('Content', 'mastrade')),
            Field::make('text', 'button_text', __('Button Text', 'mastrade')),
            Field::make('text', 'button_link', __('Button Link', 'mastrade')),
            Field::make('image', 'image_main', __('Main Image', 'mastrade')),
            Field::make('image', 'image_detail', __('Detail Image', 'mastrade')),
        ))
        ->set_render_callback(function ($fields) {
            include THEME_DIR . '/components/page/split.php';
        });

    Block::make('mastrade-gallery', __('Image Grid', 'mastrade'))
        ->set_icon('format-gallery')
        ->set_category('theme', __('Mastrade', 'mastrade'))
        ->add_fields(array(
            mastrade_block_label('Image Grid'),
            Field::make('text', 'heading', __('Heading', 'mastrade')),
            Field::make('rich_text', 'intro', __('Intro', 'mastrade')),
            Field::make('select', 'fit', __('Image Fit', 'mastrade'))
                ->add_options(array(
                    'cover' => __('Cover', 'mastrade'),
                    'contain' => __('Contain', 'mastrade'),
                )),
            Field::make('complex', 'images', __('Images', 'mastrade'))
                ->add_fields(array(
                    Field::make('image', 'image', __('Image', 'mastrade')),
                )),
        ))
        ->set_render_callback(function ($fields) {
            include THEME_DIR . '/components/page/gallery.php';
        });

    Block::make('mastrade-copy', __('Text Section', 'mastrade'))
        ->set_icon('editor-alignleft')
        ->set_category('theme', __('Mastrade', 'mastrade'))
        ->add_fields(array(
            mastrade_block_label('Text Section'),
            Field::make('select', 'align', __('Alignment', 'mastrade'))
                ->add_options(array(
                    'left' => __('Left', 'mastrade'),
                    'center' => __('Center', 'mastrade'),
                )),
            Field::make('select', 'background', __('Background', 'mastrade'))
                ->add_options(array(
                    'white' => __('White', 'mastrade'),
                    'soft' => __('Soft gold', 'mastrade'),
                    'muted' => __('Light gray', 'mastrade'),
                )),
            Field::make('text', 'heading', __('Heading', 'mastrade')),
            Field::make('rich_text', 'content', __('Content', 'mastrade')),
            Field::make('text', 'button_text', __('Button Text', 'mastrade')),
            Field::make('text', 'button_link', __('Button Link', 'mastrade')),
        ))
        ->set_render_callback(function ($fields) {
            include THEME_DIR . '/components/page/copy.php';
        });

    Block::make('mastrade-pair', __('Two Columns', 'mastrade'))
        ->set_icon('columns')
        ->set_category('theme', __('Mastrade', 'mastrade'))
        ->add_fields(array(
            mastrade_block_label('Two Columns'),
            Field::make('select', 'background', __('Background', 'mastrade'))
                ->add_options(array(
                    'white' => __('White', 'mastrade'),
                    'muted' => __('Light gray', 'mastrade'),
                )),
            Field::make('text', 'left_title', __('Left Heading', 'mastrade')),
            Field::make('rich_text', 'left_content', __('Left Content', 'mastrade')),
            Field::make('text', 'right_title', __('Right Heading', 'mastrade')),
            Field::make('rich_text', 'right_content', __('Right Content', 'mastrade')),
        ))
        ->set_render_callback(function ($fields) {
            include THEME_DIR . '/components/page/pair.php';
        });

    Block::make('mastrade-contact', __('Contact', 'mastrade'))
        ->set_icon('email')
        ->set_category('theme', __('Mastrade', 'mastrade'))
        ->add_fields(array(
            mastrade_block_label('Contact'),
            Field::make('text', 'heading', __('Heading', 'mastrade')),
            Field::make('rich_text', 'intro', __('Intro', 'mastrade')),
            Field::make('text', 'label_first_name', __('First Name Label', 'mastrade')),
            Field::make('text', 'label_last_name', __('Last Name Label', 'mastrade')),
            Field::make('text', 'label_phone', __('Phone Label', 'mastrade')),
            Field::make('text', 'label_email', __('Email Label', 'mastrade')),
            Field::make('text', 'label_message', __('Message Label', 'mastrade')),
            Field::make('text', 'button_text', __('Button Text', 'mastrade')),
            Field::make('text', 'recipient', __('Recipient Email', 'mastrade')),
            Field::make('text', 'map_embed', __('Map Embed URL', 'mastrade')),
            Field::make('text', 'location_title', __('Location Title', 'mastrade')),
            Field::make('text', 'office_title', __('Office Title', 'mastrade')),
            Field::make('textarea', 'address', __('Address', 'mastrade')),
            Field::make('text', 'email', __('Email', 'mastrade')),
            Field::make('text', 'phone', __('Phone', 'mastrade')),
        ))
        ->set_render_callback(function ($fields) {
            include THEME_DIR . '/components/page/contact.php';
        });

    Block::make('mastrade-library', __('Photo and Video Gallery', 'mastrade'))
        ->set_icon('format-video')
        ->set_category('theme', __('Mastrade', 'mastrade'))
        ->add_fields(array(
            mastrade_block_label('Photo and Video Gallery'),
            Field::make('text', 'crumb', __('Breadcrumb Label', 'mastrade')),
            Field::make('text', 'image_label', __('Image Tab', 'mastrade')),
            Field::make('text', 'video_label', __('Video Tab', 'mastrade')),
            Field::make('select', 'start', __('Open Tab', 'mastrade'))
                ->add_options(array(
                    'video' => __('Video', 'mastrade'),
                    'image' => __('Image', 'mastrade'),
                )),
            Field::make('complex', 'images', __('Images', 'mastrade'))
                ->add_fields(array(
                    Field::make('image', 'image', __('Image', 'mastrade')),
                )),
            Field::make('complex', 'videos', __('Videos', 'mastrade'))
                ->add_fields(array(
                    Field::make('text', 'url', __('YouTube URL', 'mastrade')),
                    Field::make('image', 'poster', __('Poster', 'mastrade')),
                )),
        ))
        ->set_render_callback(function ($fields) {
            include THEME_DIR . '/components/page/library.php';
        });

    Block::make('mastrade-team', __('Team', 'mastrade'))
        ->set_icon('groups')
        ->set_category('theme', __('Mastrade', 'mastrade'))
        ->add_fields(array(
            mastrade_block_label('Team'),
            Field::make('text', 'eyebrow', __('Eyebrow', 'mastrade')),
            Field::make('text', 'heading', __('Heading', 'mastrade')),
            Field::make('rich_text', 'intro', __('Intro', 'mastrade')),
            Field::make('complex', 'members', __('People', 'mastrade'))
                ->add_fields(array(
                    Field::make('image', 'image', __('Photo', 'mastrade')),
                    Field::make('text', 'title', __('Name', 'mastrade')),
                    Field::make('text', 'text', __('Role', 'mastrade')),
                )),
            Field::make('text', 'button_text', __('Button Text', 'mastrade')),
            Field::make('text', 'button_link', __('Button Link', 'mastrade')),
        ))
        ->set_render_callback(function ($fields) {
            include THEME_DIR . '/components/page/team.php';
        });

    Block::make('mastrade-quote', __('Quote', 'mastrade'))
        ->set_icon('format-quote')
        ->set_category('theme', __('Mastrade', 'mastrade'))
        ->add_fields(array(
            mastrade_block_label('Quote'),
            Field::make('complex', 'items', __('Quotes', 'mastrade'))
                ->setup_labels(array(
                    'plural_name' => __('Quotes', 'mastrade'),
                    'singular_name' => __('Quote', 'mastrade'),
                ))
                ->set_header_template('<%- name ? name : "Quote" %>')
                ->add_fields(array(
                    Field::make('image', 'image', __('Photo', 'mastrade')),
                    Field::make('textarea', 'quote', __('Quote', 'mastrade')),
                    Field::make('text', 'name', __('Name', 'mastrade')),
                    Field::make('text', 'role', __('Role', 'mastrade')),
                )),
        ))
        ->set_render_callback(function ($fields) {
            include THEME_DIR . '/components/page/quote.php';
        });

    Block::make('mastrade-faq', __('FAQ', 'mastrade'))
        ->set_icon('editor-help')
        ->set_category('theme', __('Mastrade', 'mastrade'))
        ->add_fields(array(
            mastrade_block_label('FAQ'),
            Field::make('text', 'heading', __('Heading', 'mastrade')),
            Field::make('rich_text', 'intro', __('Intro', 'mastrade')),
            Field::make('complex', 'items', __('Questions', 'mastrade'))
                ->add_fields(array(
                    Field::make('text', 'question', __('Question', 'mastrade')),
                    Field::make('rich_text', 'answer', __('Answer', 'mastrade')),
                )),
        ))
        ->set_render_callback(function ($fields) {
            include THEME_DIR . '/components/page/faq.php';
        });

    Block::make('mastrade-page-banner', __('Page Banner', 'mastrade'))
        ->set_icon('format-image')
        ->set_category('theme', __('Mastrade', 'mastrade'))
        ->add_fields(array(
            mastrade_block_label('Page Banner'),
            Field::make('image', 'background', __('Background', 'mastrade')),
            Field::make('text', 'heading', __('Heading', 'mastrade')),
            Field::make('text', 'crumb', __('Breadcrumb Label', 'mastrade')),
        ))
        ->set_render_callback(function ($fields) {
            include THEME_DIR . '/components/page/banner.php';
        });
});
