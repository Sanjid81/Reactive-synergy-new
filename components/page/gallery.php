<?php

defined('ABSPATH') || exit;

$heading = $fields['heading'] ?? '';
$intro = $fields['intro'] ?? '';
$images = $fields['images'] ?? array();
$fit = ($fields['fit'] ?? 'cover') === 'contain' ? 'contain' : 'cover';

if (!mastrade_has_content(array($heading, $intro, $images))) {
    return;
}
?>
<section class="media-grid fade-up">
    <div class="container">
        <?php if ($heading) : ?>
            <h2 class="heading-two reveal reveal-up"><?php echo esc_html($heading); ?></h2>
        <?php endif; ?>
        <?php if (trim(wp_strip_all_tags($intro))) : ?>
            <div class="rich-text body-text media-grid-intro reveal reveal-up"><?php echo wp_kses_post($intro); ?></div>
        <?php endif; ?>
        <?php if (mastrade_has_content($images)) : ?>
            <div class="media-grid-items media-grid-<?php echo esc_attr($fit); ?>">
                <?php foreach ($images as $item) :
                    echo mastrade_image($item['image'] ?? 0, 'media-grid-photo reveal reveal-zoom');
                endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
