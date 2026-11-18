<?php

defined('ABSPATH') || exit;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action('carbon_fields_register_fields', function () {
    $options = Container::make('theme_options', __('Theme Options', 'mastrade'))
        ->add_fields(array(
            Field::make('image', 'site_logo', __('Logo', 'mastrade')),
            Field::make('image', 'footer_logo', __('Footer Logo', 'mastrade')),
            Field::make('text', 'header_button_text', __('Header Button Text', 'mastrade')),
            Field::make('text', 'header_button_link', __('Header Button Link', 'mastrade')),
            Field::make('textarea', 'footer_copyright', __('Copyright', 'mastrade')),
            Field::make('text', 'privacy_link', __('Privacy Policy Link', 'mastrade')),
            Field::make('text', 'terms_link', __('Terms of Use Link', 'mastrade')),
        ));

    Container::make('theme_options', __('Footer', 'mastrade'))
        ->set_page_parent($options)
        ->add_fields(array(
            Field::make('text', 'office_title', __('Office Title', 'mastrade')),
            Field::make('textarea', 'office_address', __('Address', 'mastrade')),
            Field::make('text', 'office_phone', __('Phone', 'mastrade')),
            Field::make('text', 'office_email', __('Email', 'mastrade')),
            Field::make('rich_text', 'footer_text', __('Text Under Logo', 'mastrade'))
                ->set_help_text(__('Paragraphs and links shown under the footer logo.', 'mastrade')),
            Field::make('complex', 'social_links', __('Social Links', 'mastrade'))
                ->add_fields(array(
                    Field::make('select', 'network', __('Network', 'mastrade'))
                        ->add_options(array(
                            'facebook' => 'Facebook',
                            'linkedin' => 'LinkedIn',
                            'instagram' => 'Instagram',
                            'youtube' => 'YouTube',
                        )),
                    Field::make('text', 'url', __('URL', 'mastrade')),
                )),
        ));

    Container::make('theme_options', __('Projects', 'mastrade'))
        ->set_page_parent($options)
        ->add_fields(array(
            Field::make('text', 'projects_eyebrow', __('Eyebrow', 'mastrade')),
            Field::make('text', 'projects_heading', __('Heading', 'mastrade')),
            Field::make('textarea', 'projects_intro', __('Intro', 'mastrade')),
        ));
});
