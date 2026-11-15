<?php

defined('ABSPATH') || exit;

$heading = $fields['heading'] ?? '';
$image = mastrade_image($fields['background'] ?? 0, 'banner-zoom');
$label = $fields['crumb'] ?? '';

if (!mastrade_has_content(array($heading, $image))) {
    return;
}
?>
<section class="page-banner">
    <?php echo $image; ?>
    <div class="page-banner-shade"></div>
    <?php if ($heading) : ?>
        <h1 class="heading-two banner-rise"><?php echo esc_html($heading); ?></h1>
    <?php endif; ?>
</section>
<?php if ($label) : ?>
    <nav class="breadcrumb banner-rise" aria-label="<?php esc_attr_e('Breadcrumb', 'mastrade'); ?>">
        <ol class="container small-text">
            <li><a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'mastrade'); ?></a></li>
            <li aria-hidden="true">/</li>
            <li><?php echo esc_html($label); ?></li>
        </ol>
    </nav>
<?php endif; ?>
