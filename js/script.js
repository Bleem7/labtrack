document.addEventListener('DOMContentLoaded', function() {
  document.getElementById('register').addEventListener('submit', function(event) {
    event.preventDefault();

    // Clear previous error messages
    document.querySelectorAll('.error-message').forEach(function(error) {
      error.textContent = '';
    });

    // Retrieve form inputs
    const username = document.getElementById('username').value.trim();
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm-password').value;

    // Email format validation using regex
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
      document.getElementById('email-error').textContent = 'Please enter a valid email address';
      return;
    }

    // Strong password validation using regex
    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/;
    if (!passwordRegex.test(password)) {
      document.getElementById('password-error').textContent = 'Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, and one number';
      return;
    }

    // Confirm password validation
    if (password !== confirmPassword) {
      document.getElementById('confirm-password-error').textContent = 'Passwords do not match';
      return;
    }

    // If all validations pass, submit the form (you may replace this with your actual form submission code)
    console.log('Registration successful');
  });
});
