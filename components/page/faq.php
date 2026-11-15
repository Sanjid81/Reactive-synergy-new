<?php

defined('ABSPATH') || exit;

$heading = $fields['heading'] ?? '';
$intro = $fields['intro'] ?? '';
$items = $fields['items'] ?? array();

if (!mastrade_has_content(array($heading, $intro, $items))) {
    return;
}
?>
<section class="faq-block fade-up">
    <div class="container">
        <?php if ($heading) : ?>
            <h2 class="heading-two reveal reveal-up"><?php echo esc_html($heading); ?></h2>
        <?php endif; ?>
        <?php if (trim(wp_strip_all_tags($intro))) : ?>
            <div class="rich-text body-text faq-intro reveal reveal-up"><?php echo wp_kses_post($intro); ?></div>
        <?php endif; ?>
        <?php
        $columns = array(array(), array());
        $order = 0;
        foreach ($items as $item) {
            $question = $item['question'] ?? '';
            $answer = $item['answer'] ?? '';
            if (!mastrade_has_content(array($question, $answer))) {
                continue;
            }
            $item['_order'] = $order;
            $columns[$order % 2][] = $item;
            $order++;
        }
        ?>
        <?php if ($order) : ?>
            <div class="faq-list">
                <?php foreach ($columns as $column) : ?>
                    <?php if (!$column) {
                        continue;
                    } ?>
                    <div class="faq-column">
                        <?php foreach ($column as $item) :
                            $question = $item['question'] ?? '';
                            $answer = $item['answer'] ?? '';
                            ?>
                            <div class="faq-cell reveal reveal-up" style="order: <?php echo (int) $item['_order']; ?>">
                                <details class="faq-item">
                                    <?php if ($question) : ?>
                                        <summary><?php echo esc_html($question); ?></summary>
                                    <?php endif; ?>
                                    <?php if (trim(wp_strip_all_tags($answer))) : ?>
                                        <div class="rich-text body-text"><?php echo wp_kses_post($answer); ?></div>
                                    <?php endif; ?>
                                </details>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
