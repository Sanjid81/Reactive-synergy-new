<?php

defined('ABSPATH') || exit;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action('init', 'mastrade_register_project_type');
add_action('init', 'mastrade_seed_projects', 43);
add_action('init', 'mastrade_refresh_project_cards', 44);
add_action('pre_get_posts', 'mastrade_project_archive_query');

function mastrade_register_project_type()
{
    register_post_type('project', array(
        'labels' => array(
            'name' => __('Projects', 'mastrade'),
            'singular_name' => __('Project', 'mastrade'),
            'add_new_item' => __('Add Project', 'mastrade'),
            'edit_item' => __('Edit Project', 'mastrade'),
            'view_item' => __('View Project', 'mastrade'),
        ),
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-portfolio',
        'menu_position' => 21,
        'rewrite' => array('slug' => 'projects'),
        'supports' => array('title', 'editor', 'thumbnail'),
        'show_in_rest' => false,
    ));
}

function mastrade_project_archive_query($query)
{
    if (is_admin() || !$query->is_main_query() || !$query->is_post_type_archive('project')) {
        return;
    }

    $query->set('posts_per_page', 6);
}

add_action('carbon_fields_register_fields', function () {
    Container::make('post_meta', __('Project', 'mastrade'))
        ->where('post_type', '=', 'project')
        ->add_fields(array(
            Field::make('complex', 'shots', __('Card Images', 'mastrade'))
                ->set_max(4)
                ->set_help_text(__('Up to four photos. They make the collage on the projects page.', 'mastrade'))
                ->add_fields(array(
                    Field::make('image', 'image', __('Image', 'mastrade')),
                )),
            Field::make('text', 'place', __('Client / Location', 'mastrade')),
            Field::make('rich_text', 'story', __('Story', 'mastrade'))
                ->set_help_text(__('Add headings, paragraphs, images, and links. This is the project detail page.', 'mastrade'))
                ->set_settings(array(
                    'media_buttons' => true,
                    'tinymce' => array(
                        'toolbar1' => 'formatselect,bold,italic,bullist,numlist,blockquote,link,unlink,wp_adv',
                        'toolbar2' => 'alignleft,aligncenter,alignright,strikethrough,hr,forecolor,pastetext,removeformat,charmap,outdent,indent,undo,redo',
                        'block_formats' => 'Paragraph=p;Heading 1=h1;Heading 2=h2;Heading 3=h3',
                    ),
                    'quicktags' => true,
                )),
        ));
});

function mastrade_seed_projects()
{
    if (get_option('mastrade_projects_v1') || !get_option('mastrade_seeded_v1')) {
        return;
    }

    $previous_user = get_current_user_id();
    if (!current_user_can('unfiltered_html')) {
        $admins = get_users(array(
            'role' => 'administrator',
            'number' => 1,
            'fields' => 'ID',
        ));
        if ($admins) {
            wp_set_current_user((int) $admins[0]);
        }
    }

    $story = function ($heading, $text, $image_id, $link_label) {
        $html = '<h2>' . esc_html($heading) . '</h2>';
        $html .= '<p>' . esc_html($text) . '</p>';
        if ($image_id) {
            $html .= wp_get_attachment_image($image_id, 'large');
        }
        $html .= '<p><a href="' . esc_url(home_url('/contact/')) . '">' . esc_html($link_label) . '</a></p>';

        return $html;
    };

    $projects = array(
        array(
            'title' => 'Knitwear Program',
            'slug' => 'knitwear-program',
            'place' => 'Production floor',
            'image' => 'manufacturing-main.png',
            'inline' => 'manufacturing-detail.png',
            'heading' => 'From sample to shipment',
            'text' => 'The program moves from approved samples into line production, with quality checks at each stage before the goods are packed.',
            'link' => 'Talk to the team about a similar program',
        ),
        array(
            'title' => 'Womenswear Program',
            'slug' => 'womenswear-program',
            'place' => 'Sampling to shipment',
            'image' => 'product-women.png',
            'inline' => 'catalog-women-01.png',
            'heading' => 'How a style is developed',
            'text' => 'Design references, fit samples, and bulk production stay in one line of communication with the buyer.',
            'link' => 'Start with a sample request',
        ),
    );

    foreach ($projects as $project) {
        $existing = get_page_by_path($project['slug'], OBJECT, 'project');
        if ($existing) {
            continue;
        }

        $id = wp_insert_post(array(
            'post_type' => 'project',
            'post_status' => 'publish',
            'post_title' => $project['title'],
            'post_name' => $project['slug'],
        ));

        if (!$id || is_wp_error($id)) {
            continue;
        }

        $image_id = mastrade_import_image($project['image']);
        if ($image_id) {
            set_post_thumbnail($id, $image_id);
        }

        if (function_exists('carbon_set_post_meta')) {
            carbon_set_post_meta($id, 'place', $project['place']);
            carbon_set_post_meta($id, 'story', $story(
                $project['heading'],
                $project['text'],
                mastrade_import_image($project['inline']),
                $project['link']
            ));
        }
    }

    $locations = get_nav_menu_locations();
    $menu_id = (int) ($locations['primary'] ?? 0);
    if ($menu_id) {
        $archive = untrailingslashit(home_url('/projects'));
        $linked = false;
        foreach ((array) wp_get_nav_menu_items($menu_id) as $item) {
            if (untrailingslashit($item->url) === $archive) {
                $linked = true;
                break;
            }
        }
        if (!$linked) {
            wp_update_nav_menu_item($menu_id, 0, array(
                'menu-item-title' => 'Projects',
                'menu-item-url' => home_url('/projects/'),
                'menu-item-type' => 'custom',
                'menu-item-status' => 'publish',
            ));
        }
    }

    if (function_exists('carbon_set_theme_option')) {
        if (!carbon_get_theme_option('projects_heading')) {
            carbon_set_theme_option('projects_eyebrow', '01. Recent Projects');
            carbon_set_theme_option('projects_heading', 'Explore Our Apparel Programs');
            carbon_set_theme_option('projects_intro', 'A look at the programs we develop with buyers, from the first sample through packed shipment.');
        }
    }

    flush_rewrite_rules(false);
    update_option('mastrade_projects_v1', 1);

    if ($previous_user) {
        wp_set_current_user($previous_user);
    }
}

function mastrade_refresh_project_cards()
{
    if (get_option('mastrade_projects_v2') || !get_option('mastrade_projects_v1')) {
        return;
    }

    $previous_user = get_current_user_id();
    if (!current_user_can('unfiltered_html')) {
        $admins = get_users(array(
            'role' => 'administrator',
            'number' => 1,
            'fields' => 'ID',
        ));
        if ($admins) {
            wp_set_current_user((int) $admins[0]);
        }
    }

    $sets = array(
        'knitwear-program' => array('manufacturing-main.png', 'manufacturing-detail.png', 'process-main.png', 'experience-main.png'),
        'womenswear-program' => array('product-women.png', 'catalog-women-01.png', 'catalog-women-02.png', 'catalog-women-03.png'),
    );

    foreach ($sets as $slug => $files) {
        $project = get_page_by_path($slug, OBJECT, 'project');
        if (!$project || !function_exists('carbon_set_post_meta')) {
            continue;
        }

        $shots = array();
        foreach ($files as $file) {
            $image_id = mastrade_import_image($file);
            if ($image_id) {
                $shots[] = array('image' => $image_id);
            }
        }

        if ($shots) {
            carbon_set_post_meta($project->ID, 'shots', $shots);
        }
    }

    update_option('mastrade_projects_v2', 1);

    if ($previous_user) {
        wp_set_current_user($previous_user);
    }
}
