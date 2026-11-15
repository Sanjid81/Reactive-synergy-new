<?php

defined('ABSPATH') || exit;

$heading = $fields['heading'] ?? '';
$intro = $fields['intro'] ?? '';
$cards = $fields['cards'] ?? array();

if (!mastrade_has_content(array($heading, $intro, $cards))) {
    return;
}
?>
<section class="reasons fade-up" data-reasons>
    <div class="container">
        <div class="reasons-intro reveal reveal-up">
            <?php if ($heading) : ?>
                <h2 class="heading-two"><?php echo esc_html($heading); ?></h2>
            <?php endif; ?>
            <?php if (trim(wp_strip_all_tags($intro))) : ?>
                <div class="rich-text body-text"><?php echo wp_kses_post($intro); ?></div>
            <?php endif; ?>
        </div>
        <?php if (!empty($cards)) : ?>
            <div class="reasons-slider-wrap reveal reveal-in">
                <button class="reasons-arrow reasons-prev" type="button" aria-label="<?php esc_attr_e('Previous', 'mastrade'); ?>">&#8592;</button>
                <div class="swiper reasons-slider">
                <div class="swiper-wrapper">
                    <?php foreach ($cards as $card) :
                        $title = $card['title'] ?? '';
                        $text = $card['text'] ?? '';
                        $number = $card['number'] ?? '';
                        if (!mastrade_has_content(array($title, $text, $number))) {
                            continue;
                        }
                        ?>
                        <article class="swiper-slide reason-card">
                            <div class="reason-head">
                                <?php if ($number) : ?>
                                    <span class="reason-number"><?php echo esc_html($number); ?></span>
                                <?php endif; ?>
                                <?php if ($title) : ?>
                                    <h3 class="heading-three"><?php echo esc_html($title); ?></h3>
                                <?php endif; ?>
                            </div>
                            <?php if ($text) : ?>
                                <p class="body-text"><?php echo esc_html($text); ?></p>
                            <?php endif; ?>
                        </article>
                    <?php endforeach; ?>
                </div>
                </div>
                <button class="reasons-arrow reasons-next" type="button" aria-label="<?php esc_attr_e('Next', 'mastrade'); ?>">&#8594;</button>
            </div>
        <?php endif; ?>
    </div>
</section>
