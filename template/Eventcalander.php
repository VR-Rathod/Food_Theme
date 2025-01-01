<?php 

/**
 * Template Name: Event Calendar
 */

get_header(); 

function display_event_calendar_navigation($month, $year) {
    // Get the current URL to preserve any existing parameters
    $current_url = home_url($_SERVER['REQUEST_URI']);

    // Remove month and year from the URL (if they already exist)
    $current_url = remove_query_arg(array('month', 'year'), $current_url);

    // Set up previous and next month/year values
    $prev_month = ($month == 1) ? 12 : $month - 1;
    $prev_year = ($month == 1) ? $year - 1 : $year;

    $next_month = ($month == 12) ? 1 : $month + 1;
    $next_year = ($month == 12) ? $year + 1 : $year;

    // Create navigation links with correct month/year query parameters
    return '<div class="calendar-navigation">
        <a href="' . add_query_arg(array('month' => $prev_month, 'year' => $prev_year), $current_url) . '">&laquo; Previous</a>
        <span>' . date('F Y', strtotime("$year-$month-01")) . '</span>
        <a href="' . add_query_arg(array('month' => $next_month, 'year' => $next_year), $current_url) . '">Next &raquo;</a>
    </div>';
}


function display_event_calendar() {
    $month = isset($_GET['month']) ? $_GET['month'] : date('m');
    $year = isset($_GET['year']) ? $_GET['year'] : date('Y');

    // Get events for the current month/year
    $args = array(
        'post_type' => 'event',
        'posts_per_page' => -1,
        'meta_key' => '_event_date',
        'orderby' => 'meta_value',
        'order' => 'ASC',  // Order events by date
        'meta_query' => array(
            array(
                'key' => '_event_date',
                'value' => "$year-$month-01",
                'compare' => '>=',
                'type' => 'DATE'
            ),
            array(
                'key' => '_event_date',
                'value' => "$year-$month-" . date('t', strtotime("$year-$month-01")),
                'compare' => '<=',
                'type' => 'DATE'
            )
        )
    );

    $events = new WP_Query($args);
    
    // Initialize an array to hold events by day
    $events_by_day = array();
    while ($events->have_posts()) {
        $events->the_post();
        $event_date = get_post_meta(get_the_ID(), '_event_date', true);
        $event_day = date('j', strtotime($event_date)); // Get day of the month
        $events_by_day[$event_day][] = get_permalink(); // Store the event link by day
    }

    // Calendar structure
    $calendar = '<div class="event-calendar">';
    
    // Display month navigation
    $calendar .= display_event_calendar_navigation($month, $year);

    // Calendar table structure
    $calendar .= '<table>';
    $calendar .= '<thead><tr>';

    // Days of the week
    for ($day = 0; $day < 7; $day++) {
        $calendar .= '<th>' . date('D', strtotime("Sunday +$day days")) . '</th>';
    }

    $calendar .= '</tr></thead>';
    $calendar .= '<tbody>';

    // Get the first day of the month and total days
    $first_day_of_month = strtotime("$year-$month-01");
    $days_in_month = date('t', $first_day_of_month);

    // Start the calendar grid
    $current_day = 1;
    $calendar .= '<tr>';

    // Fill in empty days before the first day of the month
    $start_day = date('w', $first_day_of_month);
    for ($i = 0; $i < $start_day; $i++) {
        $calendar .= '<td></td>';
    }

    // Add days to the calendar grid
    while ($current_day <= $days_in_month) {
        if ($start_day == 7) {
            $start_day = 0;
            $calendar .= '</tr><tr>';
        }

        // Check if there's an event on the current day
        $calendar .= '<td>';
        if (isset($events_by_day[$current_day])) {
            // Display the event thumbnail for the current day
            $calendar .= '<a href="' . esc_url($events_by_day[$current_day][0]) . '">';
            $calendar .= $current_day; // Display the day number
            $calendar .= '</a>';
        } else {
            $calendar .= $current_day; // Just display the day number if no event
        }
        $calendar .= '</td>';

        $start_day++;
        $current_day++;
    }

    // Fill in any empty cells after the last day
    while ($start_day < 7) {
        $calendar .= '<td></td>';
        $start_day++;
    }

    $calendar .= '</tr>';
    $calendar .= '</tbody>';
    $calendar .= '</table>';
    $calendar .= '</div>';

    return $calendar;
}


// Function to display the horizontal scrollable event cards below the calendar
function display_event_cards() {
    $month = isset($_GET['month']) ? $_GET['month'] : date('m');
    $year = isset($_GET['year']) ? $_GET['year'] : date('Y');

    // Get events for the current month/year
    $args = array(
        'post_type' => 'event',
        'posts_per_page' => -1,
        'meta_key' => '_event_date',
        'orderby' => 'meta_value',
        'order' => 'ASC',  // Order events by date
        'meta_query' => array(
            array(
                'key' => '_event_date',
                'value' => "$year-$month-01",
                'compare' => '>=',
                'type' => 'DATE'
            ),
            array(
                'key' => '_event_date',
                'value' => "$year-$month-" . date('t', strtotime("$year-$month-01")),
                'compare' => '<=',
                'type' => 'DATE'
            )
        )
    );

    $events = new WP_Query($args);

    $event_cards = '<div class="event-cards-container" style="display: flex; overflow-x: auto; padding: 20px;">';

    while ($events->have_posts()) {
        $events->the_post();
        $event_thumbnail = get_the_post_thumbnail(get_the_ID(), 'medium');
        $event_title = get_the_title();
        $event_date = get_post_meta(get_the_ID(), '_event_date', true);

        $event_cards .= '<div class="event-card" style="margin-right: 15px; width: 200px;">';
        $event_cards .= '<a href="' . get_permalink() . '">';
        $event_cards .= '<div class="event-card-thumbnail">' . $event_thumbnail . '</div>';
        $event_cards .= '<div class="event-card-title">' . esc_html($event_title) . '</div>';
        $event_cards .= '<div class="event-card-date">' . date('F j, Y', strtotime($event_date)) . '</div>';
        $event_cards .= '</a>';
        $event_cards .= '</div>';
    }

    $event_cards .= '</div>';
    return $event_cards;
}

?>

<div class="event-calendar-page">
    <?php echo display_event_calendar(); ?>
    <?php echo display_event_cards(); ?>
</div>

<?php get_footer(); ?>