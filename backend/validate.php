<?php
$username = $_POST['username'];
$email  = $_POST['email'];
$password = $_POST['password'];

  $host = "localhost";
  $dbusername = "u994782675_Avis_portal";
  $dbpassword = "Avis@123456";
  $dbname = "u994782675_portal";

  $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

  if ($conn->connect_error) {
    die('Connect Error (' . $conn->connect_errno . ') ' . $conn->connect_error);
  }

  $SELECT = "SELECT email FROM registration WHERE email = ? LIMIT 1";
  $INSERT = "INSERT INTO registration (username, email, password) VALUES (?, ?, ?)";

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


?>