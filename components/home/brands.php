<?php

defined('ABSPATH') || exit;

$heading = $fields['heading'] ?? '';
$intro = $fields['intro'] ?? '';
$logos = $fields['logos'] ?? array();
$button_text = $fields['button_text'] ?? '';
$button_link = $fields['button_link'] ?? '';

if (!mastrade_has_content(array($heading, $intro, $logos, $button_text))) {
    return;
}
?>
<section class="brands fade-up">
    <div class="container">
        <?php if ($heading) : ?>
            <h2 class="heading-two reveal reveal-up"><?php echo esc_html($heading); ?></h2>
        <?php endif; ?>
        <?php if (trim(wp_strip_all_tags($intro))) : ?>
            <div class="rich-text body-text brands-intro reveal reveal-up"><?php echo wp_kses_post($intro); ?></div>
        <?php endif; ?>
        <?php if (mastrade_has_content($logos)) : ?>
            <div class="brand-marquee" aria-hidden="true">
                <div class="brand-track">
                    <?php for ($copy = 0; $copy < 2; $copy++) : ?>
                        <div class="brand-set">
                            <?php foreach ($logos as $logo) :
                                echo mastrade_image($logo['image'] ?? 0, 'brand-logo');
                            endforeach; ?>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
        <?php endif; ?>
        <?php if ($button_text && $button_link) : ?>
            <div class="brands-action reveal reveal-zoom">
                <a class="btn button-text" href="<?php echo esc_url($button_link); ?>"><?php echo esc_html($button_text); ?></a>
            </div>
        <?php endif; ?>
    </div>
</section>
