<?php

defined('ABSPATH') || exit;

$heading = $fields['heading'] ?? '';
$content = $fields['content'] ?? '';
$button_text = $fields['button_text'] ?? '';
$button_link = $fields['button_link'] ?? '';
$image_detail = $fields['image_detail'] ?? 0;
$logos = $fields['logos'] ?? array();

if (!mastrade_has_content(array($heading, $content, $button_text, $image_detail, $logos))) {
    return;
}
?>
<?php
$logo_images = array();
foreach ($logos as $logo) {
    $image = mastrade_image($logo['image'] ?? 0, 'compliance-logo');
    if ($image) {
        $logo_images[] = $image;
    }
}
?>
<section class="compliance fade-up">
    <div class="container compliance-grid">
        <?php if ($logo_images || $image_detail) : ?>
            <div class="compliance-photos reveal reveal-zoom">
                <?php if ($logo_images) : ?>
                    <div class="compliance-logos">
                        <?php foreach ($logo_images as $image) : ?>
                            <div class="compliance-logo"><?php echo $image; ?></div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <?php echo mastrade_image($image_detail, 'photo-detail'); ?>
            </div>
        <?php endif; ?>
        <div class="compliance-copy reveal reveal-right">
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
    </div>
</section>
