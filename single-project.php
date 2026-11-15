<?php

defined('ABSPATH') || exit;

get_header();

while (have_posts()) :
    the_post();
    $place = function_exists('carbon_get_the_post_meta') ? carbon_get_the_post_meta('place') : '';
    $story = function_exists('carbon_get_the_post_meta') ? carbon_get_the_post_meta('story') : '';
    ?>
    <section class="page-banner">
        <?php
        if (has_post_thumbnail()) {
            the_post_thumbnail('full', array('class' => 'banner-zoom'));
        }
        ?>
        <div class="page-banner-shade"></div>
        <h1 class="heading-two banner-rise"><?php the_title(); ?></h1>
    </section>
    <nav class="breadcrumb banner-rise" aria-label="<?php esc_attr_e('Breadcrumb', 'mastrade'); ?>">
        <ol class="container small-text">
            <li><a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'mastrade'); ?></a></li>
            <li aria-hidden="true">/</li>
            <li><a href="<?php echo esc_url(get_post_type_archive_link('project')); ?>"><?php esc_html_e('Projects', 'mastrade'); ?></a></li>
            <li aria-hidden="true">/</li>
            <li><?php the_title(); ?></li>
        </ol>
    </nav>
    <?php if (trim($story)) : ?>
        <article class="project-detail fade-up">
            <div class="container">
                <?php if ($place) : ?>
                    <p class="project-place reveal reveal-up"><?php echo esc_html($place); ?></p>
                <?php endif; ?>
                <div class="rich-text project-story reveal reveal-up"><?php echo wp_kses_post($story); ?></div>
            </div>
        </article>
    <?php endif; ?>
<?php endwhile; ?>
<?php
get_footer();
