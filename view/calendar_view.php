<!DOCTYPE html>
<html>
<head>
    <link href='https://unpkg.com/@fullcalendar/core@5/main.css' rel='stylesheet' />
    <link href='https://unpkg.com/@fullcalendar/daygrid@5/main.css' rel='stylesheet' />
    <script type="module">
        import { Calendar } from 'https://cdn.skypack.dev/@fullcalendar/core';
        import dayGridPlugin from 'https://cdn.skypack.dev/@fullcalendar/daygrid';

        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');
            var calendar = new Calendar(calendarEl, {
                plugins: [dayGridPlugin],
                events: '../action/fetch_events.php',
                eventColor: '#378006'
            });
            calendar.render();
        });
    </script>
</head>
<body>
    <div id='calendar'></div>
</body>
</html>