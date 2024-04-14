<?php
session_start();
if (!isset($_SESSION['Username'])) {
    header('Location: ../view/loginpage.php');
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reminders | Lab-Track</title>
    <link rel="stylesheet" href="../css/reminders.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

</head>

<body>
    <div class="container">
        <div class="sidebar">
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="calendar.php">Calendar</a></li>
                <li><a href="reminders.php">Reminders</a></li>
                
                <li><a href="../view/loginpage.php">Logout</a></li>
            </ul>
        </div>
        <div class="main">
            <h1>Reminders</h1>
            <form class="reminder-form" id="reminder-form" action="../action/add_reminder.php" method="post">
                <label for="reminder-task">Task Name:</label>
                <input type="text" id="reminder-task" name="reminder-task" required>
                <label for="reminder-date">Reminder Date:</label>
                <input type="date" id="reminder-date" name="reminder-date" required>
                <label for="reminder-time">Reminder Time:</label>
                <input type="time" id="reminder-time" name="reminder-time" required>
                <button type="submit">Set Reminder</button>
            </form>
            <!-- Display area for reminders -->
            <div id="reminder-list">
                <!-- Dynamically generated reminder list will be displayed here -->
                <!-- Example: <div class="reminder-item">Reminder 1 - Task 1 - April 1, 2024 - 10:00 AM</div> -->
            </div>
        </div>
    </div>
    <div id='reminder-list'></div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <script>
        $(document).ready(function () {
            $("#reminder-form").submit(function (event) {
                event.preventDefault();

                var task = $("#reminder-task").val();
                var date = $("#reminder-date").val();
                var time = $("#reminder-time").val();

                $.ajax({
                    url: "../action/add_reminder.php",
                    type: "POST",
                    data: JSON.stringify({ task: task, date: date, time: time }),
                    success: function (response) {
                        response = JSON.parse(response);
                        if (response.status === "success") {
                            getReminders();
                            $("#reminder-form").trigger("reset");
                            Swal.fire({
                                icon: "success",
                                title: "Success",
                                text: response.message,
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                text: response.message,
                            });
                        }
                    },
                    error: function (xhr, status, error) {
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: "An error occurred while adding the reminder",
                        });
                    },
                });
            });
        });

        $(document).ready(function () {
            getReminders();
        });

        function getReminders() {
            $("#reminder-list").empty();
            $.ajax({
                url: "../action/fetch_reminders.php",
                type: "GET",
                success: function (response) {
                    if (response) {
                        response.forEach(function (reminder) {
                            var reminderItem = $("<div class='reminder-item'></div>");
                            reminderItem.text(reminder.taskname + " - " + reminder.reminder_date + " - " + reminder.reminder_time);
                            $("#reminder-list").append(reminderItem);
                        });
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: "No reminders found",
                        });
                    }
                },
                error: function (xhr, status, error) {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "An error occurred while fetching reminders",
                    });
                },
            });
        }


    </script>
</body>

</html>