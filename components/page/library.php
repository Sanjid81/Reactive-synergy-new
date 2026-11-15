<?php

defined('ABSPATH') || exit;

$crumb = $fields['crumb'] ?? '';
$image_label = $fields['image_label'] ?? '';
$video_label = $fields['video_label'] ?? '';
$images = $fields['images'] ?? array();
$videos = $fields['videos'] ?? array();
$start = ($fields['start'] ?? '') === 'image' ? 'image' : 'video';

$video_items = array();
foreach ((array) $videos as $item) {
    $url = $item['url'] ?? '';
    $id = '';
    if (preg_match('~(?:youtu\.be/|youtube\.com/(?:watch\?v=|embed/|shorts/))([A-Za-z0-9_-]{6,})~', $url, $match)) {
        $id = $match[1];
    }
    $poster = $item['poster'] ?? 0;
    if (!$id && !$poster && !$url) {
        continue;
    }
    $video_items[] = array(
        'id' => $id,
        'url' => $url,
        'poster' => $poster,
    );
}

$has_images = mastrade_has_content($images);
$has_videos = !empty($video_items);
if (!mastrade_has_content(array($crumb, $image_label, $video_label, $images, $video_items))) {
    return;
}
if ($start === 'image' && !$has_images && $has_videos) {
    $start = 'video';
}
if ($start === 'video' && !$has_videos && $has_images) {
    $start = 'image';
}
?>
<?php if ($crumb) : ?>
    <nav class="breadcrumb banner-rise" aria-label="<?php esc_attr_e('Breadcrumb', 'mastrade'); ?>">
        <ol class="container small-text">
            <li><a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'mastrade'); ?></a></li>
            <li aria-hidden="true">/</li>
            <li><?php echo esc_html($crumb); ?></li>
        </ol>
    </nav>
<?php endif; ?>
<section class="library fade-up">
    <div class="container">
        <?php if ($image_label || $video_label) : ?>
            <div class="library-tabs reveal reveal-up" role="tablist">
                <button class="library-tab<?php echo $start === 'image' ? ' is-active' : ''; ?>" type="button" role="tab" data-library-tab="image" aria-selected="<?php echo $start === 'image' ? 'true' : 'false'; ?>"><?php echo esc_html($image_label ?: __('Image', 'mastrade')); ?></button>
                <button class="library-tab<?php echo $start === 'video' ? ' is-active' : ''; ?>" type="button" role="tab" data-library-tab="video" aria-selected="<?php echo $start === 'video' ? 'true' : 'false'; ?>"><?php echo esc_html($video_label ?: __('Video', 'mastrade')); ?></button>
            </div>
        <?php endif; ?>

        <div class="library-panel" data-library-panel="image" <?php echo $start === 'image' ? '' : 'hidden'; ?>>
            <?php if ($has_images) : ?>
                <div class="library-grid">
                    <?php foreach ($images as $item) :
                        echo mastrade_image($item['image'] ?? 0, 'library-photo reveal reveal-zoom');
                    endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <?php if ($has_videos) : ?>
            <div class="library-panel" data-library-panel="video" <?php echo $start === 'video' ? '' : 'hidden'; ?>>
                <div class="library-grid">
                    <?php foreach ($video_items as $item) :
                        $poster = mastrade_image($item['poster'], 'library-photo');
                        if (!$poster && $item['id']) {
                            $poster = '<img class="library-photo" src="' . esc_url('https://img.youtube.com/vi/' . $item['id'] . '/hqdefault.jpg') . '" alt="">';
                        }
                        ?>
                        <button class="library-video reveal reveal-zoom" type="button" data-video-id="<?php echo esc_attr($item['id']); ?>" data-video-url="<?php echo esc_url($item['url']); ?>">
                            <?php echo $poster; ?>
                            <span class="library-play" aria-hidden="true">
                                <svg width="70" height="70" viewBox="0 0 70 70" fill="none">
                                    <circle cx="35" cy="35" r="35" fill="#FEAF06"/>
                                    <path d="M47.5 34.13c.67.39.67 1.35 0 1.74L29.5 46.26c-.67.38-1.5-.1-1.5-.87V24.61c0-.77.83-1.25 1.5-.87L47.5 34.13Z" fill="#fff"/>
                                </svg>
                            </span>
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>
            <dialog class="library-dialog">
                <button class="library-close" type="button" data-library-close aria-label="<?php esc_attr_e('Close', 'mastrade'); ?>">&times;</button>
                <iframe title="<?php esc_attr_e('Gallery video', 'mastrade'); ?>" allow="autoplay; encrypted-media; picture-in-picture" allowfullscreen></iframe>
            </dialog>
        <?php endif; ?>
    </div>
</section>
