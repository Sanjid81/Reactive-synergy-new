<?php

defined('ABSPATH') || exit;

$heading = $fields['heading'] ?? '';
$text = $fields['text'] ?? '';
$button_text = $fields['button_text'] ?? '';
$button_link = $fields['button_link'] ?? '';
$image_id = absint($fields['background'] ?? 0);
$video_id = absint($fields['video'] ?? 0);
$image = mastrade_image($image_id, 'hero-photo');
$video_url = ($video_id && strpos((string) get_post_mime_type($video_id), 'video/') === 0) ? wp_get_attachment_url($video_id) : '';

if (!mastrade_has_content(array($heading, $text, $button_text, $image_id, $video_id))) {
    return;
}
?>
<section class="hero">
    <?php if ($video_url) : ?>
        <div class="hero-media hero-zoom">
            <video class="hero-video" autoplay muted loop playsinline<?php echo $image_id ? ' poster="' . esc_url(wp_get_attachment_url($image_id)) . '"' : ''; ?>>
                <source src="<?php echo esc_url($video_url); ?>" type="<?php echo esc_attr(get_post_mime_type($video_id)); ?>">
            </video>
        </div>
    <?php elseif ($image) : ?>
        <div class="hero-media hero-zoom"><?php echo $image; ?></div>
    <?php endif; ?>
    <div class="hero-content hero-rise">
        <?php if ($heading) : ?>
            <h1 class="heading-one"><?php echo esc_html($heading); ?></h1>
        <?php endif; ?>
        <?php if ($text) : ?>
            <p class="lead-text hero-text"><?php echo esc_html($text); ?></p>
        <?php endif; ?>
        <?php if ($button_text && $button_link) : ?>
            <a class="btn button-text" href="<?php echo esc_url($button_link); ?>"><?php echo esc_html($button_text); ?></a>
        <?php endif; ?>
    </div>
</section>
