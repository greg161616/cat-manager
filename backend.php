<?php
require 'config.php';

// ✅ Your Cat API Key (ONLY the key, no "api_key=" prefix)
$apiKey = "live_n6ZGlRsQ0V3n0NuczNtj8RzFaA2u7Kk3Evn3EJ8b4I7NvGbjYdQtmr6jlon3pK6k";

// ✅ Register
if (isset($_POST['action']) && $_POST['action'] === 'register') {
    $u = $_POST['username'];
    $p = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $u, $p);
    $stmt->execute();
    echo "registered"; exit;
}

// ✅ Login
if (isset($_POST['action']) && $_POST['action'] === 'login') {
    $u = $_POST['username'];
    $p = $_POST['password'];
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username=?");
    $stmt->bind_param("s", $u);
    $stmt->execute();
    $stmt->bind_result($id, $hashed);
    $stmt->fetch();
    if (password_verify($p, $hashed)) {
        $_SESSION['user_id'] = $id;
        echo "success"; exit;
    }
    echo "error"; exit;
}

// ✅ Logout
if (isset($_POST['action']) && $_POST['action'] === 'logout') {
    session_destroy();
    echo "logged out"; exit;
}

// ✅ Fetch Breeds
if (isset($_GET['action']) && $_GET['action'] === 'breeds') {
    $ch = curl_init("https://api.thecatapi.com/v1/breeds");
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => ["x-api-key: $apiKey"]
    ]);
    echo curl_exec($ch);
    curl_close($ch);
    exit;
}

// ✅ Upload Image
if (!empty($_FILES['file'])) {
    $file = new CURLFile($_FILES['file']['tmp_name'], $_FILES['file']['type'], $_FILES['file']['name']);
    $ch = curl_init("https://api.thecatapi.com/v1/images/upload");
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => ["file" => $file],
        CURLOPT_HTTPHEADER => ["x-api-key: $apiKey"]
    ]);
    echo curl_exec($ch);
    curl_close($ch);
    exit;
}

// ✅ Favorite
if (isset($_POST['action']) && $_POST['action'] === 'favorite') {
    $data = json_encode(["image_id" => $_POST['image_id']]);
    $ch = curl_init("https://api.thecatapi.com/v1/favourites");
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $data,
        CURLOPT_HTTPHEADER => [
            "Content-Type: application/json",
            "x-api-key: $apiKey"
        ]
    ]);
    echo curl_exec($ch);
    curl_close($ch);
    exit;
}

// ✅ Vote
if (isset($_POST['action']) && $_POST['action'] === 'vote') {
    $data = json_encode(["image_id" => $_POST['image_id'], "value" => 1]);
    $ch = curl_init("https://api.thecatapi.com/v1/votes");
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $data,
        CURLOPT_HTTPHEADER => [
            "Content-Type: application/json",
            "x-api-key: $apiKey"
        ]
    ]);
    echo curl_exec($ch);
    curl_close($ch);
    exit;
}

// ✅ Get 100 Cat Images
if (isset($_GET['action']) && $_GET['action'] === 'images') {
    $ch = curl_init("https://api.thecatapi.com/v1/images/search?limit=100");
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => ["x-api-key: $apiKey"]
    ]);
    echo curl_exec($ch);
    curl_close($ch);
    exit;
}
// ✅ Search Images by Breed ID
if (isset($_GET['action']) && $_GET['action'] === 'search') {
    $breed_id = $_GET['breed_id'];
    $ch = curl_init("https://api.thecatapi.com/v1/images/search?limit=10&breed_ids=" . urlencode($breed_id));
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => ["x-api-key: $apiKey"]
    ]);
    echo curl_exec($ch);
    curl_close($ch);
    exit;
}

?>
