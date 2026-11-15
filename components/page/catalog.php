<?php

defined('ABSPATH') || exit;

$title = $product['title'] ?? '';
$gallery = $product['gallery'] ?? array();
?>
<section class="catalog">
    <div class="container">
        <?php if ($title) : ?>
            <h1 class="catalog-title reveal reveal-up"><?php echo esc_html($title); ?></h1>
        <?php endif; ?>
        <?php if (mastrade_has_content($gallery)) : ?>
            <div class="catalog-grid">
                <?php foreach ($gallery as $photo) :
                    echo mastrade_image($photo['image'] ?? 0, 'catalog-photo reveal reveal-zoom');
                endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
