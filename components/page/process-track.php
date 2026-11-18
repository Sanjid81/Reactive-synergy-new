<?php

defined('ABSPATH') || exit;

$eyebrow = $fields['eyebrow'] ?? '';
$heading = $fields['heading'] ?? '';
$steps = $fields['steps'] ?? array();

if (!mastrade_has_content(array($eyebrow, $heading, $steps))) {
    return;
}

$icons = array(
    'board' => '<svg viewBox="0 0 48 48" fill="none" aria-hidden="true"><path d="M14 10h20v18H14V10Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M18 22l4-5 4 3 5-7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><path d="M24 28v8M17 38h14M19 28l-5 10M29 28l5 10" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>',
    'partnership' => '<svg viewBox="0 0 48 48" fill="none" aria-hidden="true"><circle cx="18" cy="16" r="4.5" stroke="currentColor" stroke-width="1.6"/><path d="M10 34c.8-6 3.6-9 8-9s7.2 3 8 9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><path d="M28 12h13v9H32l-4 3v-3" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M31 16h7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>',
    'factory' => '<svg viewBox="0 0 48 48" fill="none" aria-hidden="true"><path d="M8 38V24l7 3v-5l7 3v-7l7 3v17" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M8 38h32" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><path d="M32 20V12h5v8" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M34.5 12V8" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><circle cx="37" cy="29" r="4.2" stroke="currentColor" stroke-width="1.6"/><path d="M37 27.2v1.8l1.3.8" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/></svg>',
    'globe' => '<svg viewBox="0 0 48 48" fill="none" aria-hidden="true"><circle cx="24" cy="24" r="10" stroke="currentColor" stroke-width="1.6"/><path d="M14 24h20M24 14c2.8 2.4 4.2 5.6 4.2 10s-1.4 7.6-4.2 10c-2.8-2.4-4.2-5.6-4.2-10s1.4-7.6 4.2-10Z" stroke="currentColor" stroke-width="1.6"/><path d="M34 12a16 16 0 0 1 6 8" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><path d="M38 10v5h-5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><path d="M14 36a16 16 0 0 1-6-8" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><path d="M10 38v-5h5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>',
);
?>
<section class="process-track">
    <div class="process-track-inner">
        <div class="process-track-intro reveal reveal-up">
            <?php if ($eyebrow) : ?>
                <p class="process-track-eyebrow">
                    <svg viewBox="0 0 12 12" aria-hidden="true"><path d="M6 .6 7.1 4.9 11.4 6 7.1 7.1 6 11.4 4.9 7.1.6 6 4.9 4.9 6 .6Z" fill="currentColor"/></svg>
                    <span><?php echo esc_html($eyebrow); ?></span>
                </p>
            <?php endif; ?>
            <?php if ($heading) : ?>
                <h2><?php echo esc_html($heading); ?></h2>
            <?php endif; ?>
        </div>
        <?php if (!empty($steps)) : ?>
            <div class="process-track-slider" data-process-track>
                <button class="process-track-arrow process-track-prev" type="button" aria-label="<?php esc_attr_e('Previous step', 'mastrade'); ?>">
                    <svg viewBox="0 0 16 16" aria-hidden="true"><path d="M10 3 5 8l5 5" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>
                <div class="swiper process-track-steps">
                    <div class="swiper-wrapper">
                <?php foreach ($steps as $step) :
                    $number = trim((string) ($step['number'] ?? ''));
                    $title = trim((string) ($step['title'] ?? ''));
                    $text = trim((string) ($step['text'] ?? ''));
                    $icon_key = $step['icon'] ?? 'board';
                    $icon_html = mastrade_image($step['image'] ?? 0, 'process-track-icon-image');
                    if (!$icon_html) {
                        $icon_html = $icons[$icon_key] ?? $icons['board'];
                    }
                    if (!mastrade_has_content(array($number, $title, $text, $icon_html))) {
                        continue;
                    }
                    ?>
                    <article class="swiper-slide process-track-step">
                        <span class="process-track-icon"><?php echo $icon_html; ?></span>
                        <?php if ($title) : ?>
                            <h3><?php echo esc_html($title); ?></h3>
                        <?php endif; ?>
                        <?php if ($text !== '') : ?>
                            <p><?php echo esc_html($text); ?></p>
                        <?php endif; ?>
                        <?php if ($number !== '') : ?>
                            <span class="process-track-number" aria-hidden="true"><?php echo esc_html($number); ?></span>
                        <?php endif; ?>
                    </article>
                <?php endforeach; ?>
                    </div>
                </div>
                <button class="process-track-arrow process-track-next" type="button" aria-label="<?php esc_attr_e('Next step', 'mastrade'); ?>">
                    <svg viewBox="0 0 16 16" aria-hidden="true"><path d="M6 3l5 5-5 5" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>
            </div>
        <?php endif; ?>
    </div>
</section>
