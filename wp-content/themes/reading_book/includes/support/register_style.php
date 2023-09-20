<?php 
add_action('wp_enqueue_scripts', 'reading_book_register_styles');

function reading_book_register_styles()
{
    global $theme_prefix;
    wp_enqueue_style($theme_prefix . '-style', THEME_URL, [], 1.0, 'all');
    wp_enqueue_style($theme_prefix . '-animate-css', THEME_URL . '/css/animate.css');
    wp_enqueue_style($theme_prefix . '-icomoon-css', THEME_URL . '/css/icomoon.css');

    wp_enqueue_style($theme_prefix . '-ionicons-css', THEME_URL . '/css/ionicons.min.css');

    wp_enqueue_style($theme_prefix . '-bootstrap-css', THEME_URL . '/css/bootstrap.min.css');
    wp_enqueue_style($theme_prefix . '-magnific-popup-css', THEME_URL . '/css/magnific-popup.css');
    wp_enqueue_style($theme_prefix . '-flexslider-css', THEME_URL . '/css/flexslider.css');
    wp_enqueue_style($theme_prefix . '-owl-carousel-css', THEME_URL . '/css/owl.carousel.min.css');
    wp_enqueue_style($theme_prefix . '-owl-theme-css', THEME_URL . '/css/owl.theme.default.min.css');
    wp_enqueue_style($theme_prefix . '-bootstrap-datepicker-css', THEME_URL . '/css/bootstrap-datepicker.css');
    wp_enqueue_style($theme_prefix . '-flaticon-css', THEME_URL . '/fonts/flaticon/font/flaticon.css');
    wp_enqueue_style($theme_prefix . '-css', THEME_URL . '/css/style.css');
    wp_enqueue_style($theme_prefix . '-css', THEME_URL . '/css/custom.css');
}