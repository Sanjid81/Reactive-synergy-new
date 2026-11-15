<?php

defined('ABSPATH') || exit;

add_action('init', 'mastrade_product_rewrite');
add_filter('query_vars', 'mastrade_product_query_var');
add_action('template_redirect', 'mastrade_product_unknown');
add_filter('document_title_parts', 'mastrade_product_document_title');

function mastrade_product_rewrite()
{
    add_rewrite_rule('^products/([^/]+)/?$', 'index.php?pagename=products&mastrade_product=$matches[1]', 'top');
}

function mastrade_product_query_var($vars)
{
    $vars[] = 'mastrade_product';
    return $vars;
}

function mastrade_product_slug($item)
{
    $slug = sanitize_title($item['slug'] ?? '');
    if (!$slug) {
        $slug = sanitize_title($item['title'] ?? '');
    }

    return $slug;
}

function mastrade_find_product($slug)
{
    $slug = sanitize_title($slug);
    $page = get_page_by_path('products');
    if (!$page || !$slug) {
        return null;
    }

    foreach (parse_blocks($page->post_content) as $block) {
        if (($block['blockName'] ?? '') !== 'carbon-fields/mastrade-products') {
            continue;
        }
        $items = $block['attrs']['data']['items'] ?? array();
        foreach ((array) $items as $item) {
            if (mastrade_product_slug($item) === $slug) {
                return $item;
            }
        }
    }

    return null;
}

function mastrade_current_product()
{
    $slug = get_query_var('mastrade_product');
    if (!$slug) {
        return null;
    }

    return mastrade_find_product($slug);
}

function mastrade_product_unknown()
{
    $slug = get_query_var('mastrade_product');
    if (!$slug || mastrade_find_product($slug)) {
        return;
    }

    global $wp_query;
    $wp_query->set_404();
    status_header(404);
    nocache_headers();
    include get_query_template('404');
    exit;
}

function mastrade_product_document_title($parts)
{
    $item = mastrade_current_product();
    if ($item && !empty($item['title'])) {
        $parts['title'] = $item['title'];
    }

    return $parts;
}
