<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$username = $_POST['username'];
$email  = $_POST['email'];
$password = $_POST['password'];


if (!empty($username) && !empty($email) && !empty($password)) {

  }

  $host = "localhost";
  $dbusername = "u994782675_login_trail";
  $dbpassword = "Avis@123456";
  $dbname = "u994782675_login";

  $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

  if ($conn->connect_error) {
    die('Connect Error (' . $conn->connect_errno . ') ' . $conn->connect_error);
  }

  $SELECT = "SELECT email FROM register WHERE email = ? LIMIT 1";
  $INSERT = "INSERT INTO register (username, email, password) VALUES (?, ?, ?)";

  $stmt = $conn->prepare($SELECT);
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $stmt->store_result();

  if ($stmt->num_rows == 0) {
    $stmt->close();
    $stmt = $conn->prepare($INSERT);
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt->bind_param("sss", $username, $email, $hashedPassword);
    $stmt->execute();
    echo "New record inserted successfully";
  } else {
    echo "Someone already registered using this email";
  }

  $stmt->close();
  $conn->close();

} else {
  echo "All fields are required";
  exit;
}
?>