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
       document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');

            // Dummy JSON data for events
            const dummyEvents = [
                {
                    title: 'What if ?',
                    start: '2025-01-12T14:08:00',
                    end: '2025-01-13T15:08:00',
                    location: 'USA',
                    description: 'Special Managed By Avengers End-Game. Event You can Get chance to meet Your Hero For Visit in the world By getting lucky Ticket for plane.',
                    url: 'http://localhost/restro/events/what-if/'
                },
                {
                    title: 'Event 1',
                    start: '2025-01-02T01:24:00',
                    end: '2025-01-07T13:25:00',
                    location: 'Ahmedabad',
                    description: 'This is For Testing',
                    url: 'http://localhost/restro/events/event-1/'
                },
                {
                    title: 'Party Plote',
                    start: '2025-01-11T02:29:00',
                    end: '2025-01-12T17:26:00',
                    location: 'Mumbai',
                    description: 'This is checking System',
                    url: 'http://localhost/restro/events/party-plote/'
                },
                {
                    title: 'Sec Event',
                    start: '2025-01-30T03:09:00',
                    end: '2025-01-31T05:10:00',
                    location: 'San Francisco',
                    description: 'This is Descriptions On the Video',
                    url: 'http://localhost/restro/events/sec-event/'
                },
                {
                    title: 'Share Is Care',
                    start: '2025-01-03T15:45:00',
                    end: '2025-01-10T17:45:00',
                    location: 'Your House',
                    description: 'You can Visit Us for free lunch because We Have Extra food And I Don\'t Want to waste. so Contact Us For Free Donation',
                    url: 'http://localhost/restro/events/title/'
                },
                {
                    title: 'Jan Samaroh',
                    start: '2025-01-22T15:51:00',
                    end: '2025-01-24T19:48:00',
                    location: 'Rokdiya Hanuman Mandir',
                    description: 'Ram Bhajan With Sundarkand Path',
                    url: 'http://localhost/restro/events/event/'
                }
            ];

            // Initialize FullCalendar
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                
                // Instead of AJAX, just load the dummy events directly
                events: dummyEvents,

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

                // Use eventContent to customize how the event appears in the calendar
                eventContent: function(info) {
                    // Customize the content structure here
                    return {
                        html: `
                            <div class="event-title">${info.event.title}</div>
                            <div class="event-location">${info.event.extendedProps.location}</div>`
                    };
                },
            });

            // Render the calendar
            calendar.render();
        });
    </script>

</body>
</html>

<?php get_footer(); ?>
