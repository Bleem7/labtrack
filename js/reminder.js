document.addEventListener('DOMContentLoaded', function() {
  const reminderForm = document.getElementById('reminder-form');

  reminderForm.addEventListener('submit', function(event) {
      event.preventDefault();

      const task = document.getElementById('reminder-task').value;
      const date = document.getElementById('reminder-date').value;
      const time = document.getElementById('reminder-time').value;

      const reminderData = {
          task: task,
          date: date,
          time: time
      };

      const xhr = new XMLHttpRequest();
      xhr.open('POST', '../action/add_reminder.php', true);
      xhr.setRequestHeader('Content-Type', 'application/json');

      xhr.onload = function () {
          if (xhr.status >= 200 && xhr.status < 400) {
              try {
                  const response = JSON.parse(xhr.responseText);
                  if (response.status === 'success') {
                      console.log('Reminder added successfully');
                      // Optionally, update UI or show success message
                  } else {
                      console.error('Failed to add reminder:', response.message);
                      // Handle error message
                  }
              } catch (error) {
                  console.error('Error parsing JSON:', error);
                  console.log('Response from server:', xhr.responseText);
                  // Handle JSON parsing error
              }
          } else {
              console.error('Failed to add reminder:', xhr.status, xhr.statusText);
              // Handle HTTP error status
          }
      };

      xhr.onerror = function () {
          console.error('Request failed');
          // Handle request error
      };

      xhr.send(JSON.stringify(reminderData));
  });
});
