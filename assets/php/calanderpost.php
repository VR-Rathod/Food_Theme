<?php
function create_event_post_type() {
    $args = array(
        'labels' => array(
            'name' => 'Events',
            'singular_name' => 'Event',
            'add_new' => 'Add New Event',
            'add_new_item' => 'Add New Event',
            'edit_item' => 'Edit Event',
            'new_item' => 'New Event',
            'view_item' => 'View Event',
            'all_items' => 'All Events',
            'search_items' => 'Search Events',
            'not_found' => 'No events found',
            'not_found_in_trash' => 'No events found in trash',
            'parent_item_colon' => '',
            'menu_name' => 'Events'
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'), // 'thumbnail' enables the post thumbnail feature
        'rewrite' => array('slug' => 'events'),
        'show_in_rest' => true,  // To enable Gutenberg editor if needed
    );
    register_post_type('event', $args);
}

add_action('init', 'create_event_post_type');

// Optional: Ensure that your theme supports thumbnails globally
function theme_setup() {
    add_theme_support('post-thumbnails'); // This enables thumbnails for all post types
}

add_action('after_setup_theme', 'theme_setup');

function event_meta_boxes() {
    add_meta_box(
        'event_details',
        'Event Details',
        'event_details_callback',
        'event',  // Custom post type
        'normal',
        'default'
    );
}

add_action('add_meta_boxes', 'event_meta_boxes');

function save_event_meta($post_id) {
    // Check nonce for security
    if (!isset($_POST['event_details_nonce']) || !wp_verify_nonce($_POST['event_details_nonce'], 'save_event_details')) {
        return;
    }

    if (isset($_POST['event_date'])) {
        update_post_meta($post_id, '_event_date', sanitize_text_field($_POST['event_date']));
    }

    if (isset($_POST['start_time'])) {
        update_post_meta($post_id, '_start_time', sanitize_text_field($_POST['start_time']));
    }

    if (isset($_POST['end_time'])) {
        update_post_meta($post_id, '_end_time', sanitize_text_field($_POST['end_time']));
    }
}

add_action('save_post', 'save_event_meta');

function event_details_callback($post) {
    // Nonce for security
    wp_nonce_field('save_event_details', 'event_details_nonce');

    // Retrieve the saved meta data
    $event_date = get_post_meta($post->ID, '_event_date', true);
    $start_time = get_post_meta($post->ID, '_start_time', true);
    $end_time = get_post_meta($post->ID, '_end_time', true);

    ?>
    <p>
        <label for="event_date">Event Date:</label>
        <input type="date" id="event_date" name="event_date" value="<?php echo esc_attr($event_date); ?>" />
    </p>
    <p>
        <label for="start_time">Start Time:</label>
        <input type="time" id="start_time" name="start_time" value="<?php echo esc_attr($start_time); ?>" />
    </p>
    <p>
        <label for="end_time">End Time:</label>
        <input type="time" id="end_time" name="end_time" value="<?php echo esc_attr($end_time); ?>" />
    </p>
    <?php
}
