document.addEventListener("DOMContentLoaded", () => {
  const usernameInput = document.getElementById("username");
  const emailInput = document.getElementById("email");

  const showToast = (message) => {
    const toast = document.createElement("div");
    toast.className = "toast";
    toast.innerText = message;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 3000);
  };

  const checkUnique = (field, value) => {
    fetch("../backend/validate.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ field, value })
    })
    .then(res => res.json())
    .then(data => {
      if (!data.unique) {
        showToast(`${field} already exists`);
      }
    });
  };

  usernameInput.addEventListener("blur", () => {
    const value = usernameInput.value.trim();
    if (value) checkUnique("username", value);
  });

  emailInput.addEventListener("blur", () => {
    const value = emailInput.value.trim();
    if (value) checkUnique("email", value);
  });
});