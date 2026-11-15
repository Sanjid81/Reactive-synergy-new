<?php

defined('ABSPATH') || exit;

get_header();

while (have_posts()) :
    the_post();
    $category = get_the_category();
    $blog_page = (int) get_option('page_for_posts');
    $blog_url = $blog_page ? get_permalink($blog_page) : home_url('/blog/');
    ?>
    <nav class="breadcrumb" aria-label="<?php esc_attr_e('Breadcrumb', 'mastrade'); ?>">
        <ol class="container small-text">
            <li><a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'mastrade'); ?></a></li>
            <li aria-hidden="true">/</li>
            <li><a href="<?php echo esc_url($blog_url); ?>"><?php esc_html_e('Blog', 'mastrade'); ?></a></li>
            <li aria-hidden="true">/</li>
            <li><?php the_title(); ?></li>
        </ol>
    </nav>
    <article class="blog-page blog-single fade-up">
        <div class="blog-layout">
            <div class="blog-main">
                <div class="blog-meta reveal reveal-up">
                    <?php if ($category) : ?>
                        <a class="blog-chip" href="<?php echo esc_url(get_category_link($category[0])); ?>"><?php echo esc_html($category[0]->name); ?></a>
                    <?php endif; ?>
                    <time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date('F j, Y')); ?></time>
                    <span><?php echo esc_html(sprintf(__('By %s', 'mastrade'), get_the_author())); ?></span>
                </div>
                <h1 class="blog-single-title reveal reveal-up"><?php the_title(); ?></h1>
                <?php if (has_post_thumbnail()) : ?>
                    <div class="blog-single-media reveal reveal-up">
                        <?php the_post_thumbnail('large'); ?>
                    </div>
                <?php endif; ?>
                <div class="rich-text blog-content reveal reveal-up">
                    <?php the_content(); ?>
                </div>
            </div>
            <?php include THEME_DIR . '/components/blog/sidebar.php'; ?>
        </div>
    </article>
<?php endwhile; ?>
<?php
get_footer();
