<?php

defined('ABSPATH') || exit;

get_header();

$eyebrow = function_exists('carbon_get_theme_option') ? carbon_get_theme_option('projects_eyebrow') : '';
$heading = function_exists('carbon_get_theme_option') ? carbon_get_theme_option('projects_heading') : '';
$intro = function_exists('carbon_get_theme_option') ? carbon_get_theme_option('projects_intro') : '';
$eyebrow = $eyebrow ?: __('01. Recent Projects', 'mastrade');
$heading = $heading ?: __('Explore Our Apparel Programs', 'mastrade');
$intro = $intro ?: __('A look at the programs we develop with buyers, from the first sample through packed shipment.', 'mastrade');
$banner = function_exists('mastrade_import_image') ? mastrade_import_image('hero.png') : 0;
?>
<section class="page-banner">
    <?php
    if ($banner) {
        echo wp_get_attachment_image($banner, 'full', false, array('class' => 'banner-zoom'));
    }
    ?>
    <div class="page-banner-shade"></div>
    <h1 class="heading-two banner-rise"><?php esc_html_e('Projects', 'mastrade'); ?></h1>
</section>
<nav class="breadcrumb banner-rise" aria-label="<?php esc_attr_e('Breadcrumb', 'mastrade'); ?>">
    <ol class="container small-text">
        <li><a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'mastrade'); ?></a></li>
        <li aria-hidden="true">/</li>
        <li><?php esc_html_e('Projects', 'mastrade'); ?></li>
    </ol>
</nav>
<section class="projects-block fade-up">
    <div class="container">
        <p class="projects-eyebrow reveal reveal-up"><?php echo esc_html($eyebrow); ?></p>
        <h2 class="projects-heading reveal reveal-up"><?php echo esc_html($heading); ?></h2>
        <?php if ($intro) : ?>
            <p class="projects-intro reveal reveal-up"><?php echo esc_html($intro); ?></p>
        <?php endif; ?>

        <?php if (have_posts()) : ?>
            <div class="project-grid">
                <?php
                while (have_posts()) :
                    the_post();
                    $place = function_exists('carbon_get_the_post_meta') ? carbon_get_the_post_meta('place') : '';
                    $shots = function_exists('carbon_get_the_post_meta') ? carbon_get_the_post_meta('shots') : array();
                    $images = array();
                    foreach ((array) $shots as $shot) {
                        $image_id = absint($shot['image'] ?? 0);
                        if ($image_id) {
                            $images[] = $image_id;
                        }
                    }
                    if (!$images && has_post_thumbnail()) {
                        $images[] = get_post_thumbnail_id();
                    }
                    $images = array_slice($images, 0, 4);
                    $count = count($images);
                    $mosaic = 'is-single';
                    if ($count === 2) {
                        $mosaic = 'is-double';
                    } elseif ($count === 3) {
                        $mosaic = 'is-triple';
                    } elseif ($count >= 4) {
                        $mosaic = 'is-quad';
                    }
                    ?>
                    <a class="project-card reveal reveal-up" href="<?php the_permalink(); ?>">
                        <div class="project-mosaic <?php echo esc_attr($mosaic); ?>">
                            <?php foreach ($images as $image_id) : ?>
                                <?php echo wp_get_attachment_image($image_id, 'medium_large'); ?>
                            <?php endforeach; ?>
                        </div>
                        <div class="project-card-copy">
                            <h3><?php the_title(); ?></h3>
                            <?php if ($place) : ?>
                                <p><?php echo esc_html($place); ?></p>
                            <?php endif; ?>
                            <span class="project-go" aria-hidden="true">
                                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M7 17L17 7"></path>
                                    <path d="M9 7h8v8"></path>
                                </svg>
                            </span>
                        </div>
                    </a>
                <?php endwhile; ?>
            </div>
            <?php
            $project_links = array();
            $project_pages = (int) $GLOBALS['wp_query']->max_num_pages;
            if ($project_pages > 1) {
                $project_links = paginate_links(array(
                    'total' => $project_pages,
                    'current' => max(1, (int) get_query_var('paged')),
                    'type' => 'array',
                    'prev_text' => '<span aria-hidden="true">&#8592;</span> ' . esc_html__('Previous', 'mastrade'),
                    'next_text' => esc_html__('Next', 'mastrade') . ' <span aria-hidden="true">&#8599;</span>',
                ));
            }
            ?>
            <?php if (!empty($project_links)) : ?>
                <nav class="project-pagination" aria-label="<?php esc_attr_e('Projects pages', 'mastrade'); ?>">
                    <?php echo implode('', $project_links); ?>
                </nav>
            <?php endif; ?>
        <?php else : ?>
            <p class="projects-empty"><?php esc_html_e('Projects added in the dashboard will appear here.', 'mastrade'); ?></p>
        <?php endif; ?>
    </div>
</section>
<?php
get_footer();
