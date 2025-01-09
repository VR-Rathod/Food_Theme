<?php
/**
 * Template Name: Contact Us
*/

?>
<?php get_header(); ?>


<main id="primary" class="site-main">

    <section class="contact-us">
        <div class="container">
            
            <!-- Header Section -->
            <header class="contact-header">
                <h1>We’d Love to Hear from You!</h1>
                <p>Have a question, feedback, or just want to chat about food? Fill out the form below, and we’ll get back to you as soon as possible!</p>
            </header>

            <!-- Contact Form Section -->
            <div class="contact-form">
                <?php
                // PHP code to handle form submission
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $name = sanitize_text_field($_POST['name']);
                    $email = sanitize_email($_POST['email']);
                    $subject = sanitize_text_field($_POST['subject']);
                    $message = sanitize_textarea_field($_POST['message']);

                    // Check if fields are filled out correctly
                    if (!empty($name) && !empty($email) && !empty($message)) {
                        // Send Email
                        $to = 'your-email@example.com'; // Your email address
                        $subject = 'New Message from ' . $name . ' - ' . $subject;
                        $headers = 'From: ' . $email . "\r\n" .
                                   'Reply-To: ' . $email . "\r\n" .
                                   'Content-Type: text/html; charset=UTF-8';

                        $email_content = "<h3>New Message from Contact Form:</h3>
                                         <p><strong>Name:</strong> $name</p>
                                         <p><strong>Email:</strong> $email</p>
                                         <p><strong>Subject:</strong> $subject</p>
                                         <p><strong>Message:</strong></p><p>$message</p>";

                        if (wp_mail($to, $subject, $email_content, $headers)) {
                            echo '<p class="success-message">Thank you for your message! We’ll get back to you shortly.</p>';
                        } else {
                            echo '<p class="error-message">There was an error sending your message. Please try again later.</p>';
                        }
                    } else {
                        echo '<p class="error-message">Please fill out all the required fields.</p>';
                    }
                }
                ?>

                <!-- HTML Form -->
                <form action="" method="post" class="contact-form">
                    <div class="form-field">
                        <label for="name">Your Name *</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="form-field">
                        <label for="email">Your Email *</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-field">
                        <label for="subject">Subject</label>
                        <input type="text" id="subject" name="subject">
                    </div>
                    <div class="form-field">
                        <label for="message">Your Message *</label>
                        <textarea id="message" name="message" rows="5" required></textarea>
                    </div>
                    <div class="form-field">
                        <button type="submit" class="submit-btn">Send Message</button>
                    </div>
                </form>
            </div>

            <!-- Contact Details Section -->
            <div class="contact-details">
                <h3>Our Contact Details:</h3>
                <p><strong>Email:</strong> <a href="mailto:contact@foodplace.com">contact@foodplace.com</a></p>
                <p><strong>Phone:</strong> (123) 456-7890</p>
                <p><strong>Address:</strong> 123 Foodie St, Foodville, Country</p>
            </div>

            <!-- Embedded Google Map Section (Optional) -->
            <div class="google-map">
                <h3>Visit Us:</h3>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3669.5412736511685!2d72.53870437615731!3d23.11388257910987!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x395e84b76cc89507%3A0x9a9e7c07129fa669!2sKrishang%20Technolab!5e0!3m2!1sen!2sin!4v1736331370801!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>

            
        </div> <!-- .container -->
    </section>

</main><!-- #main -->

<?php get_footer(); ?>
