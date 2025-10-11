document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('registrationForm');

  form.addEventListener('submit', function (e) {
    e.preventDefault();

    const username = document.getElementById('username').value.trim();
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value.trim();

    // Basic client-side validation
    if (!username || !email || !password) {
      showToast('All fields are required', 'error');
      return;
    }

    if (!email.includes('@') || !email.includes('.')) {
      showToast('Invalid email format', 'error');
      return;
    }

    if (password.length < 6) {
      showToast('Password must be at least 6 characters', 'error');
      return;
    }

    // Submit to register.php
    fetch('../backend/register.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ username, email, password })
    })
    .then(res => {
      if (!res.ok) throw new Error(`Server responded with ${res.status}`);
      return res.json();
    })
    .then(data => {
      if (data.success) {
        showToast(data.success, 'success');
        form.reset();
      } else {
        showToast(data.error || 'Registration failed', 'error');
      }
    })
    .catch(err => {
      console.error('Error:', err);
      showToast('Server error. Please try again later.', 'error');
    });
  });

  function showToast(message, type = 'error') {
    const toast = document.getElementById('toast');
    toast.textContent = message;
    toast.className = type; // Use CSS classes like .error or .success
    toast.style.display = 'block';
    setTimeout(() => {
      toast.style.display = 'none';
      toast.className = ''; // Reset class after hiding
    }, 3000);
  }
});