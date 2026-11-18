<?php

defined('ABSPATH') || exit;

add_action('init', 'mastrade_seed_content', 30);
add_action('init', 'mastrade_refresh_home_sections', 31);
add_action('init', 'mastrade_insert_advantage_section', 32);
add_action('init', 'mastrade_insert_workflow_section', 33);
add_action('init', 'mastrade_insert_testimonials_section', 34);
add_action('init', 'mastrade_refresh_testimonials_slider', 35);
add_action('init', 'mastrade_refresh_compliance_logos', 36);
add_action('init', 'mastrade_insert_quote_banner', 37);
add_action('init', 'mastrade_connect_quote_form', 38);

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

    $content .= mastrade_advantage_block($images);

    $content .= mastrade_workflow_block();

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
        'image_detail' => $images['compliance_detail'] ?? 0,
        'heading' => 'Globally Recognized Compliance Standards',
        'content' => '<p>Our operations are certified and audited by internationally recognized organizations, ensuring full compliance with buyer and regulatory requirements.</p><p><strong>Key Certifications Include:</strong><br>Accord / RSC, WRAP, GRS, RCS, C-TPAT, BSCI, OEKO-TEX, Better Work, Sedex, Higg FEM, BCI.</p>',
        'button_text' => 'Our Certifications',
        'button_link' => home_url('/certifications/'),
        'logos' => mastrade_compliance_logo_items(),
    ));

    $content .= mastrade_block('mastrade-brands', array(
        'heading' => 'TRUSTED BY GLOBAL BRANDS',
        'intro' => '<p>Our partnerships are built on long-term trust, operational reliability, and ethical manufacturing excellence.</p>',
        'logos' => array(),
        'button_text' => 'Our buyers',
        'button_link' => home_url('/our-buyers/'),
    ));

    $content .= mastrade_testimonials_block();

    $content .= mastrade_block('mastrade-snapshot', array(
        'heading' => 'Business Strength Snapshot',
        'content' => '<ul><li><strong>Annual Turnover:</strong> USD 30 Million</li><li><strong>Monthly Capacity:</strong> Up to 900,000 Pieces</li><li><strong>Production Lines:</strong> 25</li><li><strong>Workforce:</strong> 3,000 Employees</li></ul><p>This reflects our ability to scale responsibly while maintaining quality and compliance.</p>',
        'button_text' => 'Know more about us',
        'button_link' => home_url('/about-us/'),
        'image' => $images['snapshot'] ?? 0,
    ));

    $content .= mastrade_quote_banner_block($images);

    return $content;
}

function mastrade_quote_form_markup()
{
    return implode("\n", array(
        '<label><span class="screen-reader-text">Full Name*</span>[text* full-name placeholder "Full Name*"]</label>',
        '<label><span class="screen-reader-text">Email Address*</span>[email* email placeholder "Email Address*"]</label>',
        '<label><span class="screen-reader-text">Phone*</span>[tel* phone placeholder "Phone*"]</label>',
        '<label><span class="screen-reader-text">Services*</span>[select* service first_as_label "Services*" "Knitwear" "Woven Garments" "Medical Wear" "Kids Wear" "Private Label"]</label>',
        '<label><span class="screen-reader-text">Date</span>[date preferred-date placeholder "mm/dd/yyyy"]</label>',
        '[submit "Get A Quote"]',
    ));
}

function mastrade_ensure_quote_form()
{
    if (!function_exists('wpcf7_contact_form')) {
        return 0;
    }

    $existing = get_posts(array(
        'post_type' => 'wpcf7_contact_form',
        'posts_per_page' => -1,
        'post_status' => 'any',
    ));
    foreach ($existing as $post) {
        if ($post->post_title === 'Request For A Quote') {
            return (int) $post->ID;
        }
    }

    $form = WPCF7_ContactForm::get_template(array(
        'title' => 'Request For A Quote',
    ));
    $recipient = get_option('admin_email');
    if (function_exists('carbon_get_theme_option')) {
        $office = sanitize_email(carbon_get_theme_option('office_email'));
        if ($office) {
            $recipient = $office;
        }
    }

    $form->set_properties(array(
        'form' => mastrade_quote_form_markup(),
        'mail' => array(
            'active' => true,
            'subject' => 'Quote request from [full-name]',
            'sender' => sprintf('%s <%s>', get_bloginfo('name'), $recipient),
            'recipient' => $recipient,
            'body' => "Name: [full-name]\nEmail: [email]\nPhone: [phone]\nService: [service]\nDate: [preferred-date]",
            'additional_headers' => 'Reply-To: [email]',
            'attachments' => '',
            'use_html' => false,
            'exclude_blank' => false,
        ),
    ));
    $form->save();

    return (int) $form->id();
}

function mastrade_quote_form_shortcode()
{
    $id = mastrade_ensure_quote_form();
    if (!$id) {
        return '';
    }

    return sprintf('[contact-form-7 id="%d" title="Request For A Quote"]', $id);
}

function mastrade_quote_banner_block($images = array())
{
    return mastrade_block('mastrade-quote-banner', array(
        'background' => $images['process_main'] ?? ($images['hero'] ?? 0),
        'form_title' => 'Request For A Quote',
        'form_text' => 'Please send us your message, we will reply within 20 hours.',
        'form_shortcode' => mastrade_quote_form_shortcode(),
        'eyebrow' => '08. GET IN TOUCH',
        'heading' => "Let's Grow Your Business - Talk to Us!",
        'address_label' => 'Address',
        'address' => "House No. 06 (Ground Floor), Road No. 04, Sector No. 13, Uttara Model Town, Dhaka-1230",
        'whatsapp_label' => 'WhatsApp',
        'whatsapp' => '+880 1319-50 7112',
        'email' => 'omar@reactivesynergy.com',
        'button_text' => 'Contact Us',
        'button_link' => home_url('/contact-us/'),
    ));
}

function mastrade_insert_quote_banner()
{
    if (get_option('mastrade_quote_banner_v1') || !get_option('mastrade_seeded_v1')) {
        return;
    }

    $home = get_page_by_path('home');
    if (!$home) {
        $front_id = (int) get_option('page_on_front');
        if ($front_id) {
            $home = get_post($front_id);
        }
    }

    if (!$home) {
        return;
    }

    if (strpos($home->post_content, 'mastrade-quote-banner') !== false) {
        update_option('mastrade_quote_banner_v1', 1);
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
        'process_main' => mastrade_import_image('process-main.png'),
        'hero' => mastrade_import_image('hero.png'),
    );

    wp_update_post(array(
        'ID' => $home->ID,
        'post_content' => wp_slash(mastrade_insert_block_after($home->post_content, mastrade_quote_banner_block($images), array(
            'carbon-fields/mastrade-snapshot',
            'carbon-fields/mastrade-testimonials',
        ))),
    ));

    update_option('mastrade_quote_banner_v1', 1);

    if ($previous_user) {
        wp_set_current_user($previous_user);
    }
}

function mastrade_connect_quote_form()
{
    if (get_option('mastrade_quote_form_v1') || !get_option('mastrade_seeded_v1')) {
        return;
    }

    if (!function_exists('wpcf7_contact_form')) {
        $plugin = 'contact-form-7/wp-contact-form-7.php';
        if (!file_exists(WP_PLUGIN_DIR . '/' . $plugin)) {
            return;
        }
        $active = (array) get_option('active_plugins', array());
        if (!in_array($plugin, $active, true)) {
            $active[] = $plugin;
            update_option('active_plugins', $active);
        }
        return;
    }

    $shortcode = mastrade_quote_form_shortcode();
    if (!$shortcode) {
        return;
    }

    $home = get_page_by_path('home');
    if (!$home) {
        $front_id = (int) get_option('page_on_front');
        if ($front_id) {
            $home = get_post($front_id);
        }
    }

    if (!$home || strpos($home->post_content, 'mastrade-quote-banner') === false) {
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

    $content = preg_replace_callback(
        '/<!-- wp:carbon-fields\/mastrade-quote-banner (\{.*?\}) \/-->/s',
        function ($matches) use ($shortcode) {
            $json = json_decode($matches[1], true);
            if (!is_array($json) || empty($json['data']) || !is_array($json['data'])) {
                return $matches[0];
            }
            if (!empty($json['data']['form_shortcode'])) {
                return $matches[0];
            }
            $json['data']['form_shortcode'] = $shortcode;
            return '<!-- wp:carbon-fields/mastrade-quote-banner ' . wp_json_encode($json, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . ' /-->';
        },
        $home->post_content,
        1
    );

    if (is_string($content) && $content !== $home->post_content) {
        wp_update_post(array(
            'ID' => $home->ID,
            'post_content' => wp_slash($content),
        ));
    }

    update_option('mastrade_quote_form_v1', 1);

    if ($previous_user) {
        wp_set_current_user($previous_user);
    }
}

function mastrade_advantage_block($images = array())
{
    return mastrade_block('mastrade-advantage', array(
        'background' => $images['process_main'] ?? 0,
        'eyebrow' => '03. OUR ADVANTAGE',
        'heading' => 'Source High Est Quality Yarn From Trusted Suppliers',
        'button_text' => 'Get Started',
        'button_link' => home_url('/contact-us/'),
        'cards' => array(
            array(
                '_type' => '_',
                'icon' => 'layers',
                'title' => 'Vibrant Selection',
                'text' => 'Sufficient fabric inventory with a wide variety of categories. Large amount of stock available for selection.',
            ),
            array(
                '_type' => '_',
                'icon' => 'sewing',
                'title' => 'Quality Assurance',
                'text' => 'With efficient production of 750 tons of fabric per month, we ensure timely delivery to help you stay on top of fashion trends.',
            ),
            array(
                '_type' => '_',
                'icon' => 'custom',
                'title' => 'Customized Requirements',
                'text' => 'Sufficient fabric inventory with a wide variety of categories. Large amount of stock available for selection.',
            ),
        ),
    ));
}

function mastrade_workflow_steps()
{
    return array(
        array('_type' => '_', 'icon' => 'inquiry', 'number' => '01', 'title' => 'Buyer Inquiry', 'text' => 'We receive the buyer’s product requirements, specifications, quantities, target price and delivery expectations.'),
        array('_type' => '_', 'icon' => 'sourcing', 'number' => '02', 'title' => 'Product & Sourcing', 'text' => 'We identify suitable sweater and knitwear sourcing options based on the buyer’s requirements.'),
        array('_type' => '_', 'icon' => 'yarn', 'number' => '03', 'title' => 'Yarn & Accessories Sourcing', 'text' => 'We coordinate yarn and required accessories and follow up on timely in-house availability.'),
        array('_type' => '_', 'icon' => 'costing', 'number' => '04', 'title' => 'Costing & CM Calculation', 'text' => 'We prepare and coordinate product costing and CM calculation according to the order requirements.'),
        array('_type' => '_', 'icon' => 'sample', 'number' => '05', 'title' => 'Sample & Product Development', 'text' => 'We coordinate product development and sampling with the relevant production partners before bulk production.'),
        array('_type' => '_', 'icon' => 'approval', 'number' => '06', 'title' => 'Buyer Approval', 'text' => 'Buyer comments, specifications and approvals are communicated to the production team for the next stage.'),
        array('_type' => '_', 'icon' => 'production', 'number' => '07', 'title' => 'Production Follow-Up', 'text' => 'We continuously follow up with the production team to monitor progress, materials and delivery schedules.'),
        array('_type' => '_', 'icon' => 'quality', 'number' => '08', 'title' => 'Quality Control', 'text' => 'Quality is followed throughout production, finishing and final inspection to support buyer requirements.'),
        array('_type' => '_', 'icon' => 'packing', 'number' => '09', 'title' => 'Finishing & Packing', 'text' => 'We follow up on finishing, packing and final order readiness, including packing-list preparation where required.'),
        array('_type' => '_', 'icon' => 'shipment', 'number' => '11', 'title' => 'Shipment Follow-Up', 'text' => 'We coordinate shipment follow-up and maintain communication with the buyer through the delivery stage.'),
    );
}

function mastrade_workflow_block()
{
    return mastrade_block('mastrade-workflow', array(
        'eyebrow' => '04. OUR WORKING PROCESS',
        'heading' => 'From Buyer Inquiry To Final Shipment',
        'steps' => mastrade_workflow_steps(),
    ));
}

function mastrade_testimonial_items()
{
    return array(
        array(
            '_type' => '_',
            'quote' => 'We are so confident in Extice that we are looking at other projects through their other site at Bury – They currently provide a processed Kevlar material for us, and we are working on a second source spreader project.',
            'name' => 'Nick Willams',
            'role' => 'Instructor',
        ),
        array(
            '_type' => '_',
            'quote' => 'The team kept sampling, costing, and production follow-up clear from the first inquiry through final shipment. Communication stayed steady at every stage.',
            'name' => 'Sarah Ahmed',
            'role' => 'Buying Manager',
        ),
        array(
            '_type' => '_',
            'quote' => 'Quality checks and packing updates arrived on time, so our delivery schedule stayed intact. We would place the next program with the same team.',
            'name' => 'James Carter',
            'role' => 'Sourcing Lead',
        ),
    );
}

function mastrade_testimonials_block()
{
    return mastrade_block('mastrade-testimonials', array(
        'eyebrow' => '07. CUSTOMER TESTIMONIALS',
        'heading' => 'What People Says About Textile Company',
        'items' => mastrade_testimonial_items(),
    ));
}

function mastrade_refresh_testimonials_slider()
{
    if (get_option('mastrade_testimonials_slider_v1') || !get_option('mastrade_seeded_v1')) {
        return;
    }

    $home = get_page_by_path('home');
    if (!$home) {
        $front_id = (int) get_option('page_on_front');
        if ($front_id) {
            $home = get_post($front_id);
        }
    }

    if (!$home || strpos($home->post_content, 'mastrade-testimonials') === false) {
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

    $count = 0;
    $ready = false;
    $content = preg_replace_callback(
        '/<!-- wp:carbon-fields\/mastrade-testimonials (\{.*?\}) \/-->/s',
        function ($matches) use (&$count, &$ready) {
            $json = json_decode($matches[1], true);
            if (!is_array($json) || empty($json['data']) || !is_array($json['data'])) {
                return $matches[0];
            }

            $items = isset($json['data']['items']) && is_array($json['data']['items']) ? $json['data']['items'] : array();
            if (count($items) > 1) {
                $ready = true;
                return $matches[0];
            }

            $next = mastrade_testimonial_items();
            if (!empty($items[0]['image'])) {
                $next[0]['image'] = $items[0]['image'];
            }
            $json['data']['items'] = $next;
            $count++;

            return '<!-- wp:carbon-fields/mastrade-testimonials ' . wp_json_encode($json, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . ' /-->';
        },
        $home->post_content,
        1
    );

    if ($count && is_string($content)) {
        wp_update_post(array(
            'ID' => $home->ID,
            'post_content' => wp_slash($content),
        ));
        $ready = true;
    }

    if (!$ready) {
        if ($previous_user) {
            wp_set_current_user($previous_user);
        }
        return;
    }

    update_option('mastrade_testimonials_slider_v1', 1);

    if ($previous_user) {
        wp_set_current_user($previous_user);
    }
}

function mastrade_compliance_logo_items()
{
    $items = array();
    foreach (array(
        'cert-accord.png',
        'cert-rsc.png',
        'cert-wrap.png',
        'cert-sedex.png',
        'cert-ctpat.png',
        'cert-grs.png',
        'cert-bsci.png',
        'cert-betterwork.png',
        'cert-oeko.png',
        'cert-higg.png',
        'cert-bci.png',
    ) as $file) {
        $id = mastrade_import_image($file);
        if (!$id) {
            continue;
        }
        $items[] = array(
            '_type' => '_',
            'image' => $id,
        );
    }

    return $items;
}

function mastrade_refresh_compliance_logos()
{
    if (get_option('mastrade_compliance_logos_v1') || !get_option('mastrade_seeded_v1')) {
        return;
    }

    $home = get_page_by_path('home');
    if (!$home) {
        $front_id = (int) get_option('page_on_front');
        if ($front_id) {
            $home = get_post($front_id);
        }
    }

    if (!$home || strpos($home->post_content, 'mastrade-compliance') === false) {
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

    $logos = mastrade_compliance_logo_items();
    $ready = false;
    $content = preg_replace_callback(
        '/<!-- wp:carbon-fields\/mastrade-compliance (\{.*?\}) \/-->/s',
        function ($matches) use ($logos, &$ready) {
            $json = json_decode($matches[1], true);
            if (!is_array($json) || empty($json['data']) || !is_array($json['data'])) {
                return $matches[0];
            }

            $existing = isset($json['data']['logos']) && is_array($json['data']['logos']) ? $json['data']['logos'] : array();
            if (count($existing) > 0 || !$logos) {
                $ready = true;
                return $matches[0];
            }

            $json['data']['logos'] = $logos;
            $json['data']['image_main'] = 0;
            $ready = true;

            return '<!-- wp:carbon-fields/mastrade-compliance ' . wp_json_encode($json, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . ' /-->';
        },
        $home->post_content,
        1
    );

    if (!$ready || !is_string($content)) {
        if ($previous_user) {
            wp_set_current_user($previous_user);
        }
        return;
    }

    if ($content !== $home->post_content) {
        wp_update_post(array(
            'ID' => $home->ID,
            'post_content' => wp_slash($content),
        ));
    }

    update_option('mastrade_compliance_logos_v1', 1);

    if ($previous_user) {
        wp_set_current_user($previous_user);
    }
}

function mastrade_insert_testimonials_section()
{
    if (get_option('mastrade_testimonials_v1') || !get_option('mastrade_seeded_v1')) {
        return;
    }

    $home = get_page_by_path('home');
    if (!$home) {
        $front_id = (int) get_option('page_on_front');
        if ($front_id) {
            $home = get_post($front_id);
        }
    }

    if (!$home) {
        return;
    }

    if (strpos($home->post_content, 'mastrade-testimonials') !== false) {
        update_option('mastrade_testimonials_v1', 1);
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
        'ID' => $home->ID,
        'post_content' => wp_slash(mastrade_insert_block_after($home->post_content, mastrade_testimonials_block(), array(
            'carbon-fields/mastrade-brands',
            'carbon-fields/mastrade-compliance',
        ))),
    ));

    update_option('mastrade_testimonials_v1', 1);

    if ($previous_user) {
        wp_set_current_user($previous_user);
    }
}

function mastrade_insert_block_after($content, $block, $markers)
{
    foreach ((array) $markers as $marker) {
        $pos = strpos($content, $marker);
        if ($pos === false) {
            continue;
        }

        $end = strpos($content, '-->', $pos);
        if ($end === false) {
            continue;
        }

        return substr($content, 0, $end + 3) . "\n" . $block . substr($content, $end + 3);
    }

    return rtrim($content) . "\n" . $block;
}

function mastrade_insert_workflow_section()
{
    if (get_option('mastrade_workflow_v1') || !get_option('mastrade_seeded_v1')) {
        return;
    }

    $home = get_page_by_path('home');
    if (!$home) {
        $front_id = (int) get_option('page_on_front');
        if ($front_id) {
            $home = get_post($front_id);
        }
    }

    $buyers = get_page_by_path('our-buyers');
    if (!$home && !$buyers) {
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

    $block = mastrade_workflow_block();

    if ($home && strpos($home->post_content, 'mastrade-workflow') === false) {
        wp_update_post(array(
            'ID' => $home->ID,
            'post_content' => wp_slash(mastrade_insert_block_after($home->post_content, $block, array(
                'carbon-fields/mastrade-advantage',
                'carbon-fields/mastrade-excellence',
            ))),
        ));
    }

    if ($buyers && strpos($buyers->post_content, 'mastrade-workflow') === false) {
        wp_update_post(array(
            'ID' => $buyers->ID,
            'post_content' => wp_slash(mastrade_insert_block_after($buyers->post_content, $block, array(
                'carbon-fields/mastrade-page-banner',
            ))),
        ));
    }

    update_option('mastrade_workflow_v1', 1);

    if ($previous_user) {
        wp_set_current_user($previous_user);
    }
}

function mastrade_insert_advantage_section()
{
    if (get_option('mastrade_advantage_v1') || !get_option('mastrade_seeded_v1')) {
        return;
    }

    $page = get_page_by_path('home');
    if (!$page && function_exists('get_option')) {
        $front_id = (int) get_option('page_on_front');
        if ($front_id) {
            $page = get_post($front_id);
        }
    }

    if (!$page) {
        return;
    }

    $content = $page->post_content;
    if (strpos($content, 'mastrade-advantage') !== false) {
        update_option('mastrade_advantage_v1', 1);
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

    $block = mastrade_advantage_block(array(
        'process_main' => mastrade_import_image('process-main.png'),
    ));

    $marker = 'carbon-fields/mastrade-excellence';
    $pos = strpos($content, $marker);
    if ($pos !== false) {
        $end = strpos($content, '-->', $pos);
        if ($end !== false) {
            $content = substr($content, 0, $end + 3) . "\n" . $block . substr($content, $end + 3);
        } else {
            $content .= "\n" . $block;
        }
    } else {
        $content .= "\n" . $block;
    }

    wp_update_post(array(
        'ID' => $page->ID,
        'post_content' => wp_slash($content),
    ));

    update_option('mastrade_advantage_v1', 1);

    if ($previous_user) {
        wp_set_current_user($previous_user);
    }
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
