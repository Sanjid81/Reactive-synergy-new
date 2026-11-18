<?php

defined('ABSPATH') || exit;

$cards = $fields['cards'] ?? array();

if (!mastrade_has_content($cards)) {
    return;
}

$icons = array(
    'phone' => '<svg viewBox="0 0 48 48" fill="none" aria-hidden="true"><path d="M18 14c.4 2.6 1.2 4.6 2.4 6.4 1.2 1.8 2.6 3.2 4.4 4.4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><path d="M16.5 18.5 14 16.2a2 2 0 0 0-2.4-.2l-1.8 1.2c-.8.6-1.1 1.6-.8 2.5 1.2 3.6 3.4 6.8 6.4 9.4 2.8 2.4 6 4 9.4 4.8 1 .2 2-.1 2.5-.9l1-1.8a2 2 0 0 0-.3-2.4l-2.4-2.2" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><path d="M29 15a7 7 0 0 1 5 5M27 13a10 10 0 0 1 8 8" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>',
    'email' => '<svg viewBox="0 0 48 48" fill="none" aria-hidden="true"><rect x="12" y="16" width="24" height="16" rx="2" stroke="currentColor" stroke-width="1.6"/><path d="m13 18 11 8 11-8" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>',
    'pin' => '<svg viewBox="0 0 48 48" fill="none" aria-hidden="true"><path d="M24 34s8-7.2 8-13a8 8 0 1 0-16 0c0 5.8 8 13 8 13Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><circle cx="24" cy="21" r="2.4" stroke="currentColor" stroke-width="1.6"/></svg>',
    'calendar' => '<svg viewBox="0 0 48 48" fill="none" aria-hidden="true"><rect x="13" y="15" width="22" height="18" rx="2" stroke="currentColor" stroke-width="1.6"/><path d="M13 21h22M19 13v4M29 13v4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><circle cx="30" cy="29" r="4.2" stroke="currentColor" stroke-width="1.5"/><path d="M30 27.4V29l1.2.8" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/></svg>',
);
?>
<section class="contact-cards">
    <div class="contact-cards-art" aria-hidden="true">
        <svg class="art-phone" viewBox="0 0 120 120" fill="none"><rect x="38" y="18" width="44" height="84" rx="8" stroke="currentColor" stroke-width="2"/><path d="M52 28h16M56 90h8" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
        <svg class="art-mail" viewBox="0 0 140 100" fill="none"><rect x="8" y="16" width="124" height="72" rx="8" stroke="currentColor" stroke-width="2"/><path d="m12 22 58 40L128 22" stroke="currentColor" stroke-width="2"/></svg>
        <svg class="art-pin" viewBox="0 0 90 120" fill="none"><path d="M45 108S78 74 78 46a33 33 0 1 0-66 0c0 28 33 62 33 62Z" stroke="currentColor" stroke-width="2"/><circle cx="45" cy="46" r="10" stroke="currentColor" stroke-width="2"/></svg>
        <svg class="art-calendar" viewBox="0 0 120 110" fill="none"><rect x="10" y="18" width="100" height="80" rx="8" stroke="currentColor" stroke-width="2"/><path d="M10 40h100M34 10v16M86 10v16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
    </div>
    <div class="contact-cards-grid">
        <?php foreach ($cards as $card) :
            $title = trim((string) ($card['title'] ?? ''));
            $text = trim((string) ($card['text'] ?? ''));
            $icon_key = $card['icon'] ?? 'phone';
            $icon_html = mastrade_image($card['image'] ?? 0, 'contact-card-icon-image');
            if (!$icon_html) {
                $icon_html = $icons[$icon_key] ?? $icons['phone'];
            }
            if (!mastrade_has_content(array($title, $text))) {
                continue;
            }
            ?>
            <article class="contact-card reveal reveal-up">
                <span class="contact-card-icon"><?php echo $icon_html; ?></span>
                <?php if ($title) : ?>
                    <h2><?php echo esc_html($title); ?></h2>
                <?php endif; ?>
                <?php if ($text !== '') : ?>
                    <p><?php echo nl2br(esc_html($text)); ?></p>
                <?php endif; ?>
            </article>
        <?php endforeach; ?>
    </div>
</section>
