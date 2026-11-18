<?php

defined('ABSPATH') || exit;

$eyebrow = $fields['eyebrow'] ?? '';
$heading = $fields['heading'] ?? '';
$text = $fields['text'] ?? '';
$stats = $fields['stats'] ?? array();
$image_id = absint($fields['background'] ?? 0);
$video_id = absint($fields['video'] ?? 0);
$image = mastrade_image($image_id, 'figures-photo');
$video_url = ($video_id && strpos((string) get_post_mime_type($video_id), 'video/') === 0) ? wp_get_attachment_url($video_id) : '';

if (!mastrade_has_content(array($eyebrow, $heading, $text, $stats, $image_id, $video_id))) {
    return;
}
?>
<section class="figures">
    <?php if ($video_url) : ?>
        <div class="figures-media">
            <video class="figures-video" autoplay muted loop playsinline<?php echo $image_id ? ' poster="' . esc_url(wp_get_attachment_url($image_id)) . '"' : ''; ?>>
                <source src="<?php echo esc_url($video_url); ?>" type="<?php echo esc_attr(get_post_mime_type($video_id)); ?>">
            </video>
        </div>
    <?php elseif ($image) : ?>
        <div class="figures-media"><?php echo $image; ?></div>
    <?php endif; ?>

    <div class="figures-grid">
        <div class="figures-copy reveal reveal-left">
            <?php if ($eyebrow) : ?>
                <p class="figures-eyebrow">
                    <svg viewBox="0 0 12 12" aria-hidden="true"><path d="M6 .6 7.1 4.9 11.4 6 7.1 7.1 6 11.4 4.9 7.1.6 6 4.9 4.9 6 .6Z" fill="currentColor"/></svg>
                    <span><?php echo esc_html($eyebrow); ?></span>
                </p>
            <?php endif; ?>
            <?php if ($heading) : ?>
                <h2><?php echo esc_html($heading); ?></h2>
            <?php endif; ?>
            <?php if (trim($text) !== '') : ?>
                <p class="figures-text"><?php echo nl2br(esc_html($text)); ?></p>
            <?php endif; ?>
        </div>

        <?php if (!empty($stats)) : ?>
            <div class="figures-stats">
                <?php foreach ($stats as $stat) :
                    $value = trim((string) ($stat['number'] ?? ($stat['value'] ?? '')));
                    $label = $stat['label'] ?? '';
                    $detail = $stat['text'] ?? '';
                    if (!mastrade_has_content(array($value, $label, $detail))) {
                        continue;
                    }
                    ?>
                    <article class="figures-stat reveal reveal-right">
                        <?php if ($value !== '') : ?>
                            <p class="figures-value" data-count="<?php echo esc_attr($value); ?>">
                                <span class="figures-value-final" aria-hidden="true"><?php echo esc_html($value); ?></span>
                                <span class="figures-value-live"><?php echo esc_html($value); ?></span>
                            </p>
                        <?php endif; ?>
                        <?php if ($label) : ?>
                            <h3><?php echo esc_html($label); ?></h3>
                        <?php endif; ?>
                        <?php if (trim($detail) !== '') : ?>
                            <p class="figures-detail"><?php echo nl2br(esc_html($detail)); ?></p>
                        <?php endif; ?>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
