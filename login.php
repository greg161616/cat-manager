<! DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Cat Manager - Login/Register</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .form-section { display: none; }
    .form-section.active { display: block; }
  </style>
</head>
<body class="bg-light">

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-5">

      <div class="text-center mb-4">
        <div class="form-check form-switch d-inline-flex align-items-center">
          <input class="form-check-input" type="checkbox" role="switch" id="toggleForm">
          <label class="form-check-label ms-2" for="toggleForm" id="formLabel">Login</label>
        </div>
      </div>

      <!-- Login Form -->
      <div class="card shadow-sm form-section active" id="loginSection">
        <div class="card-header bg-primary text-white text-center">
          <h4 class="mb-0">Login</h4>
        </div>
        <div class="card-body">
          <form id="loginForm">
            <div class="mb-3">
              <label for="username" class="form-label">Username</label>
              <input type="text" class="form-control" id="username" required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" id="password" required>
            </div>
            <div class="d-grid">
              <button type="submit" class="btn btn-primary">Login</button>
            </div>
          </form>
        </div>
      </div>

      <!-- Register Form -->
      <div class="card shadow-sm form-section" id="registerSection">
        <div class="card-header bg-success text-white text-center">
          <h4 class="mb-0">Register</h4>
        </div>
        <div class="card-body">
          <form id="registerForm">
            <div class="mb-3">
              <label for="reg_username" class="form-label">Username</label>
              <input type="text" class="form-control" id="reg_username" required>
            </div>
            <div class="mb-3">
              <label for="reg_password" class="form-label">Password</label>
              <input type="password" class="form-control" id="reg_password" required>
            </div>
            <div class="d-grid">
              <button type="submit" class="btn btn-success">Register</button>
            </div>
          </form>
        </div>
      </div>

    </div>
  </div>
</div>

<script>
const toggleSwitch = document.getElementById("toggleForm");
const loginSection = document.getElementById("loginSection");
const registerSection = document.getElementById("registerSection");
const formLabel = document.getElementById("formLabel");

toggleSwitch.addEventListener("change", () => {
  if (toggleSwitch.checked) {
    loginSection.classList.remove("active");
    registerSection.classList.add("active");
    formLabel.innerText = "Register";
  } else {
    registerSection.classList.remove("active");
    loginSection.classList.add("active");
    formLabel.innerText = "Login";
  }
});

document.getElementById("loginForm").onsubmit = async (e) => {
  e.preventDefault();
  const res = await fetch("backend.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `action=login&username=${username.value}&password=${password.value}`
  });
  const txt = await res.text();
  if (txt.includes("success")) location.href = "index.php";
  else alert("Invalid credentials");
};

document.getElementById("registerForm").onsubmit = async (e) => {
  e.preventDefault();
  const res = await fetch("backend.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `action=register&username=${reg_username.value}&password=${reg_password.value}`
  });
  const txt = await res.text();
  alert(txt);
};
</script>

</body>
</html>