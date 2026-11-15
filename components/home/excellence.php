<?php

defined('ABSPATH') || exit;

$heading = $fields['heading'] ?? '';
$content = $fields['content'] ?? '';
$stats = $fields['stats'] ?? array();
$button_text = $fields['button_text'] ?? '';
$button_link = $fields['button_link'] ?? '';
$main = mastrade_image($fields['image_main'] ?? 0, 'photo-main');
$detail = mastrade_image($fields['image_detail'] ?? 0, 'photo-detail');

if (!mastrade_has_content(array($heading, $content, $stats, $button_text, $main, $detail))) {
    return;
}
?>
<section class="excellence fade-up">
    <div class="container excellence-grid">
        <div class="reveal reveal-up">
            <?php if ($heading) : ?>
                <h2 class="heading-two"><?php echo esc_html($heading); ?></h2>
            <?php endif; ?>
            <?php if (trim(wp_strip_all_tags($content))) : ?>
                <div class="rich-text body-text"><?php echo wp_kses_post($content); ?></div>
            <?php endif; ?>
            <?php if (!empty($stats)) : ?>
                <div class="stat-grid">
                    <?php foreach ($stats as $stat) :
                        $label = $stat['text'] ?? '';
                        if (!$label) {
                            continue;
                        }
                        ?>
                        <div class="stat-card lead-text"><?php echo esc_html($label); ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <?php if ($button_text && $button_link) : ?>
                <a class="btn button-text" href="<?php echo esc_url($button_link); ?>"><?php echo esc_html($button_text); ?></a>
            <?php endif; ?>
        </div>
        <?php if ($main || $detail) : ?>
            <div class="excellence-photos reveal reveal-zoom">
                <?php echo $main; ?>
                <?php echo $detail; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
