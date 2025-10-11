document.addEventListener('DOMContentLoaded', function () {
  const usernameInput = document.getElementById('username');
  const emailInput = document.getElementById('email');

  usernameInput.addEventListener('blur', () => checkField('username', usernameInput.value));
  emailInput.addEventListener('blur', () => checkField('email', emailInput.value));

  function checkField(field, value) {
    if (!value.trim()) return;

    fetch('../backend/register.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ check: field, [field]: value })
    })
    .then(res => res.json())
    .then(data => {
      if (data.exists) showToast(`${field.charAt(0).toUpperCase() + field.slice(1)} already exists`);
    })
    .catch(err => console.error('Error:', err));
  }

  function showToast(message) {
    const toast = document.getElementById('toast');
    toast.textContent = message;
    toast.style.display = 'block';
    setTimeout(() => toast.style.display = 'none', 3000);
  }
});