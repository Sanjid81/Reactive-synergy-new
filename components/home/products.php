<?php

defined('ABSPATH') || exit;

$heading = $fields['heading'] ?? '';
$intro = $fields['intro'] ?? '';
$items = $fields['items'] ?? array();

if (!mastrade_has_content(array($heading, $intro, $items))) {
    return;
}
?>
<section class="products fade-up">
    <div class="container">
        <?php if ($heading || trim(wp_strip_all_tags($intro))) : ?>
            <div class="products-head reveal reveal-up">
                <?php if ($heading) : ?>
                    <h2 class="heading-two"><?php echo esc_html($heading); ?></h2>
                <?php endif; ?>
                <?php if (trim(wp_strip_all_tags($intro))) : ?>
                    <div class="rich-text body-text"><?php echo wp_kses_post($intro); ?></div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php foreach ($items as $item) :
            $title = $item['title'] ?? '';
            $content = $item['content'] ?? '';
            $button_text = $item['button_text'] ?? '';
            $button_link = $item['button_link'] ?? '';
            $image = $item['image'] ?? 0;
            $slug = sanitize_title($item['slug'] ?? '') ?: sanitize_title($title);
            if ($button_text && $slug) {
                $button_link = home_url('/products/' . $slug . '/');
            }
            if (!mastrade_has_content(array($title, $content, $button_text, $image))) {
                continue;
            }
            ?>
            <article class="product-row reveal reveal-up">
                <?php echo mastrade_image($image, 'product-photo'); ?>
                <div class="product-copy">
                    <?php if ($title) : ?>
                        <?php if ($slug) : ?>
                            <h3 class="product-title"><a href="<?php echo esc_url(home_url('/products/' . $slug . '/')); ?>"><?php echo esc_html($title); ?></a></h3>
                        <?php else : ?>
                            <h3 class="product-title"><?php echo esc_html($title); ?></h3>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if (trim(wp_strip_all_tags($content))) : ?>
                        <div class="rich-text body-text"><?php echo wp_kses_post($content); ?></div>
                    <?php endif; ?>
                    <?php if ($button_text && $button_link) : ?>
                        <a class="btn button-text" href="<?php echo esc_url($button_link); ?>"><?php echo esc_html($button_text); ?></a>
                    <?php endif; ?>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</section>
