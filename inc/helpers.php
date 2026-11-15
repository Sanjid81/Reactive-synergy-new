<?php

defined('ABSPATH') || exit;

function mastrade_has_content($values)
{
    foreach ((array) $values as $value) {
        if (is_array($value)) {
            if (mastrade_has_content($value)) {
                return true;
            }
            continue;
        }

        if (is_numeric($value) && (int) $value > 0) {
            return true;
        }

        if (trim(wp_strip_all_tags((string) $value)) !== '') {
            return true;
        }
    }

    return false;
}

function mastrade_image($id, $class = '')
{
    $id = absint($id);
    if (!$id) {
        return '';
    }

    return wp_get_attachment_image($id, 'full', false, array(
        'class' => $class,
    ));
}

function mastrade_block($name, $data)
{
    return '<!-- wp:carbon-fields/' . $name . ' ' . wp_json_encode(array(
        'data' => $data,
    ), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . ' /-->' . "\n";
}
