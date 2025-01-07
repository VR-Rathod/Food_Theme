<?php
/* Template Name: Cart Page */
get_header();

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

?>

<div class="cart-page">
    <h1>Your Cart</h1>
    
    <?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Food Item</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                foreach ($_SESSION['cart'] as $food_item_id => $item):
                    $item_total = $item['quantity'] * $item['price'];
                    $total += $item_total;
                    ?>
                    <tr>
                        <td><?php echo esc_html($item['name']); ?></td>
                        <td><?php echo esc_html($item['quantity']); ?></td>
                        <td>$<?php echo esc_html($item['price']); ?></td>
                        <td>$<?php echo esc_html($item_total); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <p><strong>Total Price: $<?php echo esc_html($total); ?></strong></p>

        <!-- Checkout Button -->
        <a href="/checkout/" class="checkout-button">Proceed to Checkout</a>
    <?php else: ?>
        <p>Your cart is empty.</p>
    <?php endif; ?>
</div>

<?php get_footer(); ?>
