<?php
/**
 * Template Name: About Us
*/

?>

<?php get_header(); ?>

<section class="about-us-hero" <?php $background_image_url = get_template_directory_uri() . '/assets/matirials/bg1.jpg'; ?> <?php body_class();  ?> style="background-image: url('<?php echo $background_image_url; ?>'); background-size: cover; background-position: center; background-repeat: no-repeat;" >
    <div class="hero-overlay">
        <h1>Welcome to Sweet Food</h1>
        <p>Where every meal is made with passion, care, and the finest ingredients.</p>
        <a class="cta-button">See What We are</a>
    </div>
</section>

<section class="our-story" <?php $background_image_url = get_template_directory_uri() . '/assets/matirials/abbg.jpg'; ?> <?php body_class();  ?> style="background-image: url('<?php echo $background_image_url; ?>'); background-size: cover; background-position: center; background-repeat: no-repeat;" >
    <h2>Our Journey</h2>
    <p>Sweet Food began with a simple dream: to bring people together over delicious, heartwarming meals. Founded by Bast safe Khajana in 2021, our restaurant is built on the values of quality, passion, and community. Our journey has been filled with creativity, hard work, and lots of smiles...</p>
    <div class="story-images">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/matirials/saf_founder.png" alt="Founder">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/matirials/restrorant.jpg" alt="Restaurant Opening">
    </div>
</section>

<section class="our-philosophy" <?php $background_image_url = get_template_directory_uri() . '/assets/matirials/abbg3.jpg'; ?> <?php body_class();  ?> style="background-image: url('<?php echo $background_image_url; ?>'); background-size: cover; background-position: center; background-repeat: no-repeat;" >
    <h2>Our Philosophy</h2>
    <div class="values">
        <div class="value">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/matirials/sustainable.png" alt="Sustainability">
            <h3>Sustainability</h3>
            <p>We source ingredients from local farms and suppliers who share our commitment to sustainable practices.</p>
        </div>
        <div class="value">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/matirials/cook.jpg" alt="Quality">
            <h3>Quality</h3>
            <p>Only the freshest, highest quality ingredients make it onto your plate. Every dish is crafted with care and love.</p>
        </div>
        <div class="value">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/matirials/team.jpg" alt="Family">
            <h3>Family-Friendly</h3>
            <p>We believe in creating a welcoming space where families and friends can gather, share stories, and enjoy a great meal together.</p>
        </div>
    </div>
</section>

<section class="meet-the-team" <?php $background_image_url = get_template_directory_uri() . '/assets/matirials/abbg3.jpg'; ?> <?php body_class();  ?> style="background-image: url('<?php echo $background_image_url; ?>'); background-size: cover; background-position: center; background-repeat: no-repeat;" >
    <h2>Meet the Sweet Food Family</h2>
    <br>
    <br>
    <div class="team">
        <div class="team-member">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/matirials/cook1.jpg" alt="Chef John Doe">
            <h3>John Doe</h3>
            <p>Head Chef</p>
            <p>"Cooking is my art, and I pour my heart into every dish."</p>
        </div>
        <div class="team-member">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/matirials/cook2.jpg" alt="Jane Smith">
            <h3>Jane Smith</h3>
            <p>Restaurant Manager</p>
            <p>"Creating memorable experiences for our guests is my passion."</p>
        </div>
    </div>
</section>

<section class="customer-testimonials" <?php $background_image_url = get_template_directory_uri() . '/assets/matirials/abbg2.jpg'; ?> <?php body_class();  ?> style="background-image: url('<?php echo $background_image_url; ?>'); background-size: cover; background-position: center; background-repeat: no-repeat; height:50vh " >
<br><br>
    <h2>What Our Customers Say</h2>
    <div class="testimonials">
        <div class="testimonial">
            <p>"The best dining experience we've ever had. The food was amazing, and the staff made us feel like family!"</p>
            <cite>- Sarah and Tom</cite>
        </div>
        <div class="testimonial">
            <p>"Every dish is a masterpiece. You can taste the passion and care in every bite!"</p>
            <cite>- Michael L.</cite>
        </div>
    </div>
</section>

<?php get_footer(); ?>