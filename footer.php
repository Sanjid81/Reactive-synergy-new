<?php

defined('ABSPATH') || exit;

$option = function ($key) {
    return function_exists('carbon_get_theme_option') ? carbon_get_theme_option($key) : '';
};

$logo = $option('footer_logo');
$social = $option('social_links');
$gallery = $option('footer_gallery');
$office_title = $option('office_title');
$address = $option('office_address');
$phone = $option('office_phone');
$email = $option('office_email');
$copyright = $option('footer_copyright');
$privacy = $option('privacy_link');
$terms = $option('terms_link');

$icons = array(
    'facebook' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M14 9h3V6h-3c-2.2 0-4 1.8-4 4v2H8v3h2v7h3v-7h3l1-3h-4V10c0-.6.4-1 1-1z"/></svg>',
    'linkedin' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M6.5 9H4V20h2.5V9zM5.2 4C4.3 4 3.6 4.7 3.6 5.6S4.3 7.2 5.2 7.2 6.8 6.5 6.8 5.6 6.1 4 5.2 4zM20 20h-2.5v-5.6c0-1.6-.6-2.6-2-2.6-1 0-1.5.7-1.8 1.3-.1.2-.1.6-.1.9V20H11V9h2.4v1.5c.4-.7 1.3-1.8 3.2-1.8 2.3 0 4 1.5 4 4.8V20z"/></svg>',
    'instagram' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true"><rect x="4" y="4" width="16" height="16" rx="4" stroke="currentColor" stroke-width="2"/><circle cx="12" cy="12" r="3.5" stroke="currentColor" stroke-width="2"/><circle cx="17.5" cy="6.5" r="1" fill="currentColor"/></svg>',
    'youtube' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M22 12.2s0-3.2-.4-4.6c-.2-.9-.9-1.6-1.8-1.8C18.2 5.4 12 5.4 12 5.4s-6.2 0-7.8.4c-.9.2-1.6.9-1.8 1.8C2 9 2 12.2 2 12.2s0 3.2.4 4.6c.2.9.9 1.6 1.8 1.8 1.6.4 7.8.4 7.8.4s6.2 0 7.8-.4c.9-.2 1.6-.9 1.8-1.8.4-1.4.4-4.6.4-4.6zM10 15.5v-6.6l5.2 3.3-5.2 3.3z"/></svg>',
);
?>
</main>

<?php if (mastrade_has_content(array($logo, $social, $gallery, $address, $phone, $email, $copyright))) : ?>
<footer class="site-footer">
    <div class="container">
        <div class="footer-brand reveal reveal-up">
            <?php if ($logo) : ?>
                <a class="footer-logo" href="<?php echo esc_url(home_url('/')); ?>">
                    <?php echo wp_get_attachment_image($logo, 'full', false, array('alt' => esc_attr(get_bloginfo('name')))); ?>
                </a>
            <?php endif; ?>
            <?php if (!empty($social)) : ?>
                <div class="footer-social">
                    <?php foreach ($social as $item) :
                        $url = $item['url'] ?? '';
                        $network = $item['network'] ?? '';
                        if (!$url || empty($icons[$network])) {
                            continue;
                        }
                        ?>
                        <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr($network); ?>">
                            <?php echo $icons[$network]; ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="footer-grid">
            <div class="reveal reveal-up">
                <?php if ($office_title) : ?>
                    <h2 class="footer-title heading-four"><?php echo esc_html($office_title); ?></h2>
                <?php endif; ?>
                <ul class="footer-contact small-text">
                    <?php if ($address) : ?><li><span><?php echo nl2br(esc_html($address)); ?></span></li><?php endif; ?>
                    <?php if ($phone) : ?><li><a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $phone)); ?>"><?php echo esc_html($phone); ?></a></li><?php endif; ?>
                    <?php if ($email) : ?><li><a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a></li><?php endif; ?>
                </ul>
            </div>
            <div class="reveal reveal-up">
                <h2 class="footer-title heading-four"><?php esc_html_e('Useful Links', 'mastrade'); ?></h2>
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'footer',
                    'container' => false,
                    'menu_class' => 'footer-links small-text',
                    'fallback_cb' => false,
                ));
                ?>
            </div>
            <?php if (!empty($gallery)) : ?>
                <div class="footer-gallery reveal reveal-zoom">
                    <?php foreach ($gallery as $item) :
                        $image = mastrade_image($item['image'] ?? 0);
                        if ($image) {
                            echo $image;
                        }
                    endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="footer-bottom small-text reveal reveal-in">
            <?php if ($copyright) : ?>
                <p><?php echo esc_html($copyright); ?></p>
            <?php endif; ?>
            <div class="footer-legal">
                <?php if ($privacy) : ?><a href="<?php echo esc_url($privacy); ?>"><?php esc_html_e('Privacy Policy', 'mastrade'); ?></a><?php endif; ?>
                <?php if ($terms) : ?><a href="<?php echo esc_url($terms); ?>"><?php esc_html_e('Terms of Use', 'mastrade'); ?></a><?php endif; ?>
            </div>
        </div>
    </div>
</footer>
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>
