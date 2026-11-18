<?php

defined('ABSPATH') || exit;

$eyebrow = $fields['eyebrow'] ?? '';
$heading = $fields['heading'] ?? '';
$items = array();

foreach (($fields['items'] ?? array()) as $item) {
    if (!is_array($item)) {
        continue;
    }

    if (mastrade_has_content(array($item['quote'] ?? '', $item['name'] ?? '', $item['role'] ?? '', $item['image'] ?? 0))) {
        $items[] = $item;
    }
}

if (!mastrade_has_content(array($eyebrow, $heading, $items))) {
    return;
}
?>
<section class="testimonials">
    <div class="container">
        <?php if ($eyebrow || $heading) : ?>
            <div class="testimonials-head reveal reveal-up">
                <?php if ($eyebrow) : ?>
                    <p class="testimonials-eyebrow">
                        <svg viewBox="0 0 12 12" aria-hidden="true"><path d="M6 .6 7.1 4.9 11.4 6 7.1 7.1 6 11.4 4.9 7.1.6 6 4.9 4.9 6 .6Z" fill="currentColor"/></svg>
                        <span><?php echo esc_html($eyebrow); ?></span>
                    </p>
                <?php endif; ?>
                <?php if ($heading) : ?>
                    <h2><?php echo esc_html($heading); ?></h2>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <?php if ($items) : ?>
            <div class="testimonials-stage reveal reveal-up" data-testimonials>
                <div class="testimonials-map" aria-hidden="true">
                    <svg viewBox="0 0 1200 560" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <pattern id="testimonials-map-hatch" width="6" height="6" patternUnits="userSpaceOnUse" patternTransform="rotate(42)">
                                <line x1="0" y1="0" x2="0" y2="6" stroke="#d5d5de" stroke-width="1.15"></line>
                            </pattern>
                        </defs>
                        <g fill="url(#testimonials-map-hatch)">
                            <path d="M168 78c38-34 96-28 132 8 22 22 18 52-6 78-28 30-16 62 8 92-36 8-78-6-112-28-34-22-72-8-86 18-18 36-64 28-78-8-10-28 8-52 2-82-10-42 16-74 52-90 22-12 52-18 88 12z"></path>
                            <path d="M498 92c36-22 78-8 86 22 6 24-10 46-36 52-28 6-58-8-62-34-4-22-4-32 12-40z"></path>
                            <path d="M470 168c28-18 78-8 96 28 16 32 8 78-6 118-16 46-48 78-78 70-28-8-40-46-36-86 4-36 6-96 24-130z"></path>
                            <path d="M560 86c78-36 210-28 320 18 78 34 150 28 196 62 28 22 16 58-18 72 22 28 8 70-36 84-28 36-92 28-132 8-36 22-90 8-112-22-16-22-8-48 6-70-28-16-62-48-78-86-18-42-78-78-146-66z"></path>
                            <path d="M948 318c48-16 108 6 112 40 4 28-28 52-72 48-36-4-62-28-58-52 2-16 8-30 18-36z"></path>
                        </g>
                    </svg>
                </div>
                <div class="swiper testimonials-slider">
                    <div class="swiper-wrapper">
                        <?php foreach ($items as $item) :
                            $quote = $item['quote'] ?? '';
                            $name = $item['name'] ?? '';
                            $role = $item['role'] ?? '';
                            $photo = mastrade_image($item['image'] ?? 0, 'testimonials-photo-image');
                            ?>
                            <article class="swiper-slide">
                                <div class="testimonials-panel">
                                    <div class="testimonials-photo"><?php echo $photo; ?></div>
                                    <div class="testimonials-copy">
                                        <?php if ($quote) : ?>
                                            <blockquote>
                                                <span class="testimonials-mark" aria-hidden="true">&ldquo;</span>
                                                <span><?php echo esc_html($quote); ?></span>
                                            </blockquote>
                                        <?php endif; ?>
                                        <?php if ($name || $role) : ?>
                                            <div class="testimonials-person">
                                                <?php if ($name) : ?>
                                                    <strong><?php echo esc_html($name); ?></strong>
                                                <?php endif; ?>
                                                <?php if ($role) : ?>
                                                    <span><?php echo esc_html($role); ?></span>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="testimonials-nav">
                    <button class="testimonials-arrow testimonials-prev" type="button" aria-label="<?php esc_attr_e('Previous testimonial', 'mastrade'); ?>">
                        <svg viewBox="0 0 16 16" aria-hidden="true"><path d="M10 3 5 8l5 5" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                    <button class="testimonials-arrow testimonials-next" type="button" aria-label="<?php esc_attr_e('Next testimonial', 'mastrade'); ?>">
                        <svg viewBox="0 0 16 16" aria-hidden="true"><path d="M6 3l5 5-5 5" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>
