<?php

defined('ABSPATH') || exit;

$items = array();

foreach (($fields['items'] ?? array()) as $item) {
    if (!is_array($item)) {
        continue;
    }

    if (mastrade_has_content(array($item['quote'] ?? '', $item['name'] ?? '', $item['role'] ?? '', $item['image'] ?? 0))) {
        $items[] = $item;
    }
}

if (!$items && mastrade_has_content(array($fields['quote'] ?? '', $fields['quote_name'] ?? '', $fields['quote_role'] ?? ''))) {
    $items[] = array(
        'quote' => $fields['quote'] ?? '',
        'name' => $fields['quote_name'] ?? '',
        'role' => $fields['quote_role'] ?? '',
        'image' => $fields['image'] ?? 0,
    );
}

if (!$items) {
    return;
}

$multiple = count($items) > 1;
?>
<section class="quote-block fade-up">
    <div class="container">
        <div class="quote-slider-wrap<?php echo $multiple ? '' : ' is-single'; ?>" <?php echo $multiple ? 'data-quotes' : ''; ?>>
            <div class="quote-map" aria-hidden="true">
                <svg viewBox="0 0 1200 560" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <pattern id="mastrade-map-hatch" width="6" height="6" patternUnits="userSpaceOnUse" patternTransform="rotate(42)">
                            <line x1="0" y1="0" x2="0" y2="6" stroke="#c5c5d0" stroke-width="1.15"></line>
                        </pattern>
                    </defs>
                    <g fill="url(#mastrade-map-hatch)">
                        <path d="M168 78c38-34 96-28 132 8 22 22 18 52-6 78-28 30-16 62 8 92-36 8-78-6-112-28-34-22-72-8-86 18-18 36-64 28-78-8-10-28 8-52 2-82-10-42 16-74 52-90 22-12 52-18 88 12z"></path>
                        <path d="M250 42c16-16 40-10 46 8 4 14-6 26-20 28-16 2-32-8-26-36z"></path>
                        <path d="M228 292c36-8 62 22 58 70 0 52-22 108-52 124-28 14-52-8-58-36-8-42-4-96 10-132 6-16 24-24 42-26z"></path>
                        <path d="M498 92c36-22 78-8 86 22 6 24-10 46-36 52-28 6-58-8-62-34-4-22-4-32 12-40z"></path>
                        <path d="M470 168c28-18 78-8 96 28 16 32 8 78-6 118-16 46-48 78-78 70-28-8-40-46-36-86 4-36 6-96 24-130z"></path>
                        <path d="M560 86c78-36 210-28 320 18 78 34 150 28 196 62 28 22 16 58-18 72 22 28 8 70-36 84-28 36-92 28-132 8-36 22-90 8-112-22-16-22-8-48 6-70-28-16-62-48-78-86-18-42-78-78-146-66z"></path>
                        <path d="M742 248c18 8 22 36 10 62-8 16-22 22-34 14-14-10-16-40-4-62 8-14 16-18 28-14z"></path>
                        <path d="M948 318c48-16 108 6 112 40 4 28-28 52-72 48-36-4-62-28-58-52 2-16 8-30 18-36z"></path>
                    </g>
                </svg>
            </div>
            <div class="<?php echo $multiple ? 'swiper quote-slider' : 'quote-slider'; ?>">
                <div class="<?php echo $multiple ? 'swiper-wrapper' : 'quote-slides'; ?>">
                    <?php foreach ($items as $item) :
                        $quote = $item['quote'] ?? '';
                        $name = $item['name'] ?? '';
                        $role = $item['role'] ?? '';
                        $photo = mastrade_image($item['image'] ?? 0);
                        ?>
                        <div class="<?php echo $multiple ? 'swiper-slide' : 'quote-slide'; ?>">
                            <figure class="quote-card">
                                <span class="quote-mark" aria-hidden="true">&rdquo;</span>
                                <?php if ($quote) : ?>
                                    <blockquote>&ldquo;<?php echo esc_html($quote); ?>&rdquo;</blockquote>
                                <?php endif; ?>
                                <?php if ($name || $role || $photo) : ?>
                                    <figcaption class="<?php echo $photo ? 'has-photo' : ''; ?>">
                                        <?php if ($photo) : ?>
                                            <div class="quote-photo"><?php echo $photo; ?></div>
                                        <?php endif; ?>
                                        <?php if ($name || $role) : ?>
                                            <div class="quote-person">
                                                <?php if ($name) : ?>
                                                    <strong><?php echo esc_html($name); ?></strong>
                                                <?php endif; ?>
                                                <?php if ($role) : ?>
                                                    <span><?php echo esc_html($role); ?></span>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                    </figcaption>
                                <?php endif; ?>
                            </figure>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php if ($multiple) : ?>
                <div class="quote-dots"></div>
            <?php endif; ?>
        </div>
    </div>
</section>
