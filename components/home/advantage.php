<?php

defined('ABSPATH') || exit;

$eyebrow = $fields['eyebrow'] ?? '';
$heading = $fields['heading'] ?? '';
$button_text = $fields['button_text'] ?? '';
$button_link = $fields['button_link'] ?? '';
$cards = $fields['cards'] ?? array();
$image_id = absint($fields['background'] ?? 0);
$video_id = absint($fields['video'] ?? 0);
$image = mastrade_image($image_id, 'advantage-photo');
$video_url = ($video_id && strpos((string) get_post_mime_type($video_id), 'video/') === 0) ? wp_get_attachment_url($video_id) : '';

if (!mastrade_has_content(array($eyebrow, $heading, $button_text, $cards, $image_id, $video_id))) {
    return;
}

$icons = array(
    'layers' => '<svg viewBox="0 0 48 48" fill="none" aria-hidden="true"><path d="M8 16.5 24 8l16 8.5L24 25 8 16.5Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><path d="M8 24.5 24 33l16-8.5" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><path d="M8 32.5 24 41l16-8.5" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/></svg>',
    'sewing' => '<svg viewBox="0 0 48 48" fill="none" aria-hidden="true"><path d="M9 36h30" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/><path d="M13 36V23h9l3.5-7H33v7h4v13" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><circle cx="18.5" cy="27" r="2.2" stroke="currentColor" stroke-width="1.6"/><path d="M29 20v5M33 18v7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><path d="M24 36v-4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>',
    'custom' => '<svg viewBox="0 0 48 48" fill="none" aria-hidden="true"><path d="M16 10h12l8 8v20H16V10Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><path d="M28 10v8h8" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><path d="M21 26h8M21 31h5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/><circle cx="33" cy="33" r="6" stroke="currentColor" stroke-width="1.8"/><path d="M33 30.5v2.8l1.8 1.2" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>',
);
?>
<section class="advantage">
    <div class="advantage-frame">
        <?php if ($video_url) : ?>
            <div class="advantage-media advantage-zoom">
                <video class="advantage-video" autoplay muted loop playsinline<?php echo $image_id ? ' poster="' . esc_url(wp_get_attachment_url($image_id)) . '"' : ''; ?>>
                    <source src="<?php echo esc_url($video_url); ?>" type="<?php echo esc_attr(get_post_mime_type($video_id)); ?>">
                </video>
            </div>
        <?php elseif ($image) : ?>
            <div class="advantage-media advantage-zoom"><?php echo $image; ?></div>
        <?php endif; ?>
        <div class="advantage-grid">
            <div class="advantage-copy reveal reveal-left">
                <?php if ($eyebrow) : ?>
                    <p class="advantage-eyebrow">
                        <svg class="advantage-mark" viewBox="0 0 12 12" aria-hidden="true"><path d="M6 0.6 7.1 4.9 11.4 6 7.1 7.1 6 11.4 4.9 7.1 0.6 6 4.9 4.9 6 0.6Z" fill="currentColor"/></svg>
                        <span><?php echo esc_html($eyebrow); ?></span>
                    </p>
                <?php endif; ?>
                <?php if ($heading) : ?>
                    <h2><?php echo esc_html($heading); ?></h2>
                <?php endif; ?>
                <?php if ($button_text && $button_link) : ?>
                    <a class="btn" href="<?php echo esc_url($button_link); ?>">
                        <span><?php echo esc_html($button_text); ?></span>
                        <svg viewBox="0 0 16 16" aria-hidden="true"><path d="M3 8h10M9 4l4 4-4 4" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </a>
                <?php endif; ?>
            </div>
            <?php if (!empty($cards)) : ?>
                <div class="advantage-cards">
                    <?php foreach ($cards as $card) :
                        $title = $card['title'] ?? '';
                        $text = $card['text'] ?? '';
                        $icon_key = $card['icon'] ?? 'layers';
                        $icon_html = mastrade_image($card['icon_image'] ?? 0, 'advantage-icon-image');
                        if (!$icon_html) {
                            $icon_html = $icons[$icon_key] ?? $icons['layers'];
                        }
                        if (!mastrade_has_content(array($title, $text, $icon_html))) {
                            continue;
                        }
                        ?>
                        <article class="advantage-card reveal reveal-right">
                            <div class="advantage-card-body">
                                <div class="advantage-card-top">
                                    <?php if ($title) : ?>
                                        <h3><?php echo esc_html($title); ?></h3>
                                    <?php endif; ?>
                                    <span class="advantage-icon"><?php echo $icon_html; ?></span>
                                </div>
                                <?php if ($text) : ?>
                                    <p><?php echo esc_html($text); ?></p>
                                <?php endif; ?>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
