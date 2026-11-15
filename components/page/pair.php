<?php

defined('ABSPATH') || exit;

$left_title = $fields['left_title'] ?? '';
$left_content = $fields['left_content'] ?? '';
$right_title = $fields['right_title'] ?? '';
$right_content = $fields['right_content'] ?? '';
$muted = ($fields['background'] ?? '') === 'muted';

if (!mastrade_has_content(array($left_title, $left_content, $right_title, $right_content))) {
    return;
}
?>
<section class="pair fade-up<?php echo $muted ? ' pair-muted' : ''; ?>">
    <div class="container pair-grid">
        <div class="reveal reveal-left">
            <?php if ($left_title) : ?>
                <h2 class="heading-two"><?php echo esc_html($left_title); ?></h2>
            <?php endif; ?>
            <?php if (trim(wp_strip_all_tags($left_content))) : ?>
                <div class="rich-text body-text"><?php echo wp_kses_post($left_content); ?></div>
            <?php endif; ?>
        </div>
        <div class="reveal reveal-right">
            <?php if ($right_title) : ?>
                <h2 class="heading-two"><?php echo esc_html($right_title); ?></h2>
            <?php endif; ?>
            <?php if (trim(wp_strip_all_tags($right_content))) : ?>
                <div class="rich-text body-text"><?php echo wp_kses_post($right_content); ?></div>
            <?php endif; ?>
        </div>
    </div>
</section>
