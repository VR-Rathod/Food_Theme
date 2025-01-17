<?php get_header(); ?>

<?php
if ( have_posts() ) :
    while ( have_posts() ) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="entry-header">
                <h1 class="entry-title"><?php the_title(); ?></h1>
            </header><!-- .entry-header -->

            <div class="entry-content">
                <?php the_content(); ?>
            </div><!-- entry-content -->

            <footer class="entry-footer">
                <?php the_tags( '<span class="tag-links">', '', '</span>' ); ?>
            </footer><!-- entry-footer -->
        </article><!-- #post-## -->

        <!-- Add Comment Section -->
        <?php
        if ( comments_open() || get_comments_number() ) :
            comments_template(); // This loads the comments.php template
        endif;
        ?>



    <?php endwhile;
else :
    echo '<p>No posts found.</p>';
endif;
?>

<?php get_footer(); ?>
