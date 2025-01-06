<?php
/**
 * Template Name: reservation
*/

?>

<?php get_header(); ?>

<div class="reservation-container">
    <h1>Table Reservation</h1>
    <?php 
    // Call the reservation form using do_shortcode
    echo do_shortcode('[table_reservation_form]'); 
    ?>
</div>

<?php get_footer(); ?>
