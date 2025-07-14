<?php
require 'config.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Cat Manager</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .card-img-top {
      object-fit: cover;
      height: 250px;
    }
  </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">🐱 Cat Manager</a>
    <div class="d-flex">
      <button class="btn btn-outline-light me-2" onclick="logout()">Logout</button>
    </div>
  </div>
</nav>

<div class="container my-4">

  <!-- 🔍 Search by Breed -->
  <div class="row mb-4">
    <div class="col-md-6">
      <select id="searchBreed" class="form-select">
        <option value="">-- Select a Breed to Search --</option>
      </select>
    </div>
    <div class="col-md-2">
      <button class="btn btn-secondary w-100" onclick="searchBreed()">Search</button>
    </div>
    <div class="col-md-4 text-end">
      <button class="btn btn-outline-dark" onclick="loadCats()">Show All (100)</button>
    </div>
  </div>

  <!-- 🖼️ Upload Image -->
  <form id="uploadForm" class="row g-2 mb-4" enctype="multipart/form-data">
    <div class="col-md-4">
      <input type="file" class="form-control" name="file" required>
    </div>
    <div class="col-md-6">
      <input type="text" id="image_url" class="form-control" placeholder="Image URL will appear here" readonly>
    </div>
    <div class="col-md-2">
      <button type="submit" class="btn btn-success w-100">Upload</button>
    </div>
  </form>

  <!-- ⭐ Favorite Image Manually -->
  <form id="catForm" class="row g-2 mb-5">
    <div class="col-md-4">
      <select id="breed" class="form-select" required></select>
    </div>
    <div class="col-md-6">
      <input id="image_url_manual" class="form-control" placeholder="Paste Image URL (from upload or elsewhere)" required>
    </div>
    <div class="col-md-2">
      <button type="submit" class="btn btn-primary w-100">Favorite</button>
    </div>
  </form>

  <!-- 📸 Cat Image Gallery -->
  <h4 class="mb-3">Explore Cats</h4>
  <div class="row" id="list"></div>

</div>

<script>
async function getBreeds() {
  const res = await fetch("backend.php?action=breeds");
  const breeds = await res.json();
  const breedSelect = document.getElementById("breed");
  const searchBreed = document.getElementById("searchBreed");

  breeds.forEach(b => {
    breedSelect.innerHTML += `<option value="${b.id}">${b.name}</option>`;
    searchBreed.innerHTML += `<option value="${b.id}">${b.name}</option>`;
  });
}

async function loadCats() {
  const res = await fetch("backend.php?action=images");
  const cats = await res.json();
  const list = document.getElementById("list");
  list.innerHTML = cats.map(cat => `
    <div class="col-md-4 col-lg-3 mb-4">
      <div class="card shadow-sm h-100">
        <img src="${cat.url}" class="card-img-top" alt="Cat">
        <div class="card-body text-center">
          <button class="btn btn-sm btn-outline-primary me-1" onclick="vote('${cat.id}')">❤️ Vote</button>
          <button class="btn btn-sm btn-outline-success" onclick="favorite('${cat.id}')">⭐ Favorite</button>
        </div>
      </div>
    </div>
  `).join('');
}

async function searchBreed() {
  const breedId = document.getElementById("searchBreed").value;
  if (!breedId) {
    alert("Please select a breed.");
    return;
  }

  const res = await fetch(`backend.php?action=search&breed_id=${breedId}`);
  const cats = await res.json();
  const list = document.getElementById("list");

  if (cats.length === 0) {
    list.innerHTML = `<p class="text-muted">No cats found for this breed.</p>`;
    return;
  }

  list.innerHTML = cats.map(cat => `
    <div class="col-md-4 col-lg-3 mb-4">
      <div class="card shadow-sm h-100">
        <img src="${cat.url}" class="card-img-top" alt="Cat">
        <div class="card-body text-center">
          <button class="btn btn-sm btn-outline-primary me-1" onclick="vote('${cat.id}')">❤️ Vote</button>
          <button class="btn btn-sm btn-outline-success" onclick="favorite('${cat.id}')">⭐ Favorite</button>
        </div>
      </div>
    </div>
  `).join('');
}

async function logout() {
  await fetch("backend.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: "action=logout"
  });
  location.href = "login.php";
}

uploadForm.onsubmit = async (e) => {
  e.preventDefault();
  const fd = new FormData(uploadForm);
  const res = await fetch("backend.php", {
    method: "POST",
    body: fd
  });
  const data = await res.json();
  image_url.value = data.url;
};

catForm.onsubmit = async (e) => {
  e.preventDefault();
  const id = image_url_manual.value;
  await fetch("backend.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `action=favorite&image_id=${id}`
  });
  alert("Added to favorites!");
};

async function vote(id) {
  await fetch("backend.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `action=vote&image_id=${id}`
  });
  alert("Voted!");
}

async function favorite(id) {
  await fetch("backend.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `action=favorite&image_id=${id}`
  });
  alert("Favorited!");
}

// Init
getBreeds();
loadCats();
</script>

</body>
</html>