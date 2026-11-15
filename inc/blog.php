<?php

defined('ABSPATH') || exit;

add_action('init', 'mastrade_blog_labels');
add_action('init', 'mastrade_seed_blog', 45);
add_action('init', 'mastrade_seed_blog_posts', 46);
add_action('pre_get_posts', 'mastrade_blog_query');
add_filter('use_block_editor_for_post_type', 'mastrade_classic_blog_editor', 10, 2);
add_filter('default_hidden_meta_boxes', 'mastrade_show_excerpt_box', 10, 2);

function mastrade_blog_labels()
{
    $post_type = get_post_type_object('post');
    if (!$post_type) {
        return;
    }

    $labels = $post_type->labels;
    $labels->name = __('Blog', 'mastrade');
    $labels->singular_name = __('Blog Post', 'mastrade');
    $labels->add_new_item = __('Add Blog Post', 'mastrade');
    $labels->edit_item = __('Edit Blog Post', 'mastrade');
    $labels->menu_name = __('Blog', 'mastrade');
}

function mastrade_classic_blog_editor($use, $post_type)
{
    if ($post_type === 'post') {
        return false;
    }

    return $use;
}

function mastrade_show_excerpt_box($hidden, $screen)
{
    if ($screen && $screen->id === 'post') {
        $hidden = array_diff($hidden, array('postexcerpt'));
    }

    return $hidden;
}

function mastrade_blog_query($query)
{
    if (is_admin() || !$query->is_main_query()) {
        return;
    }

    if ($query->is_home() || $query->is_category() || $query->is_tag()) {
        $query->set('posts_per_page', 6);
    }
}

function mastrade_blog_pagination()
{
    $pages = (int) $GLOBALS['wp_query']->max_num_pages;
    if ($pages < 2) {
        return;
    }

    $links = paginate_links(array(
        'total' => $pages,
        'current' => max(1, (int) get_query_var('paged'), (int) get_query_var('page')),
        'type' => 'array',
        'prev_text' => '<span aria-hidden="true">&#8592;</span> ' . esc_html__('Previous', 'mastrade'),
        'next_text' => esc_html__('Next', 'mastrade') . ' <span aria-hidden="true">&#8599;</span>',
    ));

    if (!$links) {
        return;
    }

    echo '<nav class="blog-pagination" aria-label="' . esc_attr__('Blog pages', 'mastrade') . '">';
    echo implode('', $links);
    echo '</nav>';
}

function mastrade_seed_blog()
{
    if (get_option('mastrade_blog_v1') || !get_option('mastrade_seeded_v1')) {
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

    $page_id = mastrade_ensure_page('blog', 'Blog', '');
    if ($page_id && !get_option('page_for_posts')) {
        update_option('page_for_posts', $page_id);
    }

    $category_id = function ($name) {
        $term = term_exists($name, 'category');
        if (!$term) {
            $term = wp_insert_term($name, 'category');
        }
        if (is_wp_error($term)) {
            return 0;
        }

        return (int) (is_array($term) ? $term['term_id'] : $term);
    };
    $news = $category_id('News');
    $factory = $category_id('Factory');

    $published = wp_count_posts('post');
    if ($published && (int) $published->publish < 1) {
        $posts = array(
            array(
                'title' => 'How a sample moves into production',
                'slug' => 'how-a-sample-moves-into-production',
                'category' => $news,
                'image' => 'manufacturing-main.png',
                'excerpt' => 'A short look at the path from an approved sample to a packed shipment, and where the buyer stays involved.',
                'content' => '<p>An approved sample is the start of the line plan. The team confirms the fabric, the measurements, and the packing method before the first bulk piece is cut.</p><h2>What happens on the floor</h2><p>Each line follows the approved standard. Quality checks sit between sewing, finishing, and packing, so a problem is caught before the carton is closed.</p><p><a href="' . esc_url(home_url('/contact/')) . '">Talk to the team about a program</a></p>',
            ),
            array(
                'title' => 'What buyers check before a bulk order',
                'slug' => 'what-buyers-check-before-a-bulk-order',
                'category' => $factory,
                'image' => 'experience-main.png',
                'excerpt' => 'Capacity, compliance, and a clear sample process are the three things most buyers ask about first.',
                'content' => '<p>Before a bulk order, buyers usually want three answers: how many pieces the factory can finish, which compliance programs are in place, and how a sample is approved.</p><h2>A clear next step</h2><p>Share the style, the fabric, and the quantity. The merchandising team can then map the sample calendar and the production window.</p>',
            ),
        );

        foreach ($posts as $post) {
            $id = wp_insert_post(array(
                'post_type' => 'post',
                'post_status' => 'publish',
                'post_title' => $post['title'],
                'post_name' => $post['slug'],
                'post_excerpt' => $post['excerpt'],
                'post_content' => $post['content'],
                'post_category' => array($post['category']),
            ));

            if ($id && !is_wp_error($id)) {
                $image_id = mastrade_import_image($post['image']);
                if ($image_id) {
                    set_post_thumbnail($id, $image_id);
                }
            }
        }
    }

    $locations = get_nav_menu_locations();
    $menu_id = (int) ($locations['primary'] ?? 0);
    $blog_url = $page_id ? get_permalink($page_id) : home_url('/blog/');
    if ($menu_id && $blog_url) {
        $target = untrailingslashit($blog_url);
        $linked = false;
        foreach ((array) wp_get_nav_menu_items($menu_id) as $item) {
            if (untrailingslashit($item->url) === $target) {
                $linked = true;
                break;
            }
        }
        if (!$linked) {
            wp_update_nav_menu_item($menu_id, 0, array(
                'menu-item-title' => 'Blog',
                'menu-item-url' => $blog_url,
                'menu-item-type' => 'custom',
                'menu-item-status' => 'publish',
            ));
        }
    }

    update_option('mastrade_blog_v1', 1);

    if ($previous_user) {
        wp_set_current_user($previous_user);
    }
}

function mastrade_seed_blog_posts()
{
    if (get_option('mastrade_blog_v2') || !get_option('mastrade_blog_v1')) {
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

    $category_id = function ($name) {
        $term = term_exists($name, 'category');
        if (!$term) {
            $term = wp_insert_term($name, 'category');
        }
        if (is_wp_error($term)) {
            return 0;
        }

        return (int) (is_array($term) ? $term['term_id'] : $term);
    };

    $posts = array(
        array(
            'title' => 'How a sample moves into production',
            'slug' => 'how-a-sample-moves-into-production',
            'category' => $category_id('News'),
            'image' => 'manufacturing-main.png',
            'excerpt' => 'A short look at the path from an approved sample to a packed shipment, and where the buyer stays involved.',
            'content' => '<p>An approved sample is the start of the line plan. The team confirms the fabric, the measurements, and the packing method before the first bulk piece is cut.</p><h2>What happens on the floor</h2><p>Each line follows the approved standard. Quality checks sit between sewing, finishing, and packing, so a problem is caught before the carton is closed.</p>',
        ),
        array(
            'title' => 'What buyers check before a bulk order',
            'slug' => 'what-buyers-check-before-a-bulk-order',
            'category' => $category_id('Factory'),
            'image' => 'experience-main.png',
            'excerpt' => 'Capacity, compliance, and a clear sample process are the three things most buyers ask about first.',
            'content' => '<p>Before a bulk order, buyers usually want three answers: how many pieces the factory can finish, which compliance programs are in place, and how a sample is approved.</p><h2>A clear next step</h2><p>Share the style, the fabric, and the quantity. The merchandising team can then map the sample calendar and the production window.</p>',
        ),
    );

    foreach ($posts as $post) {
        $existing = get_page_by_path($post['slug'], OBJECT, 'post');
        if ($existing) {
            continue;
        }

        $id = wp_insert_post(array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'post_title' => $post['title'],
            'post_name' => $post['slug'],
            'post_excerpt' => $post['excerpt'],
            'post_content' => $post['content'],
            'post_category' => array($post['category']),
        ));

        if ($id && !is_wp_error($id)) {
            $image_id = mastrade_import_image($post['image']);
            if ($image_id) {
                set_post_thumbnail($id, $image_id);
            }
        }
    }

    update_option('mastrade_blog_v2', 1);

    if ($previous_user) {
        wp_set_current_user($previous_user);
    }
}
