<?php

defined('ABSPATH') || exit;

$form_title = $fields['form_title'] ?? '';
$form_text = $fields['form_text'] ?? '';
$form_shortcode = $fields['form_shortcode'] ?? '';
$eyebrow = $fields['eyebrow'] ?? '';
$heading = $fields['heading'] ?? '';
$address_label = $fields['address_label'] ?? '';
$address = $fields['address'] ?? '';
$whatsapp_label = $fields['whatsapp_label'] ?? '';
$whatsapp = $fields['whatsapp'] ?? '';
$email = $fields['email'] ?? '';
$button_text = $fields['button_text'] ?? '';
$button_link = $fields['button_link'] ?? '';
$image_id = absint($fields['background'] ?? 0);
$video_id = absint($fields['video'] ?? 0);
$image = mastrade_image($image_id, 'quote-banner-photo');
$video_url = ($video_id && strpos((string) get_post_mime_type($video_id), 'video/') === 0) ? wp_get_attachment_url($video_id) : '';
if (!mastrade_has_content(array($form_title, $form_text, $form_shortcode, $eyebrow, $heading, $address, $whatsapp, $email, $button_text, $image_id, $video_id))) {
    return;
}

$whatsapp_href = $whatsapp ? 'https://wa.me/' . preg_replace('/\D+/', '', $whatsapp) : '';
$arrow = '<svg viewBox="0 0 16 16" aria-hidden="true"><path d="M3 8h10M9 4l4 4-4 4" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>';
?>
<section class="quote-banner">
    <?php if ($video_url) : ?>
        <div class="quote-banner-media">
            <video class="quote-banner-video" autoplay muted loop playsinline<?php echo $image_id ? ' poster="' . esc_url(wp_get_attachment_url($image_id)) . '"' : ''; ?>>
                <source src="<?php echo esc_url($video_url); ?>" type="<?php echo esc_attr(get_post_mime_type($video_id)); ?>">
            </video>
        </div>
    <?php elseif ($image) : ?>
        <div class="quote-banner-media"><?php echo $image; ?></div>
    <?php endif; ?>

    <div class="quote-banner-grid">
        <?php if ($form_title || $form_shortcode) : ?>
            <div class="quote-banner-card reveal reveal-left">
                <?php if ($form_title) : ?>
                    <h2><?php echo esc_html($form_title); ?></h2>
                <?php endif; ?>
                <?php if ($form_text) : ?>
                    <p><?php echo esc_html($form_text); ?></p>
                <?php endif; ?>
                <?php if ($form_shortcode) : ?>
                    <div class="quote-banner-form">
                        <?php echo do_shortcode($form_shortcode); ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="quote-banner-copy reveal reveal-right">
            <?php if ($eyebrow) : ?>
                <p class="quote-banner-eyebrow">
                    <svg viewBox="0 0 12 12" aria-hidden="true"><path d="M6 .6 7.1 4.9 11.4 6 7.1 7.1 6 11.4 4.9 7.1.6 6 4.9 4.9 6 .6Z" fill="currentColor"/></svg>
                    <span><?php echo esc_html($eyebrow); ?></span>
                </p>
            <?php endif; ?>
            <?php if ($heading) : ?>
                <h2><?php echo esc_html($heading); ?></h2>
            <?php endif; ?>
            <div class="quote-banner-details">
                <?php if ($address_label || $address) : ?>
                    <div>
                        <?php if ($address_label) : ?>
                            <h3><?php echo esc_html($address_label); ?></h3>
                        <?php endif; ?>
                        <?php if ($address) : ?>
                            <p><?php echo nl2br(esc_html($address)); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                <?php if ($whatsapp_label || $whatsapp || $email) : ?>
                    <div>
                        <?php if ($whatsapp_label) : ?>
                            <h3><?php echo esc_html($whatsapp_label); ?></h3>
                        <?php endif; ?>
                        <?php if ($whatsapp) : ?>
                            <a href="<?php echo esc_url($whatsapp_href); ?>"><?php echo esc_html($whatsapp); ?></a>
                        <?php endif; ?>
                        <?php if ($email) : ?>
                            <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
            <?php if ($button_text && $button_link) : ?>
                <a class="btn" href="<?php echo esc_url($button_link); ?>">
                    <span><?php echo esc_html($button_text); ?></span>
                    <?php echo $arrow; ?>
                </a>
            <?php endif; ?>
        </div>
    </div>
</section>
