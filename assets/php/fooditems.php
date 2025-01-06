<?php

// Register Custom Post Type for Food Items
function register_food_post_type() {
    $args = array(
        'labels' => array(
            'name' => 'Food Items',
            'singular_name' => 'Food Item',
            'menu_name' => 'Food Management',
            'add_new' => 'Add New Food',
            'add_new_item' => 'Add New Food Item',
            'edit_item' => 'Edit Food Item',
            'new_item' => 'New Food Item',
            'view_item' => 'View Food Item',
            'all_items' => 'All Food Items',
            'search_items' => 'Search Food Items',
            'not_found' => 'No food items found',
            'not_found_in_trash' => 'No food items found in Trash',
            'parent_item_colon' => '',
        ),
        'public' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'food-items'),
        'supports' => array('title', 'editor', 'thumbnail'),
        'menu_icon' => 'dashicons-carrot',
        'show_in_rest' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_admin_bar' => true,
    );
    register_post_type('food', $args);
}
add_action('init', 'register_food_post_type');

// Add custom meta boxes for food items
function add_food_meta_boxes() {
    add_meta_box(
        'food_availability_meta', // Meta box ID
        'Food Availability', // Meta box title
        'display_food_availability_meta_box', // Callback function to display the fields
        'food', // Custom post type (Food Items)
        'normal', // Where to display the meta box
        'high' // Priority (positioning in the editor)
    );
}
add_action('add_meta_boxes', 'add_food_meta_boxes');

// Display the availability field in the meta box
function display_food_availability_meta_box($post) {
    $availability = get_post_meta($post->ID, '_food_availability', true);
    ?>
    <p>
        <label for="food_availability">Available</label><br>
        <input type="radio" name="food_availability" value="1" <?php checked($availability, '1'); ?> /> Available
        <input type="radio" name="food_availability" value="0" <?php checked($availability, '0'); ?> /> Unavailable
    </p>
    <?php
}

// Save custom availability meta field data
function save_food_availability_meta_box($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $post_id;
    
    if (isset($_POST['food_availability'])) {
        update_post_meta($post_id, '_food_availability', sanitize_text_field($_POST['food_availability']));
    } else {
        delete_post_meta($post_id, '_food_availability');
    }
}
add_action('save_post', 'save_food_availability_meta_box');

// Display the other custom fields in the meta box
function display_food_meta_box($post) {
    $price = get_post_meta($post->ID, '_food_price', true);
    $quantity = get_post_meta($post->ID, '_food_quantity', true);
    $description = get_post_meta($post->ID, '_food_description', true);

    ?>
    <p><label for="food_price">Price</label>
    <input type="text" name="food_price" value="<?php echo esc_attr($price); ?>" /></p>

    <p><label for="food_quantity">Quantity</label>
    <input type="number" name="food_quantity" value="<?php echo esc_attr($quantity); ?>" min="1" /></p>

    <p><label for="food_description">Description</label>
    <textarea name="food_description"><?php echo esc_textarea($description); ?></textarea></p>
    <?php
}

// Save custom meta box data
function save_food_meta_box($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $post_id;
    
    // Sanitize and save the price, ensuring it's numeric
    if (isset($_POST['food_price'])) {
        $price = sanitize_text_field($_POST['food_price']);
        update_post_meta($post_id, '_food_price', $price);
    }

    // Save quantity and description
    if (isset($_POST['food_quantity'])) {
        update_post_meta($post_id, '_food_quantity', intval($_POST['food_quantity']));
    }
    if (isset($_POST['food_description'])) {
        update_post_meta($post_id, '_food_description', sanitize_textarea_field($_POST['food_description']));
    }
}
add_action('save_post', 'save_food_meta_box');

?>
