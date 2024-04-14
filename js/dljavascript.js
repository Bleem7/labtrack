document.addEventListener('DOMContentLoaded', function () {

  // Initialize FullCalendar
  const calendarEl = document.getElementById('calendar');
  const calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth', // Change the initial view as needed
    locale: 'en', // Change the locale as needed
    events: [], // Initialize with an empty array of events
  });
  calendar.render();

  // Function to add assignment to the calendar
  function addAssignmentToCalendar(assignment) {
    calendar.addEvent({
      title: assignment.taskName,
      start: assignment.taskDueDate,
      // Add more properties as needed
    });
  }

  // Function to open the popup
  function openPopup() {
    const popupOverlay = document.getElementById('popup-overlay');
    popupOverlay.classList.add('visible');
  }

  // Function to close the popup
  function closePopup() {
    const popupOverlay = document.getElementById('popup-overlay');
    popupOverlay.classList.remove('visible');
  }

  // Function to close the popup without adding an assignment
  function closePopupWithoutAdding() {
    const popupOverlay = document.getElementById('popup-overlay');
    popupOverlay.classList.remove('visible');
    // Reset form fields if needed
    document.getElementById('add-assignment-form').reset();
  }

  // Function to update assignments table with new assignment
  function updateAssignmentsTable(newAssignment) {
    const assignmentList = document.querySelector('.assignment-list');
    const card = generateAssignmentCard(newAssignment);
    assignmentList.appendChild(card);
  }

  // Function to generate assignment card HTML
  function generateAssignmentCard(assignment) {
    const card = document.createElement('div');
    card.classList.add('assignment-card');
    card.innerHTML = `
      <h3>${assignment.taskName}</h3>
      <p>Due Date: ${assignment.taskDueDate}</p>
      <button class="edit-btn" onclick="openPopupEdit()">Edit</button>
      <button class="delete-btn">Delete</button>
    `;
    return card;
  }

  // Function to send the edit request
  function sendEditRequest(taskId) {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', '../action/edit_assignment_action.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json');

    xhr.onload = function () {
      if (xhr.status >= 200 && xhr.status < 400) {
        // Success - parse response
        const response = JSON.parse(xhr.responseText);
        console.log('Server response:', response);
        // Handle success message
        alert(response.message);
        // Reload page or update UI as needed
      } else {
        // Error - handle accordingly
        console.error('Server error:', xhr.status, xhr.statusText);
        // Handle error message
        alert('Failed to edit assignment. Please try again.');
      }
    };

    xhr.onerror = function () {
      console.error('Request failed');
      // Handle error message
      alert('Failed to edit assignment. Please check your internet connection and try again.');
    };

    xhr.send(JSON.stringify({ task_id: taskId }));
  }

  // Function to send the delete request
  function sendDeleteRequest(taskId) {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', '../action/delete_user_action.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json');

    xhr.onload = function () {
      if (xhr.status >= 200 && xhr.status < 400) {
        // Success - parse response
        const response = JSON.parse(xhr.responseText);
        console.log('Server response:', response);
        // Handle success message
        alert(response.message);
        // Reload page or update UI as needed
      } else {
        // Error - handle accordingly
        console.error('Server error:', xhr.status, xhr.statusText);
        // Handle error message
        alert('Failed to delete assignment. Please try again.');
      }
    };

    xhr.onerror = function () {
      console.error('Request failed');
      // Handle error message
      alert('Failed to delete assignment. Please check your internet connection and try again.');
    };

    xhr.send(JSON.stringify({ task_id: taskId }));
  }

  // Add event listener for the "Add Assignment" button
  const addAssignmentBtn = document.querySelector('.add-assignment-btn');
  addAssignmentBtn.addEventListener('click', function () {
    openPopup();
  });

  // Add event listener for the form submission
  const addAssignmentForm = document.getElementById('add-assignment-form');
  addAssignmentForm.addEventListener('submit', function (event) {
    event.preventDefault();

    // Get input values
    const taskName = document.getElementById('task_name').value;
    const taskDueDate = document.getElementById('task_due_date').value;

    // Create new assignment object
    const newAssignment = {
      taskName,
      taskDueDate,
    };

    // Reset form fields
    document.getElementById('task_name').value = '';
    document.getElementById('task_due_date').value = '';

    // Send data to server
    const xhr = new XMLHttpRequest();
    xhr.open('POST', '../action/add_assignment_action_action.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json');

    xhr.onload = function () {
      if (xhr.status >= 200 && xhr.status < 400) {
        const response = JSON.parse(xhr.responseText);
        if (response.success) {
          updateAssignmentsTable(newAssignment);
          addAssignmentToCalendar(newAssignment);
          addNotification(newAssignment.taskName + ' has been added successfully.');
        } else {
          alert(response.message);
        }
      } else {
        alert('Failed to add assignment. Please try again.');
      }
    };

    xhr.onerror = function () {
      console.error('Request failed');
      alert('Failed to add assignment. Please check your internet connection and try again.');
    };

    xhr.send(JSON.stringify(newAssignment));

    // Close popup
    closePopup();
  });

  // Function to open the popup for editing
  function openPopupEdit() {
    const editPage = document.getElementById('edit-popup-overlay');
    editPage.style.display = 'block';
  }

  // Fetch assignments from server on page load
  const assignmentsData = [];
  const notificationsData = []; // Define this array

  // Define these elements
  const assignmentList = document.querySelector('.assignment-list');
  const notificationList = document.querySelector('.notification-list');

  fetch('../action/fetch_all_tasks.php')
    .then(response => response.json())
    .then(data => {
      assignmentsData.push(...data);

      // Populate assignment list
      assignmentsData.forEach(function (assignment) {
        const card = generateAssignmentCard(assignment);
        assignmentList.appendChild(card);
      });

      // Populate notification list
      notificationsData.forEach(function (notification) {
        const item = generateNotificationItem(notification);
        notificationList.appendChild(item);
      });
    })
    .catch(error => {
      console.error('Failed to fetch tasks:', error);
      alert('Failed to fetch tasks. Please try again.');
    });

  // Function to generate notification item HTML
  function generateNotificationItem(notification) {
    const item = document.createElement('div');
    item.classList.add('notification-item');
    item.innerHTML = `
      <p>${notification.message}</p>
      <span class="close-btn">×</span>
    `;
    return item;
  }

  // Function to handle notification item removal
  notificationList.addEventListener('click', function (event) {
    if (event.target.classList.contains('close-btn')) {
      const item = event.target.parentElement;
      item.style.animation = 'fadeOut 0.5s ease';
      setTimeout(function () {
        item.remove();
      }, 500);
    }
  });

  // Add event listener for the edit button in assignment cards
  assignmentList.addEventListener('click', function (event) {
    if (event.target.classList.contains('edit-btn')) {
      openPopupEdit();
      // const card = event.target.parentElement;
      // const taskId = card.dataset.taskId;

      // // Send edit request
      // sendEditRequest(taskId);
    }
  });

  // Add event listener for the delete button in assignment cards
  assignmentList.addEventListener('click', function (event) {
    if (event.target.classList.contains('delete-btn')) {
      const card = event.target.parentElement;
      const taskId = card.dataset.taskId;

      // Send delete request
      sendDeleteRequest(taskId);
    }
  });

});
