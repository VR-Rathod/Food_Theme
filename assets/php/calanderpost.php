<?php
// Handle the get_events action
function fetch_calendar_events() {
    $args = array(
        'post_type' => 'event',
        'posts_per_page' => -1,
        'post_status' => 'publish',
    );

    $events_query = new WP_Query($args);
    $event_data = [];

    // Check if there are events
    if ($events_query->have_posts()) {
        while ($events_query->have_posts()) {
            $events_query->the_post();

            // Get event details
            $start_date = get_post_meta(get_the_ID(), '_event_start_date', true);
            $start_time = get_post_meta(get_the_ID(), '_event_start_time', true);
            $end_date = get_post_meta(get_the_ID(), '_event_end_date', true);
            $end_time = get_post_meta(get_the_ID(), '_event_end_time', true);
            $event_location = get_post_meta(get_the_ID(), '_event_location', true);
            $event_description = get_post_meta(get_the_ID(), '_event_description', true);

            // Ensure start date and time are valid
            if (!$start_date || !$start_time) {
                continue; // Skip invalid events
            }

            // Combine date and time into a full datetime string
            $start_datetime = $start_date . ' ' . $start_time;
            $end_datetime = $end_date && $end_time ? $end_date . ' ' . $end_time : $start_datetime;

            // Add event to data array
            $event_data[] = array(
                'title'       => get_the_title(),
                'start'       => $start_datetime,
                'end'         => $end_datetime,
                'description' => $event_description,
                'location'    => $event_location,
                'url'         => get_permalink(),
            );
        }
    }

    wp_reset_postdata(); // Reset post data

    // Return the event data as JSON response
    wp_send_json_success($event_data);
}
add_action('wp_ajax_get_events', 'fetch_calendar_events'); // For logged-in users
add_action('wp_ajax_nopriv_get_events', 'fetch_calendar_events'); // For non-logged-in users
