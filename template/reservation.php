<?php
/**
 * Template Name: reservation
*/
?>

<?php get_header(); ?>

<div class="reservation-container" <?php $back_img = get_template_directory_uri() . '/assets/matirials/restrorant.jpeg';?> <?php body_class(); ?> style = "background-image: url('<?php echo $back_img; ?>');
background-size: cover; background-position: center; background-repeat: no-repeat; height: 70vh; width: 100%;  ">


    <h1>Table Reservation</h1>
    
    <?php 
    // Call the reservation form using do_shortcode
    echo do_shortcode('[table_reservation_form]'); 
    ?>
</div>



<?php get_footer(); ?>
