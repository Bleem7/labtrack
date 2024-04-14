<?php
session_start();
if (!isset($_SESSION['Username'])) {
    header('Location: ../view/loginpage.php');
}
?>





<!DOCTYPE html>
<html>

<head>
	<style>
		/* nav ul {
			list-style-type: none;
			padding: 0;
		}

		nav ul li {
			display: inline;
			margin-right: 10px;
		} */
	</style>
	<link rel="stylesheet" type="text/css" href="../css/calendar.css">
	<link href='https://unpkg.com/@fullcalendar/core@5/main.css' rel='stylesheet' />
	<link href='https://unpkg.com/@fullcalendar/daygrid@5/main.css' rel='stylesheet' />
	<script type="module">
		import { Calendar } from 'https://cdn.skypack.dev/@fullcalendar/core';
		import dayGridPlugin from 'https://cdn.skypack.dev/@fullcalendar/daygrid';

		document.addEventListener('DOMContentLoaded', function () {
			var calendarEl = document.getElementById('calendar');
			var calendar = new Calendar(calendarEl, {
				plugins: [dayGridPlugin],
				events: function (fetchInfo, successCallback, failureCallback) {
					Promise.all([
						fetch('../action/fetch_past_tasks.php'),
						fetch('../action/fetch_past_reminders.php'),
						fetch('../action/fetch_upcoming_tasks.php'),
						fetch('../action/fetch_upcoming_reminders.php')
					]).then(async ([response1, response2, response3, response4]) => {
						const pastTasks = await response1.json();
						const pastReminders = await response2.json();
						const upcomingTasks = await response3.json();
						const upcomingReminders = await response4.json();

						pastTasks.forEach(event => event.color = 'gray');
						pastReminders.forEach(event => event.color = 'gray');
						upcomingTasks.forEach(event => event.color = '#378006');
						upcomingReminders.forEach(event => {
							event.color = 'red';
							event.className = 'blink';
						});

						successCallback([...pastTasks, ...pastReminders, ...upcomingTasks, ...upcomingReminders]);
					});
				}
			});
			calendar.render();
		});

	</script>
</head>

<body>
	<nav class="sidebar">
		<ul>
			<li><a href="dashboard.php">Dashboard </a></li>
			<li><a href="calendar.php">Calendar</a></li>
			<li><a href="reminders.php">Reminders</a></li>

			<li><a href="../view/loginpage.php">Logout</a></li>
		</ul>
	</nav>
	<div id='calendar'></div>


</body>

</html>