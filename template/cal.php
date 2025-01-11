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
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script> <!-- Include FullCalendar -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Include jQuery -->
    <title>Calendar</title>
</head>

<body>
    <!-- Calendar Container -->
    <div class="design-cal">
        <div id="calendar"></div>
    </div>

    <script>
      document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');

    // Function to check if events are already stored in localStorage
    function getStoredEvents() {
        let storedEvents = localStorage.getItem('calendarEvents');
        return storedEvents ? JSON.parse(storedEvents) : [];
    }

    // Function to store events in localStorage
    function storeEvents(events) {
        localStorage.setItem('calendarEvents', JSON.stringify(events));
    }

   // Function to fetch events from the server
function fetchEvents() {
    const url = new URL('<?php echo admin_url('admin-ajax.php'); ?>');
    url.searchParams.append('action', 'get_events'); // Append the action to the query string

    return fetch(url)
        .then(response => response.text()) // Get the response as text first
        .then(text => {
            // Remove all HTML comments using regex
            const cleanedText = text.replace(/<!--[\s\S]*?-->/g, '').trim();

            // Now parse the cleaned text as JSON
            try {
                const data = JSON.parse(cleanedText);
                if (data.success) {
                    return data.data; // Return the events data
                } else {
                    throw new Error('Error fetching events');
                }
            } catch (error) {
                console.error('Error parsing the response:', error);
                return [];
            }
        })
        .catch(error => {
            console.error(error);
            return [];
        });
}


    // Initialize FullCalendar
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: function (fetchInfo, successCallback, failureCallback) {
            // Check if events are stored in localStorage
            let events = getStoredEvents();

            // If events are not already stored, fetch from the server
            if (events.length === 0) {
                fetchEvents()
                    .then(fetchedEvents => {
                        storeEvents(fetchedEvents); // Store fetched events in localStorage
                        successCallback(fetchedEvents); // Pass the events to FullCalendar
                    })
                    .catch(() => {
                        failureCallback('Error fetching events');
                    });
            } else {
                // If events are in localStorage, use them directly
                successCallback(events);
            }
        },
        eventClick: function (info) {
            const event = info.event;
            const eventDetails = `
                <h2>${event.title}</h2>
                <p><strong>Location:</strong> ${event.extendedProps.location}</p>
                <p><strong>Description:</strong> ${event.extendedProps.description}</p>
                <p><strong>Start:</strong> ${event.start.toLocaleString()}</p>
                <p><strong>End:</strong> ${event.end ? event.end.toLocaleString() : 'N/A'}</p>
                <a href="${event.url}" target="_blank">View Event Details</a>
            `;
            alert(eventDetails); // Show event details
        },
        eventContent: function (info) {
            return {
                html: `
                    <div class="event-title">${info.event.title}</div>
                    <div class="event-location">${info.event.extendedProps.location}</div>`
            };
        }
    });

    // Render the calendar
    calendar.render();

    // Refresh the calendar periodically to check for new events
    setInterval(function () {
        calendar.refetchEvents();
    }, 60000); // Every 1 minute
});

    </script>

</body>
</html>

<?php get_footer(); ?>
