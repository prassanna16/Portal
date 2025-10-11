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
    .then(res => {
      if (!res.ok) throw new Error(`Server responded with ${res.status}`);
      return res.json();
    })
    .then(data => {
      if (data.exists) {
        showToast(`${capitalize(field)} already exists`, 'error');
      } else {
        showToast(`${capitalize(field)} is available`, 'success');
      }
    })
    .catch(err => {
      console.error('Error:', err);
      showToast('Unable to check availability. Please try again.', 'error');
    });
  }

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

  function capitalize(str) {
    return str.charAt(0).toUpperCase() + str.slice(1);
  }
});