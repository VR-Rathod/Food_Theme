<?php
/**
 * Template Name: EventCalendar
 */
?>

<?php get_header(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Include jQuery -->
    <title>Calendar</title>
</head>
<body>
    <!-- Calendar Container -->
    <div id="calendar"></div>

    <!-- Event Cards Container -->
    <div class="events-container">
        <?php
        // Query to fetch all 'event' custom post type
        $args = array(
            'post_type' => 'event',
            'posts_per_page' => -1, // Get all events
            'post_status' => 'publish',
        );
        $event_query = new WP_Query($args);

        // Check if there are any events
        if ($event_query->have_posts()) :
            while ($event_query->have_posts()) : $event_query->the_post();
                // Get custom fields (meta values)
                $start_date = get_post_meta(get_the_ID(), '_event_start_date', true);
                $start_time = get_post_meta(get_the_ID(), '_event_start_time', true);
                $end_date = get_post_meta(get_the_ID(), '_event_end_date', true);
                $end_time = get_post_meta(get_the_ID(), '_event_end_time', true);
                $event_location = get_post_meta(get_the_ID(), '_event_location', true);
                $event_description = get_post_meta(get_the_ID(), '_event_description', true);

                // Format the date and time
                $start_datetime = $start_date . ' ' . $start_time;
                $end_datetime = $end_date && $end_time ? $end_date . ' ' . $end_time : $start_datetime;
                ?>
                <div class="event-card">
                    <h3><?php the_title(); ?></h3>
                    <p class="event-location"><strong>Location:</strong> <?php echo esc_html($event_location); ?></p>
                    <p class="event-dates"><strong>Start:</strong> <?php echo esc_html($start_datetime); ?> <br><strong>End:</strong> <?php echo esc_html($end_datetime); ?></p>
                    <p class="event-description"><?php echo esc_html($event_description); ?></p>
                    <a href="<?php the_permalink(); ?>" target="_blank">View Event Details</a>
                </div>
                <?php
            endwhile;
            wp_reset_postdata(); // Reset post data after the loop
        else :
            echo '<p>No events found.</p>';
        endif;
        ?>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: function(fetchInfo, successCallback, failureCallback) {
                    $.ajax({
                        url: '<?php echo admin_url("admin-ajax.php"); ?>',  // WordPress AJAX endpoint
                        method: 'GET',
                        data: {
                            action: 'get_events', // The action we defined in functions.php
                        },
                        success: function(response) {
                            if (response.success) {
                                // Log the response data for debugging
                                console.log(response.data);  // Log events data

                                // Parse the events data to FullCalendar format
                                const events = response.data.map(event => ({
                                    title: event.title,
                                    start: event.start,  // FullCalendar expects these as datetime strings
                                    end: event.end,
                                    description: event.description,
                                    location: event.location,
                                    url: event.url,
                                }));

                                // Pass events to FullCalendar
                                successCallback(events);
                            } else {
                                failureCallback('Error fetching events.');
                            }
                        },
                        error: function() {
                            failureCallback('Error fetching events.');
                        }
                    });
                },

                eventClick: function(info) {
                    const event = info.event;
                    const eventDetails = `
                        <h2>${event.title}</h2>
                        <p><strong>Location:</strong> ${event.extendedProps.location}</p>
                        <p><strong>Description:</strong> ${event.extendedProps.description}</p>
                        <p><strong>Start:</strong> ${event.start.toLocaleString()}</p>
                        <p><strong>End:</strong> ${event.end ? event.end.toLocaleString() : 'N/A'}</p>
                        <a href="${event.url}" target="_blank">View Event Details</a>
                    `;
                    alert(eventDetails);
                },
            });

            calendar.render();
        });
    </script>

</body>
</html>

<?php get_footer(); ?>
