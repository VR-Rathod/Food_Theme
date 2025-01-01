<?php 

/**
 * Template Name: Event Calander
 */


get_header(); ?>
<?php

function display_event_calendar_navigation($month, $year) {
    $prev_month = ($month == 1) ? 12 : $month - 1;
    $prev_year = ($month == 1) ? $year - 1 : $year;

    $next_month = ($month == 12) ? 1 : $month + 1;
    $next_year = ($month == 12) ? $year + 1 : $year;

    return '<div class="calendar-navigation">
        <a href="?month=' . $prev_month . '&year=' . $prev_year . '">&laquo; Previous</a>
        <span>' . date('F Y', strtotime("$year-$month-01")) . '</span>
        <a href="?month=' . $next_month . '&year=' . $next_year . '">Next &raquo;</a>
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
    $calendar = '<table>';
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
            $calendar .= '<a href="' . esc_url($events_by_day[$current_day][0]) . '">' . $current_day . '</a>';
        } else {
            $calendar .= $current_day;
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

    return $calendar;
}

?>

<?php get_footer(); ?>
