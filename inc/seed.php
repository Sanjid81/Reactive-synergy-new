<?php

defined('ABSPATH') || exit;

add_action('init', 'mastrade_seed_content', 30);
add_action('init', 'mastrade_refresh_home_sections', 31);

function mastrade_seed_content()
{
    if (get_option('mastrade_seeded_v1')) {
        return;
    }

    if (!function_exists('carbon_set_theme_option')) {
        return;
    }

    $previous_user = get_current_user_id();
    if (!current_user_can('edit_theme_options')) {
        $admins = get_users(array(
            'role' => 'administrator',
            'number' => 1,
            'fields' => 'ID',
        ));
        if ($admins) {
            wp_set_current_user((int) $admins[0]);
        }
    }

    $images = array();
    foreach (array(
        'logo' => 'logo.png',
        'logo_white' => 'logo-white.png',
        'hero' => 'hero.png',
        'excellence_main' => 'excellence-main.png',
        'excellence_detail' => 'excellence-detail.png',
        'product_women' => 'product-women.png',
        'product_men' => 'product-men.png',
        'product_kids' => 'product-kids.png',
        'process_main' => 'process-main.png',
        'process_detail' => 'process-detail.png',
        'compliance_main' => 'compliance-main.png',
        'compliance_detail' => 'compliance-detail.png',
        'snapshot' => 'snapshot.png',
        'footer_1' => 'footer-1.png',
        'footer_2' => 'footer-2.png',
        'footer_3' => 'footer-3.png',
        'footer_4' => 'footer-4.png',
        'footer_5' => 'footer-5.png',
        'footer_6' => 'footer-6.png',
    ) as $key => $file) {
        $images[$key] = mastrade_import_image($file);
    }

    carbon_set_theme_option('site_logo', $images['logo']);
    carbon_set_theme_option('footer_logo', $images['logo_white']);
    carbon_set_theme_option('header_button_text', 'Contact Us');
    carbon_set_theme_option('header_button_link', home_url('/contact-us/'));
    carbon_set_theme_option('office_title', 'Corporate Office');
    carbon_set_theme_option('office_address', 'Helal Complex, Plot # 72, Bypass Biswa Road, Mogarkhal, Gazipur 1701');
    carbon_set_theme_option('office_phone', '+880 1618-667434');
    carbon_set_theme_option('office_email', 'info@mastradebd.com');
    carbon_set_theme_option('footer_copyright', '© Mastrade International Garments Ltd. All Rights Reserved 2026');
    carbon_set_theme_option('privacy_link', home_url('/privacy-policy/'));
    carbon_set_theme_option('terms_link', home_url('/terms-of-use/'));
    carbon_set_theme_option('social_links', array(
        array('network' => 'facebook', 'url' => 'https://facebook.com'),
        array('network' => 'linkedin', 'url' => 'https://linkedin.com'),
        array('network' => 'instagram', 'url' => 'https://instagram.com'),
        array('network' => 'youtube', 'url' => 'https://youtube.com'),
    ));
    carbon_set_theme_option('footer_gallery', array(
        array('image' => $images['footer_1']),
        array('image' => $images['footer_2']),
        array('image' => $images['footer_3']),
        array('image' => $images['footer_4']),
        array('image' => $images['footer_5']),
        array('image' => $images['footer_6']),
    ));

    $pages = array(
        'home' => array('Home', mastrade_home_content($images)),
        'about-us' => array('About Us', mastrade_banner_content($images['hero'], 'About Mastrade International Garments Ltd.', 'About Us')),
        'products' => array('Products', mastrade_banner_content($images['hero'], 'Our Products', 'Products')),
        'our-buyers' => array('Our Buyers', mastrade_banner_content($images['hero'], 'Trusted by Global Brands', 'Our Buyers')),
        'certifications' => array('Certifications', mastrade_banner_content($images['hero'], 'Compliance & Certifications', 'Certifications')),
        'sustainability' => array('Sustainability', mastrade_banner_content($images['hero'], 'Sustainability', 'Sustainability')),
        'company-profile' => array('Company Profile', mastrade_banner_content($images['hero'], 'Our Profile', 'Company Profile')),
        'contact-us' => array('Contact Us', mastrade_banner_content($images['hero'], 'Contact Us', 'Contact Us')),
        'gallery' => array('Gallery', mastrade_gallery_content()),
    );

    $ids = array();
    foreach ($pages as $slug => $page) {
        $ids[$slug] = mastrade_ensure_page($slug, $page[0], $page[1]);
    }

    if (!empty($ids['home'])) {
        update_option('show_on_front', 'page');
        update_option('page_on_front', $ids['home']);
    }

    mastrade_ensure_menu('primary', array(
        'Home' => $ids['home'],
        'About Us' => $ids['about-us'],
        'Products' => $ids['products'],
        'Our Buyers' => $ids['our-buyers'],
        'Certifications' => $ids['certifications'],
        'Sustainability' => $ids['sustainability'],
        'Company Profile' => $ids['company-profile'],
    ));

    mastrade_ensure_menu('footer', array(
        'About Us' => $ids['about-us'],
        'Gallery' => $ids['gallery'] ?? $ids['products'],
        'Our Products' => $ids['products'],
        'Contact Us' => $ids['contact-us'],
    ));

    update_option('mastrade_seeded_v1', 1);

    if ($previous_user) {
        wp_set_current_user($previous_user);
    }
}

function mastrade_home_content($images)
{
    $content = mastrade_block('mastrade-hero', array(
        'background' => $images['hero'],
        'heading' => 'Your Trusted Apparel Manufacturing Partner From Bangladesh',
        'text' => 'Trusted by global fashion brands since 1991.',
        'button_text' => 'Discuss Your Next Production',
        'button_link' => home_url('/contact-us/'),
    ));

    $content .= mastrade_block('mastrade-excellence', array(
        'heading' => '30+ Years of Manufacturing Excellence',
        'content' => '<p><strong>Mastrade International Garments Ltd.</strong> is a fully compliant apparel manufacturing company based in Gazipur, Bangladesh. Established in 1991, we specialize in producing high-quality garments for internationally recognized fashion brands and retailers.</p><p>With a strong focus on compliance, product versatility, and efficient production systems, we support our buyers with consistent quality, flexible capacity, and dependable lead times — season after season.</p>',
        'stats' => array(
            array('_type' => '_', 'text' => '30+ Years of Manufacturing Excellence'),
            array('_type' => '_', 'text' => '25 Production Lines | 3,000 Skilled Employees'),
            array('_type' => '_', 'text' => '650,000 – 900,000 Pieces Monthly Capacity'),
            array('_type' => '_', 'text' => 'RSC 100% Compliance Score'),
        ),
        'button_text' => 'Learn More About Mastrade',
        'button_link' => home_url('/about-us/'),
        'image_main' => $images['excellence_main'],
        'image_detail' => $images['excellence_detail'],
    ));

    $content .= mastrade_block('mastrade-reasons', array(
        'heading' => 'Why Global Brands Choose Mastrade',
        'intro' => '<p>Both our buyers and employees benefit from our unique and effective working process.</p>',
        'cards' => array(
            array('_type' => '_', 'number' => '1', 'title' => 'Compliance-First Manufacturing', 'text' => 'We operate with full transparency and internationally recognized certifications, maintaining a 100% RSC score and strict adherence to global compliance standards.'),
            array('_type' => '_', 'number' => '2', 'title' => 'Fast & Flexible Production Capability', 'text' => 'Our SMED-based changeover system enables rapid style transitions, supporting multiple product categories with reduced lead time.'),
            array('_type' => '_', 'number' => '3', 'title' => 'Proven Experience & Quality Consistency', 'text' => 'Over three decades of manufacturing expertise ensure stable quality, process control, and buyer confidence.'),
            array('_type' => '_', 'number' => '4', 'title' => 'Stable Workforce, Reliable Delivery', 'text' => 'A skilled and experienced workforce of 3,000 professionals ensures production continuity, efficiency, and on-time shipment.'),
        ),
    ));

    $content .= mastrade_block('mastrade-products', array(
        'heading' => 'Our Product Capabilities',
        'intro' => '<p>We manufacture a wide range of woven and tailored garments for men, women, and children, covering both fashion and functional requirements.</p>',
        'items' => array(
            array(
                '_type' => '_',
                'image' => $images['product_women'] ?? 0,
                'title' => "Women's Wear",
                'content' => '<p>KEY CATEGORIES :<br>Tops – Blouses, shirts, dresses, robes, vest, cam, t-shirts etc.<br>Bottoms – Trousers, palazzo, skirts, shorts, skorts etc.<br>Outerwear – Blazers, coats, overcoats, trench coats, bombers jackets, cardigans, coatigans etc.</p>',
                'button_text' => 'View Gallery',
                'button_link' => home_url('/products/'),
            ),
            array(
                '_type' => '_',
                'image' => $images['product_men'] ?? 0,
                'title' => "Men's Wear",
                'content' => '<p>KEY CATEGORIES :<br>Tops – Shirts, t-shirts, etc.<br>Bottoms – Trousers, pyjamas, boxers, shorts etc.<br>Outer wears – Blazers, coats, overcoats, trench coats, bombers jackets, shackets etc.</p>',
                'button_text' => 'View Gallery',
                'button_link' => home_url('/products/'),
            ),
            array(
                '_type' => '_',
                'image' => $images['product_kids'] ?? 0,
                'title' => "Kid's Wear",
                'content' => '<p>KEY CATEGORIES :<br>Boys – Shirts, t-shirts, trousers, shorts etc.<br>Girls – Frocks, dresses, jumpsuits, rompers etc.<br>Outerwear – Coats, cardigans, bomber jackets etc.</p>',
                'button_text' => 'View Gallery',
                'button_link' => home_url('/products/'),
            ),
        ),
    ));

    $content .= mastrade_block('mastrade-process', array(
        'heading' => 'End-to-End Manufacturing Excellence',
        'content' => '<p>Our production process is designed to ensure precision, traceability, and consistent quality at every stage.</p><ul><li>Raw Material Inspection</li><li>CAD, Marker &amp; Sampling</li><li>Cutting &amp; Preparation</li><li>Sewing &amp; Assembly</li><li>Quality Control &amp; Finishing</li><li>Metal Detection &amp; Export Packing</li></ul><p>Supported by modern machinery, standardized operations, and digital production controls.</p>',
        'image_main' => $images['process_main'] ?? 0,
        'image_detail' => $images['process_detail'] ?? 0,
    ));

    $content .= mastrade_block('mastrade-compliance', array(
        'image_main' => $images['compliance_main'] ?? 0,
        'image_detail' => $images['compliance_detail'] ?? 0,
        'heading' => 'Globally Recognized Compliance Standards',
        'content' => '<p>Our operations are certified and audited by internationally recognized organizations, ensuring full compliance with buyer and regulatory requirements.</p><p><strong>Key Certifications Include:</strong><br>Accord / RSC, WRAP, GRS, RCS, C-TPAT, BSCI, OEKO-TEX, Better Work, Sedex, Higg FEM, BCI.</p>',
        'button_text' => 'Our Certifications',
        'button_link' => home_url('/certifications/'),
    ));

    $content .= mastrade_block('mastrade-brands', array(
        'heading' => 'TRUSTED BY GLOBAL BRANDS',
        'intro' => '<p>Our partnerships are built on long-term trust, operational reliability, and ethical manufacturing excellence.</p>',
        'logos' => array(),
        'button_text' => 'Our buyers',
        'button_link' => home_url('/our-buyers/'),
    ));

    $content .= mastrade_block('mastrade-snapshot', array(
        'heading' => 'Business Strength Snapshot',
        'content' => '<ul><li><strong>Annual Turnover:</strong> USD 30 Million</li><li><strong>Monthly Capacity:</strong> Up to 900,000 Pieces</li><li><strong>Production Lines:</strong> 25</li><li><strong>Workforce:</strong> 3,000 Employees</li></ul><p>This reflects our ability to scale responsibly while maintaining quality and compliance.</p>',
        'button_text' => 'Know more about us',
        'button_link' => home_url('/about-us/'),
        'image' => $images['snapshot'] ?? 0,
    ));

    return $content;
}

function mastrade_refresh_home_sections()
{
    if (get_option('mastrade_home_sections_v3') || !get_option('mastrade_seeded_v1')) {
        return;
    }

    $page = get_page_by_path('home');
    if (!$page) {
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

    $files = array(
        'logo' => 'logo.png',
        'hero' => 'hero.png',
        'excellence_main' => 'excellence-main.png',
        'excellence_detail' => 'excellence-detail.png',
        'product_women' => 'product-women.png',
        'product_men' => 'product-men.png',
        'product_kids' => 'product-kids.png',
        'process_main' => 'process-main.png',
        'process_detail' => 'process-detail.png',
        'compliance_main' => 'compliance-main.png',
        'compliance_detail' => 'compliance-detail.png',
        'snapshot' => 'snapshot.png',
    );

    $images = array();
    foreach ($files as $key => $file) {
        $images[$key] = mastrade_import_image($file);
    }

    wp_update_post(array(
        'ID' => $page->ID,
        'post_content' => wp_slash(mastrade_home_content($images)),
    ));

    update_option('mastrade_home_sections_v3', 1);

    if ($previous_user) {
        wp_set_current_user($previous_user);
    }
}

function mastrade_banner_content($image, $heading, $crumb)
{
    return mastrade_block('mastrade-page-banner', array(
        'background' => $image,
        'heading' => $heading,
        'crumb' => $crumb,
    ));
}

function mastrade_ensure_page($slug, $title, $content)
{
    $existing = get_page_by_path($slug);
    if ($existing) {
        return (int) $existing->ID;
    }

    $id = wp_insert_post(array(
        'post_type' => 'page',
        'post_status' => 'publish',
        'post_name' => $slug,
        'post_title' => $title,
        'post_content' => $content,
    ));

    return (int) $id;
}

function mastrade_ensure_menu($location, $items)
{
    $locations = get_theme_mod('nav_menu_locations', array());
    if (!empty($locations[$location])) {
        return;
    }

    $menu_id = wp_create_nav_menu(ucfirst($location) . ' Menu');
    if (is_wp_error($menu_id)) {
        return;
    }

    foreach ($items as $label => $page_id) {
        if (!$page_id) {
            continue;
        }
        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => $label,
            'menu-item-object' => 'page',
            'menu-item-object-id' => $page_id,
            'menu-item-type' => 'post_type',
            'menu-item-status' => 'publish',
        ));
    }

    $locations[$location] = $menu_id;
    set_theme_mod('nav_menu_locations', $locations);
}

function mastrade_import_image($filename)
{
    $existing = get_posts(array(
        'post_type' => 'attachment',
        'post_status' => 'inherit',
        'meta_key' => '_mastrade_file',
        'meta_value' => $filename,
        'posts_per_page' => 1,
        'fields' => 'ids',
    ));

    if ($existing) {
        return (int) $existing[0];
    }

    $path = THEME_DIR . '/assets/images/' . $filename;
    if (!file_exists($path)) {
        return 0;
    }

    $upload = wp_upload_bits($filename, null, file_get_contents($path));
    if (!empty($upload['error'])) {
        return 0;
    }

    $filetype = wp_check_filetype($filename);
    $id = wp_insert_attachment(array(
        'post_mime_type' => $filetype['type'],
        'post_title' => sanitize_file_name(pathinfo($filename, PATHINFO_FILENAME)),
        'post_status' => 'inherit',
    ), $upload['file']);

    if (is_wp_error($id) || !$id) {
        return 0;
    }

    require_once ABSPATH . 'wp-admin/includes/image.php';
    wp_update_attachment_metadata($id, wp_generate_attachment_metadata($id, $upload['file']));
    update_post_meta($id, '_mastrade_file', $filename);

    return (int) $id;
}
