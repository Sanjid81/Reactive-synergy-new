<?php

defined('ABSPATH') || exit;

$heading = $fields['heading'] ?? '';
$intro = $fields['intro'] ?? '';
$recipient = $fields['recipient'] ?? '';
$labels = array(
    'first_name' => $fields['label_first_name'] ?? '',
    'last_name' => $fields['label_last_name'] ?? '',
    'phone' => $fields['label_phone'] ?? '',
    'email' => $fields['label_email'] ?? '',
    'message' => $fields['label_message'] ?? '',
);
$button = $fields['button_text'] ?? '';
$map = $fields['map_embed'] ?? '';
$location_title = $fields['location_title'] ?? '';
$office_title = $fields['office_title'] ?? '';
$address = $fields['address'] ?? '';
$email = $fields['email'] ?? '';
$phone = $fields['phone'] ?? '';
$sent = isset($_GET['contact']) && $_GET['contact'] === 'sent';

if (!mastrade_has_content(array($heading, $intro, $labels, $button, $map, $location_title, $address, $email, $phone))) {
    return;
}
?>
<section class="contact-block fade-up">
    <div class="container">
        <?php if ($heading || trim(wp_strip_all_tags($intro))) : ?>
            <div class="contact-head reveal reveal-up">
                <?php if ($heading) : ?>
                    <h2 class="heading-two"><?php echo esc_html($heading); ?></h2>
                <?php endif; ?>
                <?php if (trim(wp_strip_all_tags($intro))) : ?>
                    <div class="rich-text body-text"><?php echo wp_kses_post($intro); ?></div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ($button && mastrade_has_content($labels)) : ?>
            <?php if ($sent) : ?>
                <p class="contact-notice body-text"><?php esc_html_e('Thank you. Your message has been sent.', 'mastrade'); ?></p>
            <?php endif; ?>
            <form class="contact-form reveal reveal-up" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                <input type="hidden" name="action" value="mastrade_contact">
                <input type="hidden" name="recipient" value="<?php echo esc_attr($recipient); ?>">
                <?php wp_nonce_field('mastrade_contact', 'mastrade_contact_nonce'); ?>
                <?php if ($labels['first_name']) : ?>
                    <label><span class="screen-reader-text"><?php echo esc_html($labels['first_name']); ?></span><input type="text" name="first_name" placeholder="<?php echo esc_attr($labels['first_name']); ?>" required></label>
                <?php endif; ?>
                <?php if ($labels['last_name']) : ?>
                    <label><span class="screen-reader-text"><?php echo esc_html($labels['last_name']); ?></span><input type="text" name="last_name" placeholder="<?php echo esc_attr($labels['last_name']); ?>" required></label>
                <?php endif; ?>
                <?php if ($labels['phone']) : ?>
                    <label><span class="screen-reader-text"><?php echo esc_html($labels['phone']); ?></span><input type="tel" name="phone" placeholder="<?php echo esc_attr($labels['phone']); ?>"></label>
                <?php endif; ?>
                <?php if ($labels['email']) : ?>
                    <label><span class="screen-reader-text"><?php echo esc_html($labels['email']); ?></span><input type="email" name="email" placeholder="<?php echo esc_attr($labels['email']); ?>" required></label>
                <?php endif; ?>
                <?php if ($labels['message']) : ?>
                    <label class="full"><span class="screen-reader-text"><?php echo esc_html($labels['message']); ?></span><textarea name="message" placeholder="<?php echo esc_attr($labels['message']); ?>" required></textarea></label>
                <?php endif; ?>
                <button class="btn button-text full" type="submit"><?php echo esc_html($button); ?></button>
            </form>
        <?php endif; ?>
    </div>

    <?php if ($map) : ?>
        <div class="contact-map reveal reveal-zoom">
            <iframe title="<?php esc_attr_e('Map', 'mastrade'); ?>" src="<?php echo esc_url($map); ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    <?php endif; ?>

    <?php if (mastrade_has_content(array($location_title, $office_title, $address, $email, $phone))) : ?>
        <div class="container location-panel reveal reveal-up">
            <?php if ($location_title) : ?>
                <h2 class="heading-three"><?php echo esc_html($location_title); ?></h2>
            <?php endif; ?>
            <ul class="location-list body-text">
                <?php if ($office_title || $address) : ?>
                    <li>
                        <?php if ($office_title) : ?><strong><?php echo esc_html($office_title); ?></strong><?php endif; ?>
                        <?php if ($address) : ?><span><?php echo esc_html($address); ?></span><?php endif; ?>
                    </li>
                <?php endif; ?>
                <?php if ($email) : ?>
                    <li><strong><?php esc_html_e('Email Address', 'mastrade'); ?></strong><a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a></li>
                <?php endif; ?>
                <?php if ($phone) : ?>
                    <li><strong><?php esc_html_e('Phone Number', 'mastrade'); ?></strong><a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $phone)); ?>"><?php echo esc_html($phone); ?></a></li>
                <?php endif; ?>
            </ul>
        </div>
    <?php endif; ?>
</section>
