<?php

defined('ABSPATH') || exit;

$eyebrow = $fields['eyebrow'] ?? '';
$heading = $fields['heading'] ?? '';
$steps = $fields['steps'] ?? array();

if (!mastrade_has_content(array($eyebrow, $heading, $steps))) {
    return;
}

$icons = array(
    'inquiry' => '<svg viewBox="0 0 48 48" fill="none" aria-hidden="true"><path d="M6 40V20l10-7V8h8v5l18 7v20" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><path d="M6 40h36M20 40V30h8v10" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><path d="M30 16h4M32 14v4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>',
    'sourcing' => '<svg viewBox="0 0 48 48" fill="none" aria-hidden="true"><circle cx="22" cy="22" r="12" stroke="currentColor" stroke-width="1.8"/><path d="M10 22h24M22 10c3 3.2 4.6 7.4 4.6 12S25 30.8 22 34c-3-3.2-4.6-7.4-4.6-12S19 13.2 22 10Z" stroke="currentColor" stroke-width="1.8"/><path d="M30 30l4 4 8-2-2 6-6 2 2-6-6-4Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/></svg>',
    'yarn' => '<svg viewBox="0 0 48 48" fill="none" aria-hidden="true"><path d="M14 34c0-8 4-14 10-14s10 6 10 14" stroke="currentColor" stroke-width="1.8"/><path d="M16 34h16M18 18c2 3 6 3 8 0M24 14V8" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/><circle cx="24" cy="34" r="2" fill="currentColor"/></svg>',
    'costing' => '<svg viewBox="0 0 48 48" fill="none" aria-hidden="true"><rect x="10" y="8" width="28" height="32" rx="3" stroke="currentColor" stroke-width="1.8"/><path d="M16 16h16M16 24h4M24 24h4M32 24h0M16 30h4M24 30h4M32 30h4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>',
    'sample' => '<svg viewBox="0 0 48 48" fill="none" aria-hidden="true"><path d="M16 14l8-6 8 6v22H16V14Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><path d="M16 18h16M24 14v22" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>',
    'approval' => '<svg viewBox="0 0 48 48" fill="none" aria-hidden="true"><rect x="12" y="8" width="24" height="32" rx="3" stroke="currentColor" stroke-width="1.8"/><path d="M18 16h12M18 22h12M18 30l4 4 8-8" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>',
    'production' => '<svg viewBox="0 0 48 48" fill="none" aria-hidden="true"><circle cx="16" cy="18" r="6" stroke="currentColor" stroke-width="1.8"/><circle cx="32" cy="30" r="6" stroke="currentColor" stroke-width="1.8"/><path d="M20.5 21.5l7 5M13 34h10M29 16h8" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>',
    'quality' => '<svg viewBox="0 0 48 48" fill="none" aria-hidden="true"><circle cx="22" cy="22" r="10" stroke="currentColor" stroke-width="1.8"/><path d="M29.5 29.5 38 38M18 22l3 3 6-6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>',
    'packing' => '<svg viewBox="0 0 48 48" fill="none" aria-hidden="true"><path d="M8 16l16-8 16 8-16 8-16-8Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><path d="M8 16v16l16 8 16-8V16M24 24v16" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/></svg>',
    'shipment' => '<svg viewBox="0 0 48 48" fill="none" aria-hidden="true"><path d="M6 30h26V16H6v14Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><path d="M32 22h6l4 6v6h-10V22Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><circle cx="14" cy="34" r="3" stroke="currentColor" stroke-width="1.8"/><circle cx="36" cy="34" r="3" stroke="currentColor" stroke-width="1.8"/></svg>',
);
?>
<section class="workflow">
    <div class="container">
        <div class="workflow-intro reveal reveal-up">
            <?php if ($eyebrow) : ?>
                <p class="workflow-eyebrow">
                    <svg viewBox="0 0 12 12" aria-hidden="true"><path d="M6 .6 7.1 4.9 11.4 6 7.1 7.1 6 11.4 4.9 7.1.6 6 4.9 4.9 6 .6Z" fill="currentColor"/></svg>
                    <span><?php echo esc_html($eyebrow); ?></span>
                </p>
            <?php endif; ?>
            <?php if ($heading) : ?>
                <h2><?php echo esc_html($heading); ?></h2>
            <?php endif; ?>
        </div>
        <?php if (!empty($steps)) : ?>
            <div class="workflow-grid">
                <?php foreach ($steps as $step) :
                    $number = trim((string) ($step['number'] ?? ''));
                    $title = trim((string) ($step['title'] ?? ''));
                    $text = $step['text'] ?? '';
                    $icon_key = $step['icon'] ?? 'inquiry';
                    $icon_html = mastrade_image($step['image'] ?? 0, 'workflow-icon-image');
                    if (!$icon_html) {
                        $icon_html = $icons[$icon_key] ?? $icons['inquiry'];
                    }
                    if (!mastrade_has_content(array($number, $title, $text))) {
                        continue;
                    }
                    $label = $title;
                    if ($number !== '') {
                        $label = rtrim($number, '.') . '. ' . $title;
                    }
                    ?>
                    <article class="workflow-step reveal reveal-up">
                        <span class="workflow-icon"><?php echo $icon_html; ?></span>
                        <?php if ($label) : ?>
                            <h3><?php echo esc_html($label); ?></h3>
                        <?php endif; ?>
                        <?php if ($text) : ?>
                            <p><?php echo esc_html($text); ?></p>
                        <?php endif; ?>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
