<?php
header('Content-Type: application/json');

// Database credentials
$host = "localhost";
$dbusername = "u994782675_Avis_portal";
$dbpassword = "Avis@123456";
$dbname = "u994782675_portal";

// Connect to database
$conn = new mysqli($host, $dbusername, $dbpassword, $dbname);
if ($conn->connect_error) {
  echo json_encode(['error' => 'Database connection failed']);
  exit;
}

// Get input data
$input = json_decode(file_get_contents("php://input"), true);
$username = trim($input['username'] ?? '');
$email    = trim($input['email'] ?? '');
$password = trim($input['password'] ?? '');

// Validate input
if (!$username || !$email || !$password) {
  echo json_encode(['error' => 'All fields are required']);
  exit;
}

// Check if username exists
$stmt = $conn->prepare("SELECT COUNT(*) FROM registration WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($userCount);
$stmt->fetch();
$stmt->close();

if ($userCount > 0) {
  echo json_encode(['error' => 'Username already exists']);
  $conn->close();
  exit;
}

// Check if email exists
$stmt = $conn->prepare("SELECT COUNT(*) FROM registration WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($emailCount);
$stmt->fetch();
$stmt->close();

if ($emailCount > 0) {
  echo json_encode(['error' => 'Email already exists']);
  $conn->close();
  exit;
}

// Insert new user
$stmt = $conn->prepare("INSERT INTO registration (username, email, password) VALUES (?, ?, ?)");
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
$stmt->bind_param("sss", $username, $email, $hashedPassword);
$stmt->execute();
$stmt->close();

echo json_encode(['success' => 'New user registered successfully']);
$conn->close();
?>