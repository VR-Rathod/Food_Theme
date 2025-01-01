<?php

register_nav_menus(
    array('primary-menu'=> 'Header Menu') // header menu is name for the menu shows in distpaly location
);

?>

<!-- Custom logo Define -->

<?php

function mytheme_setup() {
    // Add theme support for custom logo
    add_theme_support('custom-logo');
}
add_action('after_setup_theme', 'mytheme_setup');

?>

<!-- Css Apply -->
<?php
function mytheme_enqueue_styles() {
    
    // Check if we are on the 'about-us' page
    if (is_page('about-us')) {
        // Enqueue a specific style for the 'about-us' page
        wp_enqueue_style('about-us-style', get_template_directory_uri() . '/assets/css/about.css');
    }
    
    // Check if we are on the 'events-calendar' page
    if (is_page('contact-us')) {
        // Enqueue a specific style for the 'events-calendar' page
        wp_enqueue_style('about-us-style', get_template_directory_uri() . '/assets/css/ContactUs.css');
    }
    
    // Check if we are on the 'events-calendar' page
    if (is_page('events-calendar')) {
        // Enqueue a specific style for the 'events-calendar' page
        wp_enqueue_style('about-us-style', get_template_directory_uri() . '/assets/css/cal.css');
    }

// Check if we are on a single post page
    if (is_single()) {
        wp_enqueue_style('single-post-style', get_template_directory_uri() . '/assets/css/single.css');
    }

    
    wp_enqueue_style('mytheme-style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'mytheme_enqueue_styles');

?>


<!-- custom php Files -->
<?php 
 require get_template_directory() . '/assets/php/calanderpost.php';
?>