<?php
// Check if there are any comments and display them
if ( have_comments() ) : ?>
    <h2 class="comments-title">
        <?php
        printf(
            _n( 'One Comment', '%1$s Comments', get_comments_number(), 'textdomain' ),
            number_format_i18n( get_comments_number() )
        );
        ?>
    </h2>

    <ol class="comment-list">
        <?php
        // List the comments
        wp_list_comments( array(
            'style' => 'ol',
            'short_ping' => true,
        ) );
        ?>
    </ol>

    <?php
    // Display comments pagination if necessary
    the_comments_navigation();

endif; // End if there are comments

// Display the comment form if comments are open
if ( comments_open() ) : ?>
    <div class="comment-form">
        <?php
        // Display the comment form for users to submit comments
        comment_form();
        ?>
    </div><!-- .comment-form -->
<?php endif; ?>
