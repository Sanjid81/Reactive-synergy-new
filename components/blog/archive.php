<?php

defined('ABSPATH') || exit;
?>
<section class="blog-page fade-up">
    <div class="blog-layout">
        <div class="blog-main">
            <?php if (is_search()) : ?>
                <h1 class="blog-page-title"><?php echo esc_html(sprintf(__('Search: %s', 'mastrade'), get_search_query())); ?></h1>
            <?php elseif (is_category()) : ?>
                <h1 class="blog-page-title"><?php single_cat_title(); ?></h1>
            <?php endif; ?>

            <?php if (have_posts()) : ?>
                <?php
                while (have_posts()) :
                    the_post();
                    $category = get_the_category();
                    ?>
                    <article class="blog-card reveal reveal-up">
                        <?php if (has_post_thumbnail()) : ?>
                            <a class="blog-card-media" href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('large'); ?>
                            </a>
                        <?php endif; ?>
                        <div class="blog-meta">
                            <?php if ($category) : ?>
                                <a class="blog-chip" href="<?php echo esc_url(get_category_link($category[0])); ?>"><?php echo esc_html($category[0]->name); ?></a>
                            <?php endif; ?>
                            <time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date('F j, Y')); ?></time>
                            <span><?php echo esc_html(sprintf(__('By %s', 'mastrade'), get_the_author())); ?></span>
                        </div>
                        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        <p><?php echo esc_html(wp_trim_words(get_the_excerpt(), 32)); ?></p>
                        <a class="blog-more" href="<?php the_permalink(); ?>"><?php esc_html_e('Read More', 'mastrade'); ?> <span aria-hidden="true">&#8599;</span></a>
                    </article>
                <?php endwhile; ?>
                <?php mastrade_blog_pagination(); ?>
            <?php else : ?>
                <p class="blog-empty"><?php esc_html_e('Posts added in the dashboard will appear here.', 'mastrade'); ?></p>
            <?php endif; ?>
        </div>
        <?php include THEME_DIR . '/components/blog/sidebar.php'; ?>
    </div>
</section>
