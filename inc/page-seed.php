<?php

defined('ABSPATH') || exit;

add_action('init', 'mastrade_refresh_inner_pages', 32);
add_action('init', 'mastrade_append_about_closing', 33);
add_action('init', 'mastrade_refresh_sustainability', 34);
add_action('init', 'mastrade_refresh_profile', 35);
add_action('init', 'mastrade_refresh_gallery', 36);
add_action('init', 'mastrade_refresh_catalog', 37);
add_action('init', 'mastrade_refresh_about_pages', 38);
add_action('init', 'mastrade_refresh_team_page', 39);
add_action('init', 'mastrade_refresh_team_layout', 40);
add_action('init', 'mastrade_refresh_quote_fields', 41);
add_action('init', 'mastrade_refresh_faq_layout', 42);

function mastrade_refresh_inner_pages()
{
    if (get_option('mastrade_pages_v1') || !get_option('mastrade_seeded_v1')) {
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
        'hero' => 'hero.png',
        'who_main' => 'who-main.png',
        'who_detail' => 'who-detail.png',
        'experience_main' => 'experience-main.png',
        'experience_detail' => 'experience-detail.png',
        'manufacturing_main' => 'manufacturing-main.png',
        'manufacturing_detail' => 'manufacturing-detail.png',
        'product_women' => 'product-women.png',
        'product_men' => 'product-men.png',
        'product_kids' => 'product-kids.png',
        'product_medical' => 'product-medical.png',
        'profile_main' => 'profile-main.png',
        'profile_detail' => 'profile-detail.png',
    );

    $images = array();
    foreach ($files as $key => $file) {
        $images[$key] = mastrade_import_image($file);
    }

    $pages = array(
        'about-us' => mastrade_about_content($images),
        'products' => mastrade_products_page_content($images),
        'our-buyers' => mastrade_banner_content($images['hero'], 'Trusted by Global Brands', 'Our Buyers') . mastrade_block('mastrade-gallery', array(
            'heading' => 'Trusted by Global Brands',
            'intro' => '',
            'fit' => 'cover',
            'images' => array(),
        )),
        'certifications' => mastrade_banner_content($images['hero'], 'Compliance & Certifications', 'Certifications') . mastrade_block('mastrade-gallery', array(
            'heading' => 'Compliance & Certifications',
            'intro' => '',
            'fit' => 'contain',
            'images' => array(),
        )),
        'sustainability' => mastrade_sustainability_content($images),
        'company-profile' => mastrade_profile_content($images),
        'contact-us' => mastrade_contact_page_content($images),
    );

    foreach ($pages as $slug => $content) {
        $page = get_page_by_path($slug);
        if (!$page) {
            continue;
        }
        wp_update_post(array(
            'ID' => $page->ID,
            'post_content' => wp_slash($content),
        ));
    }

    update_option('mastrade_pages_v1', 1);

    if ($previous_user) {
        wp_set_current_user($previous_user);
    }
}

function mastrade_about_content($images)
{
    $content = mastrade_banner_content($images['hero'], 'About Mastrade International Garments Ltd.', 'About Us');

    $content .= mastrade_block('mastrade-split', array(
        'media_side' => 'left',
        'background' => 'white',
        'text_style' => 'lead',
        'list_style' => 'bullet',
        'heading' => 'Who We Are',
        'content' => '<p><strong>Mastrade International Garments Ltd.</strong> is a fully compliant apparel manufacturing company based in Gazipur, Bangladesh. <strong>Established in 1991</strong>, we have grown into a trusted manufacturing partner for leading global fashion brands and retailers.</p><p>For more than three decades, Mastrade has been delivering <strong>consistent quality, operational reliability, and ethical manufacturing</strong> – supporting buyers across diverse product categories and market requirements. Our long-standing success is built on trust, transparency, and disciplined execution at every level of our operation.</p>',
        'image_main' => $images['who_main'],
        'image_detail' => $images['who_detail'],
    ));

    $content .= mastrade_block('mastrade-split', array(
        'media_side' => 'right',
        'background' => 'soft',
        'text_style' => 'body',
        'list_style' => 'bullet',
        'heading' => 'Experience That Delivers Confidence',
        'content' => '<p>With over 30 years of industry experience, we understand the realities of global sourcing—tight timelines, seasonal variations, evolving compliance requirements, and the need for flexibility.</p><p>Our buyers value us for:</p><ul><li>Quality consistency across repeat orders</li><li>SMED-based fast changeover capability</li><li>Product versatility across fabrics and styles</li><li>Reliable lead-time management</li><li>Stable workforce ensuring operational continuity</li></ul><p>This experience allows us to act not just as a manufacturer, but as a long-term sourcing partner.</p>',
        'image_main' => $images['experience_main'],
        'image_detail' => $images['experience_detail'],
    ));

    $content .= mastrade_block('mastrade-split', array(
        'media_side' => 'left',
        'background' => 'white',
        'text_style' => 'body',
        'list_style' => 'bullet',
        'heading' => 'Our Manufacturing Strength',
        'content' => '<p>Our vertically coordinated manufacturing setup enables us to manage <strong>high-volume production without compromising quality or compliance</strong>.</p><ul><li><strong>25 modern production lines</strong></li><li><strong>3,000 skilled and experienced employees</strong></li><li><strong>Monthly capacity of 650,000 to 900,000 pieces</strong></li><li><strong>Multi-category production capability</strong></li></ul><p>By combining skilled craftsmanship with advanced machinery and standardized operating systems, we ensure precision, consistency, and on-time delivery across every order.</p>',
        'image_main' => $images['manufacturing_main'],
        'image_detail' => $images['manufacturing_detail'],
    ));

    $content .= mastrade_block('mastrade-split', array(
        'media_side' => 'left',
        'background' => 'white',
        'text_style' => 'body',
        'list_style' => 'bullet',
        'heading' => 'Compliance & Ethical Manufacturing',
        'content' => '<ul><li>Accord / RSC (100% Score)</li><li>WRAP</li><li>Sedex</li><li>GRS &amp; RCS</li><li>C-TPAT</li><li>BSCI</li><li>OEKO-TEX</li><li>Better Work</li><li>Higg FEM</li><li>BCI</li></ul>',
        'button_text' => 'Our Certifications',
        'button_link' => home_url('/certifications/'),
    ));

    $content .= mastrade_block('mastrade-reasons', array(
        'heading' => 'Our People, Our Strength',
        'intro' => '',
        'cards' => array(
            array('_type' => '_', 'number' => '1', 'title' => 'Respect and fairness', 'text' => ''),
            array('_type' => '_', 'number' => '2', 'title' => 'Skill development and training', 'text' => ''),
            array('_type' => '_', 'number' => '3', 'title' => 'Performance recognition', 'text' => ''),
            array('_type' => '_', 'number' => '4', 'title' => 'Long-term employment stability', 'text' => ''),
        ),
    ));

    $content .= mastrade_about_closing();

    return $content;
}

function mastrade_about_closing()
{
    $content = mastrade_block('mastrade-copy', array(
        'align' => 'center',
        'background' => 'white',
        'heading' => '',
        'content' => '<p>This people-first approach directly translates into <strong>higher efficiency, lower defect rates, and consistent delivery performance</strong> for our buyers.</p>',
    ));

    $content .= mastrade_block('mastrade-pair', array(
        'background' => 'muted',
        'left_title' => 'Our Mission',
        'left_content' => '<p>To consistently deliver exceptional apparel solutions through advanced technology, skilled craftsmanship and ethical sourcing, fostering long-term partnerships and inspiring confidence in every garment.</p>',
        'right_title' => 'Our Vision',
        'right_content' => '<p>To be the leading global apparel manufacturer recognized for innovation, quality, and sustainable practices, shaping the future of fashion.</p>',
    ));

    $content .= mastrade_block('mastrade-copy', array(
        'align' => 'center',
        'background' => 'white',
        'heading' => 'Looking Ahead',
        'content' => '<p>With an annual turnover of <strong>USD 30 million</strong> and a clear focus on responsible growth, Mastrade continues to strengthen its capabilities while staying true to its core values – quality, compliance, and reliability.</p><p><strong>Mastrade International Garments Ltd.</strong><br>A manufacturing partner you can trust – today and for the future.</p>',
    ));

    return $content;
}

function mastrade_append_about_closing()
{
    if (get_option('mastrade_about_closing_v1')) {
        return;
    }

    $page = get_page_by_path('about-us');
    if (!$page) {
        return;
    }

    if (strpos($page->post_content, 'Our Mission') !== false) {
        update_option('mastrade_about_closing_v1', 1);
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

    wp_update_post(array(
        'ID' => $page->ID,
        'post_content' => wp_slash($page->post_content . "\n" . mastrade_about_closing()),
    ));

    update_option('mastrade_about_closing_v1', 1);

    if ($previous_user) {
        wp_set_current_user($previous_user);
    }
}

function mastrade_catalog_rows($prefix)
{
    $rows = array();
    $paths = glob(THEME_DIR . '/assets/images/catalog-' . $prefix . '-*');
    if (!$paths) {
        return $rows;
    }
    natsort($paths);
    foreach ($paths as $path) {
        $id = mastrade_import_image(basename($path));
        if ($id) {
            $rows[] = array(
                '_type' => '_',
                'image' => $id,
            );
        }
    }

    return $rows;
}

function mastrade_products_page_content($images)
{
    $content = mastrade_banner_content($images['hero'], 'Our Products', 'Products');
    $content .= mastrade_block('mastrade-products', array(
        'heading' => 'Our Products',
        'intro' => '<p>By making fashion a matter of both elegance and convenience, Latest Attire strives to master the craft of innovation. We strive to improve comfort in all our woven, knit, and other products.</p>',
        'items' => array(
            array('_type' => '_', 'slug' => 'womens-wear', 'image' => $images['product_women'], 'title' => "Women's Wear", 'content' => '<p>KEY CATEGORIES :<br>Tops – Blouses, shirts, dresses, robes, vest, cam, t-shirts etc.<br>Bottoms – Trousers, palazzo, skirts, shorts, skorts etc.<br>Outerwear – Blazers, coats, overcoats, trench coats, bombers jackets, cardigans, coatigans etc.</p>', 'button_text' => 'View Gallery', 'button_link' => home_url('/products/womens-wear/'), 'gallery' => mastrade_catalog_rows('women')),
            array('_type' => '_', 'slug' => 'mens-wear', 'image' => $images['product_men'], 'title' => "Men's Wear", 'content' => '<p>KEY CATEGORIES :<br>Tops – Shirts, t-shirts, etc.<br>Bottoms – Trousers, pyjamas, boxers, shorts etc.<br>Outer wears – Blazers, coats, overcoats, trench coats, bombers jackets, shackets etc.</p>', 'button_text' => 'View Gallery', 'button_link' => home_url('/products/mens-wear/'), 'gallery' => mastrade_catalog_rows('men')),
            array('_type' => '_', 'slug' => 'kids-wear', 'image' => $images['product_kids'], 'title' => "Kid's Wear", 'content' => '<p>KEY CATEGORIES :<br>Boys – Shirts, t-shirts, trousers, shorts etc.<br>Girls – Frocks, dresses, jumpsuits, rompers etc.<br>Outerwear – Coats, cardigans, bomber jackets etc.</p>', 'button_text' => 'View Gallery', 'button_link' => home_url('/products/kids-wear/'), 'gallery' => mastrade_catalog_rows('kids')),
            array('_type' => '_', 'slug' => 'medical-wear', 'image' => $images['product_medical'], 'title' => 'Medical Wear', 'content' => '<p>KEY CATEGORIES :<br>Tops<br>Bottoms<br>Jackets</p>', 'button_text' => 'View Gallery', 'button_link' => home_url('/products/medical-wear/'), 'gallery' => mastrade_catalog_rows('medical')),
        ),
    ));

    return $content;
}

function mastrade_refresh_catalog()
{
    if (get_option('mastrade_catalog_v1') || !get_option('mastrade_seeded_v1')) {
        return;
    }

    $page = get_page_by_path('products');
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

    $images = array(
        'hero' => mastrade_import_image('hero.png'),
        'product_women' => mastrade_import_image('product-women.png'),
        'product_men' => mastrade_import_image('product-men.png'),
        'product_kids' => mastrade_import_image('product-kids.png'),
        'product_medical' => mastrade_import_image('product-medical.png'),
    );

    wp_update_post(array(
        'ID' => $page->ID,
        'post_content' => wp_slash(mastrade_products_page_content($images)),
    ));

    flush_rewrite_rules(false);
    update_option('mastrade_catalog_v1', 1);

    if ($previous_user) {
        wp_set_current_user($previous_user);
    }
}

function mastrade_sustainability_images($images = array())
{
    $files = array(
        'commit_main' => 'sustain-commit-main.png',
        'commit_detail' => 'sustain-commit-detail.png',
        'env_main' => 'sustain-env-main.png',
        'env_detail' => 'sustain-env-detail.png',
        'ethical_main' => 'sustain-ethical-main.png',
        'ethical_detail' => 'sustain-ethical-detail.png',
        'compliance_main' => 'sustain-compliance-main.png',
        'compliance_detail' => 'sustain-compliance-detail.png',
        'future_main' => 'sustain-future-main.jpg',
        'future_detail' => 'sustain-future-detail.jpg',
        'purpose' => 'sustain-purpose.png',
    );

    foreach ($files as $key => $file) {
        if (empty($images[$key])) {
            $images[$key] = mastrade_import_image($file);
        }
    }

    return $images;
}

function mastrade_sustainability_content($images)
{
    $images = mastrade_sustainability_images($images);
    $section = array(
        'heading_size' => 'section',
        'text_style' => 'body',
        'list_style' => 'icon',
    );

    $content = mastrade_banner_content($images['hero'], 'Sustainability', 'Sustainability');

    $content .= mastrade_block('mastrade-split', array_merge($section, array(
        'media_side' => 'right',
        'background' => 'white',
        'intro_heading' => 'Responsible Manufacturing. Ethical Operations. Long-Term Impact',
        'heading' => 'Our Commitment to Responsible Manufacturing',
        'content' => '<p>At <strong>Mastrade International Garments Ltd.</strong>, sustainability and responsibility are not treated as standalone initiatives—they are embedded into how we operate, manage people, and plan for long-term growth.</p><p>We believe responsible manufacturing is essential to:</p><ul><li>Protect the environment</li><li>Ensure worker safety and wellbeing</li><li>Maintain buyer trust and compliance</li><li>Support sustainable business growth</li></ul><p>Our ESG approach aligns with international standards and evolving global sourcing expectations.</p>',
        'image_main' => $images['commit_main'],
        'image_detail' => $images['commit_detail'],
    )));

    $content .= mastrade_block('mastrade-split', array_merge($section, array(
        'media_side' => 'left',
        'background' => 'soft',
        'heading' => 'Environmental Responsibility',
        'content' => '<p>We continuously invest in systems and practices that reduce environmental impact while improving operational efficiency.</p><h3>Energy Efficiency &amp; Renewable Energy</h3><ul><li>Use of solar panel system to reduce reliance on non-renewable energy.</li><li>Continuous monitoring to improve energy efficiency across operations.</li></ul><h3>Water Management Energy</h3><ul><li>Advance water waste management system.</li><li>Rainwater harvesting and recycling for industrial use.</li><li>Responsible discharge practices aligned with regulatory requirements.</li></ul><p>These initiatives help minimize resource consumption and support environmentally responsible production.</p>',
        'image_main' => $images['env_main'],
        'image_detail' => $images['env_detail'],
    )));

    $content .= mastrade_block('mastrade-split', array_merge($section, array(
        'media_side' => 'right',
        'background' => 'white',
        'heading' => 'Ethical Workplace & Social Responsibility',
        'content' => '<p>Our people are the foundation of our success. We maintain a safe, respectful, and inclusive working environment where rights, dignity, and wellbeing are protected.</p><h3>Worker Welfare &amp; Safety</h3><ul><li>Fully compliant fire safety infrastructure.</li><li>Regular safety training and emergency preparedness drills.</li><li>Secure factory premises with trained security personnel</li></ul><h3>Employee Wellbeing</h3><ul><li>Daycare facilities to support working parents.</li><li>Clean, accessible, and hygienic workplace facilities.</li><li>Fair employment practices and transparent policies.</li></ul><p>This disciplined approach allows us to meet evolving ESG expectations with confidence.</p>',
        'image_main' => $images['ethical_main'],
        'image_detail' => $images['ethical_detail'],
    )));

    $content .= mastrade_block('mastrade-split', array_merge($section, array(
        'media_side' => 'left',
        'background' => 'soft',
        'list_style' => 'chips',
        'heading' => 'Compliance & Governance',
        'content' => '<p>Mastrade operates under a compliance-first governance framework, ensuring transparency, accountability, and audit readiness at all times.</p><p>Our factory is <strong>regularly audited and certified by globally</strong> recognized organizations, including:</p><ul><li>Accord</li><li>RSC (100% score)</li><li>WRAP</li><li>Sedex</li><li>GRS</li><li>C-TPAT</li><li>BSCI</li><li>Okeo-Tex</li><li>Better Work</li><li>Higg FEM</li><li>BCI</li></ul><h3>These certifications reflect our commitment to:</h3><ul><li>Ethical labor practices</li><li>Workplace safety</li><li>Environmental responsibility</li><li>Supply chain transparency</li></ul><p>We believe a stable, supported workforce directly contributes to higher quality, productivity, and consistency.</p>',
        'button_text' => 'Learn More',
        'button_link' => home_url('/certifications/'),
        'image_main' => $images['compliance_main'],
        'image_detail' => $images['compliance_detail'],
    )));

    $content .= mastrade_block('mastrade-split', array_merge($section, array(
        'media_side' => 'right',
        'background' => 'white',
        'heading' => 'Continuous Improvement & Future Focus',
        'content' => '<p><strong>Sustainability is an ongoing journey. At Mastrade, we are committed to:</strong></p><ul><li>Enhancing environmental performance through innovation.</li><li>Strengthening worker engagement and skill development.</li><li>Aligning operations with future ESG standards and buyer expectations.</li></ul><p>Our focus is on building a manufacturing operation that is <strong>responsible today and resilient for the future</strong>.</p>',
        'image_main' => $images['future_main'],
        'image_detail' => $images['future_detail'],
    )));

    $content .= mastrade_block('mastrade-split', array_merge($section, array(
        'media_side' => 'left',
        'background' => 'soft',
        'list_style' => 'bullet',
        'heading' => 'Manufacturing with Purpose',
        'content' => '<p><strong>Responsible manufacturing is not just about compliance – it is about doing business the right way.</strong></p><p>At <strong>Mastrade International Garments Ltd.</strong>, sustainability, ethics, and accountability guide every decision we make – ensuring our partners can source with confidence and integrity.</p>',
        'image_main' => $images['purpose'],
    )));

    return $content;
}

function mastrade_refresh_sustainability()
{
    if (get_option('mastrade_sustainability_v2') || !get_option('mastrade_seeded_v1')) {
        return;
    }

    $page = get_page_by_path('sustainability');
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

    $images = mastrade_sustainability_images(array(
        'hero' => mastrade_import_image('hero.png'),
    ));

    wp_update_post(array(
        'ID' => $page->ID,
        'post_content' => wp_slash(mastrade_sustainability_content($images)),
    ));

    update_option('mastrade_sustainability_v2', 1);

    if ($previous_user) {
        wp_set_current_user($previous_user);
    }
}

function mastrade_profile_content($images)
{
    if (empty($images['profile_video'])) {
        $images['profile_video'] = mastrade_import_image('profile-video.png');
    }

    $content = mastrade_banner_content($images['hero'], 'Our Profile', 'Company Profile');
    $content .= mastrade_block('mastrade-split', array(
        'media_side' => 'right',
        'background' => 'white',
        'text_style' => 'body',
        'list_style' => 'icon',
        'heading' => 'A Comprehensive Overview of Our Manufacturing Capability',
        'content' => '<p>The Mastrade International Garments Ltd. Company Profile presents a clear, structured overview of our manufacturing strength, compliance framework, sustainability practices, and long-term business vision.</p><p>Designed for international buyers, sourcing managers, and compliance teams, this document reflects who we are, how we operate, and why global brands trust Mastrade as a long-term manufacturing partner.</p><h3 class="product-title">Why Buyers Download Our Company Profile?</h3><ul><li>Clear, visual overview of factory capability</li><li>Compliance and ESG-aligned presentation</li><li>Ideal for sourcing evaluation and internal sharing</li><li>Supports audit preparation and buyer onboarding</li><li>Reflects long-term stability and growth vision</li></ul>',
        'button_text' => 'Download Company Profile',
        'button_link' => 'https://mastradebd.com/wp-content/uploads/2026/04/PDF-Version-Mastrade-Corporate-Profile-4.pdf',
        'image_main' => $images['profile_main'],
        'image_detail' => $images['profile_detail'],
    ));
    $content .= mastrade_block('mastrade-split', array(
        'media_side' => 'right',
        'background' => 'soft',
        'text_style' => 'body',
        'list_style' => 'bullet',
        'image_layout' => 'poster',
        'heading' => 'Corporate AV | Our Vision in Motion',
        'content' => '<p>Experience the essence of Mastrade through compelling visuals that highlight our mission, values, and impact.</p>',
        'button_text' => 'Watch the video',
        'button_link' => 'https://www.youtube.com/watch?v=vWRoKLLQ8X4',
        'image_main' => $images['profile_video'],
    ));

    return $content;
}

function mastrade_refresh_profile()
{
    if (get_option('mastrade_profile_v2') || !get_option('mastrade_seeded_v1')) {
        return;
    }

    $page = get_page_by_path('company-profile');
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

    $images = array(
        'hero' => mastrade_import_image('hero.png'),
        'profile_main' => mastrade_import_image('profile-main.png'),
        'profile_detail' => mastrade_import_image('profile-detail.png'),
        'profile_video' => mastrade_import_image('profile-video.png'),
    );

    wp_update_post(array(
        'ID' => $page->ID,
        'post_content' => wp_slash(mastrade_profile_content($images)),
    ));

    update_option('mastrade_profile_v2', 1);

    if ($previous_user) {
        wp_set_current_user($previous_user);
    }
}

function mastrade_contact_page_content($images)
{
    $content = mastrade_banner_content($images['hero'], 'Contact Us', 'Contact Us');
    $content .= mastrade_block('mastrade-contact', array(
        'heading' => 'Ask Your Query',
        'intro' => '<p>Have something to discuss? Our team is available to assist you at any time.</p>',
        'label_first_name' => 'First Name',
        'label_last_name' => 'Last Name',
        'label_phone' => 'Your Phone',
        'label_email' => 'Your Email',
        'label_message' => 'Write your message',
        'button_text' => 'Send Message',
        'recipient' => 'info@mastradebd.com',
        'map_embed' => 'https://maps.google.com/maps?q=Helal+Complex,+Plot+72,+Bypass+Biswa+Road,+Mogarkhal,+Gazipur+1701&z=14&output=embed',
        'location_title' => 'Our Location',
        'office_title' => 'Corporate Office',
        'address' => 'Helal Complex, Plot # 72, Bypass Biswa Road, Mogarkhal, Gazipur 1701',
        'email' => 'info@mastradebd.com',
        'phone' => '+880 1618-667434',
    ));

    return $content;
}

function mastrade_gallery_content()
{
    $clips = array(
        'sqt0k-A6ZT4',
        'ikp1j-BdGgc',
        'M39IwDqo4C0',
        'srJJxRGbujE',
        'RjUuITuK5-0',
        'sNlWakWKWb4',
    );
    $videos = array();
    foreach ($clips as $id) {
        $videos[] = array(
            '_type' => '_',
            'url' => 'https://youtu.be/' . $id,
            'poster' => mastrade_import_image('gallery-' . $id . '.jpg'),
        );
    }

    return mastrade_block('mastrade-library', array(
        'crumb' => 'Gallery',
        'image_label' => 'Image',
        'video_label' => 'Video',
        'start' => 'video',
        'images' => array(),
        'videos' => $videos,
    ));
}

function mastrade_refresh_gallery()
{
    if (get_option('mastrade_gallery_v1') || !get_option('mastrade_seeded_v1')) {
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

    $page_id = mastrade_ensure_page('gallery', 'Gallery', mastrade_gallery_content());
    if ($page_id) {
        wp_update_post(array(
            'ID' => $page_id,
            'post_content' => wp_slash(mastrade_gallery_content()),
        ));
    }

    $locations = get_nav_menu_locations();
    if (!empty($locations['footer']) && $page_id) {
        $menu_id = (int) $locations['footer'];
        $items = wp_get_nav_menu_items($menu_id);
        if ($items) {
            foreach ($items as $item) {
                if ($item->title !== 'Gallery') {
                    continue;
                }
                wp_update_nav_menu_item($menu_id, (int) $item->ID, array(
                    'menu-item-title' => 'Gallery',
                    'menu-item-object' => 'page',
                    'menu-item-object-id' => $page_id,
                    'menu-item-type' => 'post_type',
                    'menu-item-status' => 'publish',
                    'menu-item-parent-id' => (int) $item->menu_item_parent,
                ));
            }
        }
    }

    update_option('mastrade_gallery_v1', 1);

    if ($previous_user) {
        wp_set_current_user($previous_user);
    }
}

function mastrade_team_content($image, $omar = 0, $anik = 0)
{
    $member = function ($name, $role, $photo) {
        return array('_type' => '_', 'title' => $name, 'text' => $role, 'image' => $photo);
    };

    $content = mastrade_banner_content($image, 'Our Team', 'Team');
    $content .= mastrade_block('mastrade-team', array(
        'eyebrow' => '01. Meet Our Team',
        'heading' => 'Meet With Our Honest Leadership',
        'members' => array(
            $member('Omar Faruque Chowdhury', 'Managing Director', $omar),
            $member('Md Lutfor Rahman Anik', 'Manager ( Merchandising )', $anik),
        ),
    ));
    $content .= mastrade_quote_block();

    return $content;
}

function mastrade_faq_content($image)
{
    $item = function ($question, $answer) {
        return array('_type' => '_', 'question' => $question, 'answer' => $answer);
    };

    $content = mastrade_banner_content($image, 'FAQ', 'FAQ');
    $content .= mastrade_block('mastrade-faq', array(
        'heading' => 'Questions Buyers Ask',
        'intro' => '<p>A short guide to how Mastrade manufactures, what we make, and how to start a conversation.</p>',
        'items' => array(
            $item('Where is Mastrade located?', '<p>Our factory and corporate office are at Helal Complex, Plot # 72, Bypass Biswa Road, Mogarkhal, Gazipur 1701, Bangladesh.</p>'),
            $item('What do you manufacture?', '<p>We produce women’s wear, men’s wear, kids’ wear, and medical wear for international fashion brands and retailers.</p>'),
            $item('How large is the factory?', '<p>The factory runs 25 production lines with about 3,000 employees and a monthly capacity of 650,000 to 900,000 pieces.</p>'),
            $item('Which compliance standards do you follow?', '<p>Our program includes Accord / RSC, WRAP, Sedex, GRS and RCS, C-TPAT, BSCI, OEKO-TEX, Better Work, Higg FEM, and BCI.</p>'),
            $item('How can we start a production discussion?', '<p>Send your requirement through the contact form, or email <a href="mailto:info@mastradebd.com">info@mastradebd.com</a>. The team can also be reached at +880 1618-667434.</p>'),
        ),
    ));
    $content .= mastrade_quote_block();

    return $content;
}

function mastrade_quote_block()
{
    return mastrade_block('mastrade-quote', array(
        'items' => array(
            array(
                '_type' => '_',
                'image' => 0,
                'quote' => 'I absolutely love my the new modern living room! The clean lines, a neutral tones, and minimalist interior create such a calming & stylish atmosphere. Highly recommend their modern interior design services!',
                'name' => 'Morgan Dufresne',
                'role' => 'Journalist',
            ),
        ),
    ));
}

function mastrade_refresh_about_pages()
{
    if (get_option('mastrade_about_pages_v1') || !get_option('mastrade_seeded_v1')) {
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

    $image = mastrade_import_image('hero.png');
    $pages = array(
        'team' => array('Team', mastrade_team_content($image)),
        'faq' => array('FAQ', mastrade_faq_content($image)),
    );

    $ids = array();
    foreach ($pages as $slug => $page) {
        $ids[$slug] = mastrade_ensure_page($slug, $page[0], '');
        if ($ids[$slug]) {
            wp_update_post(array(
                'ID' => $ids[$slug],
                'post_title' => $page[0],
                'post_content' => wp_slash($page[1]),
            ));
        }
    }

    $locations = get_nav_menu_locations();
    $menu_id = (int) ($locations['primary'] ?? 0);
    $about = get_page_by_path('about-us');
    if ($menu_id && $about) {
        $items = wp_get_nav_menu_items($menu_id);
        $parent_id = 0;
        $linked = array();
        foreach ((array) $items as $item) {
            if ($item->object === 'page' && (int) $item->object_id === (int) $about->ID && !(int) $item->menu_item_parent) {
                $parent_id = (int) $item->ID;
            }
            $linked[(int) $item->object_id] = (int) $item->menu_item_parent;
        }
        if ($parent_id) {
            foreach (array('Team' => $ids['team'], 'FAQ' => $ids['faq']) as $label => $page_id) {
                if (!$page_id || (($linked[$page_id] ?? 0) === $parent_id)) {
                    continue;
                }
                wp_update_nav_menu_item($menu_id, 0, array(
                    'menu-item-title' => $label,
                    'menu-item-object' => 'page',
                    'menu-item-object-id' => $page_id,
                    'menu-item-type' => 'post_type',
                    'menu-item-status' => 'publish',
                    'menu-item-parent-id' => $parent_id,
                ));
            }
        }
    }

    update_option('mastrade_about_pages_v1', 1);

    if ($previous_user) {
        wp_set_current_user($previous_user);
    }
}

function mastrade_refresh_team_page()
{
    if (get_option('mastrade_team_v2') || !get_option('mastrade_seeded_v1')) {
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

    $page_id = mastrade_ensure_page('team', 'Team', '');
    if ($page_id) {
        wp_update_post(array(
            'ID' => $page_id,
            'post_content' => wp_slash(mastrade_team_content(
                mastrade_import_image('hero.png'),
                mastrade_import_image('team-omar.png'),
                mastrade_import_image('team-anik.png')
            )),
        ));
    }

    update_option('mastrade_team_v2', 1);

    if ($previous_user) {
        wp_set_current_user($previous_user);
    }
}

function mastrade_refresh_team_layout()
{
    if (get_option('mastrade_team_v3') || !get_option('mastrade_seeded_v1')) {
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

    $page = get_page_by_path('team');
    if ($page) {
        wp_update_post(array(
            'ID' => $page->ID,
            'post_content' => wp_slash(mastrade_team_content(
                mastrade_import_image('hero.png'),
                mastrade_import_image('team-omar.png'),
                mastrade_import_image('team-anik.png')
            )),
        ));
    }

    update_option('mastrade_team_v3', 1);

    if ($previous_user) {
        wp_set_current_user($previous_user);
    }
}

function mastrade_refresh_quote_fields()
{
    if (get_option('mastrade_quote_v1') || !get_option('mastrade_seeded_v1')) {
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

    $page = get_page_by_path('team');
    if ($page) {
        wp_update_post(array(
            'ID' => $page->ID,
            'post_content' => wp_slash(mastrade_team_content(
                mastrade_import_image('hero.png'),
                mastrade_import_image('team-omar.png'),
                mastrade_import_image('team-anik.png')
            )),
        ));
    }

    update_option('mastrade_quote_v1', 1);

    if ($previous_user) {
        wp_set_current_user($previous_user);
    }
}

function mastrade_refresh_faq_layout()
{
    if (get_option('mastrade_faq_v2') || !get_option('mastrade_seeded_v1')) {
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

    $page = get_page_by_path('faq');
    if ($page) {
        wp_update_post(array(
            'ID' => $page->ID,
            'post_content' => wp_slash(mastrade_faq_content(mastrade_import_image('hero.png'))),
        ));
    }

    update_option('mastrade_faq_v2', 1);

    if ($previous_user) {
        wp_set_current_user($previous_user);
    }
}
