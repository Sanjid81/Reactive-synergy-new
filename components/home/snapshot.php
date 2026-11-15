<?php

defined('ABSPATH') || exit;

$heading = $fields['heading'] ?? '';
$content = $fields['content'] ?? '';
$button_text = $fields['button_text'] ?? '';
$button_link = $fields['button_link'] ?? '';
$image = $fields['image'] ?? 0;

if (!mastrade_has_content(array($heading, $content, $button_text, $image))) {
    return;
}
?>
<section class="snapshot fade-up">
    <div class="container snapshot-grid">
        <div class="snapshot-copy reveal reveal-left">
            <?php if ($heading) : ?>
                <h2 class="heading-two"><?php echo esc_html($heading); ?></h2>
            <?php endif; ?>
            <?php if (trim(wp_strip_all_tags($content))) : ?>
                <div class="rich-text body-text"><?php echo wp_kses_post($content); ?></div>
            <?php endif; ?>
            <?php if ($button_text && $button_link) : ?>
                <a class="btn button-text" href="<?php echo esc_url($button_link); ?>"><?php echo esc_html($button_text); ?></a>
            <?php endif; ?>
        </div>
        <?php if ($image) : ?>
            <div class="snapshot-media reveal reveal-zoom">
                <?php echo mastrade_image($image, 'snapshot-chart'); ?>
            </div>
        <?php endif; ?>
    </div>
</section>
