<?php
get_header(); // Include the header.php file
?>

<section class="site-content" <?php $background_image_url = get_template_directory_uri() . '/assets/matirials/bgs.jpg'; ?> <?php body_class();  ?> style="background-image: url('<?php echo $background_image_url; ?>'); 
background-size: cover; background-position: center; background-repeat: no-repeat; height: 100vh; display: flex;
  justify-content: flex-end; align-items: center; color: white;
  overflow: hidden; transition: background-image 0.5s ease; " >
    <div class="content-area">
        <main id="main" class="site-main">
        <div class="headline">
            <h1>Welcome To sweet Food</h1>
            <p>We are here for Your satifaction, You can Visit use contect us and buy our special Food And Now We can Provide Special service Home delivery. Also You can visit our Cupan Code page for extra discount and Join On our future evetnts page. To enjoy Fastivals with Us. </p>
        </div>
        </main>
    </div>
</section>

<?php get_footer(); ?>