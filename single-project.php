<?php

defined('ABSPATH') || exit;

get_header();

while (have_posts()) :
    the_post();
    $place = function_exists('carbon_get_post_meta') ? carbon_get_post_meta(get_the_ID(), 'place') : '';
    $story = function_exists('carbon_get_post_meta') ? carbon_get_post_meta(get_the_ID(), 'story') : '';
    $shots = function_exists('carbon_get_post_meta') ? carbon_get_post_meta(get_the_ID(), 'shots') : array();
    $story = is_string($story) ? $story : '';
    $place = is_string($place) ? $place : '';
    $content = apply_filters('the_content', get_the_content());
    $shots = is_array($shots) ? $shots : array();
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
    <?php if (mastrade_has_content(array($place, $story, $content, $shots))) : ?>
        <article class="project-detail fade-up">
            <div class="container">
                <?php if ($place) : ?>
                    <p class="project-place reveal reveal-up"><?php echo esc_html($place); ?></p>
                <?php endif; ?>
                <?php if ($shots) : ?>
                    <div class="project-gallery reveal reveal-up">
                        <?php foreach ($shots as $shot) :
                            $image = mastrade_image($shot['image'] ?? 0, 'project-gallery-photo');
                            if (!$image) {
                                continue;
                            }
                            echo $image;
                        endforeach; ?>
                    </div>
                <?php endif; ?>
                <?php if (trim(wp_strip_all_tags($story)) !== '') : ?>
                    <div class="rich-text project-story reveal reveal-up"><?php echo apply_filters('the_content', $story); ?></div>
                <?php endif; ?>
                <?php if (trim(wp_strip_all_tags($content)) !== '') : ?>
                    <div class="rich-text project-story reveal reveal-up"><?php echo $content; ?></div>
                <?php endif; ?>
            </div>
        </article>
    <?php endif; ?>
<?php endwhile; ?>
<?php
get_footer();
