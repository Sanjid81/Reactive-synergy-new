<?php

defined('ABSPATH') || exit;

$eyebrow = $fields['eyebrow'] ?? '';
$heading = $fields['heading'] ?? '';
$intro = $fields['intro'] ?? '';
$members = $fields['members'] ?? array();
$button_text = $fields['button_text'] ?? '';
$button_link = $fields['button_link'] ?? '';

if (!mastrade_has_content(array($eyebrow, $heading, $intro, $members, $button_text))) {
    return;
}
?>
<section class="team-block fade-up">
    <div class="container">
        <?php if ($eyebrow) : ?>
            <p class="team-eyebrow reveal reveal-up"><?php echo esc_html($eyebrow); ?></p>
        <?php endif; ?>
        <?php if ($heading) : ?>
            <h2 class="heading-two reveal reveal-up"><?php echo esc_html($heading); ?></h2>
        <?php endif; ?>
        <?php if (trim(wp_strip_all_tags($intro))) : ?>
            <div class="rich-text body-text team-intro reveal reveal-up"><?php echo wp_kses_post($intro); ?></div>
        <?php endif; ?>
        <?php if (!empty($members)) : ?>
            <div class="team-grid">
                <?php foreach ($members as $member) :
                    $title = $member['title'] ?? '';
                    $text = $member['text'] ?? '';
                    $image = mastrade_image($member['image'] ?? 0, 'team-photo');
                    if (!mastrade_has_content(array($title, $text, $member['image'] ?? 0))) {
                        continue;
                    }
                    ?>
                    <article class="team-card reveal reveal-up">
                        <?php if ($image) : ?>
                            <div class="team-photo"><?php echo $image; ?></div>
                        <?php endif; ?>
                        <div class="team-copy">
                            <?php if ($title) : ?>
                                <h3><?php echo esc_html($title); ?></h3>
                            <?php endif; ?>
                            <?php if ($text) : ?>
                                <p><?php echo esc_html($text); ?></p>
                            <?php endif; ?>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <?php if ($button_text && $button_link) : ?>
            <a class="btn button-text" href="<?php echo esc_url($button_link); ?>"><?php echo esc_html($button_text); ?></a>
        <?php endif; ?>
    </div>
</section>
