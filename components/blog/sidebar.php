<?php

defined('ABSPATH') || exit;

$categories = get_categories(array(
    'hide_empty' => false,
    'orderby' => 'name',
));
$recent = new WP_Query(array(
    'post_type' => 'post',
    'posts_per_page' => 4,
    'post__not_in' => is_singular('post') ? array(get_queried_object_id()) : array(),
    'ignore_sticky_posts' => true,
));
?>
<aside class="blog-side">
    <section class="blog-widget">
        <h2><?php esc_html_e('Search', 'mastrade'); ?></h2>
        <form class="blog-search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
            <label class="screen-reader-text" for="blog-search"><?php esc_html_e('Search', 'mastrade'); ?></label>
            <input id="blog-search" type="search" name="s" value="<?php echo esc_attr(get_search_query()); ?>" placeholder="<?php esc_attr_e('Search ...', 'mastrade'); ?>">
            <input type="hidden" name="post_type" value="post">
            <button type="submit" aria-label="<?php esc_attr_e('Search', 'mastrade'); ?>">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <circle cx="11" cy="11" r="7"></circle>
                    <path d="M20 20l-3.5-3.5"></path>
                </svg>
            </button>
        </form>
    </section>

    <?php if ($categories) : ?>
        <section class="blog-widget">
            <h2><?php esc_html_e('Categories', 'mastrade'); ?></h2>
            <ul class="blog-categories">
                <?php foreach ($categories as $category) : ?>
                    <li>
                        <a href="<?php echo esc_url(get_category_link($category)); ?>"><?php echo esc_html($category->name); ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>
    <?php endif; ?>

    <?php if ($recent->have_posts()) : ?>
        <section class="blog-widget">
            <h2><?php esc_html_e('Recent Posts', 'mastrade'); ?></h2>
            <ul class="blog-recent">
                <?php
                while ($recent->have_posts()) :
                    $recent->the_post();
                    ?>
                    <li>
                        <a href="<?php the_permalink(); ?>">
                            <?php if (has_post_thumbnail()) : ?>
                                <span class="blog-recent-photo"><?php the_post_thumbnail('thumbnail'); ?></span>
                            <?php endif; ?>
                            <span>
                                <time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date('F j, Y')); ?></time>
                                <strong><?php the_title(); ?></strong>
                            </span>
                        </a>
                    </li>
                <?php endwhile; ?>
            </ul>
        </section>
    <?php endif; ?>
    <?php wp_reset_postdata(); ?>
</aside>
