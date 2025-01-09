<?php

// Register Custom Post Type for Food Items
function create_food_post_type() {
    $args = array(
        'labels' => array(
            'name' => 'Food Items',
            'singular_name' => 'Food Item',
            'add_new' => 'Add New',
            'add_new_item' => 'Add New Food Item',
            'edit_item' => 'Edit Food Item',
            'new_item' => 'New Food Item',
            'view_item' => 'View Food Item',
            'all_items' => 'All Food Items',
            'search_items' => 'Search Food Items',
            'not_found' => 'No Food Items Found',
            'not_found_in_trash' => 'No Food Items found in Trash',
            'parent_item_colon' => '',
            'menu_name' => 'Food Items'
        ),
        
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-food',
        'rewrite' => array('slug' => 'food-items'),
    );

    register_post_type('food_item', $args);
}

add_action('init', 'create_food_post_type');

function add_food_item_meta_boxes() {
    add_meta_box(
        'food_item_details',
        'Food Item Details',
        'food_item_details_callback',
        'food_item',
        'normal',
        'high'
    );
}

add_action('add_meta_boxes', 'add_food_item_meta_boxes');

function food_item_details_callback($post) {
    // Nonce field for security
    wp_nonce_field('food_item_details_nonce', 'food_item_nonce');

    // Get current data
    $price = get_post_meta($post->ID, '_food_item_price', true);
    $ingredients = get_post_meta($post->ID, '_food_item_ingredients', true);

    echo '<label for="food_item_price">Price:</label>';
    echo '<input type="text" id="food_item_price" name="food_item_price" value="' . esc_attr($price) . '" />';
    
    echo '<label for="food_item_ingredients">Ingredients:</label>';
    echo '<textarea id="food_item_ingredients" name="food_item_ingredients">' . esc_textarea($ingredients) . '</textarea>';
}

function save_food_item_details($post_id) {
    // Check nonce for security
    if (!isset($_POST['food_item_nonce']) || !wp_verify_nonce($_POST['food_item_nonce'], 'food_item_details_nonce')) {
        return $post_id;
    }

    // Save fields
    if (isset($_POST['food_item_price'])) {
        update_post_meta($post_id, '_food_item_price', sanitize_text_field($_POST['food_item_price']));
    }

    if (isset($_POST['food_item_ingredients'])) {
        update_post_meta($post_id, '_food_item_ingredients', sanitize_textarea_field($_POST['food_item_ingredients']));
    }
}

add_action('save_post', 'save_food_item_details');
