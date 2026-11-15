<?php

defined('ABSPATH') || exit;

$heading = $fields['heading'] ?? '';
$intro = $fields['intro_heading'] ?? '';
$content = $fields['content'] ?? '';
$button_text = $fields['button_text'] ?? '';
$button_link = $fields['button_link'] ?? '';
$image_main = $fields['image_main'] ?? 0;
$image_detail = $fields['image_detail'] ?? 0;
$side = ($fields['media_side'] ?? 'right') === 'left' ? 'left' : 'right';
$soft = ($fields['background'] ?? '') === 'soft';
$lead = ($fields['text_style'] ?? '') === 'lead';
$section = ($fields['heading_size'] ?? '') === 'section';
$poster = ($fields['image_layout'] ?? '') === 'poster';
$list_style = $fields['list_style'] ?? '';
$list = '';
if ($list_style === 'check') {
    $list = ' check-list';
} elseif ($list_style === 'icon') {
    $list = ' icon-list';
} elseif ($list_style === 'chips') {
    $list = ' icon-list chip-list';
}

if (!mastrade_has_content(array($intro, $heading, $content, $button_text, $image_main, $image_detail))) {
    return;
}

$classes = 'split fade-up split-' . $side;
if ($soft) {
    $classes .= ' split-soft';
}
if ($lead) {
    $classes .= ' split-lead';
}
if ($section) {
    $classes .= ' split-section';
}
if ($poster) {
    $classes .= ' split-poster';
} elseif ($image_main && !$image_detail) {
    $classes .= ' split-single';
}
?>
<section class="<?php echo esc_attr($classes); ?>">
    <?php if ($intro) : ?>
        <div class="container">
            <h2 class="heading-two split-intro reveal reveal-up"><?php echo esc_html($intro); ?></h2>
        </div>
    <?php endif; ?>
    <div class="container split-grid">
        <div class="split-copy reveal <?php echo $side === 'left' ? 'reveal-right' : 'reveal-left'; ?>">
            <?php if ($heading) : ?>
                <h2 class="heading-two"><?php echo esc_html($heading); ?></h2>
            <?php endif; ?>
            <?php if (trim(wp_strip_all_tags($content))) : ?>
                <div class="rich-text <?php echo $lead ? 'lead-text' : 'body-text'; ?><?php echo esc_attr($list); ?>"><?php echo wp_kses_post($content); ?></div>
            <?php endif; ?>
            <?php if ($button_text && $button_link) : ?>
                <a class="btn button-text" href="<?php echo esc_url($button_link); ?>"><?php echo esc_html($button_text); ?></a>
            <?php endif; ?>
        </div>
        <?php if ($image_main || $image_detail) : ?>
            <div class="split-photos reveal reveal-zoom">
                <?php echo mastrade_image($image_main, 'photo-main'); ?>
                <?php echo mastrade_image($image_detail, 'photo-detail'); ?>
            </div>
        <?php endif; ?>
    </div>
</section>
