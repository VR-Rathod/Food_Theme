<?php
/* Template Name: online order */
get_header(); ?>

<div class="food-items-container">
    <?php
    $args = array(
        'post_type' => 'food_item',
        'posts_per_page' => -1,
    );
    $food_query = new WP_Query($args);

    if ($food_query->have_posts()) :
        while ($food_query->have_posts()) : $food_query->the_post();
            // Get food item details
            $price = get_post_meta(get_the_ID(), '_food_item_price', true);
            $ingredients = get_post_meta(get_the_ID(), '_food_item_ingredients', true);
            ?>
            <div class="food-item-card">
                <div class="food-item-thumbnail">
                    <?php the_post_thumbnail(); ?>
                </div>
                <div class="food-item-details">
                    <h2><?php the_title(); ?></h2>
                    <p><?php echo esc_html($ingredients); ?></p>
                    <p><strong>Price:</strong> $<?php echo esc_html($price); ?></p>
                    <a href="<?php echo get_permalink(); ?>" class="buy-now-button">Buy Now</a>
                </div>
            </div>
        <?php endwhile;
        wp_reset_postdata();
    else :
        echo '<p>No food items available.</p>';
    endif;
    ?>
</div>

<?php get_footer(); ?>
