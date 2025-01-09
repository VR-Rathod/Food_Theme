<?php
get_header(); // Include the header.php file

// Define the background image URL before the HTML
$background_image_url = get_template_directory_uri() . '/assets/matirials/bgs.png';
?>
<!-- Inline animation CSS -->
<style>
  /* Animation to zoom out and slide the background */
  @keyframes zoomAndSlide {
    0% {
      background-size: 140%; /* Start with the image zoomed in */
      background-position: top left; /* Start from the top-left corner */
      background-color: gray;
    }
    100% {
      background-size: 100%; /* Image zooms out to full size */
      background-position: center center; /* Moves the background to the center */
      background-color: black; 
    }
  }
</style>

<section class="site-content" <?php body_class(); ?> 
    style=" background-image: url('<?php echo $background_image_url; ?>'); 
    background-size: 200%; 
    background-position: top left; 
    background-repeat: no-repeat; 
    height: 100vh; 
    display: flex;
    justify-content: flex-end; 
    align-items: center; 
    color: white; 
    overflow: hidden; 
   
    animation: zoomAndSlide 2s ease-out forwards;
    ">
  
    <div class="content-area">
        <main id="main" class="site-main">
            <div class="headline">
                <h1>Welcome To Sweet Food</h1>
                <p>We are here for your satisfaction. You can visit us, contact us, and buy our special food. We now offer home delivery services. Also, check out our Coupon Code page for extra discounts and join our future events to enjoy festivals with us.</p>
            </div>
        </main>
    </div>

</section>

<?php get_footer(); ?>

