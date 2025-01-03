<?php

// Register Custom Post Type for Events
function create_event_post_type() {
    register_post_type('event',
        array(
            'labels' => array(
                'name' => 'Events',
                'singular_name' => 'Event'
            ),
            'public' => true,
            'has_archive' => true,
            'supports' => array('title', 'editor'),
            'rewrite' => array('slug' => 'events'),
        )
    );
}
add_action('init', 'create_event_post_type');

// Register Custom Meta Box for Event Details
function event_meta_box() {
    add_meta_box(
        'event_meta',               // Meta Box ID
        'Event Details',            // Title of the meta box
        'event_meta_box_callback',  // Callback function
        'event',                    // Custom post type name
        'normal',                   // Context (normal, side, etc.)
        'high'                      // Priority (high, default, low)
    );
}
add_action('add_meta_boxes', 'event_meta_box');

// Callback function to display meta fields
function event_meta_box_callback($post) {
    wp_nonce_field('event_meta_nonce', 'meta_box_nonce');

    // Get existing values
    $start_date = get_post_meta($post->ID, '_event_start_date', true);
    $end_date = get_post_meta($post->ID, '_event_end_date', true);
    $start_time = get_post_meta($post->ID, '_event_start_time', true);
    $end_time = get_post_meta($post->ID, '_event_end_time', true);
    $event_location = get_post_meta($post->ID, '_event_location', true);
    $event_description = get_post_meta($post->ID, '_event_description', true);

    // Display input fields
    echo '<label for="event_start_date">Start Date: </label>';
    echo '<input type="date" id="event_start_date" name="event_start_date" value="' . esc_attr($start_date) . '" />';

    echo '<br><label for="event_end_date">End Date: </label>';
    echo '<input type="date" id="event_end_date" name="event_end_date" value="' . esc_attr($end_date) . '" />';

    echo '<br><label for="event_start_time">Start Time: </label>';
    echo '<input type="time" id="event_start_time" name="event_start_time" value="' . esc_attr($start_time) . '" />';

    echo '<br><label for="event_end_time">End Time: </label>';
    echo '<input type="time" id="event_end_time" name="event_end_time" value="' . esc_attr($end_time) . '" />';

    echo '<br><label for="event_location">Location: </label>';
    echo '<input type="text" id="event_location" name="event_location" value="' . esc_attr($event_location) . '" />';

    echo '<br><label for="event_description">Description: </label>';
    echo '<textarea id="event_description" name="event_description">' . esc_textarea($event_description) . '</textarea>';
}

// Save custom fields when the post is saved
function save_event_meta($post_id) {
    // Check if nonce is set
    if (!isset($_POST['meta_box_nonce']) || !wp_verify_nonce($_POST['meta_box_nonce'], 'event_meta_nonce')) {
        return;
    }

    // Check if the user has permission to save
    if ('event' != get_post_type($post_id)) {
        return;
    }

    // Save custom field values
    if (isset($_POST['event_start_date'])) {
        update_post_meta($post_id, '_event_start_date', sanitize_text_field($_POST['event_start_date']));
    }
    if (isset($_POST['event_end_date'])) {
        update_post_meta($post_id, '_event_end_date', sanitize_text_field($_POST['event_end_date']));
    }
    if (isset($_POST['event_start_time'])) {
        update_post_meta($post_id, '_event_start_time', sanitize_text_field($_POST['event_start_time']));
    }
    if (isset($_POST['event_end_time'])) {
        update_post_meta($post_id, '_event_end_time', sanitize_text_field($_POST['event_end_time']));
    }
    if (isset($_POST['event_location'])) {
        update_post_meta($post_id, '_event_location', sanitize_text_field($_POST['event_location']));
    }
    if (isset($_POST['event_description'])) {
        update_post_meta($post_id, '_event_description', sanitize_textarea_field($_POST['event_description']));
    }
}
add_action('save_post', 'save_event_meta');

// AJAX function to fetch events
function fetch_calendar_events() {

    $args = array(
        'post_type' => 'event',
        'posts_per_page' => -1,
        'post_status' => 'publish',
    );

    $events_query = new WP_Query($args);
    $event_data = [];

    // Check if there are events in the query result
    if ($events_query->have_posts()) {
        while ($events_query->have_posts()) {
            $events_query->the_post();

            // Get event details (start date, end date, etc.)
            $start_date = get_post_meta(get_the_ID(), '_event_start_date', true);
            $start_time = get_post_meta(get_the_ID(), '_event_start_time', true);
            $end_date = get_post_meta(get_the_ID(), '_event_end_date', true);
            $end_time = get_post_meta(get_the_ID(), '_event_end_time', true);
            $event_location = get_post_meta(get_the_ID(), '_event_location', true);
            $event_description = get_post_meta(get_the_ID(), '_event_description', true);

            // If start date or start time is missing, skip this event
            if (!$start_date || !$start_time) {
                continue; // Skip this event if required fields are missing
            }

            // Combine start date and time into a single datetime string
            $start_datetime = $start_date . ' ' . $start_time;
            $end_datetime = $end_date && $end_time ? $end_date . ' ' . $end_time : $start_datetime;

            // Add event data to the array
            $event_data[] = array(
                'title'       => get_the_title(),
                'start'       => $start_datetime,  // Full datetime format
                'end'         => $end_datetime,    // Full datetime format
                'description' => $event_description,
                'location'    => $event_location,
                'url'         => get_permalink(),
            );
        }
    }

    // Log the events data to help with debugging
    if (empty($event_data)) {
        error_log('No events found or invalid data.');
    } else {
        error_log('Fetched events: ' . print_r($event_data, true)); // Log the data fetched from MySQL
    }

    wp_reset_postdata(); // Reset the post data

    // Send the event data back as a JSON response
    wp_send_json_success($event_data);
}

// Hook the AJAX actions
add_action('wp_ajax_get_events', 'fetch_calendar_events');       // For logged-in users
add_action('wp_ajax_nopriv_get_events', 'fetch_calendar_events'); // For non-logged-in users
