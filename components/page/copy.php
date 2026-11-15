<?php

defined('ABSPATH') || exit;

$heading = $fields['heading'] ?? '';
$content = $fields['content'] ?? '';
$button_text = $fields['button_text'] ?? '';
$button_link = $fields['button_link'] ?? '';
$center = ($fields['align'] ?? '') === 'center';
$background = $fields['background'] ?? '';
$soft = $background === 'soft';
$muted = $background === 'muted';

if (!mastrade_has_content(array($heading, $content, $button_text))) {
    return;
}

$classes = 'copy-block fade-up';
if ($center) {
    $classes .= ' copy-center';
}
if ($soft) {
    $classes .= ' copy-soft';
}
if ($muted) {
    $classes .= ' copy-muted';
}
?>
<section class="<?php echo esc_attr($classes); ?>">
    <div class="container reveal reveal-up">
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
</section>
