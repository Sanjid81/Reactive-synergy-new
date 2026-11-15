<?php

defined('ABSPATH') || exit;

add_action('admin_post_nopriv_mastrade_contact', 'mastrade_handle_contact');
add_action('admin_post_mastrade_contact', 'mastrade_handle_contact');

function mastrade_handle_contact()
{
    $back = wp_get_referer() ?: home_url('/contact-us/');
    $back = remove_query_arg('contact', $back);

    if (!isset($_POST['mastrade_contact_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['mastrade_contact_nonce'])), 'mastrade_contact')) {
        wp_safe_redirect($back);
        exit;
    }

    $first = sanitize_text_field(wp_unslash($_POST['first_name'] ?? ''));
    $last = sanitize_text_field(wp_unslash($_POST['last_name'] ?? ''));
    $phone = sanitize_text_field(wp_unslash($_POST['phone'] ?? ''));
    $email = sanitize_email(wp_unslash($_POST['email'] ?? ''));
    $message = sanitize_textarea_field(wp_unslash($_POST['message'] ?? ''));
    $recipient = sanitize_email(wp_unslash($_POST['recipient'] ?? ''));

    if (!$recipient && function_exists('carbon_get_theme_option')) {
        $recipient = sanitize_email(carbon_get_theme_option('office_email'));
    }
    if (!$recipient) {
        $recipient = sanitize_email(get_option('admin_email'));
    }

    if ($first && $email && $message && $recipient) {
        $body = "Name: {$first} {$last}\nPhone: {$phone}\nEmail: {$email}\n\n{$message}";
        wp_mail($recipient, sprintf('Website enquiry from %s %s', $first, $last), $body, array('Reply-To: ' . $email));
        $back = add_query_arg('contact', 'sent', $back);
    }

    wp_safe_redirect($back);
    exit;
}
