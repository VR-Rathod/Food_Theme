<!-- navbar setup -->
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
        wp_enqueue_style('events-calendar-style', get_template_directory_uri() . '/assets/css/cal.css');
    }

    // Check if we are on the 'events-calendar' page
    if (is_page('online-ordering')) {
        wp_enqueue_style('events-calendar-style', get_template_directory_uri() . '/assets/css/fooditems.css');
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
 require get_template_directory() . '/assets/php/fooditems.php';
?>

<!-- Js Files  -->
<?php
function my_theme_enqueue_scripts() {
    wp_enqueue_script('jquery');  // This ensures jQuery is loaded
    wp_enqueue_script('fullcalendar', 'https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js', array('jquery'), null, true); // Ensure FullCalendar is loaded after jQuery
    wp_enqueue_script('events-calendar', get_template_directory_uri() . '/js/events-calendar.js', array('jquery', 'fullcalendar'), null, true);  // Your custom JS file that depends on jQuery and FullCalendar
      wp_enqueue_script('custom-calendar', get_template_directory_uri() . '/js/custom-calendar.js', array('jquery', 'fullcalendar-js'), null, true);
}
add_action('wp_enqueue_scripts', 'my_theme_enqueue_scripts');

?>

<!-- For comments -->
<?php
// Ensure that comments are enabled for posts
add_action( 'init', 'enable_comments_on_posts' );
function enable_comments_on_posts() {
    add_post_type_support( 'post', 'comments' );
}
?>

<?php 
// Register the AJAX action to fetch events as JSON
function load_events_as_json() {
    // Ensure the user has permission to view the events
    if (!current_user_can('read')) {
        wp_send_json_error(array('message' => 'You are not authorized to view the events.'));
    }

    // WP Query to fetch 'event' custom post type
    $args = array(
        'post_type' => 'event',
        'posts_per_page' => -1, // Get all events
        'post_status' => 'publish',
    );

    $event_query = new WP_Query($args);

    // Prepare the events array
    $events = array();

    // Loop through the events
    if ($event_query->have_posts()) {
        while ($event_query->have_posts()) {
            $event_query->the_post();

            // Get custom fields
            $start_date = get_post_meta(get_the_ID(), '_event_start_date', true);
            $start_time = get_post_meta(get_the_ID(), '_event_start_time', true);
            $end_date = get_post_meta(get_the_ID(), '_event_end_date', true);
            $end_time = get_post_meta(get_the_ID(), '_event_end_time', true);
            $event_location = get_post_meta(get_the_ID(), '_event_location', true);
            $event_description = get_post_meta(get_the_ID(), '_event_description', true);

            // Combine start date and time
            $start_datetime = $start_date . ' ' . $start_time;
            $end_datetime = $end_date && $end_time ? $end_date . ' ' . $end_time : $start_datetime;

            // Push the event data into the events array
            $events[] = array(
                'title' => get_the_title(),
                'start' => $start_datetime, // Start datetime in string format
                'end' => $end_datetime,     // End datetime in string format
                'location' => $event_location,
                'description' => $event_description,
                'url' => get_permalink(),
            );
        }
        wp_reset_postdata();
    }

    // If no events are found, return an empty response
    if (empty($events)) {
        wp_send_json_error(array('message' => 'No events found.'));
    }

    // Return the events as JSON
    wp_send_json_success($events);

    // Prevent WordPress from sending any extra HTML
    wp_die();
}

// Register the AJAX action for both logged-in and non-logged-in users
add_action('wp_ajax_get_events_json', 'load_events_as_json');
add_action('wp_ajax_nopriv_get_events_json', 'load_events_as_json');

?>