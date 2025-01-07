<?php
get_header(); ?>

<div class="single-food-item">
    <?php
    if (have_posts()) :
        while (have_posts()) : the_post();
            // Get food item details
            $price = get_post_meta(get_the_ID(), '_food_item_price', true);  // Assuming price is stored in custom field
            $ingredients = get_post_meta(get_the_ID(), '_food_item_ingredients', true);  // Assuming ingredients are stored in custom field
            ?>
            <div class="food-item-details">
                <h1><?php the_title(); ?></h1>
                <div class="food-item-thumbnail">
                    <?php the_post_thumbnail('large'); ?>
                </div>
                <p><strong>Price:</strong> $<?php echo esc_html($price); ?></p>
                <p><strong>Ingredients:</strong> <?php echo esc_html($ingredients); ?></p>

                <!-- Buy Now Form -->
                <form action="" method="POST">
                    <input type="hidden" name="food_item_id" value="<?php the_ID(); ?>" />
                    <input type="number" name="quantity" value="1" min="1" />
                    <button type="submit" name="add_to_cart" class="buy-now-button">Add to Cart</button>
                </form>
            </div>
        <?php endwhile;
    else :
        echo '<p>Food item not found.</p>';
    endif;
    ?>
</div>

<?php get_footer(); ?>
