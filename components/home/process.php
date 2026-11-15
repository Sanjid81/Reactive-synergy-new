<?php

defined('ABSPATH') || exit;

$heading = $fields['heading'] ?? '';
$content = $fields['content'] ?? '';
$image_main = $fields['image_main'] ?? 0;
$image_detail = $fields['image_detail'] ?? 0;

if (!mastrade_has_content(array($heading, $content, $image_main, $image_detail))) {
    return;
}
?>
<section class="process fade-up">
    <div class="container process-grid">
        <div class="process-copy reveal reveal-left">
            <?php if ($heading) : ?>
                <h2 class="heading-two"><?php echo esc_html($heading); ?></h2>
            <?php endif; ?>
            <?php if (trim(wp_strip_all_tags($content))) : ?>
                <div class="rich-text body-text"><?php echo wp_kses_post($content); ?></div>
            <?php endif; ?>
        </div>
        <?php if ($image_main || $image_detail) : ?>
            <div class="process-photos reveal reveal-zoom">
                <?php echo mastrade_image($image_main, 'photo-main'); ?>
                <?php echo mastrade_image($image_detail, 'photo-detail'); ?>
            </div>
        <?php endif; ?>
    </div>
</section>
